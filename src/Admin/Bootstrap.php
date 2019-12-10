<?php

namespace TotalPoll\Admin;

use TotalPollVendors\TotalCore\Contracts\Foundation\Environment;
use TotalPollVendors\TotalCore\Contracts\Http\Request;
use TotalPollVendors\TotalCore\Helpers\Strings;


/**
 * Class Bootstrap
 * @package TotalPoll\Admin
 */
class Bootstrap {
	/**
	 * @var array $pages
	 */
	public $pages = [];
	/**
	 * @var string|null $requestedPage
	 */
	public $requestedPage = null;
	/**
	 * @var null|\TotalPollVendors\TotalCore\Application $currentPage
	 */
	public $currentPage = null;
	/**
	 * @var array $env
	 */
	public $env = [];

	/**
	 * @var \TotalPollVendors\TotalCore\Http\Request
	 */
	public $request = null;

	protected $messages = [];

	/**
	 * Bootstrap constructor.
	 *
	 * @param Request $request
	 * @param Environment $env
	 */
	public function __construct( Request $request, Environment $env ) {

		$this->messages = [
			'reset-success' => [ __( 'Poll has been reset', 'totalpoll' ), 'updated' ],
			'reset-error'   => [ __( 'Poll reset failed', 'totalpoll' ), 'error' ]
		];

		// TotalPoll Request
		$this->request = $request;

		$this->env = $env;
		// TotalPoll Pages
		$this->pages = [
			'dashboard'  => [
				'title'      => __( 'Dashboard', 'totalpoll' ),
				'name'       => __( 'Dashboard', 'totalpoll' ),
				'capability' => 'manage_options',
			],
			'entries'    => [
				'title'      => __( 'Entries', 'totalpoll' ),
				'name'       => __( 'Entries', 'totalpoll' ),
				'capability' => 'edit_polls',
			],
			'insights'   => [
				'title'      => __( 'Insights', 'totalpoll' ),
				'name'       => __( 'Insights', 'totalpoll' ),
				'capability' => 'edit_polls',
			],
			'log'        => [
				'title'      => __( 'Log', 'totalpoll' ),
				'name'       => __( 'Logs', 'totalpoll' ),
				'capability' => 'manage_options',
			],
			'templates'  => [
				'title'      => __( 'Templates', 'totalpoll' ),
				'name'       => __( 'Templates', 'totalpoll' ),
				'capability' => 'manage_options',
			],
			'extensions' => [
				'title'      => __( 'Extensions', 'totalpoll' ),
				'name'       => __( 'Extensions', 'totalpoll' ),
				'capability' => 'manage_options',
			],
			'options'    => [
				'title'      => __( 'Options', 'totalpoll' ),
				'name'       => __( 'Options', 'totalpoll' ),
				'capability' => 'manage_options',
			],
			
			'upgrade-to-pro' => [
				'title'      => __( 'Upgrade to Pro', 'totalpoll' ),
				'name'       => __( 'Upgrade to Pro', 'totalpoll' ),
				'capability' => 'manage_options',
			],
			
		];
		// Requested page
		$this->requestedPage = $request->request( 'page' );

		// Hook into WordPress menu and screen
		add_action( 'current_screen', [ $this, 'screen' ] );
		add_action( 'admin_menu', [ $this, 'menu' ] );
		add_filter( 'admin_body_class', [ $this, 'directionClass' ] );

		// Display the page, if present
		if ( $GLOBALS['pagenow'] === 'edit.php' && $request->request( 'post_type' ) === TP_POLL_CPT_NAME ):
			if ( array_key_exists( $this->requestedPage, $this->pages ) ):
				$this->currentPage = TotalPoll( "admin.pages.{$this->requestedPage}" );
			endif;
		endif;

		// Notice
		add_action( 'admin_notices', [ $this, 'showMessages' ] );
		// Cleanup
		add_action( 'before_delete_post', [ $this, 'pollCleanup' ] );

		add_action( 'admin_post_reset_poll', [ $this, 'resetPoll' ] );
		/**
		 * Fires when admin is bootstrapped.
		 *
		 * @since 4.0.0
		 * @order 10
		 */
		do_action( 'totalpoll/actions/bootstrap-admin' );
	}

