<?php

namespace TotalPoll\Modules\Extensions\Troubleshooter\Checks;

/**
 * Class RecommendedExtensions
 * @package TotalPoll\Modules\Extensions\Troubleshooter\Checks
 */
class RecommendedExtensions extends Checkup {

	/**
	 * Get checkup name.
	 *
	 * @return string
	 */
	public function getName() {
		return __( 'Recommended extensions', 'totalpoll' );
	}

	/**
	 * Get checkup description.
	 *
	 * @return string
	 */
	public function getDescription() {
		return __( 'Check if recommended PHP extensions are installed.', 'totalpoll' );
	}

	/**
	 * @return void
	 */
	public function check() {
		if ( ! extension_loaded( 'mbstring' ) ):
			$this->addWarning(
				__( 'mbstring is not enabled. A polyfill will be used instead.', 'totalpoll' )
			);
		endif;

		if ( ! function_exists( 'curl_init' ) ):
			$this->addWarning(
				__( 'curl is not enabled. A polyfill will be used instead.', 'totalpoll' )
			);
		endif;

		if ( ! extension_loaded( 'json' ) ):
			$this->addWarning(
				__( 'json is not enabled. A polyfill will be used instead.', 'totalpoll' )
			);
		endif;

		if ( ! extension_loaded( 'json' ) ):
			$this->addWarning(
				__( 'json is not enabled. A polyfill will be used instead.', 'totalpoll' )
			);
		endif;
	}

}