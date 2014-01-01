<?php
/**
* A page controller to display a page, for example an about-page, displays content labelled as "page".
* 
* @package ZeldaCore
*/
class CCPage extends CObject implements IController {

  /**
   * Constructor
   */
  public function __construct() {
    parent::__construct();
  }

  /**
   * Display an empty page.
   */
  public function Index() {
    $content = new CMContent();
    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    $this->views->SetTitle('Sida')
                ->AddInclude(__DIR__ . '/index.tpl.php', array(
                  'content' => null,
                ), 'primary')
                ->AddInclude(__DIR__ . '/../sidebar.tpl.php', array('controllers'=>$controllers), 'sidebar');
  }

  /**
   * Display a page.
   *
   * @param $id integer the id of the page.
   */
  public function View($id=null) {
    $content = new CMContent($id);
    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    $this->views->SetTitle('Sida: '.htmlEnt($content['title']))
                ->AddInclude(__DIR__ . '/index.tpl.php', array(
                  'content' => $content,
                ), 'primary')
                ->AddInclude(__DIR__ . '/../sidebar.tpl.php', array('controllers'=>$controllers), 'sidebar');
  }
}

?>