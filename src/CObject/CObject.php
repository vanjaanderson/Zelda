<?php
/**
* Holding a instance of CZelda to enable use of $this in subclasses.
*
* @package ZeldaCore
*/
class CObject {

  /**
  * Members
  */
  public $config;
  public $request;
  public $data;
  public $db;
  public $views;

  /**
  * Constructor
  */
  protected function __construct() {
    $ze = CZelda::Instance();
    $this->config   = &$ze->config;
    $this->request  = &$ze->request;
    $this->data     = &$ze->data;
    $this->db       = &$ze->db;
    $this->views    = &$ze->views;
  }
}

?>