	/**
	 * Register admin assets.
	 */
	public function registerAssets() {
		// Add a dynamic part to assets URL when debugging to prevent cache.
		$assetsVersion = WP_DEBUG ? time() : $this->env['version'];
		$baseUrl       = $this->env['url'];

		// ------------------------------
		// Vendor
		// ------------------------------
		wp_register_script( 'angular', "{$baseUrl}assets/dist/scripts/vendor/angular.min.js", $assetsVersion );
		wp_register_script( 'angular-resource', "{$baseUrl}assets/dist/scripts/vendor/angular-resource.min.js", [ 'angular' ], $assetsVersion );
		wp_register_script( 'angular-file-input', "{$baseUrl}assets/dist/scripts/vendor/ng-file-input.min.js", [ 'angular' ], $assetsVersion );
		wp_register_script( 'angular-dnd-lists', "{$baseUrl}assets/dist/scripts/vendor/angular-drag-and-drop-lists.min.js", [ 'angular' ], $assetsVersion );
		wp_register_script( 'jquery-datetimepicker', "{$baseUrl}assets/dist/scripts/vendor/jquery.datetimepicker.full.min.js", [ 'jquery' ], $assetsVersion );
		wp_register_script( 'platform.js', "{$baseUrl}assets/dist/scripts/vendor/platform.js", [ 'angular' ], $assetsVersion );
		wp_register_script( 'chart.js', "{$baseUrl}assets/dist/scripts/vendor/Chart.min.js", [ 'angular' ], $assetsVersion );
		wp_register_style( 'jquery-datetimepicker', "{$baseUrl}assets/dist/styles/vendor/datetimepicker.css", [], $assetsVersion );
		/**
		 * @asset-style totalpoll-admin-totalcore
		 */
		wp_register_style(
			'totalpoll-admin-totalcore',
			"{$baseUrl}assets/dist/styles/admin-totalcore.css",
			[],
			$assetsVersion
		);
		// ------------------------------
		// Dashboard
		// ------------------------------
		/**
		 * @asset-script totalpoll-admin-dashboard
		 */
		wp_register_script(
			'totalpoll-admin-dashboard',
			"{$baseUrl}assets/dist/scripts/dashboard.js",
			[ 'angular', 'angular-resource' ],
			$assetsVersion
		);
		/**
		 * @asset-style totalpoll-admin-dashboard
		 */
		wp_register_style(
			'totalpoll-admin-dashboard',
			"{$baseUrl}assets/dist/styles/admin-dashboard.css",
			[ 'totalpoll-admin-totalcore' ],
			$assetsVersion
		);

		// ------------------------------
		// Editor
		// ------------------------------
		/**
		 * @asset-script totalpoll-admin-poll-editor
		 */
		wp_register_script(
			'totalpoll-admin-poll-editor',
			"{$baseUrl}assets/dist/scripts/poll-editor.js",
			[
				'wp-color-picker',
				'jquery-datetimepicker',
				'media-views',
				'angular',
				'angular-resource',
				'angular-dnd-lists'
			],
			$assetsVersion
		);
		/**
		 * @asset-style totalpoll-admin-poll-editor
		 */
		wp_register_style(
			'totalpoll-admin-poll-editor',
			"{$baseUrl}assets/dist/styles/admin-poll-editor.css",
			[ 'wp-color-picker', 'jquery-datetimepicker', 'totalpoll-admin-totalcore' ],
			$assetsVersion
		);

		// ------------------------------
		// Polls listing
		// ------------------------------
		/**
		 * @asset-style totalpoll-admin-listing
		 */
		wp_register_style(
			'totalpoll-admin-poll-listing',
			"{$baseUrl}assets/dist/styles/admin-poll-listing.css",
			[],
			$assetsVersion
		);

		// ------------------------------
		// Entries
		// ------------------------------
		/**
		 * @asset-script totalpoll-admin-entries
		 */
		wp_register_script(
			'totalpoll-admin-entries',
			"{$baseUrl}assets/dist/scripts/entries.js",
			[ 'jquery-datetimepicker', 'angular', 'angular-resource', 'platform.js' ],
			$assetsVersion
		);
		/**
		 * @asset-style totalpoll-admin-entries
		 */
		wp_register_style(
			'totalpoll-admin-entries',
			"{$baseUrl}assets/dist/styles/admin-entries.css",
			[ 'jquery-datetimepicker', 'totalpoll-admin-totalcore' ],
			$assetsVersion
		);

		// ------------------------------
		// Insights
		// ------------------------------
		/**
		 * @asset-script totalpoll-admin-insights
		 */
		wp_register_script(
			'totalpoll-admin-insights',
			"{$baseUrl}assets/dist/scripts/insights.js",
			[ 'jquery-datetimepicker', 'angular', 'angular-resource', 'platform.js', 'chart.js' ],
			$assetsVersion
		);
		/**
		 * @asset-style totalpoll-admin-insights
		 */
		wp_register_style(
			'totalpoll-admin-insights',
			"{$baseUrl}assets/dist/styles/admin-insights.css",
			[ 'jquery-datetimepicker', 'totalpoll-admin-totalcore' ],
			$assetsVersion
		);

		// ------------------------------
		// Log
		// ------------------------------
		/**
		 * @asset-script totalpoll-admin-log
		 */
		wp_register_script( 'totalpoll-admin-log',
			"{$baseUrl}assets/dist/scripts/log.js",
			[ 'jquery-datetimepicker', 'angular', 'angular-resource', 'platform.js' ],
			$assetsVersion
		);
		/**
		 * @asset-style totalpoll-admin-log
		 */
		wp_register_style(
			'totalpoll-admin-log',
			"{$baseUrl}assets/dist/styles/admin-log.css",
			[ 'jquery-datetimepicker', 'totalpoll-admin-totalcore' ],
			$assetsVersion
		);

		// ------------------------------
		// Modules
		// ------------------------------
		/**
		 * @asset-script totalpoll-admin-modules
		 */
		wp_register_script(
			'totalpoll-admin-modules',
			"{$baseUrl}assets/dist/scripts/modules.js",
			[ 'angular', 'angular-resource', 'angular-file-input' ],
			$assetsVersion
		);
		/**
		 * @asset-style totalpoll-admin-modules
		 */
		wp_register_style(
			'totalpoll-admin-modules',
			"{$baseUrl}assets/dist/styles/admin-modules.css",
			[ 'totalpoll-admin-totalcore' ],
			$assetsVersion
		);

		// ------------------------------
		// Options
		// ------------------------------
		/**
		 * @asset-script totalpoll-admin-options
		 */
		wp_register_script(
			'totalpoll-admin-options',
			"{$baseUrl}assets/dist/scripts/options.js",
			[ 'angular', 'angular-resource' ],
			$assetsVersion
		);
		/**
		 * @asset-script totalpoll-admin-options
		 */
		wp_register_style(
			'totalpoll-admin-options',
			"{$baseUrl}assets/dist/styles/admin-options.css",
			[ 'totalpoll-admin-totalcore' ],
			$assetsVersion
		);

		
		// ------------------------------
		// Upgrade to pro
		// ------------------------------
		/**
		 * @asset-script totalpoll-admin-options
		 */
		wp_register_style(
			'totalpoll-admin-upgrade-to-pro',
			"{$baseUrl}assets/dist/styles/admin-upgrade-to-pro.css",
			[ 'totalpoll-admin-totalcore' ],
			$assetsVersion
		);
		
	}

