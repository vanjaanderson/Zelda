<?php
/**
* A guestbook controller as an example to show off some basic controller and model-stuff.
* 
* @package ZeldaCore
*/
class CCGuestbook extends CObject implements IController {

  private $guestbookModel;
  
  /**
   * Constructor
   */
  public function __construct() {
    parent::__construct();
    $this->guestbookModel = new CMGuestbook();
  }

  /**
   * Implementing interface IController. All controllers must have an index action.
   * Show a standard frontpage for the guestbook.
   */
  public function Index() {
    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    $this->views->SetTitle('Zelda Gästbok');
    $this->views->AddInclude(__DIR__ . '/index.tpl.php', array(
      'entries'=>$this->guestbookModel->ReadAll(), 
      'formAction'=>$this->request->CreateUrl('', 'handler')
    ), 'primary')
                ->AddInclude(__DIR__ . '/../adminsidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'], 
                  'user'=>$this->user,'controllers'=>$controllers), 'sidebar');
  }
  
  /**
   * Handle posts from the form and take appropriate action.
   */
  public function Handler() {
    // spam protection
    if(empty($_POST['email']) && isset($_POST['doAdd'])) {
      $this->guestbookModel->Add(strip_tags($_POST['newEntry']));
    }
    elseif(isset($_POST['doClear'])) {
      $this->guestbookModel->DeleteAll();
    }
    elseif(isset($_POST['doCreate'])) {
      $this->guestbookModel->Init();
    }            
    $this->RedirectTo($this->request->CreateUrl($this->request->controller));
  }
}

?>