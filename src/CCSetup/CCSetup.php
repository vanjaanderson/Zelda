<?php
/**
* Standard controller layout.
* 
* @package ZeldaCore
*/
class CCSetup extends CObject implements IController {

  /**
  * Constructor
  */
  public function __construct() {
    parent::__construct();
  }

  /**
   * Implementing interface IController. All controllers must have an index action.
   */
  public function Index() {     
    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    $this->views->SetTitle('Installera')
                ->AddInclude(__DIR__ . '/index.tpl.php', array(), 'primary')
                ->AddInclude(__DIR__ . '/sidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'], 
                  'user'=>$this->user,'controllers'=>$controllers), 'sidebar');
  }
}

?>