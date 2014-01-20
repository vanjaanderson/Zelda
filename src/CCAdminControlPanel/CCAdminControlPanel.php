<?php
/**
 * Admin Control Panel to manage admin stuff.
 * 
 * @package ZeldaCore
 */
class CCAdminControlPanel extends CObject implements IController {

  /**
   * Constructor
   */
  public function __construct() {
    parent::__construct();
  }

  /**
   * Show profile information of the user.
   */
  public function Index() {
    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    $this->views->SetTitle('AKP: Admin KontrollPanel')
                ->AddInclude(__DIR__ . '/index.tpl.php', array(), 'primary')
                ->AddInclude(__DIR__ . '/sidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'], 
                  'user'=>$this->user,'controllers'=>$controllers), 'sidebar');
  } 
}

?>