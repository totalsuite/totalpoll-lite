<?php

namespace TotalPoll\Admin\Poll;

use TotalPoll\Contracts\Modules\Repository as ModulesRepository;
use TotalPoll\Contracts\Poll\Model;
use TotalPoll\Contracts\Poll\Repository as PollRepository;
use TotalPollVendors\TotalCore\Helpers\Arrays;
use TotalPollVendors\TotalCore\Helpers\Misc;

/**
 * Class Editor
 * @package TotalPoll\Admin\Poll
 */
class Editor {
	/**
	 * @var array $env
	 */
	protected $env;
	/**
	 * @var \WP_Filesystem_Base $filesystem
	 */
	protected $filesystem;
	/**
	 * @var PollRepository $pollRepository
	 */
	protected $pollRepository;
	/**
	 * @var ModulesRepository $modulesRepository
	 */
	protected $modulesRepository;
	/**
	 * @var array $templates
	 */
	protected $templates = [];
	/**
	 * @var Model $poll
	 */
	protected $poll;
	/**
	 * @var \WP_Post $post
	 */
	protected $post;
	/**
	 * @var array $settings
	 */
	protected $settings = [];

	/**
	 * Editor constructor.
	 *
	 * @param array               $env
	 * @param \WP_Filesystem_Base $filesystem
	 * @param PollRepository      $pollRepository
	 * @param ModulesRepository   $modulesRepository
	 */
	public function __construct( $env, $filesystem, PollRepository $pollRepository, ModulesRepository $modulesRepository ) {
		$this->env               = $env;
		$this->filesystem        = $filesystem;
		$this->pollRepository    = $pollRepository;
		$this->modulesRepository = $modulesRepository;

		$this->templates = $this->modulesRepository->getActiveWhere( [ 'type' => 'template' ] );
		foreach ( $this->templates as $templateId => $template ):
			foreach ( [ 'defaults', 'settings', 'preview' ] as $item ):
				$this->templates[ $templateId ][ $item ] = add_query_arg(
					[ 'action' => "totalpoll_templates_get_{$item}", 'template' => $templateId ],
					admin_url( 'admin-ajax.php' )
				);
			endforeach;
		endforeach;
		// Enqueue assets
		add_action( 'admin_enqueue_scripts', [ $this, 'assets' ], 99 );
		// Editor
		add_action( 'edit_form_after_title', [ $this, 'content' ] );
		// Actions
		add_action( 'submitpost_box', [ $this, 'actions' ] );
		// Save poll
		add_filter( 'wp_insert_post_data', [ $this, 'save' ], 10, 2 );
		// Remove WP filters
		remove_filter( 'content_save_pre', 'wp_targeted_link_rel' );
	}

