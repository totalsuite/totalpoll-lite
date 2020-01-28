<?php

namespace TotalPoll\Admin\Poll;

use TotalPoll\Contracts\Entry\Repository as EntryRepository;
use TotalPoll\Contracts\Log\Repository as LogRepository;
use TotalPoll\Contracts\Poll\Repository as PollRepository;

/**
 * Class Listing
 * @package TotalPoll\Admin\Poll
 */
class Listing {
	/**
	 * @var PollRepository
	 */
	protected $pollRepository;
	/**
	 * @var EntryRepository
	 */
	protected $entryRepository;
	/**
	 * @var EntryRepository
	 */
	protected $logRepository;

	/**
	 * Listing constructor.
	 *
	 * @param PollRepository $pollRepository
	 * @param EntryRepository $entryRepository
	 * @param LogRepository $logRepository
	 */
	public function __construct( PollRepository $pollRepository, EntryRepository $entryRepository, LogRepository $logRepository ) {
		$this->pollRepository  = $pollRepository;
		$this->entryRepository = $entryRepository;
		$this->logRepository   = $logRepository;

		// Assets
		add_action( 'admin_enqueue_scripts', [ $this, 'assets' ] );

		// States
		add_filter( 'display_post_states', [ $this, 'states' ], 10, 2 );

		// Columns
		add_filter( 'manage_poll_posts_columns', [ $this, 'columns' ] );

		// Columns content
		add_action( 'manage_poll_posts_custom_column', [ $this, 'columnsContent' ], 10, 2 );

		// Actions
		add_filter( 'post_row_actions', [ $this, 'actions' ], 10, 2 );

		// Scope
		add_filter( 'pre_get_posts', [ $this, 'scope' ] );


	}

	/**
	 * Page assets.
	 */
	public function assets() {
		/**
		 * @asset-style totalpoll-admin-poll-listing
		 */
		wp_enqueue_style( 'totalpoll-admin-poll-listing' );
	}

	/**
	 * Columns.
	 *
	 * @param array $originalColumns
	 *
	 * @filter-callback manage_poll_posts_columns
	 * @return array
	 */
	public function columns( $originalColumns ) {
		$columns = [
			'cb'      => '<input type="checkbox" />',
			'title'   => __( 'Title' ),
			'votes'   => __( 'Votes', 'totalpoll' ),
			'entries' => __( 'Entries', 'totalpoll' ),
			'log'     => __( 'Log', 'totalpoll' ),
			'date'    => __( 'Date' ),
		];

		if ( ! current_user_can( 'manage_options' ) ):
			unset( $columns['log'] );
		endif;

		if ( ! current_user_can( 'edit_polls' ) ):
			unset( $columns['entries'] );
		endif;

		/**
		 * Filters the list of columns in polls listing.
		 *
		 * @param array $columns Array of columns.
		 * @param array $originalColumns Array of original columns.
		 *
		 * @return array
		 * @since 4.0.0
		 */
		return apply_filters(
			'totalpoll/filters/admin/listing/columns',
			$columns,
			$originalColumns
		);
	}

	/**
	 * Columns content.
	 *
	 * @param $column
	 * @param $id
	 *
	 * @action-callback manage_poll_posts_custom_column
	 * @return void
	 */
	public function columnsContent( $column, $id ) {
		// Votes column
		add_filter( 'totalpoll/filters/admin/listing/columns-content/votes', function ( $content, $id ) {
			return number_format_i18n( array_sum( $this->pollRepository->getVotes( $id ) ) );
		}, 10, 2 );

		// Entries column
		add_filter( 'totalpoll/filters/admin/listing/columns-content/entries', function ( $content, $id ) {
			return number_format_i18n( $this->entryRepository->count( [ 'conditions' => [ 'poll_id' => $id ] ] ) );
		}, 10, 2 );

		// Log column
		add_filter( 'totalpoll/filters/admin/listing/columns-content/log', function ( $content, $id ) {
			return number_format_i18n( $this->logRepository->count( [ 'conditions' => [ 'poll_id' => $id ] ] ) );
		}, 10, 2 );

		/**
		 * Filters the content of a column in polls listing.
		 *
		 * @param array $content Column content.
		 * @param array $id Poll post ID.
		 *
		 * @return string
		 * @since 4.0.0
		 */
		echo apply_filters( "totalpoll/filters/admin/listing/columns-content/{$column}", null, $id );
	}

