<?php

namespace TotalPoll\Restrictions;

use TotalPollVendors\TotalCore\Helpers\Arrays;
use TotalPollVendors\TotalCore\Restrictions\Restriction as RestrictionBase;

/**
 * Base Restriction.
 * @package TotalPoll\Restrictions
 */
abstract class Restriction extends RestrictionBase {
	use \TotalPollVendors\TotalCore\Traits\Cookies;

	/**
	 * @return bool
	 */
	public function isFullCheck() {
		return (bool) Arrays::getDotNotation( $this->args, 'fullCheck', false );
	}

	/**
	 * @return mixed
	 */
	public function getPollId() {
		return $this->args['poll']->getId();
	}

	/**
	 * @param int $default
	 *
	 * @return int
	 */
	public function getTimeout( $default = 3600 ) {
		return (int) Arrays::getDotNotation( $this->args, 'timeout', 3600 );
	}

	/**
	 * @return string
	 */
	public function getAction() {
		return (string) Arrays::getDotNotation( $this->args, 'action' );
	}

	/**
	 * @param int $default
	 *
	 * @return int
	 */
	public function getVotesPerSession( $default = 1 ) {
		return (int) Arrays::getDotNotation( $this->args, 'perSession', $default );
	}

	/**
	 * @param int $default
	 *
	 * @return int
	 */
	public function getVotesPerIP( $default = 1 ) {
		return (int) Arrays::getDotNotation( $this->args, 'perIP', $default );
	}

	/**
	 * @param int $default
	 *
	 * @return int
	 */
	public function getVotesPerUser( $default = 1 ) {
		return (int) Arrays::getDotNotation( $this->args, 'perUser', $default );
	}

	/**
	 * @return string
	 */
	public function getMessage() {
		return empty( $this->args['message'] ) ? __( 'You cannot vote again.', 'totalpoll' ) : (string) $this->args['message'];
	}

	/**
	 * @param $prefix
	 *
	 * @return string
	 */
	public function getCookieName( $prefix ) {
		return $this->generateCookieName( $prefix . $this->getAction() . $this->getPollId() );
	}
}