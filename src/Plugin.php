<?php

namespace TotalPoll;

use TotalPollVendors\TotalCore\Helpers\Misc;

/**
 * TotalPoll Plugin.
 * @package TotalPoll
 */
class Plugin extends \TotalPollVendors\TotalCore\Foundation\Plugin {

	public function registerProviders() {
		// Bootstrap
		$this->container->share( 'bootstrap', function () {
			return new Bootstrap();
		} );

		// Custom implementation of modules repository
		$this->container->share( 'modules.repository', function () {
			return new Modules\Repository( $this->container->get( 'env' ), $this->container->get( 'admin.activation' ), $this->container->get( 'admin.account' ) );
		} );

		// Poll post type
		$this->container->share( 'polls.cpt', function () {
			return new Poll\PostType();
		} );

		// Poll post defaults
		$this->container->add( 'polls.defaults', function () {
			return [
				'uid'           => Misc::generateUid(),
				'id'            => get_the_ID(),
				'questions'     => [],
				'fields'        => [],
				'vote'          => [
					'limitations' => [
						'region' => [
							'rules' => [],
						],
					],
					'frequency'   => [
						'cookies'    => [ 'enabled' => true ],
						'ip'         => [ 'enabled' => false ],
						'user'       => [ 'enabled' => false ],
						'perSession' => 1,
						'perUser'    => 1,
						'perIP'      => 1,
						'timeout'    => 3600,
					],
				],
				'choices'       => [
					'sort' => [
						'field'     => 'position',
						'direction' => 'ASC',
					],
				],
				'results'       => [
					'sort'          => [
						'field'     => 'votes',
						'direction' => 'DESC',
					],
					'visibility'    => 'all',
					'untilReaching' => null,
					'format'        => '{{votesPercentage}}',
				],
				'design'        => [
					'template'   => 'basic-template',
					'text'       => [
						'fontFamily' => 'inherit',
						'fontWeight' => 'inherit',
						'fontSize'   => 'inherit',
						'lineHeight' => 'inherit',
						'align'      => 'inherit',
						'transform'  => 'none',
					],
					'colors'     => [
						'primary'           => '#2196f3',
						'primaryContrast'   => '#ffffff',
						'primaryLighter'    => '#64b5f6',
						'primaryLight'      => '#42a5f5',
						'primaryDark'       => '#1e88e5',
						'primaryDarker'     => '#1976d2',
						'secondary'         => '#4caf50',
						'secondaryContrast' => '#ffffff',
						'secondaryLighter'  => '#a5d6a7',
						'secondaryLight'    => '#81c784',
						'secondaryDark'     => '#43a047',
						'secondaryDarker'   => '#388e3c',
						'accent'            => '#ffc107',
						'accentContrast'    => '#ffffff',
						'accentLighter'     => '#ffd54f',
						'accentLight'       => '#ffca28',
						'accentDark'        => '#ffb300',
						'accentDarker'      => '#ffa000',
						'dark'              => '#333333',
						'gray'              => '#dddddd',
						'grayContrast'      => '#333333',
						'grayLighter'       => '#fafafa',
						'grayLight'         => '#eeeeee',
						'grayDark'          => '#aaaaaa',
						'grayDarker'        => '#999999',
					],
					'layout'     => [
						'choicesPerRow'   => 1,
						'questionsPerRow' => 1,
						'maxWidth'        => '100%',
						'gutter'          => '1em',
						'radius'          => '0',
					],
					'custom'     => null,
					'behaviours' => [
						'ajax'     => true,
						'scrollUp' => true,
					],
					'effects'    => [
						'transition' => 'fade',
						'duration'   => '500',
					],
				],
				'notifications' => [
					'email' => [ 'recipient' => (string) get_option( 'admin_email' ), 'on' => [ 'newVote' => false ] ],
				],
				'meta'          => [
					'schema' => '1.0',
				],
			];
		} );

		// Poll shortcode
		$this->container->add( 'polls.shortcode', function ( $attributes, $content = null ) {
			return new Shortcodes\Poll( $attributes, $content );
		} );

		// Poll form
		$this->container->add( 'polls.form', function ( $poll ) {
			return new Poll\Form( $this->container->get( 'http.request' ), $this->container->get( 'form.factory' ), $poll );
		} );

		// Poll repository
		$this->container->share( 'polls.repository', function () {
			return new Poll\Repository( $this->container->get( 'http.request' ), $this->container->get( 'database' ), $this->container->get( 'env' ) );
		} );

		// Poll controller
		$this->container->share( 'poll.controller', function () {
			return new Poll\Controller( $this->container->get( 'http.request' ), $this->container->get( 'polls.repository' ) );
		} );

		// Poll render
		$this->container->add( 'polls.renderer', function ( $poll ) {
			return new Poll\Renderer( $poll, $this->container->get( 'modules.repository' ), $this->container->get( 'filesystem' ), $this->container->get( 'env' ) );
		} );

		// Poll commands - count vote
		$this->container->add( 'polls.commands.vote.count', function ( $poll ) {
			return new Poll\Commands\CountVote( $poll, $this->container->get( 'http.request' ), $this->container->get( 'polls.repository' ) );
		} );

		// Poll commands - log vote
		$this->container->add( 'polls.commands.vote.log', function ( $poll ) {
			return new Poll\Commands\LogVote( $poll, $this->container->get( 'log.repository' ) );
		} );

		// Poll commands - save entry
		$this->container->add( 'polls.commands.vote.entry', function ( $poll ) {
			return new Poll\Commands\SaveEntry( $poll, $this->container->get( 'entries.repository' ) );
		} );

		// Poll commands - notify
		$this->container->add( 'polls.commands.vote.notify', function ( $poll ) {
			return new Poll\Commands\SendNotifications( $poll );
		} );

		// Log repository
		$this->container->share( 'log.repository', function () {
			return new Log\Repository( $this->container->get( 'http.request' ), $this->container->get( 'database' ), $this->container->get( 'env' ) );
		} );

		// Entry repository
		$this->container->share( 'entries.repository', function () {
			return new Entry\Repository( $this->container->get( 'http.request' ), $this->container->get( 'database' ), $this->container->get( 'env' ) );
		} );

		// Admin bootstrap
		$this->container->share( 'admin.bootstrap', function () {
			return new Admin\Bootstrap( $this->container->get( 'http.request' ), $this->container->get( 'env' ) );
		} );

		// Admin ajax bootstrap
		$this->container->share( 'admin.ajax', function () {
			return new Admin\Ajax\Bootstrap();
		} );

		// Admin ajax (dashboard)
		$this->container->share( 'admin.ajax.dashboard', function () {
			return new Admin\Ajax\Dashboard( $this->container->get( 'http.request' ), $this->container->get( 'admin.activation' ), $this->container->get( 'admin.account' ), $this->container->get( 'polls.repository' ), $this->container->get( 'entries.repository' ) );
		} );

		// Admin ajax (log)
		$this->container->share( 'admin.ajax.log', function () {
			return new Admin\Ajax\Log( $this->container->get( 'http.request' ), $this->container->get( 'log.repository' ) );
		} );

		// Admin ajax (entries)
		$this->container->share( 'admin.ajax.entries', function () {
			return new Admin\Ajax\Entries( $this->container->get( 'http.request' ), $this->container->get( 'entries.repository' ) );
		} );

		// Admin ajax (insights)
		$this->container->share( 'admin.ajax.insights', function () {
			return new Admin\Ajax\Insights( $this->container->get( 'http.request' ), $this->container->get( 'log.repository' ), $this->container->get( 'polls.repository' ) );
		} );

		// Admin ajax (modules)
		$this->container->share( 'admin.ajax.modules', function () {
			return new Admin\Ajax\Modules( $this->container->get( 'http.request' ), $this->container->get( 'modules.manager' ) );
		} );

		// Admin ajax (options)
		$this->container->share( 'admin.ajax.options', function () {
			return new Admin\Ajax\Options( $this->container->get( 'http.request' ), $this->container->get( 'migrations.migrators' ) );
		} );

		// Admin ajax (polls)
		$this->container->share( 'admin.ajax.polls', function () {
			return new Admin\Ajax\Polls( $this->container->get( 'http.request' ) );
		} );

		// Admin ajax (templates)
		$this->container->share( 'admin.ajax.templates', function () {
			return new Admin\Ajax\Templates( $this->container->get( 'http.request' ), $this->container->get( 'modules.repository' ) );
		} );

		// Poll editor
		$this->container->share( 'admin.poll.editor', function () {
			return new Admin\Poll\Editor( $this->container->get( 'env' ), $this->container->get( 'filesystem' ), $this->container->get( 'polls.repository' ), $this->container->get( 'modules.repository' ) );
		} );

		// Poll listing
		$this->container->share( 'admin.poll.listing', function () {
			return new Admin\Poll\Listing( $this->container->get( 'polls.repository' ), $this->container->get( 'entries.repository' ), $this->container->get( 'log.repository' ) );
		} );

		// Entries
		$this->container->share( 'admin.pages.entries', function () {
			return new Admin\Entries\Page( $this->container->get( 'http.request' ), $this->container->get( 'env' ) );
		} );

		// Insights
		$this->container->share( 'admin.pages.insights', function () {
			return new Admin\Insights\Page( $this->container->get( 'http.request' ), $this->container->get( 'env' ) );
		} );

		// Log
		$this->container->share( 'admin.pages.log', function () {
			return new Admin\Log\Page( $this->container->get( 'http.request' ), $this->container->get( 'env' ) );
		} );

		// Modules
		$this->container->share( 'admin.pages.modules', function () {
			return new Admin\Modules\Page( $this->container->get( 'http.request' ), $this->container->get( 'env' ) );
		} );

		// Templates
		$this->container->share( 'admin.pages.templates', function () {
			return new Admin\Modules\Templates\Page( $this->container->get( 'http.request' ), $this->container->get( 'env' ) );
		} );

		// Extensions
		$this->container->share( 'admin.pages.extensions', function () {
			return new Admin\Modules\Extensions\Page( $this->container->get( 'http.request' ), $this->container->get( 'env' ) );
		} );

		// Options
		$this->container->share( 'admin.pages.options', function () {
			return new Admin\Options\Page( $this->container->get( 'http.request' ), $this->container->get( 'env' ), $this->container->get( 'migrations.migrators' ) );
		} );

		// Dashboard
		$this->container->share( 'admin.pages.dashboard', function () {
			return new Admin\Dashboard\Page( $this->container->get( 'http.request' ), $this->container->get( 'env' ), $this->container->get( 'admin.activation' ), $this->container->get( 'admin.account' ) );
		} );

		$this->container->share( 'admin.privacy', function () {
			return new Admin\Privacy\Policy( $this->container->get( 'env' ), $this->container->get( 'entries.repository' ), $this->container->get( 'log.repository' ) );
		} );

		// Schema migration
		$this->container->share( 'migrations.schema', function () {
			require_once ABSPATH . 'wp-admin/includes/upgrade.php';

			return new Migrations\Schema\Migrator( $this->container->get( 'env' ), $this->container->get( 'database' ) );
		} );

		// Polls migration
		$this->container->share( 'migrations.totalpoll', function () {
			return new Migrations\Polls\TotalPoll\Migrator( $this->container->get( 'env' ) );
		} );

		$this->container->share( 'migrations.yop', function () {
			return new Migrations\Polls\YOP\Migrator( $this->container->get( 'env' ) );
		} );

		$this->container->share( 'migrations.wp-polls', function () {
			return new Migrations\Polls\WPPolls\Migrator( $this->container->get( 'env' ) );
		} );

		$this->container->share( 'migrations.migrators', function () {
			return [
				'totalpoll-3' => $this->container->get( 'migrations.totalpoll' ),
				'yop'         => $this->container->get( 'migrations.yop' ),
				'wp-polls'    => $this->container->get( 'migrations.wp-polls' ),
			];
		} );

		$this->container->share( 'decorators.structuredData', function () {
			return new Decorators\StructuredData();
		} );

		$this->container->add( 'utils.create.cache', function () {
			wp_mkdir_p( $this->application->env( 'cache.path' ) . 'css/' );
		} );

		$this->container->add( 'utils.purge.cache', function () {
			$this->container->get( 'filesystem' )->rmdir( $this->application->env( 'cache.path' ), true );
		} );

		$this->container->add( 'utils.purge.store', function () {
			delete_transient( $this->application->env( 'slug' ) . '_modules_store_response' );
		} );

		
		// Upgrade
		$this->container->share( 'admin.pages.upgrade-to-pro', function () {
			return new Admin\Upgrade\Page( $this->container->get( 'http.request' ), $this->container->get( 'env' ) );
		} );

		$this->container->add( 'upgrade-to-pro', function () {
			$url     = esc_attr( TotalPoll()->env( 'links.upgrade-to-pro' ) );
			$tooltip = __( 'This feature is available in Pro version.', 'totalpoll' );

			echo "<a href=\"{$url}\" target=\"_blank\" class=\"totalpoll-pro-badge\" tooltip=\"${tooltip}\">Pro</a>";
		} );
		
	}

