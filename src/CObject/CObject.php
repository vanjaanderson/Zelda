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
  protected $ze;
  protected $config;
  protected $request;
  protected $data;
  protected $db;
  protected $views;
  protected $session;
  protected $user;

  /**
  * Constructor
  */
  protected function __construct($ze=null) {
    if(!$ze) {
      $ze = CZelda::Instance();
    }
    $this->ze       = &$ze;
    $this->config   = &$ze->config;
    $this->request  = &$ze->request;
    $this->data     = &$ze->data;
    $this->db       = &$ze->db;
    $this->views    = &$ze->views;
    $this->session  = &$ze->session;
    $this->user     = &$ze->user;
  }

  /**
   * Wrapper for same method in CZelda. See there for documentation.
   */
  protected function RedirectTo($urlOrController=null, $method=null, $arguments=null) {
    $this->ze->RedirectTo($urlOrController, $method, $arguments);
  }

  /**
   * Wrapper for same method in CZelda. See there for documentation.
   */
  protected function RedirectToController($method=null, $arguments=null) {
    $this->ze->RedirectToController($method, $arguments);
  }

  /**
   * Wrapper for same method in CZelda. See there for documentation.
   */
  protected function RedirectToControllerMethod($controller=null, $method=null, $arguments=null) {
    $this->ze->RedirectToControllerMethod($controller, $method, $arguments);
  }

  /**
   * Wrapper for same method in CZelda. See there for documentation.
   */
  protected function AddMessage($type, $message, $alternative=null) {
    return $this->ze->AddMessage($type, $message, $alternative);
  }

  /**
   * Wrapper for same method in CZelda. See there for documentation.
   */
  protected function CreateUrl($urlOrController=null, $method=null, $arguments=null) {
    return $this->ze->CreateUrl($urlOrController, $method, $arguments);
  }
}

?>