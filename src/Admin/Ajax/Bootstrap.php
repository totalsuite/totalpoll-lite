<?php

namespace TotalPoll\Admin\Ajax;

/**
 * Class Bootstrap
 * @package TotalPoll\Admin\Ajax
 * @since   1.0.0
 */
class Bootstrap {

	/**
	 * Attach ajax actions to their appropriate callbacks.
	 */
	public function __construct() {
		if ( current_user_can( 'edit_polls' ) ):
			// ------------------------------
			// Polls
			// ------------------------------
			/**
			 * @action wp_ajax_totalpoll_polls_add_to_sidebar
			 * @since  4.0.0
			 */
			add_action( 'wp_ajax_totalpoll_polls_add_to_sidebar', function () {
				TotalPoll( 'admin.ajax.polls' )->addToSidebar();
			} );

			// ------------------------------
			// Entries
			// ------------------------------
			/**
			 * @action wp_ajax_totalpoll_entries_list
			 * @since  4.0.0
			 */
			add_action( 'wp_ajax_totalpoll_entries_list', function () {
				TotalPoll( 'admin.ajax.entries' )->fetch();
			} );
			/**
			 * @action wp_ajax_totalpoll_entries_download
			 * @since  4.0.0
			 */
			add_action( 'wp_ajax_totalpoll_entries_download', function () {
				TotalPoll( 'admin.ajax.entries' )->download();
			} );

			/**
			 * @action wp_ajax_totalpoll_entries_polls
			 * @since  4.0.0
			 */
			add_action( 'wp_ajax_totalpoll_entries_polls', function () {
				TotalPoll( 'admin.ajax.entries' )->polls();
			} );

			// ------------------------------
			// Insights
			// ------------------------------
			/**
			 * @action wp_ajax_totalpoll_insights_metrics
			 * @since  4.0.0
			 */
			add_action( 'wp_ajax_totalpoll_insights_metrics', function () {
				TotalPoll( 'admin.ajax.insights' )->metrics();
			} );
			/**
			 * @action wp_ajax_totalpoll_insights_polls
			 * @since  4.0.0
			 */
			add_action( 'wp_ajax_totalpoll_insights_polls', function () {
				TotalPoll( 'admin.ajax.insights' )->polls();
			} );

            /**
             * @action wp_ajax_totalpoll_insights_download
             * @since  4.0.0
             */
            add_action( 'wp_ajax_totalpoll_insights_download', function () {
                TotalPoll( 'admin.ajax.insights' )->download();
            } );
		endif;
		if ( current_user_can( 'manage_options' ) ):
			// ------------------------------
			// Dashboard
			// ------------------------------
			/**
			 * @action wp_ajax_totalpoll_dashboard_activate
			 * @since  4.0.0
			 */
			add_action( 'wp_ajax_totalpoll_dashboard_activate', function () {
				TotalPoll( 'admin.ajax.dashboard' )->activate();
			} );
			/**
			 * @action wp_ajax_totalpoll_dashboard_account
			 * @since  4.0.0
			 */
			add_action( 'wp_ajax_totalpoll_dashboard_account', function () {
				TotalPoll( 'admin.ajax.dashboard' )->account();
			} );
			/**
			 * @action wp_ajax_totalpoll_dashboard_polls_overview
			 * @since  4.0.0
			 */
			add_action( 'wp_ajax_totalpoll_dashboard_polls_overview', function () {
				TotalPoll( 'admin.ajax.dashboard' )->polls();
			} );

			// ------------------------------
			// Log
			// ------------------------------
			/**
			 * @action wp_ajax_totalpoll_log_list
			 * @since  4.0.0
			 */
			add_action( 'wp_ajax_totalpoll_log_list', function () {
				TotalPoll( 'admin.ajax.log' )->fetch();
			} );
			/**
			 * @action wp_ajax_totalpoll_log_download
			 * @since  4.0.0
			 */
			add_action( 'wp_ajax_totalpoll_log_download', function () {
				TotalPoll( 'admin.ajax.log' )->download();
			} );

			// ------------------------------
			// Modules
			// ------------------------------
			/**
			 * @action wp_ajax_totalpoll_modules_install_from_file
			 * @since  4.0.0
			 */
			add_action( 'wp_ajax_totalpoll_modules_install_from_file', function () {
				TotalPoll( 'admin.ajax.modules' )->installFromFile();
			} );
			/**
			 * @action wp_ajax_totalpoll_modules_install_from_store
			 * @since  4.0.0
			 */
			add_action( 'wp_ajax_totalpoll_modules_install_from_store', function () {
				TotalPoll( 'admin.ajax.modules' )->installFromStore();
			} );
			/**
			 * @action wp_ajax_totalpoll_modules_list
			 * @since  4.0.0
			 */
			add_action( 'wp_ajax_totalpoll_modules_list', function () {
				try {
					TotalPoll( 'admin.ajax.modules' )->fetch();
				} catch ( \Exception $exception ) {
					wp_send_json_error( $exception );
				}
			} );
			/**
			 * @action wp_ajax_totalpoll_modules_update
			 * @since  4.0.0
			 */
			add_action( 'wp_ajax_totalpoll_modules_update', function () {
				TotalPoll( 'admin.ajax.modules' )->update();
			} );
			/**
			 * @action wp_ajax_totalpoll_modules_uninstall
			 * @since  4.0.0
			 */
			add_action( 'wp_ajax_totalpoll_modules_uninstall', function () {
				TotalPoll( 'admin.ajax.modules' )->uninstall();
			} );
			/**
			 * @action wp_ajax_totalpoll_modules_activate
			 * @since  4.0.0
			 */
			add_action( 'wp_ajax_totalpoll_modules_activate', function () {
				TotalPoll( 'admin.ajax.modules' )->activate();
			} );
			/**
			 * @action wp_ajax_totalpoll_modules_deactivate
			 * @since  4.0.0
			 */
			add_action( 'wp_ajax_totalpoll_modules_deactivate', function () {
				TotalPoll( 'admin.ajax.modules' )->deactivate();
			} );

			// ------------------------------
			// Options
			// ------------------------------
			add_action( 'wp_ajax_totalpoll_options_save_options', function () {
				TotalPoll( 'admin.ajax.options' )->saveOptions();
			} );
			add_action( 'wp_ajax_totalpoll_options_purge', function () {
				TotalPoll( 'admin.ajax.options' )->purge();
			} );
			add_action( 'wp_ajax_totalpoll_options_migrate_polls', function () {
				TotalPoll( 'admin.ajax.options' )->migratePolls();
			} );
		endif;

		// ------------------------------
		// Templates
		// ------------------------------
		/**
		 * @action wp_ajax_totalpoll_templates_get_defaults
		 * @since  4.0.0
		 */
		add_action( 'wp_ajax_totalpoll_templates_get_defaults', function () {
			TotalPoll( 'admin.ajax.templates' )->getDefaults();
		} );
		/**
		 * @action wp_ajax_totalpoll_templates_get_preview
		 * @since  4.0.0
		 */
		add_action( 'wp_ajax_totalpoll_templates_get_preview', function () {
			TotalPoll( 'admin.ajax.templates' )->getPreview();
		} );
		/**
		 * @action wp_ajax_totalpoll_templates_get_settings
		 * @since  4.0.0
		 */
		add_action( 'wp_ajax_totalpoll_templates_get_settings', function () {
			TotalPoll( 'admin.ajax.templates' )->getSettings();
		} );

		/**
		 * Fires when AJAX handlers are bootstrapped.
		 *
		 * @since 4.0.0
		 * @order 7
		 */
		do_action( 'totalpoll/actions/bootstrap-ajax' );
	}

}