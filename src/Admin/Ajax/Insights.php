<?php

namespace TotalPoll\Admin\Ajax;

use TotalPoll\Contracts\Log\Repository as LogRepository;
use TotalPoll\Contracts\Poll\Model;
use TotalPoll\Contracts\Poll\Repository as PollRepository;
use TotalPollVendors\TotalCore\Contracts\Http\Request;

/**
 * Class Insights
 * @package TotalPoll\Admin\Ajax
 * @since   1.0.0
 */
class Insights {
	/**
	 * @var Request $request
	 */
	protected $request;
	/**
	 * @var LogRepository $log
	 */
	protected $log;
	/**
	 * @var PollRepository $poll
	 */
	protected $poll;
	/**
	 * @var array $criteria
	 */
	protected $criteria = [];

	/**
	 * Insights constructor.
	 *
	 * @param Request        $request
	 * @param LogRepository  $log
	 * @param PollRepository $poll
	 */
	public function __construct( Request $request, LogRepository $log, PollRepository $poll ) {
		$this->request = $request;
		$this->log     = $log;
		$this->poll    = $poll;

		$this->criteria = [
			'poll'   => $this->request->request( 'poll', null ),
			'from'   => $this->request->request( 'from', null ),
			'to'     => $this->request->request( 'to', null ),
			'format' => $this->request->request( 'format', null ),
		];
	}

	/**
	 * Get metrics AJAX endpoint.
	 * @action-callback wp_ajax_totalpoll_insights_metrics
	 */
	public function metrics() {
		
	}

	/**
	 * Get polls AJAX endpoint.
	 * @action-callback wp_ajax_totalpoll_insights_polls
	 */
	public function polls() {

		$queryArgs = [
			'status' => 'any',
			'perPage' => -1,
		];

		if ( ! current_user_can( 'edit_others_polls' ) ):
			$queryArgs['wpQuery']['author'] = get_current_user_id();
		endif;

		$polls = array_map(
			function ( $poll ) {

				/**
				 * Filters the poll object sent to insights.
				 *
				 * @param array $pollRepresentation The representation of a poll.
				 * @param Model $poll               Poll model object.
				 *
				 * @since 4.0.0
				 * @return array
				 */
				return apply_filters( 'totalpoll/filters/admin/insights/poll', [ 'id' => $poll->getId(), 'title' => $poll->getTitle() ], $poll, $this );
			},

			TotalPoll('polls.repository')->get( $queryArgs )
		);

		/**
		 * Filters the polls list sent to insights browser.
		 *
		 * @param Model[] $polls Array of poll models.
		 *
		 * @since 4.0.0
		 * @return array
		 */
		$polls = apply_filters( 'totalpoll/filters/admin/insights/polls', $polls );

		wp_send_json( $polls );
	}
}