	/**
	 * Poll screens.
	 */
	public function screen() {
		$isTotalPoll    = $GLOBALS['current_screen']->post_type === TP_POLL_CPT_NAME;
		$isEditor       = $GLOBALS['current_screen']->base === 'post' && $isTotalPoll;
		$isPollsListing = $GLOBALS['current_screen']->base === 'edit' && $isTotalPoll;

		if ( $isTotalPoll ):
			// Register assets
			$this->registerAssets();

			add_filter( 'admin_footer_text', [ $this, 'footerText' ] );
			add_filter( 'update_footer', [ $this, 'footerVersion' ] );
		endif;

		if ( $isEditor ):
			TotalPoll( 'admin.poll.editor' );
		elseif ( $isPollsListing ):
			TotalPoll( 'admin.poll.listing' );
		endif;
	}

	/**
	 * Admin menu.
	 * @action-callback admin_menu
	 */
	public function menu() {
		$slug = 'edit.php?post_type=' . TP_POLL_CPT_NAME;

		foreach ( $this->pages as $pageSlug => $page ):
			add_submenu_page(
				$slug,
				$page['title'],
				$page['name'],
				empty( $page['capability'] ) ? 'manage_options' : $page['capability'],
				$pageSlug,
				[ $this, 'page' ]
			);
		endforeach;

		add_filter( 'parent_file', function ( $file ) use ( $slug ) {
			foreach ( $GLOBALS['submenu'][ $slug ] as $itemIndex => $item ):
				if ( $item[2] === 'dashboard' ):
					unset( $GLOBALS['submenu'][ $slug ][ $itemIndex ] );
					array_unshift( $GLOBALS['submenu'][ $slug ], $item );
				endif;
			endforeach;

			$pages = array_keys( $this->pages );
			foreach ( $GLOBALS['submenu'][ $slug ] as $index => $item ):
				if ( in_array( $item[2], $pages, true ) ):
					$GLOBALS['submenu'][ $slug ][ $index ][4] = ! empty( $GLOBALS['plugin_page'] ) && $GLOBALS['plugin_page'] === $item[2] && $GLOBALS['typenow'] === TP_POLL_CPT_NAME ? 'current' : '';
					$GLOBALS['submenu'][ $slug ][ $index ][2] = add_query_arg( [ 'page' => $item[2] ], $slug );
				endif;
			endforeach;

			return $file;
		} );
	}

