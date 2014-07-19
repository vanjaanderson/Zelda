<?php
/**
 * To manage and analyse all modules of Zelda.
 * 
 * @package ZeldaCore
 */
class CCModules extends CObject implements IController {

  /**
   * Constructor
   */
  public function __construct() { parent::__construct(); }


  /**
   * Show a index-page and display what can be done through this controller.
   */
  public function Index() {
    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    $allModules = $modules->ReadAndAnalyse();
    $this->views->SetTitle('Hantera moduler')
                ->AddInclude(__DIR__ . '/index.tpl.php', array('controllers'=>$controllers), 'primary')
                ->AddInclude(__DIR__ . '/../adminsidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'], 
                  'user'=>$this->user,'modules'=>$allModules,'controllers'=>$controllers), 'sidebar');
  }

  /**
   * Show a index-page and display what can be done through this controller.
   */
  public function Install() {
    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    $results = $modules->Install();
    $allModules = $modules->ReadAndAnalyse();
    $this->views->SetTitle('Installera moduler')
                ->AddInclude(__DIR__ . '/install.tpl.php', array('modules'=>$results), 'primary')
                ->AddInclude(__DIR__ . '/../adminsidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'], 
                  'user'=>$this->user,'modules'=>$allModules,'controllers'=>$controllers), 'sidebar');
  }

  /**
   * Show a module and its parts.
   */
  public function View($module=null) {
    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    $allModules = $modules->ReadAndAnalyse();
    $this->views->SetTitle('Hantera moduler')
                ->AddInclude(__DIR__ . '/../adminsidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'], 
                  'user'=>$this->user,'modules'=>$allModules,'controllers'=>$controllers), 'sidebar');

    if(!preg_match('/^C[a-zA-Z]+$/', $module)) {throw new Exception('Ogiltiga tecken i modulnamnet.');}
    $aModule = $modules->ReadAndAnalyseModule($module);
    $this->views->AddInclude(__DIR__ . '/view.tpl.php', array('modules'=>$aModule), 'primary');
  }
}