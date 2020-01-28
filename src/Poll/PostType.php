<?php

namespace TotalPoll\Poll;


/**
 * Poll post type.
 * @package TotalPoll\PostType
 */
class PostType extends \TotalPollVendors\TotalCore\PostTypes\PostType {
	public function __construct() {
		parent::__construct();
		add_action( 'totalpoll/actions/activated', [ $this, 'capabilities' ] );
	}

	/**
	 * Register post type.
	 *
	 * @return \WP_Error|\WP_Post_Type
	 */
	public function register() {
		define( 'TP_POLL_CPT_NAME', $this->getName() );

		return parent::register();
	}

	/**
	 * Capabilities mapping.
	 */
	public function capabilities() {
		$map = [
			'edit_poll'   => [ 'administrator', 'editor', 'author', 'contributor' ],
			'read_poll'   => [ 'administrator', 'editor', 'author', 'contributor' ],
			'delete_poll' => [ 'administrator', 'editor', 'author', 'contributor' ],

			'edit_polls'    => [ 'administrator', 'editor', 'author', 'contributor' ],
			'delete_polls'  => [ 'administrator', 'editor', 'author', 'contributor' ],
			'publish_polls' => [ 'administrator', 'editor', 'author' ],

			'edit_others_polls'   => [ 'administrator', 'editor' ],
			'delete_others_polls' => [ 'administrator', 'editor' ],

			'edit_published_polls'   => [ 'administrator', 'editor', 'author' ],
			'delete_published_polls' => [ 'administrator', 'editor', 'author' ],

			'read_private_polls'   => [ 'administrator', 'editor' ],
			'edit_private_polls'   => [ 'administrator', 'editor' ],
			'delete_private_polls' => [ 'administrator', 'editor' ],
			'create_polls'         => [ 'administrator', 'editor', 'author', 'contributor' ],
		];

		foreach ( $map as $capability => $roles ):
			foreach ( $roles as $role ):
				$role = get_role( $role );
				if ( $role ):
					$role->add_cap( $capability );
				endif;
			endforeach;
		endforeach;
	}

	/**
	 * @param \WP_Post $post WordPress post.
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public function getMessages( $post ) {
		return [
			0  => '', // Unused. Messages start at index 1.
			1  => sprintf( __( 'Poll updated. <a href="%s">View poll</a>', 'totalpoll' ), esc_url( get_permalink( $post->ID ) ) ),
			2  => __( 'Custom field updated.', 'totalpoll' ),
			3  => __( 'Custom field deleted.', 'totalpoll' ),
			4  => __( 'Poll updated.', 'totalpoll' ),
			5  => isset( $_GET['revision'] ) ? sprintf( __( 'Poll restored to revision from %s', 'totalpoll' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6  => sprintf( __( 'Poll published. <a href="%s">View poll</a>', 'totalpoll' ), esc_url( get_permalink( $post->ID ) ) ),
			7  => __( 'Poll saved.', 'totalpoll' ),
			8  => sprintf( __( 'Poll submitted. <a target="_blank" href="%s">Preview poll</a>', 'totalpoll' ),
				esc_url( add_query_arg( 'preview', 'true', get_permalink( $post->ID ) ) ) ),
			9  => sprintf( __( 'Poll scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview poll</a>', 'totalpoll' ),
				date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post->ID ) ) ),
			10 => sprintf( __( 'Poll draft updated. <a target="_blank" href="%s">Preview poll</a>', 'totalpoll' ),
				esc_url( add_query_arg( 'preview', 'true', get_permalink( $post->ID ) ) ) ),
		];
	}

	/**
	 * Get CPT name.
	 *
	 * @return string
	 */
	public function getName() {
		/**
		 * Filters the name of poll CPT.
		 *
		 * @param string $name CPT name.
		 *
		 * @since 4.0.0
		 * @return string
		 */
		return apply_filters( 'totalpoll/filters/cpt/name', 'poll' );
	}

	/**
	 * Get CPT args.
	 *
	 * @return array
	 */
	public function getArguments() {
		/**
		 * Filters the arguments of poll CPT.
		 *
		 * @param array $args CPT arguments.
		 *
		 * @since 4.0.0
		 * @return array
		 */
		return apply_filters( 'totalpoll/filters/cpt/args', [
			'labels' => [
				'name'               => __( 'Polls', 'totalpoll' ),
				'singular_name'      => __( 'Poll', 'totalpoll' ),
				'add_new'            => __( 'Create Poll', 'totalpoll' ),
				'add_new_item'       => __( 'New Poll', 'totalpoll' ),
				'edit_item'          => __( 'Edit Poll', 'totalpoll' ),
				'new_item'           => __( 'New Poll', 'totalpoll' ),
				'all_items'          => __( 'Polls', 'totalpoll' ),
				'view_item'          => __( 'View Poll', 'totalpoll' ),
				'search_items'       => __( 'Search Polls', 'totalpoll' ),
				'not_found'          => __( 'No polls found', 'totalpoll' ),
				'not_found_in_trash' => __( 'No polls found in Trash', 'totalpoll' ),
				'menu_name'          => __( 'TotalPoll', 'totalpoll' ),
			],

			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => false,
			'rewrite'            => [
				'slug'  => _x( $this->getName(), 'slug', 'totalpoll' ),
				'feeds' => false,
				'pages' => false,
			],
			'capabilities'       => [
				'edit_post'          => 'edit_poll',
				'read_post'          => 'read_poll',
				'delete_post'        => 'delete_poll',
				'edit_posts'         => 'edit_polls',
				'edit_others_posts'  => 'edit_others_polls',
				'publish_posts'      => 'publish_polls',
				'read_private_posts' => 'read_private_polls',
				'create_posts'       => 'create_polls',
			],
			'map_meta_cap'       => true,
			'has_archive'        => _x( 'polls', 'slug', 'totalpoll' ),
			'menu_position'      => null,
			'hierarchical'       => false,
			'show_in_rest'       => false,
			'menu_icon'          => 'dashicons-chart-bar',
			'supports'           => [ 'title', 'revisions', 'excerpt' ],
		] );
	}
}