	/**
	 * Inline actions.
	 *
	 * @param $actions
	 * @param $post
	 *
	 * @filter-callback post_row_actions
	 * @return array
	 */
	public function actions( $actions, $post ) {
		$pollPostType = TP_POLL_CPT_NAME;

		if ( current_user_can( 'edit_poll', $post->ID ) ):
			$actions['entries']  = sprintf( '<a href="%s">%s</a>', esc_attr( wp_nonce_url( admin_url( "edit.php?post_type={$pollPostType}&page=entries&poll={$post->ID}" ) ) ), esc_html( __( 'Entries', 'totalpoll' ) ) );
			$actions['insights'] = sprintf( '<a href="%s">%s</a>', esc_attr( wp_nonce_url( admin_url( "edit.php?post_type={$pollPostType}&page=insights&poll={$post->ID}" ) ) ), esc_html( __( 'Insights', 'totalpoll' ) ) );
		endif;

		if ( current_user_can( 'manage_options' ) ):
			$actions['log'] = sprintf( '<a href="%s">%s</a>', esc_attr( wp_nonce_url( admin_url( "edit.php?post_type={$pollPostType}&page=log&poll={$post->ID}" ) ) ), esc_html( __( 'Log', 'totalpoll' ) ) );
		endif;

		if ( current_user_can( 'manage_options' ) ) :
			$url              = admin_url( "admin-post.php?action=reset_poll&post_type={$pollPostType}&poll={$post->ID}" );
			$actions['reset'] = sprintf( '<a href="%s">%s</a>', esc_attr( add_query_arg( '_wpnonce', wp_create_nonce( 'reset_poll' ), $url ) ), esc_html( __( 'Reset Poll', 'totalpoll' ) ) );
		endif;

		if ( current_user_can( 'manage_options' ) ) :
			$primaryItem = __( 'Export results', 'totalpoll' );

			$items = [];

			foreach ( [ 'csv', 'json', 'html' ] as $format ):
				$items[] = [
					'label' => sprintf( __( 'Export as %s', 'totalpoll' ), strtoupper( $format ) ),
					'url'   => wp_nonce_url(
						admin_url(
							sprintf( 'admin-ajax.php?action=%s&poll=%d&format=%s', 'totalpoll_insights_download', $post->ID, $format )
						)
					)
				];
			endforeach;

			ob_start();
			include 'views/quick-action-menu.php';

			$actions['export-results'] = ob_get_clean();
		endif;

		/**
		 * Filters the list of available actions in polls listing (under each poll).
		 *
		 * @param array $actions Array of actions [id => url].
		 * @param \WP_Post $post Poll post.
		 *
		 * @return array
		 * @since 4.0.0
		 */
		return apply_filters( 'totalpoll/filters/admin/listing/actions', $actions, $post );
	}

	/**
	 * @param $states
	 * @param $post
	 *
	 * @return array
	 */
	public function states( $states, $post ) {
		if ( $post->post_status === 'publish' ):
			$states[] = __( 'Live', 'totalpoll' );
		else:
			$states[] = __( 'Offline', 'totalpoll' );
		endif;

		/**
		 * Filters the list of states actions in polls listing (beside each title).
		 *
		 * @param array $states Array of states [id => label].
		 *
		 * @return array
		 * @since 4.0.0
		 */
		return apply_filters( 'totalpoll/filters/admin/listing/states', $states, $post );
	}

	/**
	 * @param $query
	 *
	 * @return mixed
	 */
	public function scope( $query ) {
		if ( ! current_user_can( 'edit_others_polls' ) ):
			$query->set( 'author', get_current_user_id() );
		endif;

		return $query;
	}

}
