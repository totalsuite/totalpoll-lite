<?php

namespace TotalPoll\Admin\Log;

use TotalPollVendors\TotalCore\Admin\Pages\Page as TotalCoreAdminPage;

/**
 * Class Page
 * @package TotalPoll\Admin\Log
 */
class Page extends TotalCoreAdminPage {
	/**
	 * Page assets.
	 */
	public function assets() {
		/**
		 * @asset-script totalpoll-admin-log
		 */
		wp_enqueue_script( 'totalpoll-admin-log' );
		/**
		 * @asset-style totalpoll-admin-log
		 */
		wp_enqueue_style( 'totalpoll-admin-log' );

		// Some variables for frontend controller
		wp_localize_script(
			'totalpoll-admin-log',
			'TotalPollLog',
			[ 'pollId' => $this->request->query( 'poll' ) ]
		);
	}

	/**
	 * Page content.
	 */
	public function render() {
		/**
		 * Filters the list of columns in log browser.
		 *
		 * @param array $columns Array of columns.
		 *
		 * @return array
		 * @since 4.0.0
		 */
		$columns = apply_filters(
			'totalpoll/filters/admin/log/columns',
			[
				'status'     => [ 'label' => __( 'Status', 'totalpoll' ), 'default' => true, ],
				'action'     => [ 'label' => __( 'Action', 'totalpoll' ), 'default' => true, ],
				'date'       => [ 'label' => __( 'Date', 'totalpoll' ), 'default' => true, ],
				'ip'         => [ 'label' => __( 'IP', 'totalpoll' ), 'default' => true, ],
				'browser'    => [ 'label' => __( 'Browser', 'totalpoll' ), 'default' => true, ],
				'poll'       => [ 'label' => __( 'Poll', 'totalpoll' ), 'default' => true, ],
				'user_name'  => [ 'label' => __( 'User name', 'totalpoll' ), 'default' => false, ],
				'user_id'    => [ 'label' => __( 'User ID', 'totalpoll' ), 'default' => false, ],
				'user_login' => [ 'label' => __( 'User login', 'totalpoll' ), 'default' => true, ],
				'user_email' => [ 'label' => __( 'User email', 'totalpoll' ), 'default' => false, ],
				'details'    => [ 'label' => __( 'Details', 'totalpoll' ), 'default' => false, 'compact' => true ],
			]
		);
		/**
		 *
		 * Filters the list of available formats that can be used for export.
		 *
		 * @param array $formats Array of formats [id => label].
		 *
		 * @return array
		 * @since 4.0.0
		 */
		$formats = apply_filters(
			'totalpoll/filters/admin/log/formats',
			[
				'html' => __( 'HTML', 'totalpoll' ),
				
			]
		);

		include __DIR__ . '/views/index.php';
	}
}
