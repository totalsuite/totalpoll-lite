<?php

namespace TotalPoll\Shortcodes;

/**
 * Poll Shortcode.
 * @package TotalPoll\Shortcode
 * @since   1.0.0
 */
class Poll extends \TotalPollVendors\TotalCore\Shortcodes\Shortcode {

	/**
	 * Render shortcode.
	 *
	 * @return mixed|string
	 */
	public function handle() {
		$poll = TotalPoll( 'polls.repository' )->getById( $this->getAttribute( 'id' ) );
		if ( ! $poll ):
			return __( 'Could not load the poll.', 'totalpoll' );
		endif;

		$screen = $this->getAttribute( 'screen', $this->getAttribute( 'fragment' ) );
		if ( $screen ):
			// Override screen when rendering
			add_filter( 'totalpoll/filters/render/screen', function ( $currentScreen, $renderedPoll ) use ( $poll, $screen ) {
				if ( $renderedPoll->getId() || $poll->getId() ) :
					return $screen;
				endif;

				return $currentScreen;
			}, 10, 2 );

			// Override results visibility
			add_filter(
				'totalpoll/filters/poll/results-hidden',
				function ( $hidden, $renderedPoll ) use ( $poll ) {
					if ( $renderedPoll->getId() === $poll->getId() ) :
						return false;
					endif;

					return $hidden;
				},
				10, 2
			);

			// Hide buttons
			add_filter( 'totalpoll/filters/form/buttons', function ( $buttons, $renderedPoll ) use ( $poll ) {
				if ( $renderedPoll->getId() === $poll->getId() ) :
					return [];
				endif;

				return $buttons;
			}, 10, 2 );
		endif;

		return $poll->render();
	}


}