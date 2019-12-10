<?php

namespace TotalPoll\Admin\Options;

use TotalPoll\Contracts\Migrations\Poll\Migrator;
use TotalPollVendors\TotalCore\Admin\Pages\Page as AdminPageContract;
use TotalPollVendors\TotalCore\Contracts\Foundation\Environment;
use TotalPollVendors\TotalCore\Contracts\Http\Request;
use TotalPollVendors\TotalCore\Helpers\Misc;

/**
 * Class Page
 * @package TotalPoll\Admin\Options
 */
class Page extends AdminPageContract {
	/**
	 * @var Migrator[] $migrators
	 */
	protected $migrators;

	/**
	 * Options.
	 *
	 * @var array $options
	 */
	protected $options;

	/**
	 * Page constructor.
	 *
	 * @param Request $request
	 * @param Environment $env
	 * @param Migrator[] $migrators
	 */
	public function __construct( Request $request, $env, $migrators ) {
		parent::__construct( $request, $env );
		$this->migrators = $migrators;
		$this->options   = TotalPoll( 'options' )->getOptions();

		if ( empty( $this->options ) ):
			$this->options = null;
		endif;
	}

	/**
	 * Enqueue assets.
	 *
	 * @return mixed
	 */
	public function assets() {
		// TotalPoll
		wp_enqueue_script( 'totalpoll-admin-options' );
		wp_enqueue_style( 'totalpoll-admin-options' );

		/**
		 * Filters the list of expressions that are available through the interface to override.
		 *
		 * @param array $expressions Array of expressions.
		 *
		 * @return array
		 * @since 4.0.0
		 */
		$expressions = apply_filters(
			'totalpoll/filters/admin/options/expressions',
			[
				'votes'       => [
					'label'       => __( 'Votes', 'totalpoll' ),
					'expressions' =>
						[
							'%s Vote' => [
								'translations' => [
									__( '%s Vote', 'totalpoll' ),
									__( '%s Votes', 'totalpoll' ),
								],
							],
						],
				],
				'buttons'     => [
					'label'       => __( 'Buttons', 'totalpoll' ),
					'expressions' =>
						[
							'Previous'         => [
								'translations' => [
									__( 'Previous', 'totalpoll' ),
								],
							],
							'Next'             => [
								'translations' => [
									__( 'Next', 'totalpoll' ),
								],
							],
							'Results'          => [
								'translations' => [
									__( 'Results', 'totalpoll' ),
								],
							],
							'Vote'             => [
								'translations' => [
									__( 'Vote', 'totalpoll' ),
								],
							],
							'Back to vote'     => [
								'translations' => [
									__( 'Back to vote', 'totalpoll' ),
								],
							],
							'Continue to vote' => [
								'translations' => [
									__( 'Continue to vote', 'totalpoll' ),
								],
							],
						],
				],
				'fields'      => [
					'label'       => __( 'Fields', 'totalpoll' ),
					'expressions' =>
						[
							'Other' => [
								'translations' => [
									__( 'Other', 'totalpoll' ),
								],
							],
						],
				],
				'errors'      => [
					'label'       => __( 'Errors', 'totalpoll' ),
					'expressions' =>
						[
							'You cannot vote again in this poll.'                                                                    =>
								[
									'translations' => [
										__( 'You cannot vote again in this poll.', 'totalpoll' ),
									],
								],
							'You have to vote for at least one choice.'                                                              =>
								[
									'translations' => [
										__( 'You have to vote for at least one choice.', 'totalpoll' ),
										__( 'You have to vote for at least %d choices.', 'totalpoll' ),
									],
								],
							'You cannot vote for more than one choice.'                                                              =>
								[
									'translations' => [
										__( 'You cannot vote for more than one choice.', 'totalpoll' ),
										__( 'You cannot vote for more than %d choices.', 'totalpoll' ),
									],
								],
							'You have entered an invalid captcha code.'                                                              =>
								[
									'translations' => [
										__( 'You have entered an invalid captcha code.', 'totalpoll' ),
									],
								],
							'You cannot vote because the quota has been exceeded.'                                                   =>
								[
									'translations' => [
										__( 'You cannot vote because the quota has been exceeded.', 'totalpoll' ),
									],
								],
							'You cannot see results before voting.'                                                                  =>
								[
									'translations' => [
										__( 'You cannot see results before voting.', 'totalpoll' ),
									],
								],
							'You cannot vote because this poll has not started yet.'                                                 =>
								[
									'translations' => [
										__( 'You cannot vote because this poll has not started yet.', 'totalpoll' ),
									],
								],
							'You cannot vote because this poll has expired.'                                                         =>
								[
									'translations' => [
										__( 'You cannot vote because this poll has expired.', 'totalpoll' ),
									],
								],
							'You cannot vote because this poll is not available in your region.'                                     =>
								[
									'translations' => [
										__( 'You cannot vote because this poll is not available in your region.', 'totalpoll' ),
									],
								],
							'You cannot vote because you have insufficient rights.'                                                  =>
								[
									'translations' => [
										__( 'You cannot vote because you have insufficient rights.', 'totalpoll' ),
									],
								],
							'You cannot vote because you are a guest, please <a href="%s">sign in</a> or <a href="%s">register</a>.' =>
								[
									'translations' => [
										__( 'You cannot vote because you are a guest, please <a href="%s">sign in</a> or <a href="%s">register</a>.', 'totalpoll' ),
									],
								],
							'Voting via links has been disabled for this poll.'                                                      =>
								[
									'translations' => [
										__( 'Voting via links has been disabled for this poll.', 'totalpoll' ),
									],
								],
							'To continue, you must be a part of these roles: %s.'                                                    =>
								[
									'translations' => [
										__( 'To continue, you must be a part of these roles: %s.', 'totalpoll' ),
									],
								],
						],
				],
				'validations' => [
					'label'       => __( 'Validations', 'totalpoll' ),
					'expressions' =>
						[
							'{{label}} must be a valid email address.'     => [
								'translations' => [
									__( '{{label}} must be a valid email address.', 'totalpoll' ),
								],
							],
							'{{label}} must be filled.'                    => [
								'translations' => [
									__( '{{label}} must be filled.', 'totalpoll' ),
								],
							],
							'{{label}} is not within the supported range.' => [
								'translations' => [
									__( '{{label}} is not within the supported range.', 'totalpoll' ),
								],
							],
							'{{label}} has been used before.'              => [
								'translations' => [
									__( '{{label}} has been used before.', 'totalpoll' ),
								],
							],
							'{{label}} is not accepted.'                   => [
								'translations' => [
									__( '{{label}} is not accepted.', 'totalpoll' ),
								],
							],
							'{{label}} does not allow this value.'         => [
								'translations' => [
									__( '{{label}} does not allow this value.', 'totalpoll' ),
								],
							],
						],
				]
			]
		);

		wp_localize_script( 'totalpoll-admin-options', 'TotalPollExpressions', $expressions );
		wp_localize_script( 'totalpoll-admin-options', 'TotalPollSavedExpressions', Misc::getJsonOption( 'totalpoll_expressions' ) );
		wp_localize_script( 'totalpoll-admin-options', 'TotalPollOptions', $this->options );
		wp_localize_script( 'totalpoll-admin-options', 'TotalPollDebugInformation', Misc::getDebugInfo() );
		wp_localize_script( 'totalpoll-admin-options', 'TotalPollMigrationPlugins', $this->migrators );
	}