	public function registerWidgets() {
		register_widget( '\TotalPoll\Widgets\Poll' );
		register_widget( '\TotalPoll\Widgets\LatestPoll' );
	}

	public function registerShortCodes() {
		$callback = function ( $attributes, $content = null ) {
			return (string) $this->container->get( 'polls.shortcode', [ $attributes, $content ] );
		};
		add_shortcode( 'tp-poll', $callback );
		add_shortcode( 'totalpoll', $callback );
	}

	public function registerCustomPostTypes() {
		$this->container->get( 'polls.cpt' );
	}

	public function registerTaxonomies() {

	}

	public function loadTextDomain() {
		$locale         = get_locale();
		$localeFallback = substr( $locale, 0, 2 );
		$mofile         = "totalpoll-{$locale}.mo";
		$mofileFallback = "totalpoll-{$localeFallback}.mo";
		$path           = $this->application->env( 'path' );

		$loaded = load_textdomain( 'totalpoll', "{$path}languages/{$mofile}" );
		if ( ! $loaded ):
			$loaded = load_textdomain( 'totalpoll', "{$path}languages/{$mofileFallback}" );
		endif;

		if ( ! is_admin() || Misc::isDoingAjax() ):
			// Customized expressions
			$expressions = (array) $this->application->option( 'expressions', [] );

			if ( ! empty( $expressions ) ):
				if ( isset( $GLOBALS['l10n']['totalpoll'] ) ):
					$domain = $GLOBALS['l10n']['totalpoll'];
				else:
					$domain = $GLOBALS['l10n']['totalpoll'] = new \MO();
				endif;

				foreach ( $expressions as $expression => $expressionContent ):
					if ( empty( $expressionContent['translations'] ) || empty( $expressionContent['translations'][0] ) ):
						continue;
					endif;
					if ( empty( $domain->entries[ $expression ] ) ):
						$entry = new \Translation_Entry( [
							'singular'     => $expression,
							'translations' => $expressionContent['translations'],
						] );
						$domain->add_entry( $entry );
					else:
						$domain->entries[ $expression ]->translations = $expressionContent['translations'];
					endif;
				endforeach;
			endif;
		endif;
	}

