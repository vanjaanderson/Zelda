<?php
/**
 * Holding a instance of CZelda to enable use of $this in subclasses.
 *
 * @package ZeldaCore
 */
class CObject {

	public $config;
	public $request;
	public $data;

	/**
	 * Constructor
	 */
	protected function __construct() {
    $ze = CZelda::Instance();
    $this->config   = &$ze->config;
    $this->request  = &$ze->request;
    $this->data     = &$ze->data;
  }
}

?>