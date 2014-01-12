<?php
/**
 * Sample controller for a site builder.
 */
class CCMycontroller extends CObject implements IController {

  
  /**
   * Constructor
   */
  public function __construct() { parent::__construct(); }
  
  /**
   * Index page
   */
  public function Index() {
    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    $this->views->SetTitle('Välkommen')
                ->AddInclude(__DIR__ . '/index.tpl.php', array(
                  'is_authenticated'=>$this->user['isAuthenticated'], 
                  'user'=>$this->user,
                ), 'primary')
                ->AddInclude(__DIR__ . '/sidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'], 
                  'user'=>$this->user,'controllers'=>$controllers), 'sidebar');
  }

  /**
   * The page about me
   */
  public function Page() {
    $content = new CMContent(1);
    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    $this->views->SetTitle('Exempelsida')
                ->AddInclude(__DIR__ . '/page.tpl.php', array(
                  'is_authenticated'=>$this->user['isAuthenticated'], 
                  'user'=>$this->user,
                  'content' => $content,
                ), 'primary')
                ->AddInclude(__DIR__ . '/sidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'], 
                  'user'=>$this->user,'controllers'=>$controllers), 'sidebar');
  }

  /**
   * The blog.
   */
  public function Blog() {
    $content = new CMContent();
    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    $this->views->SetTitle('Min blogg')
                ->AddInclude(__DIR__ . '/blog.tpl.php', array(
                  'is_authenticated'=>$this->user['isAuthenticated'], 
                  'user'=>$this->user,
                  'contents' => $content->ListAll(array('type'=>'post', 'order-by'=>'title', 'order-order'=>'ASC')),
                  ), 'primary')
                ->AddInclude(__DIR__ . '/sidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'], 
                  'user'=>$this->user,'controllers'=>$controllers), 'sidebar');
  }

  /**
   * The guestbook.
   */
  public function Guestbook() {
    $guestbook = new CMGuestbook();
    $form = new CFormMyGuestbook($guestbook);
    $status = $form->Check();
    if($status === false) {
      $this->AddMessage('notice', 'Formuläret kunde inte skickas.');
      $this->RedirectToControllerMethod();
    } else if($status === true) {
      $this->RedirectToControllerMethod();
    }
    
    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    $this->views->SetTitle('Min Gästbok')
         ->AddInclude(__DIR__ . '/guestbook.tpl.php', array(
            'is_authenticated'=>$this->user['isAuthenticated'], 
            'user'=>$this->user,
            'entries'=>$guestbook->ReadAll(), 
            'form'=>$form,
         ), 'primary')
                ->AddInclude(__DIR__ . '/sidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'], 
                  'user'=>$this->user,'controllers'=>$controllers), 'sidebar');
  }
} 

/**
 * Form for the guestbook
 */
class CFormMyGuestbook extends CForm {

  /**
   * Properties
   */
  private $object;

  /**
   * Constructor
   */
  public function __construct($object) {
    parent::__construct();
    $this->objecyt = $object;
    $this->AddElement(new CFormElementTextarea('data', array('label'=>'Nytt meddelande:')))
         ->AddElement(new CFormElementSubmit('Spara', array('callback'=>array($this, 'DoAdd'), 'callback-args'=>array($object))));
  }
  
  /**
   * Callback to add the form content to database.
   */
  public function DoAdd($form, $object) {
    return $object->Add(strip_tags($form['data']['value']));
  } 
}

?>