	public function onActivation() {
		// Migrate the database
		$this->container->get( 'migrations.schema' )->migrate();

		// Register post types  & flush rewrite rules
		$this->registerCustomPostTypes();

		// Purge previous cache
		$this->container->get( 'utils.purge.cache' );
		$this->container->get( 'utils.purge.store' );

		// Create cache directories
		$this->container->get( 'utils.create.cache' );

		// Reactivate current license, if any
		$this->container->get( 'admin.activation' )->reactivateLicense();

		// Trigger action
		do_action( 'totalpoll/actions/activated' );
	}

	public function onDeactivation() {
		// Flush rewrite rules
		flush_rewrite_rules();

		// Flush cache
		wp_cache_flush();

		// Trigger action
		do_action( 'totalpoll/actions/deactivated' );
	}

	public static function onUninstall() {
		// Flush rewrite rules
		flush_rewrite_rules();

		$userConsent = TotalPoll()->option( 'advanced.uninstallAll' );
		if ( $userConsent ):
			// Delete tables
			$tables = TotalPoll()->env( 'db.tables' );
			foreach ( $tables as $table ):
				$query = "DROP TABLE IF EXISTS {$table}";
				TotalPoll( 'database' )->query( $query );
			endforeach;
			// Delete polls
			$query = new \WP_Query( [ 'post_type' => 'poll', 'post_status' => 'any', 'fields' => 'ids' ] );
			$polls = $query->get_posts();
			foreach ( $polls as $id ) {
				wp_delete_post( $id, true );
			}
			// Delete files
			TotalPoll( 'utils.purge.cache' );
			TotalPoll( 'utils.purge.store' );
			// Delete options
			TotalPoll( 'options' )->deleteOptions();
		endif;

		// Trigger action
		do_action( 'totalpoll/actions/uninstalled', $userConsent );
	}