	/**
	 * Footer text.
	 *
	 * @action-callback admin_footer_text
	 * @return string
	 */
	public function footerText() {
		$text = __( '{{product}} is part of <a href="{{totalsuite}}" target="_blank">TotalSuite</a>, a suite of robust and maintained plugins for WordPress.', 'totalpoll' );

		return Strings::template(
			$text,
			[
				'product'    => $this->env['name'],
				'totalsuite' => add_query_arg(
					[
						'utm_source'   => 'in-app',
						'utm_medium'   => 'footer',
						'utm_campaign' => 'totalpoll',
					],
					$this->env['links.totalsuite']
				),
			]
		);
	}

	/**
	 * Footer version.
	 *
	 * @action-callback update_footer
	 * @return string
	 */
	public function footerVersion() {
		return "{$this->env['name']} {$this->env['version']}";
	}

	/**
	 * Render current page.
	 */
	public function page() {
		echo $this->currentPage;
	}

	/**
	 * Add direction (rtl|ltr) to body css classes.
	 *
	 * @param $classes
	 *
	 * @return string
	 */
	public function directionClass( $classes ) {
		return $classes . ( is_rtl() ? 'is-rtl' : ' is-ltr' );
	}

	/**
	 * @param $postId
	 */
	public function pollCleanup( $postId ) {
		$post = get_post( $postId );

		if ( $post && $post->post_type == TP_POLL_CPT_NAME ):
			TotalPoll( 'log.repository' )->delete( [ 'poll_id' => $postId ] );
			TotalPoll( 'entries.repository' )->delete( [ 'poll_id' => $postId ] );
			TotalPoll( 'polls.repository' )->deleteVotes( [ 'poll_id' => $postId ] );
		endif;
	}

	/**
	 * Reset Poll
	 */
	function resetPoll() {
		$poll = $this->request->query( 'poll', 0 );
		$url  = wp_get_referer();

		if ( check_admin_referer( 'reset_poll' ) ) {
			$this->pollCleanup( $poll );
			$url = add_query_arg( 'message', 'reset-success', $url );
		} else {
			$url = add_query_arg( 'message', 'reset-error', $url );
		}
		wp_redirect( $url );
		exit();
	}

	/**
	 * Show admin messages / admin notice hook.
	 */
	function showMessages() {
		$message = $this->request->query( 'message' );

		if ( array_key_exists( $message, $this->messages ) ) {
			list( $content, $type ) = $this->messages[ $message ];
			printf( '<div class="notice %s"><p>%s</p></div>', $type, $content );
		}
	}
}