	/**
	 * Register assets
	 */
	public function assets() {
		$this->post = get_post();

		if ( ! empty( $this->post ) ):
			$this->poll     = $this->pollRepository->getById( $this->post->ID );
			$this->settings = json_decode( $this->post->post_content, true );
		endif;

		// Disable auto save
		wp_dequeue_script( 'autosave' );
		// ACF
		wp_dequeue_script( 'acf-timepicker' );

		// WP Media
		wp_enqueue_media();

		// TinyMCE
		if ( ! class_exists( '_WP_Editors', false ) ):
			require ABSPATH . WPINC . '/class-wp-editor.php';
			\_WP_Editors::enqueue_scripts();
		endif;

		/**
		 * @asset-script totalpoll-admin-poll-editor
		 */
		wp_enqueue_script( 'totalpoll-admin-poll-editor' );
		/**
		 * @asset-style totalpoll-admin-poll-editor
		 */
		wp_enqueue_style( 'totalpoll-admin-poll-editor' );

		// Add/set votesOverride property for each choice and set votes property to reflect current votes.
		if ( ! empty( $this->settings['questions'] ) ):
			foreach ( $this->settings['questions'] as $questionIndex => $question ):
				if ( ! empty( $question['choices'] ) ):
					foreach ( $question['choices'] as $choiceIndex => $choice ):
						$votes = $this->poll->getChoiceVotes( $choice['uid'] ) ?: 0;

						$this->settings['questions'][ $questionIndex ]['choices'][ $choiceIndex ]['votes']         = $votes;
						$this->settings['questions'][ $questionIndex ]['choices'][ $choiceIndex ]['votesOverride'] = $votes;
					endforeach;
				endif;
			endforeach;
		endif;

		/**
		 * Filters the defaults settings of poll editor.
		 *
		 * @param array $defaults Array of settings.
		 *
		 * @return array
		 * @since 4.0.0
		 */
		$defaults = apply_filters(
			'totalpoll/filters/admin/editor/defaults',
			TotalPoll( 'polls.defaults' )
		);

		/**
		 * Filters the information passed to frontend controller.
		 *
		 * @param array $information Array of values [key => value].
		 *
		 * @return array
		 * @since 4.0.0
		 */
		$information = apply_filters(
			'totalpoll/filters/admin/editor/information',
			[
				'migrated' => $this->poll ? $this->poll->isMigrated() : true,
				'sidebars' => $GLOBALS['wp_registered_sidebars'],
			]
		);

		/**
		 * Filters the settings of poll passed to frontend controller.
		 *
		 * @param array $settings Array of settings.
		 *
		 * @return array
		 * @since 4.0.0
		 */
		$settings = apply_filters( 'totalpoll/filters/admin/editor/settings', $this->settings );

		$i18n = [
			'Are you sure?'                                                                           => __( 'Are you sure?', 'totalpoll' ),
			'Yes'                                                                                     => __( 'Yes', 'totalpoll' ),
			'No'                                                                                      => __( 'No', 'totalpoll' ),
			'Done'                                                                                    => __( 'Done', 'totalpoll' ),
			'Do you want to receive notifications from TotalPoll?'                                    => __( 'Do you want to receive notifications from TotalPoll?', 'totalpoll' ),
			'Unfortunately, your browser does not support push notifications.'                        => __( 'Unfortunately, your browser does not support push notifications.', 'totalpoll' ),
			'ATTENTION! Overriding votes is not reversible. Are you sure you want to override votes?' => __( 'ATTENTION! Overriding votes is not reversible. Are you sure you want to override votes?', 'totalpoll' ),
		];

		// Send JSON to TotalPoll frontend controller
		wp_localize_script( 'totalpoll-admin-poll-editor', 'TotalPollSettings', $settings );
		wp_localize_script( 'totalpoll-admin-poll-editor', 'TotalPollDefaults', $defaults );
		wp_localize_script( 'totalpoll-admin-poll-editor', 'TotalPollInformation', $information );
		wp_localize_script( 'totalpoll-admin-poll-editor', 'TotalPollTemplates', $this->templates );
		wp_localize_script( 'totalpoll-admin-poll-editor', 'TotalPollLanguages', Misc::getSiteLanguages() );
		wp_localize_script( 'totalpoll-admin-poll-editor', 'TotalPollI18n', $i18n );
	}