	/**
	 * Bootstrap plugin.
	 */
	public function bootstrap() {
		/**
		 * Fires before bootstrapping TotalPoll.
		 *
		 * @param Plugin $this Plugin instance.
		 *
		 * @since 4.0.0
		 * @order 3
		 */
		do_action( 'totalpoll/actions/before/bootstrap', $this );

		$this->container->get( 'bootstrap' );

		/**
		 * Fires after bootstrapping TotalPoll.
		 *
		 * @param Plugin $this Plugin instance.
		 *
		 * @since 4.0.0
		 * @order 5
		 */
		do_action( 'totalpoll/actions/after/bootstrap', $this );
	}

	/**
	 * Bootstrap AJAX.
	 */
	public function bootstrapAjax() {
		/**
		 * Fires before bootstrapping AJAX handler.
		 *
		 * @param Plugin $this Plugin instance.
		 *
		 * @since 4.0.0
		 * @order 6
		 */
		do_action( 'totalpoll/actions/before/bootstrap-ajax', $this );

		$this->container->get( 'admin.ajax' );

		/**
		 * Fires after bootstrapping AJAX handler.
		 *
		 * @param Plugin $this Plugin instance.
		 *
		 * @since 4.0.0
		 * @order 8
		 */
		do_action( 'totalpoll/actions/after/bootstrap-ajax', $this );
	}

