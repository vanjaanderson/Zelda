<?php
/**
* A user controller to manage content.
* 
* @package ZeldaCore
*/
class CCContent extends CObject implements IController {

  /**
   * Constructor
   */
  public function __construct() { parent::__construct(); }

  /**
   * Show a listing of all content.
   */
  public function Index() {
    $content = new CMContent();
    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    $this->views->SetTitle('Innehållskontroller')
                ->AddInclude(__DIR__ . '/index.tpl.php', array(
                  'contents' => $content->ListAll(),
                ), 'primary')
                ->AddInclude(__DIR__ . '/../sidebar.tpl.php', array('controllers'=>$controllers), 'sidebar');
  }
  
  /**
   * Edit a selected content, or prepare to create new content if argument is missing.
   *
   * @param id integer the id of the content.
   */
  public function Edit($id=null) {
    $content = new CMContent($id);
    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    $form = new CFormContent($content);
    $status = $form->Check();
    if($status === false) {
      $this->AddMessage('notice', 'Formuläret kunde inte skickas.');
      $this->RedirectToController('edit', $id);
    } else if($status === true) {
      $this->RedirectToController('edit', $content['id']);
    }
    
    $title = isset($id) ? 'Ändra' : 'Skapa';
    $this->views->SetTitle("$title innehåll: ".htmlEnt($content['title']))
                ->AddInclude(__DIR__ . '/edit.tpl.php', array(
                  'user'=>$this->user, 
                  'content'=>$content, 
                  'form'=>$form,
                ), 'primary')
                ->AddInclude(__DIR__ . '/../sidebar.tpl.php', array('controllers'=>$controllers), 'sidebar');
  }
  
  /**
   * Create new content.
   */
  public function Create() {
    $this->Edit();
  }

  /**
   * Init the content database.
   */
  public function Init() {
    $content = new CMContent();
    $content->Init();
    $this->RedirectToController();
  }
  
  /*public function Manage() {
    $content = new CMContent();
    $content->Manage('install');
    $this->RedirectToController();
  }*/
}

?>