	/**
	 * Page content.
	 */
	public function content() {
		/**
		 * Filters tabs list in poll editor.
		 *
		 * @param array $tabs Array of tabs [id => [label, icon]].
		 *
		 * @return array
		 * @since 4.0.0
		 */
		$tabs = apply_filters(
			'totalpoll/filters/admin/editor/tabs',
			[
				'questions'    => [ 'label' => __( 'Questions', 'totalpoll' ), 'icon' => 'editor-help' ],
				'form'         => [ 'label' => __( 'Fields', 'totalpoll' ), 'icon' => 'welcome-widgets-menus' ],
				'settings'     => [ 'label' => __( 'Settings', 'totalpoll' ), 'icon' => 'admin-settings' ],
				'design'       => [ 'label' => __( 'Design', 'totalpoll' ), 'icon' => 'admin-appearance' ],
				'integration'  => [ 'label' => __( 'Integration', 'totalpoll' ), 'icon' => 'admin-generic' ],
				'translations' => [ 'label' => __( 'Translations', 'totalpoll' ), 'icon' => 'translation' ],
			]
		);

		/**
		 * Filters the list of settings tabs in poll editor.
		 *
		 * @param array $settingsTabs Array of tabs [id => [label, icon, tabs => []]].
		 *
		 * @return array
		 * @since 4.0.0
		 */
		$settingsTabs = apply_filters(
			'totalpoll/filters/admin/editor/settings/tabs',
			[
				'vote'          => [
					'label' => __( 'Vote', 'totalpoll' ),
					'icon'  => 'marker',
					'tabs'  => [
						'limitations' => [ 'label' => __( 'Limitations', 'totalpoll' ), 'icon' => 'lock' ],
						'frequency'   => [ 'label' => __( 'Frequency', 'totalpoll' ), 'icon' => 'backup' ],
					],
				],
				'choices'       => [
					'label' => __( 'Choices', 'totalpoll' ),
					'icon'  => 'editor-justify',
					'tabs'  => [
						'sort' => [ 'label' => __( 'Sort', 'totalpoll' ), 'icon' => 'sort' ],
					],
				],
				'results'       => [
					'label' => __( 'Results', 'totalpoll' ),
					'icon'  => 'chart-pie',
					'tabs'  => [
						'sort'       => [ 'label' => __( 'Sort', 'totalpoll' ), 'icon' => 'sort' ],
						'visibility' => [ 'label' => __( 'Visibility', 'totalpoll' ), 'icon' => 'visibility' ],
						'format'     => [ 'label' => __( 'Format', 'totalpoll' ), 'icon' => 'admin-generic' ],
					],
				],
				'content'       => [
					'label' => __( 'Content', 'totalpoll' ),
					'icon'  => 'admin-page',
					'tabs'  => [
						'welcome'  => [ 'label' => __( 'Welcome', 'totalpoll' ), 'icon' => 'admin-home' ],
						'vote'     => [ 'label' => __( 'Vote', 'totalpoll' ), 'icon' => 'editor-justify' ],
						'thankyou' => [ 'label' => __( 'Thank you', 'totalpoll' ), 'icon' => 'admin-page' ],
						'results'  => [ 'label' => __( 'Results', 'totalpoll' ), 'icon' => 'chart-pie' ],
					],
				],
				'seo'           => [ 'label' => __( 'SEO', 'totalpoll' ), 'icon' => 'search' ],
				'notifications' => [
					'label' => __( 'Notifications', 'totalpoll' ),
					'icon'  => 'megaphone',
					'tabs'  => [
						'email'   => [ 'label' => __( 'Email', 'totalpoll' ), 'icon' => 'email' ],
						'push'    => [ 'label' => __( 'Push', 'totalpoll' ), 'icon' => 'format-status' ],
						'webhook' => [ 'label' => __( 'WebHook', 'totalpoll' ), 'icon' => 'admin-site' ],
					],
				],
				'customization' => [ 'label' => __( 'Customization', 'totalpoll' ), 'icon' => 'admin-plugins' ],
			]
		);
		/**
		 * Filters the list of design tabs in poll editor.
		 *
		 * @param array $designTabs Array of tabs [id => [label]].
		 *
		 * @return array
		 * @since 4.0.0
		 */
		$designTabs = apply_filters(
			'totalpoll/filters/admin/editor/design/tabs',
			[
				'templates' => [ 'label' => __( 'Templates', 'totalpoll' ) ],
				'layout'    => [ 'label' => __( 'Layout', 'totalpoll' ) ],
				'colors'    => [ 'label' => __( 'Colors', 'totalpoll' ) ],
				'text'      => [ 'label' => __( 'Text', 'totalpoll' ) ],
				'advanced'  => [
					'label' => __( 'Advanced', 'totalpoll' ),
					'tabs'  => [
						'template-settings' => [ 'label' => __( 'Template Settings', 'totalpoll' ) ],
						'behaviours'        => [ 'label' => __( 'Behaviours', 'totalpoll' ) ],
						'effects'           => [ 'label' => __( 'Effects', 'totalpoll' ) ],
						'custom-css'        => [ 'label' => __( 'Custom CSS', 'totalpoll' ) ],
					],
				],
			]
		);

		/**
		 * Filters the list of integration tabs in poll editor.
		 *
		 * @param array $tabs Array of tabs [id => [label, description, icon]].
		 *
		 * @return array
		 * @since 4.0.0
		 */
		$integrationTabs = apply_filters(
			'totalpoll/filters/admin/editor/integration/tabs',
			[
				'shortcode' => [ 'label' => __( 'Shortcode', 'totalpoll' ), 'description' => __( 'WordPress feature', 'totalpoll' ), 'icon' => 'editor-code' ],
				'widget'    => [ 'label' => __( 'Widget', 'totalpoll' ), 'description' => __( 'WordPress feature', 'totalpoll' ), 'icon' => 'welcome-widgets-menus' ],
				'link'      => [ 'label' => __( 'Direct link', 'totalpoll' ), 'description' => __( 'Standard link', 'totalpoll' ), 'icon' => 'admin-links' ],
				'embed'     => [ 'label' => __( 'Embed', 'totalpoll' ), 'description' => __( 'External inclusion', 'totalpoll' ), 'icon' => 'admin-site' ],
				'email'     => [ 'label' => __( 'Email', 'totalpoll' ), 'description' => __( 'Vote links', 'totalpoll' ), 'icon' => 'email' ],
			]
		);

		$dateTimeFormat = get_option( 'date_format' ) . ' ' . get_option( 'time_format' );

		if ( ! current_user_can( 'edit_theme_options' ) ):
			unset( $integrationTabs['widget'] );
		endif;

		include_once __DIR__ . '/views/editor.php';
	}

