<?php

// Uploads path
$upload = wp_upload_dir();

// TotalPoll environment
return apply_filters(
	'totalpoll/filters/environment',
	array(
		'name'           => 'TotalPoll',
		'version'        => '4.1.1',
		'versions'       => array(
			'wp'    => $GLOBALS['wp_version'],
			'php'   => PHP_VERSION,
			'mysql' => $GLOBALS['wpdb']->db_version(),
		),
		'textdomain'     => 'totalpoll',
		'domain'         => $_SERVER['SERVER_NAME'],
		'root'           => TOTALPOLL_ROOT,
		'path'           => plugin_dir_path( TOTALPOLL_ROOT ),
		'url'            => plugin_dir_url( TOTALPOLL_ROOT ),
		'basename'       => plugin_basename( TOTALPOLL_ROOT ),
		'rest-namespace' => 'totalpoll/v4',
		'namespace'      => 'TotalPoll',
		'dirname'        => dirname( plugin_basename( TOTALPOLL_ROOT ) ),
		'cache'          => array(
			'path' => WP_CONTENT_DIR . '/cache/totalpoll/',
			'url'  => content_url( '/cache/totalpoll/' ),
		),
		'slug'           => 'totalpoll',
		'prefix'         => 'totalpoll_',
		'short-prefix'   => 'tp_',
		'options-key'    => 'totalpoll_options_repository',
		'db'             => array(
			'version'    => '400',
			'option-key' => 'totalpoll_db_version',
			'tables'     => array(
				'log'     => $GLOBALS['wpdb']->prefix . 'totalpoll_log',
				'votes'   => $GLOBALS['wpdb']->prefix . 'totalpoll_votes',
				'entries' => $GLOBALS['wpdb']->prefix . 'totalpoll_entries',
			),
			'prefix'     => (string) $GLOBALS['wpdb']->prefix,
			'charset'    => (string) $GLOBALS['wpdb']->get_charset_collate(),
		),
		'api'            => array(
			'update'             => 'https://totalsuite.net/api/v1/products/totalpoll/update/',
			'store'              => 'https://totalsuite.net/api/v1/products/totalpoll/store/{{license}}/',
			'activation'         => 'https://totalsuite.net/api/v1/products/totalpoll/activate/',
			'check-access-token' => 'https://totalsuite.net/api/v1/users/check/',
		),
		'links'          => array(
			'activation'     => admin_url( 'edit.php?post_type=poll&page=dashboard&tab=dashboard>activation' ),
			'my-account'     => admin_url( 'edit.php?post_type=poll&page=dashboard&tab=dashboard>my-account' ),
			'upgrade-to-pro' => admin_url( 'edit.php?post_type=poll&page=upgrade-to-pro' ),
			'signin-account' => 'https://totalsuite.net/ext/auth/signin',
			'changelog'      => 'https://totalsuite.net/product/totalpoll/changelog/#version-4.1.0',
			'website'        => 'https://totalsuite.net/product/totalpoll/',
			'support'        => 'https://totalsuite.net/support/',
			'customization'  => 'https://totalsuite.net/services/new/?department=25',
			'translate'      => 'https://totalsuite.net/translate/',
			'search'         => 'https://totalsuite.net/search/',
			'forums'         => 'https://totalsuite.net/forums/',
			'totalsuite'     => 'https://totalsuite.net/',
			'subscribe'      => 'https://subscribe.misqtech.com/totalsuite/',
			'twitter'        => 'https://twitter.com/totalsuite',
			'facebook'       => 'https://fb.me/totalsuite',
			'youtube'        => 'https://www.youtube.com/channel/UCp44ZQMpZhBB6chpKWoeEOw/',
		),
		'requirements'   => array(
			'wp'    => '4.6',
			'php'   => '5.5',
			'mysql' => '5.5',
		),
		'recommended'    => array(
			'wp'    => '5.0',
			'php'   => '7.0',
			'mysql' => '8.0',
		),
		'autoload'       => array(
			'loader' => dirname( TOTALPOLL_ROOT ) . '/vendor/autoload.php',
			'psr4'   => array(
				"TotalPoll\\Modules\\Templates\\"  => array(
					trailingslashit( $upload['basedir'] . '/totalpoll/templates/' ),
					dirname( TOTALPOLL_ROOT ) . '/modules/templates',
				),
				"TotalPoll\\Modules\\Extensions\\" => array(
					trailingslashit( $upload['basedir'] . '/totalpoll/extensions/' ),
					dirname( TOTALPOLL_ROOT ) . '/modules/extensions',
				),
			),
		),
	)
);
