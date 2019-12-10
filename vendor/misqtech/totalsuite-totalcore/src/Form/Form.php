<?php

namespace TotalPollVendors\TotalCore\Form;

use TotalPollVendors\TotalCore\Contracts\Form\Form as FormContract;

/**
 * Class Form
 * @package TotalPollVendors\TotalCore\Form
 */
class Form implements FormContract {
	/**
	 * @var array $pages
	 */
	protected $pages = [];
	/**
	 * @var int $currentPage
	 */
	protected $currentPage = 0;
	/**
	 * @var array $errors
	 */
	protected $errors = [];
	/**
	 * @var bool $validated
	 */
	protected $validated = false;

	/**
	 * Form constructor.
	 */
	public function __construct() {

	}

	/**
	 * @return bool
	 */
	public function validate() {
		foreach ( $this->pages as $page ):
			$validationResult = $page->validate();
			$this->errors     = array_merge( $validationResult === true ? [] : $validationResult, $this->errors );
		endforeach;

		$this->validated = true;

		return empty( $this->errors );
	}

	/**
	 * @return bool
	 */
	public function isValidated() {
		return (bool) $this->validated;
	}

	/**
	 * @return array
	 */
	public function errors() {
		return $this->errors;
	}

	/**
	 * @return array
	 */
	public function toArray() {
		$fields = [];
		foreach ( $this->pages as $page ):
			$fields = array_merge( $page->toArray(), $fields );
		endforeach;

		return $fields;
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return $this->render();
	}

	/**
	 * @return string
	 */
	public function render() {
		$form   = $this->getFormElement();
		$submit = $this->getSubmitButtonElement();
		$form->setInner( $this->pages );

		if ( $submit ):
			$form->appendToInner( $submit->render() );
		endif;

		return $form->render();
	}

	/**
	 * @return \TotalPollVendors\TotalCore\Helpers\Html
	 */
	public function getFormElement() {
		$form = new \TotalPollVendors\TotalCore\Helpers\Html(
			'form',
			[
				'action'  => '',
				'enctype' => 'multipart/form-data',
				'class'   => \TotalPollVendors\TotalCore\Application::getInstance()->env( 'slug' ) . '-form',
				'method'  => 'POST',
			]
		);

		return $form;
	}

	/**
	 * @return \TotalPollVendors\TotalCore\Helpers\Html
	 */
	public function getSubmitButtonElement() {
		$submit = new \TotalPollVendors\TotalCore\Helpers\Html(
			'button',
			[
				'type'  => 'submit',
				'class' => \TotalPollVendors\TotalCore\Application::getInstance()->env( 'slug' ) . '-button is-primary',
			],
			__( 'Submit', \TotalPollVendors\TotalCore\Application::getInstance()->env( 'slug' ) )
		);

		return $submit;
	}

	/**
	 * @param mixed $offset
	 *
	 * @return bool
	 */
	public function offsetExists( $offset ) {
		return isset( $this->pages[ $offset ] );
	}

	/**
	 * @param mixed $offset
	 *
	 * @return mixed
	 */
	public function offsetGet( $offset ) {
		return $this->pages[ $offset ];
	}

	/**
	 * @param mixed $offset
	 * @param mixed $value
	 */
	public function offsetSet( $offset, $value ) {
		if ( $offset === '' ):
			$offset = count( $this->pages );
		endif;

		$this->pages[ $offset ] = $value;
	}

	/**
	 * @param mixed $offset
	 */
	public function offsetUnset( $offset ) {
		unset( $this->pages[ $offset ] );
	}

	/**
	 * @return mixed
	 */
	public function current() {
		return current( $this->pages );
	}

	/**
	 * @return void
	 */
	public function next() {
		next( $this->pages );
	}

	/**
	 * @return int|mixed|null|string
	 */
	public function key() {
		return key( $this->pages );
	}

	/**
	 * @return bool
	 */
	public function valid() {
		return current( $this->pages ) !== false;
	}

	/**
	 * @return void
	 */
	public function rewind() {
		reset( $this->pages );
	}

	/**
	 * @return int
	 */
	public function count() {
		return count( $this->pages );
	}
}