	/**
	 * Page actions.
	 */
	public function actions() {
		$actions = [];

		if ( current_user_can( 'edit_polls' ) ):
			$actions['insights'] = [ 'label' => __( 'Insights', 'totalpoll' ), 'icon' => 'chart-area', 'url' => add_query_arg( [ 'post_type' => TP_POLL_CPT_NAME, 'page' => 'insights', 'poll' => $this->post->ID ], admin_url( 'edit.php' ) ) ];
			$actions['entries']  = [ 'label' => __( 'Entries', 'totalpoll' ), 'icon' => 'list-view', 'url' => add_query_arg( [ 'post_type' => TP_POLL_CPT_NAME, 'page' => 'entries', 'poll' => $this->post->ID ], admin_url( 'edit.php' ) ) ];
		endif;

		if ( current_user_can( 'manage_options' ) ):
			$actions['log'] = [ 'label' => __( 'Log', 'totalpoll' ), 'icon' => 'archive', 'url' => add_query_arg( [ 'post_type' => TP_POLL_CPT_NAME, 'page' => 'log', 'poll' => $this->post->ID ], admin_url( 'edit.php' ) ) ];
		endif;

		/**
		 * Filters the list of available action (side) in poll editor.
		 *
		 * @param array $actions Array of actions [id => [label, icon, url]].
		 *
		 * @return array
		 * @since 4.0.0
		 */
		$actions = apply_filters( 'totalpoll/filters/admin/editor/actions', $actions );

		include_once __DIR__ . '/views/actions.php';
	}

