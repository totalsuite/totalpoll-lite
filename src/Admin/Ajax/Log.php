<?php

namespace TotalPoll\Admin\Ajax;

use TotalPoll\Contracts\Log\Repository;
use TotalPoll\Log\Model;
use TotalPollVendors\TotalCore\Contracts\Http\Request;
use TotalPollVendors\TotalCore\Export\ColumnTypes\DateColumn;
use TotalPollVendors\TotalCore\Export\ColumnTypes\TextColumn;
use TotalPollVendors\TotalCore\Export\Spreadsheet;
use TotalPollVendors\TotalCore\Export\Writer;
use TotalPollVendors\TotalCore\Export\Writers\CsvWriter;
use TotalPollVendors\TotalCore\Export\Writers\HTMLWriter;
use TotalPollVendors\TotalCore\Export\Writers\JsonWriter;

/**
 * Class Log
 * @package TotalPoll\Admin\Ajax
 * @since   1.0.0
 */
class Log {
	/**
	 * @var Request $request
	 */
	protected $request;
	/**
	 * @var Repository $log
	 */
	protected $log;
	/**
	 * @var array $criteria
	 */
	protected $criteria = [];

	/**
	 * Log constructor.
	 *
	 * @param Request    $request
	 * @param Repository $log
	 */
	public function __construct( Request $request, Repository $log ) {
		$this->request = $request;
		$this->log     = $log;

		$this->criteria = [
			'page'   => absint( $this->request->request( 'page', 1 ) ),
			'poll'   => $this->request->request( 'poll', null ),
			'from'   => $this->request->request( 'from', null ),
			'to'     => $this->request->request( 'to', null ),
			'format' => $this->request->request( 'format', null ),
		];
	}

	/**
	 * Get AJAX endpoint.
	 * @action-callback wp_ajax_totalpoll_log_list
	 */
	public function fetch() {
		$args = [ 'conditions' => [ 'date' => [] ], 'page' => $this->criteria['page'] ];

		if ( $this->criteria['poll'] ):
			$args['conditions']['poll_id'] = $this->criteria['poll'];
		endif;

		if ( $this->criteria['from'] && strptime( $this->criteria['from'], '%Y-%m-%d' ) ):
			$args['conditions']['date'][] = [ 'operator' => '>=', 'value' => "{$this->criteria['from']} 00:00:00" ];
		endif;

		if ( $this->criteria['to'] && strptime( $this->criteria['to'], '%Y-%m-%d' ) ):
			$args['conditions']['date'][] = [ 'operator' => '<=', 'value' => "{$this->criteria['to']} 23:59:59" ];
		endif;

		$entries = $this->log->get( $args );
		/**
		 * Filters the list of log entries sent to log browser.
		 *
		 * @param Model[] $entries  Array of log entries models.
		 * @param array   $criteria Array of criteria.
		 *
		 * @return array
		 * @since 4.0.0
		 */
		$entries = apply_filters( 'totalpoll/filters/admin/log/fetch', $entries, $this->criteria );

		wp_send_json( [ 'entries' => $entries, 'lastPage' => count( $entries ) === 0 || count( $entries ) < 30 ] );
	}

	/**
	 * Download AJAX endpoint.
	 * @action-callback wp_ajax_totalpoll_log_download
	 */
	public function download() {
		$args = [ 'conditions' => [ 'date' => [] ], 'perPage' => - 1 ];

		if ( $this->criteria['poll'] ):
			$args['conditions']['poll_id'] = $this->criteria['poll'];
		endif;

		if ( $this->criteria['from'] && strptime( $this->criteria['from'], '%Y-%m-%d 00:00:00' ) ):
			$args['conditions']['date'][] = [ 'operator' => '>=', 'value' => "{$this->criteria['from']} 00:00:00" ];
		endif;

		if ( $this->criteria['to'] && strptime( $this->criteria['to'], '%Y-%m-%d 23:59:59' ) ):
			$args['conditions']['date'][] = [ 'operator' => '<=', 'value' => "{$this->criteria['to']} 23:59:59" ];
		endif;

		$entries = (array) $this->log->get( $args );

		/**
		 * Filters the list of log entries to be exported.
		 *
		 * @param Model[] $entries Array of log entries models.
		 *
		 * @return array
		 * @since 4.0.0
		 */
		$entries = apply_filters( 'totalpoll/filters/admin/log/export/entries', $entries );

		$export = new Spreadsheet();

		$export->addColumn( new TextColumn( 'Status' ) );
		$export->addColumn( new TextColumn( 'Action' ) );
		$export->addColumn( new DateColumn( 'Date' ) );
		$export->addColumn( new TextColumn( 'IP' ) );
		$export->addColumn( new TextColumn( 'Browser' ) );
		$export->addColumn( new TextColumn( 'Poll' ) );
		$export->addColumn( new TextColumn( 'User ID' ) );
		$export->addColumn( new TextColumn( 'User login' ) );
		$export->addColumn( new TextColumn( 'User name' ) );
		$export->addColumn( new TextColumn( 'User email' ) );
		$export->addColumn( new TextColumn( 'Entry' ) );
		$export->addColumn( new TextColumn( 'Details' ) );

		/**
		 * Fires after setup essential columns and before populating data. Useful for define new columns.
		 *
		 * @param Spreadsheet $export  Spreadsheet object.
		 * @param array       $entries Array of log entries.
		 *
		 * @since 4.0.0
		 */
		do_action( 'totalpoll/actions/admin/log/export/columns', $export, $entries );

		foreach ( $entries as $entry ):

            $poll = $entry->getPoll();

			/**
			 * Filters a row of exported log entries.
			 *
			 * @param array $row   Array of values.
			 * @param Model $entry Log entry model.
			 *
			 * @return array
			 * @since 4.0.0
			 */
			$row = apply_filters(
				'totalpoll/filters/admin/log/export/row',
				[
					$entry->getStatus(),
					$entry->getAction(),
					$entry->getDate(),
					$entry->getIp(),
					$entry->getUseragent(),
					$poll ? $poll->getTitle() : 'N/A',
					$entry->getUserId() ?: 'N/A',
					$entry->getUser()->user_login ?: 'N/A',
					$entry->getUser()->display_name ?: 'N/A',
					$entry->getUser()->user_email ?: 'N/A',
					json_encode( $entry->getEntry() ),
					$this->criteria['format'] !== 'json' ? json_encode( $entry->getDetails() ) : $entry->getDetails(),
				],
				$entry,
				$this
			);

			$export->addRow( $row );
		endforeach;

		if ( empty( $this->criteria['format'] ) ):
			$this->criteria['format'] = 'default';
		endif;

		$format = $this->criteria['format'];


		
		$writer = new HTMLWriter();
		

		

		/**
		 * Filters the file writer for a specific format when exporting log entries.
		 *
		 * @param Writer $writer Writer object.
		 *
		 * @return Writer
		 * @since 4.0.0
		 */
		$writer = apply_filters( "totalpoll/filters/admin/log/export/writer/{$format}", $writer );

		$writer->includeColumnHeaders = true;

		$export->download( $writer, 'totalpoll-export-log-' . date( 'Y-m-d H:i:s' ) );

		exit;
	}

}