	public function render() {
		/**
		 * Filters the list of tabs in options page.
		 *
		 * @param array $tabs Array of tabs [id => [label, icon, file]].
		 *
		 * @return array
		 * @since 4.0.0
		 */
		$tabs = apply_filters(
			'totalpoll/filters/admin/options/tabs',
			[
				'general'       => [ 'label' => __( 'General', 'totalpoll' ), 'icon' => 'admin-settings' ],
				'performance'   => [ 'label' => __( 'Performance', 'totalpoll' ), 'icon' => 'performance' ],
				'services'      => [ 'label' => __( 'Services', 'totalpoll' ), 'icon' => 'cloud' ],
				'sharing'       => [ 'label' => __( 'Sharing', 'totalpoll' ), 'icon' => 'share' ],
				'advanced'      => [ 'label' => __( 'Advanced', 'totalpoll' ), 'icon' => 'admin-generic' ],
				'notifications' => [ 'label' => __( 'Notifications', 'totalpoll' ), 'icon' => 'email' ],
				'expressions'   => [ 'label' => __( 'Expressions', 'totalpoll' ), 'icon' => 'admin-site' ],
				'migration'     => [ 'label' => __( 'Migration', 'totalpoll' ), 'icon' => 'migrate' ],
				'import-export' => [ 'label' => __( 'Import & Export', 'totalpoll' ), 'icon' => 'update' ],
				'debug'         => [ 'label' => __( 'Debug', 'totalpoll' ), 'icon' => 'info' ],
			]
		);

		include_once __DIR__ . '/views/index.php';
	}
}