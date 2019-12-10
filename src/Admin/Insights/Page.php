<?php

namespace TotalPoll\Admin\Insights;

use TotalPollVendors\TotalCore\Admin\Pages\Page as TotalCoreAdminPage;

/**
 * Class Page
 * @package TotalPoll\Admin\Insights
 */
class Page extends TotalCoreAdminPage {

	/**
	 * Page assets.
	 */
	public function assets() {
		
	}

	/**
	 * Page content.
	 */
	public function render() {
		include __DIR__ . '/views/index.php';
	}
}
