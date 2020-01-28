<?php
/*
 * Plugin Name: TotalPoll – Lite
 * Plugin URI: https://totalsuite.net/products/totalpoll/
 * Description: Yet another powerful poll plugin for WordPress.
 * Version: 4.1.3
 * Author: TotalSuite
 * Author URI: https://totalsuite.net/
 * Text Domain: totalpoll
 * Domain Path: languages
 * Requires at least: 4.6
 * Requires PHP: 5.5
 * Tested up to: 5.3.2
 *
 * @package TotalPoll
 * @category Core
 * @author TotalSuite
 * @version 4.1.3
 */

// Root plugin file name
define( 'TOTALPOLL_ROOT', __FILE__ );

// TotalPoll environment
$environment = require dirname( __FILE__ ) . '/env.php';

// Include plugin setup
require_once dirname( __FILE__ ) . '/setup.php';

// Setup
new TotalPollSetup( $environment );

// Oh yeah, we're up and running!
