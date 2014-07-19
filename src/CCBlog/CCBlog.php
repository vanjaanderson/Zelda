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
                ->AddInclude(__DIR__ . '/../adminsidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'], 
                  'user'=>$this->user,'controllers'=>$controllers,'contents'=>$content->ListAll(array('type'=>'post', 'order-by'=>'title', 'order-order'=>'DESC')),), 'sidebar');
   }

  /**
   * Display a post.
   *
   * @param $id integer the id of the page.
   */
  /*public function View($id=null) {
    $content = new CMContent($id);
    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    $this->views->SetTitle(htmlEnt($content['title']))
                ->AddInclude(__DIR__ . '/index.tpl.php', array(
                  'contents' => $content,
                ), 'primary')
                ->AddInclude(__DIR__ . '/sidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'], 
                  'user'=>$this->user,'controllers'=>$controllers,'contents'=>$content->ListAll(array('type'=>'post', 'order-by'=>'title', 'order-order'=>'DESC')),), 'sidebar');
  }*/

  /**
   * Display all posts.
   *
   * @param $id integer the id of the page.
   */
  public function ViewAll() {
    $content = new CMContent();
    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    $this->views->SetTitle('Inlägg')
                ->AddInclude(__DIR__ . '/view.tpl.php', array(
                  'content' => $content->ListAll(array('type'=>'post', 'order-by'=>'title', 'order-order'=>'DESC')),
                ), 'primary')
                ->AddInclude(__DIR__ . '/../sidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'], 
                  'user'=>$this->user,'controllers'=>$controllers,'contents'=>$content->ListAll(array('type'=>'post', 'order-by'=>'title', 'order-order'=>'DESC')),), 'sidebar');
  }
}

?>