	/**
	 * Save poll action.
	 *
	 * @param array $pollArgs
	 * @param array $post
	 *
	 * @return mixed
	 */
	public function save( $pollArgs, $post ) {
		$pollId = absint( $post['ID'] );

		if ( ! empty( $pollArgs['post_content'] ) ):
			$settings = json_decode( wp_unslash( $pollArgs['post_content'] ), true );
			/**
			 * Filters the settings before saving the poll.
			 *
			 * @param array $settings Array of settings.
			 * @param array $pollArgs Array of post args.
			 * @param int   $pollId   Poll post ID.
			 *
			 * @return array
			 * @since 4.0.0
			 */
			$settings = apply_filters( 'totalpoll/filters/before/admin/editor/save/settings', $settings, $pollArgs, $pollId, $this );

			// Purge CSS cache
			if ( ! empty( $settings['presetUid'] ) ):
				$cachedFile = wp_normalize_path( $this->env['cache']['path'] . "css/{$settings['presetUid']}.css" );
				$this->filesystem->delete( $cachedFile );
			endif;

			// Update votes, if overridden
			$overriddenChoicesVotes = [];
			if ( ! empty( $settings['questions'] ) ):
				foreach ( $settings['questions'] as $questionIndex => $question ):
					if ( ! empty( $question['choices'] ) ):
						foreach ( $question['choices'] as $choiceIndex => $choice ):
							if ( $choice['votes'] != $choice['votesOverride'] ):
								$settings['questions'][ $questionIndex ]['choices'][ $choiceIndex ]['votes'] = $choice['votesOverride'];
								$overriddenChoicesVotes[ $choice['uid'] ]                                    = $choice['votesOverride'];
							endif;
						endforeach;
					endif;
				endforeach;

				if ( ! empty( $overriddenChoicesVotes ) ):
					$this->pollRepository->setVotes( $pollId, $overriddenChoicesVotes );
				endif;
			endif;

			// Server-side validations

			// Questions
			$questions = (array) Arrays::getDotNotation( $settings, 'questions', [] );
			foreach ( $questions as $questionIndex => $question ):
				$settings = Arrays::setDotNotation(
					$settings,
					"questions.{$questionIndex}.settings.selection.minimum",
					absint( Arrays::getDotNotation( $question, 'settings.selection.minimum', 1 ) )
				);

				$choices = (array) Arrays::getDotNotation( $question, 'choices', [] );
				foreach ( $choices as $choiceIndex => $choice ):
					$settings = Arrays::setDotNotation(
						$settings,
						"questions.{$questionIndex}.choices.{$choiceIndex}.votes",
						absint( Arrays::getDotNotation( $choice, 'votes', 0 ) )
					);

					$settings = Arrays::setDotNotation(
						$settings,
						"questions.{$questionIndex}.choices.{$choiceIndex}.votesOverride",
						absint( Arrays::getDotNotation( $choice, 'votesOverride', 0 ) )
					);
				endforeach;
			endforeach;

			// Fields
			$fields = (array) Arrays::getDotNotation( $settings, 'fields', [] );
			foreach ( $fields as $fieldIndex => $field ):
				$settings = Arrays::setDotNotation(
					$settings,
					"fields.{$fieldIndex}.name",
					sanitize_title_with_dashes( Arrays::getDotNotation( $field, "name", uniqid( 'untitled', false ) ), '', 'save' )
				);
			endforeach;

			// Settings
			$timePeriodStart = Arrays::getDotNotation( $settings, 'vote.limitations.period.start', '' );
			if ( ! (bool) strtotime( $timePeriodStart ) ):
				$settings = Arrays::setDotNotation(
					$settings,
					'vote.limitations.period.start',
					''
				);
			endif;
			$timePeriodEnd = Arrays::getDotNotation( $settings, 'vote.limitations.period.end', '' );
			if ( ! (bool) strtotime( $timePeriodEnd ) ):
				$settings = Arrays::setDotNotation(
					$settings,
					'vote.limitations.period.end',
					''
				);
			endif;
			$settings = Arrays::setDotNotation(
				$settings,
				'vote.limitations.quota.value',
				absint( Arrays::getDotNotation( $settings, 'vote.limitations.quota.value', 0 ) )
			);

			$settings = Arrays::setDotNotation(
				$settings,
				'vote.frequency.perSession',
				absint( Arrays::getDotNotation( $settings, 'vote.frequency.perSession', 0 ) )
			);

			$settings = Arrays::setDotNotation(
				$settings,
				'vote.frequency.perUser',
				absint( Arrays::getDotNotation( $settings, 'vote.frequency.perUser', 0 ) )
			);

			$settings = Arrays::setDotNotation(
				$settings,
				'vote.frequency.perIP',
				absint( Arrays::getDotNotation( $settings, 'vote.frequency.perIP', 0 ) )
			);

			$settings = Arrays::setDotNotation(
				$settings,
				'vote.frequency.timeout',
				absint( Arrays::getDotNotation( $settings, 'vote.frequency.timeout', 0 ) )
			);

			// Generate a UID based on design settings
			$settings['presetUid'] = md5( json_encode( $settings['design'] ) );

			/**
			 * Filters the settings after validation to be saved.
			 *
			 * @param array $settings Array of settings.
			 * @param array $pollArgs Array of post args.
			 * @param int   $pollId   Poll post ID.
			 *
			 * @return array
			 * @since 4.0.0
			 */
			$settings = apply_filters( 'totalpoll/filters/admin/editor/save/settings', $settings, $pollArgs, $pollId, $this );

			// Prepare settings for insertion
			$pollArgs['post_content'] = json_encode( $settings );
			// Sanitize
			if ( ! current_user_can( 'unfiltered_html' ) ):
				$pollArgs['post_content'] = wp_kses_post( $pollArgs['post_content'] );
			endif;
			// Add slashes
			$pollArgs['post_content'] = wp_slash( $pollArgs['post_content'] );

			/**
			 * Filters the arguments that are passed back to wp_update_post to save the changes.
			 *
			 * @param array $pollArgs Array of post args.
			 * @param array $settings Array of settings.
			 * @param int   $pollId   Poll post ID.
			 *
			 * @return array
			 * @since 4.0.0
			 * @see   Check wp_update_post documentation for more details.
			 *
			 */
			$pollArgs = apply_filters( 'totalpoll/filters/admin/editor/save/post', $pollArgs, $settings, $pollId, $this );
		endif;

		// Purge global cache
		Misc::purgePluginsCache();

		// Adjust redirect url
		add_filter( 'redirect_post_location', function ( $location ) {
			$params = [
				'tab' => empty( $_POST['totalpoll_current_tab'] ) ? null : urlencode( (string) $_POST['totalpoll_current_tab'] ),
			];

			return add_query_arg( $params, $location );
		} );

		return $pollArgs;
	}
}
