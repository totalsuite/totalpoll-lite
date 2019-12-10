<?php

namespace TotalPollVendors\TotalCore\Admin;

use TotalPollVendors\TotalCore\Contracts\Admin\Activation as ActivationContract;
use TotalPollVendors\TotalCore\Contracts\Foundation\Environment as EnvironmentContract;
use TotalPollVendors\TotalCore\Helpers\Strings;

/**
 * Class Updates
 * @package TotalPollVendors\TotalCore\Admin
 */
class Updates {
	/**
	 * @var ActivationContract
	 */
	protected $activation;
	/**
	 * @var EnvironmentContract
	 */
	protected $env;

	/**
	 * Updates constructor.
	 *
	 * @param ActivationContract  $activation
	 * @param EnvironmentContract $env
	 */
	public function __construct( ActivationContract $activation, EnvironmentContract $env ) {
		$this->activation = $activation;
		$this->env        = $env;

		$this->registerHooks();
	}

	/**
	 * Register required hooks.
	 */
	public function registerHooks() {
		// Transient filter
		add_filter( 'pre_set_site_transient_update_plugins', [ $this, 'checkUpdates' ] );
		// Get information
		add_filter( 'plugins_api', [ $this, 'getInformation' ], 10, 3 );
		// Activation message
		if ( ! $this->activation->getLicenseStatus() ):
			add_action( "in_plugin_update_message-{$this->env['basename']}", [ $this, 'inlineMessage' ] );
		endif;
	}

	/**
	 * Filter transient to show update details.
	 *
	 * @param $transient
	 *
	 * @return mixed
	 */
	public function checkUpdates( $transient ) {
		if ( ! empty( $transient->response ) || ! empty( $transient->checked ) ):

			$update = $this->getLastUpdate();

			if ( isset( $update->new_version ) && version_compare( $update->new_version, $this->env['version'], '>' ) ):
				$update->package                        = str_replace( [ '__KEY__', '__DOMAIN__' ], [
					$this->activation->getLicenseKey(),
					$this->env['domain'],
				], $update->package );
				$transient->response[ $update->plugin ] = $update;

				if ( isset( $transient->no_update[ $update->plugin ] ) ) :
					unset( $transient->no_update[ $update->plugin ] );
				endif;
			endif;

		endif;

		return $transient;
	}

	/**
	 * Get last update.
	 *
	 * @return array|mixed|object
	 */
	public function getLastUpdate() {
		$args = [
			'license' => $this->activation->getLicenseKey(),
			'domain'  => $this->env['domain'],
			'version' => $this->env['version'],
			'env'     => $this->env['versions'],
		];

		$apiEndpoint = Strings::template( $this->env['api']['update'], $args );
		$apiEndpoint = add_query_arg( $args, $apiEndpoint );

		return (object) json_decode( wp_remote_retrieve_body( wp_remote_get( $apiEndpoint ) ), true );
	}

	/**
	 * Get update information.
	 *
	 * @param $false
	 * @param $action
	 * @param $response
	 *
	 * @return array|bool|mixed|object
	 */
	public function getInformation( $false, $action, $response ) {
		if ( $action === 'plugin_information' && $response->slug === $this->env['slug'] ):
			$update = $this->getLastUpdate();

			return $update;
		endif;

		return false;
	}

	/**
	 * Inline message for update.
	 *
	 * @param array $package
	 */
	public function inlineMessage( $package ) {
		printf(
			'<span style="display: block;border: 1px solid black;background: white;padding: 0.35rem 0.5rem;margin: 1rem 0 0.5rem;"><span class="dashicons dashicons-warning"></span>&nbsp;&nbsp;%s</span>',
			sprintf( __( 'You need to <a href="%s">enter your license key</a> in order to apply updates.', \TotalPollVendors\TotalCore\Application::getInstance()->env( 'slug' ) ), \TotalPollVendors\TotalCore\Application::getInstance()->env( 'links.activation', '#' ) )
		);
	}
}