	/**
	 * Bootstrap admin.
	 */
	public function bootstrapAdmin() {
		/**
		 * Fires before bootstrapping admin.
		 *
		 * @param Plugin $this Plugin instance.
		 *
		 * @since 4.0.0
		 * @order 9
		 */
		do_action( 'totalpoll/actions/before/bootstrap-admin', $this );

		$this->container->get( 'admin.bootstrap' );

		/**
		 * Fires after bootstrapping admin.
		 *
		 * @param Plugin $this Plugin instance.
		 *
		 * @since 4.0.0
		 * @order 11
		 */
		do_action( 'totalpoll/actions/after/bootstrap-admin', $this );
	}

	/**
	 * Bootstrap extensions.
	 * @throws \Exception
	 */
	public function bootstrapExtensions() {
		/**
		 * Fires before bootstrapping extensions.
		 *
		 * @param Plugin $this Plugin instance.
		 *
		 * @since 4.0.0
		 * @order 1
		 */
		do_action( 'totalpoll/actions/before/bootstrap-extensions', $this );

		$activatedExtension = $this->container->get( 'modules.repository' )->getActiveWhere( [ 'type' => 'extension' ] );
		/**
		 * Filters the list of activated extensions.
		 *
		 * @param array $activatedExtension Array of extensions information.
		 *
		 * @return array
		 * @since 4.0.0
		 */
		$activatedExtension = apply_filters( 'totalpoll/filters/extensions/activated', $activatedExtension );

		// @TODO: Improve error reporting for this part.
		try {
			foreach ( $activatedExtension as $extension ):
				if ( $this->container->get( 'filesystem' )->exists( $extension['dirName'] . '/Extension.php' ) && class_exists( $extension['class'] ) ):
					( new $extension['class'] )->run();
				else:
					throw new \RuntimeException( "Please check that \"{$extension['id']}\" extension file uses the correct namespace." );
				endif;
			endforeach;
		} catch ( \Exception $exception ) {
			if ( Misc::isDevelopmentMode() ):
				trigger_error( $exception->getMessage(), E_USER_WARNING );
			else:
				TotalPoll( 'modules.repository' )->setInactive( $extension['id'] );
			endif;
		}

		/**
		 * Fires after bootstrapping extensions.
		 *
		 * @param Plugin $this Plugin instance.
		 *
		 * @since 4.0.0
		 * @order 2
		 */
		do_action( 'totalpoll/actions/after/bootstrap-extensions', $this );
	}
}
