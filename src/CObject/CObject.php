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
  public $session;

  /**
  * Constructor
  */
  protected function __construct($ze=null) {
    if(!$ze) {
      $ze = CZelda::Instance();
    } 
    $this->config   = &$ze->config;
    $this->request  = &$ze->request;
    $this->data     = &$ze->data;
    $this->db       = &$ze->db;
    $this->views    = &$ze->views;
    $this->session  = &$ze->session;
    $this->user     = &$ze->user;
  }

  /**
  * Redirect to another url and store the session
  */
  protected function RedirectTo($urlOrController=null, $method=null) {
    $ze = CZelda::Instance();
    if(isset($ze->config['debug']['db-num-queries']) && $ze->config['debug']['db-num-queries'] && isset($ze->db)) {
      $this->session->SetFlash('database_numQueries', $this->db->GetNumQueries());
    }    
    if(isset($ze->config['debug']['db-queries']) && $ze->config['debug']['db-queries'] && isset($ze->db)) {
      $this->session->SetFlash('database_queries', $this->db->GetQueries());
    }    
    if(isset($ze->config['debug']['timer']) && $ze->config['debug']['timer']) {
      $this->session->SetFlash('timer', $ze->timer);
    }    
    $this->session->StoreInSession();
    header('Location: ' . $this->request->CreateUrl($urlOrController, $method));
  }
/**
   * Redirect to a method within the current controller. Defaults to index-method. Uses RedirectTo().
   *
   * @param string method name the method, default is index method.
   */
  protected function RedirectToController($method=null) {
    $this->RedirectTo($this->request->controller, $method);
  }

  /**
   * Redirect to a controller and method. Uses RedirectTo().
   *
   * @param string controller name the controller or null for current controller.
   * @param string method name the method, default is current method.
   */
  protected function RedirectToControllerMethod($controller=null, $method=null) {
    $controller = is_null($controller) ? $this->request->controller : null;
    $method = is_null($method) ? $this->request->method : null;   
    $this->RedirectTo($this->request->CreateUrl($controller, $method));
  }
  /**
   * Save a message in the session. Uses $this->session->AddMessage()
   *
   * @param $type string the type of message, for example: notice, info, success, warning, error.
   * @param $message string the message.
   */
  protected function AddMessage($type, $message) {
    $this->session->AddMessage($type, $message);
  }

  /**
   * Create an url. Uses $this->request->CreateUrl()
   *
   * @param $urlOrController string the relative url or the controller
   * @param $method string the method to use, $url is then the controller or empty for current
   * @param $arguments string the extra arguments to send to the method
   */
  protected function CreateUrl($urlOrController=null, $method=null, $arguments=null) {
    $this->request->CreateUrl($urlOrController, $method, $arguments);
  }
}

?>