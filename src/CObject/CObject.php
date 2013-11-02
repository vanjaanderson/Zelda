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
  protected function __construct() {
    $ze = CZelda::Instance();
    $this->config   = &$ze->config;
    $this->request  = &$ze->request;
    $this->data     = &$ze->data;
    $this->db       = &$ze->db;
    $this->views    = &$ze->views;
    $this->session  = &$ze->session;
  }

  /**
  * Redirect to another url and store the session
  */
  protected function RedirectTo($url) {
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
    header('Location: ' . $this->request->CreateUrl($url));
  }
}

?>