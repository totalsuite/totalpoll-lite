<?php

namespace TotalPoll\Admin\Ajax;

use TotalPollVendors\TotalCore\Contracts\Http\Request;

/**
 * Class Polls
 * @package TotalPoll\Admin\Ajax
 * @since   1.0.0
 */
class Polls {
	/**
	 * @var Request $request
	 */
	protected $request;
	/**
	 * @var \WP_Post|int $poll
	 */
	protected $poll;

	/**
	 * Polls constructor.
	 *
	 * @param Request $request
	 */
	public function __construct( Request $request ) {
		$this->request = $request;
		$this->poll    = get_post( absint( $this->request->request( 'poll', 0 ) ) );

		if ( $this->poll && $this->poll->post_type == TP_POLL_CPT_NAME && current_user_can( 'edit_poll', $this->poll->ID ) ):
			$this->poll = $this->poll->ID;
		endif;
	}

	/**
	 * Add to sidebar AJAX endpoint.
	 * @action-callback wp_ajax_totalpoll_polls_add_to_sidebar
	 */
	public function addToSidebar() {
		if ( ! $this->poll || ! current_user_can( 'edit_theme_options' ) ):
			wp_send_json_error( __( 'Invalid Poll ID.', 'totalpoll' ) );
		endif;

		$sidebar = (string) $this->request->request( 'sidebar', null );
		if ( is_registered_sidebar( $sidebar ) ):
			// Get sidebars
			$sidebarsWidgets  = wp_get_sidebars_widgets();
			$totalpollWidgets = array_filter( (array) get_option( 'widget_totalpoll_poll', [ '_multiwidget' => 1 ] ) );

			// Prepare the new widget
			$widgetName    = 'totalpoll_poll-' . count( $totalpollWidgets );
			$widgetOptions = [ 'title' => get_the_title( $this->poll ), 'poll' => $this->poll, 'screen' => 'vote' ];

			// Add to widgets
			$sidebarsWidgets[ $sidebar ][]                  = $widgetName;
			$totalpollWidgets[ count( $totalpollWidgets ) ] = $widgetOptions;

			// Save
			update_option( "widget_totalpoll_poll", $totalpollWidgets );
			wp_set_sidebars_widgets( $sidebarsWidgets );

			wp_send_json_success( __( 'Widget added successfully.', 'totalpoll' ) );
		else:
			wp_send_json_error( __( 'Invalid Sidebar ID.', 'totalpoll' ) );
		endif;
	}
}