<?php
/**
* A blog controller to display a blog-like list of all content labelled as "post".
* 
* @package ZeldaCore
*/
class CCBlog extends CObject implements IController {

  /**
   * Constructor
   */
  public function __construct() {
    parent::__construct();
  }

  /**
   * Display all content of the type "post".
   */
  public function Index() {
    $content = new CMContent();
    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    $this->views->SetTitle('Blogg')
                ->AddInclude(__DIR__ . '/index.tpl.php', array(
                  'contents' => $content->ListAll(array('type'=>'post', 'order-by'=>'title', 'order-order'=>'DESC')),
                ), 'primary')
                ->AddInclude(__DIR__ . '/../sidebar.tpl.php', array('controllers'=>$controllers), 'sidebar');
  }

  /**
   * Display a blog.
   *
   * @param $id integer the id of the page.
   */
  public function View($id=null) {
    $content = new CMContent($id);
    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    $this->views->SetTitle(htmlEnt($content['title']))
                ->AddInclude(__DIR__ . '/index.tpl.php', array(
                  'contents' => $content,
                ), 'primary')
                ->AddInclude(__DIR__ . '/../sidebar.tpl.php', array('controllers'=>$controllers), 'sidebar');
  }

}

?>