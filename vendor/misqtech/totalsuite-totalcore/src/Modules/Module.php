<?php

namespace TotalPollVendors\TotalCore\Modules;


use TotalPollVendors\TotalCore\Contracts\Modules\Module as ModuleContract;
use TotalPollVendors\TotalCore\Helpers\Arrays;

/**
 * Class Module
 * @package TotalPollVendors\TotalCore\Modules
 */
abstract class Module implements ModuleContract {
	/**
	 * @var array $options
	 */
	public $options = [];
	/**
	 * @var string $textdomain
	 */
	public $textdomain = '';
	/**
	 * @var string $root
	 */
	protected $root = __FILE__;
	/**
	 * @var string $path
	 */
	protected $path = __DIR__;
	/**
	 * @var string $url
	 */
	protected $url = '';

	/**
	 * Module constructor.
	 *
	 * @param array $options
	 */
	public function __construct( $options = [] ) {
		$this->options = (array) $options;

		$this->path = str_replace( '\\', '/', dirname( $this->root ) . '/' );
		$this->url  = content_url( str_replace( str_replace( '\\', '/', WP_CONTENT_DIR ), '', $this->path ) );
	}

	/**
	 * On activation hook.
	 */
	public static function onActivate() {
		return;
	}

	/**
	 * On deactivation hook.
	 */
	public static function onDeactivate() {
		return;
	}

	/**
	 * On uninstall hook.
	 */
	public static function onUninstall() {
		return;
	}

	/**
	 * Get URL.
	 *
	 * @since 1.0.0
	 *
	 * @param string $relativePath relative path.
	 *
	 * @return bool true on success, false on failure.
	 */
	public function getUrl( $relativePath = '' ) {
		return $this->url . $relativePath;
	}

	/**
	 * Get path.
	 *
	 * @since 1.0.0
	 *
	 * @param string $relativePath relative path.
	 *
	 * @return bool true on success, false on failure.
	 */
	public function getPath( $relativePath = '' ) {
		return $this->path . $relativePath;
	}

	/**
	 * Load text domain.
	 *
	 * @since 1.0.0
	 * @return bool true on success, false on failure.
	 */
	public function loadTextdomain() {
		if ( ! empty( $this->textdomain ) ):
			$locale = apply_filters( 'plugin_locale', get_locale(), $this->textdomain );

			return load_textdomain( $this->textdomain, "{$this->path}/languages/{$this->textdomain}-{$locale}.mo" );
		endif;

		return false;
	}

	/**
	 * Get option.
	 *
	 * @param      $needle
	 * @param null $default
	 *
	 * @return mixed|null
	 */
	public function getOption( $needle, $default = null ) {
		return Arrays::getDotNotation( $this->options, $needle, $default );
	}

	/**
	 * Get options.
	 *
	 * @return array
	 */
	public function getOptions() {
		return $this->options;
	}
}