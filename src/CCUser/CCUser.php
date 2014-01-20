<?php
/**
* A user controller  to manage login and view edit the user profile.
* 
* @package ZeldaCore
*/
class CCUser extends CObject implements IController {

  //private $userModel;
  
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
    $this->views->SetTitle('Användarkontroller')
                ->AddInclude(__DIR__ . '/index.tpl.php', array(
                  'is_authenticated'=>$this->user['isAuthenticated'], 
                  'user'=>$this->user,
                ), 'primary')
                ->AddInclude(__DIR__ . '/sidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'], 
                  'user'=>$this->user,'controllers'=>$controllers), 'sidebar');
  }

  /**
   * View and edit user profile.
   */
  public function Profile() {    
    $form = new CFormUserProfile($this, $this->user);
    if($form->Check() === false) {
      $this->AddMessage('notice', 'Formuläret kunde inte skickas, eftersom vissa fält ej är ifyllda.');
      $this->RedirectToController('profile');
    }

    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    $this->views->SetTitle('Användarprofil')
                ->AddInclude(__DIR__ . '/profile.tpl.php', array(
                  'is_authenticated'=>$this->user['isAuthenticated'], 
                  'user'=>$this->user,
                  'profile_form'=>$form->GetHTML(),
                ), 'primary')
                ->AddInclude(__DIR__ . '/sidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'], 
                  'user'=>$this->user,'controllers'=>$controllers), 'sidebar');
  }

  /**
   * Change the password.
   */
  public function DoChangePassword($form) {
    if($form['password']['value'] != $form['password1']['value'] || empty($form['password']['value']) || empty($form['password1']['value'])) {
      $this->AddMessage('error', 'Lösenordet är tomt eller matchar inte.');
    } else {
      $ret = $this->user->ChangePassword($form['password']['value']);
      $this->AddMessage($ret, 'Nytt lösenord sparat.', 'Uppdatering av lösenordet misslyckades.');
    }
    $this->RedirectToController('profile');
  }

  /**
   * Save updates to profile information.
   */
  public function DoProfileSave($form) {
    $this->user['name'] = $form['name']['value'];
    $this->user['email'] = $form['email']['value'];
    $ret = $this->user->Save();
    $this->AddMessage($ret, 'Profil sparad.', 'Uppdatering av profil misslyckades.');
    $this->RedirectToController('profile');
  }

  /**
   * Authenticate and login a user.
   */
    /**
   * Authenticate and login a user.
   */
  public function Login() {
    $form = new CFormUserLogin($this);
    if($form->Check() === false) {
      $this->AddMessage('notice', 'Du måste fylla i användarnamn och lösenord.');
      $this->RedirectToController('login');
    }
    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    $this->views->SetTitle('Logga in')
                ->AddInclude(__DIR__ . '/login.tpl.php', array(
                  'login_form' => $form,
                  'allow_create_user' => CZelda::Instance()->config['create_new_users'],
                  'create_user_url' => $this->CreateUrl(null, 'create'),
                ), 'primary')
                ->AddInclude(__DIR__ . '/sidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'], 
                  'user'=>$this->user,'controllers'=>$controllers), 'sidebar');
  }
  
  /**
   * Perform a login of the user as callback on a submitted form.
   */
  public function DoLogin($form) {
    if($this->user->Login($form['acronym']['value'], $form['password']['value'])) {
      $this->AddMessage('success', "Välkommen {$this->user['name']}.");
      $this->RedirectToController('profile');
    } else {
      $this->AddMessage('notice', "Inloggningen misslyckades, eftersom användarnamnet eller lösenordet är fel.");
      $this->RedirectToController('login');      
    }
  }
  
  /**
   * Logout a user.
   */
  public function Logout() {
    $this->user->Logout();
    $this->RedirectToController('login');
  }

  /**
   * Create a new user.
   */
  public function Create() {
    $form = new CFormUserCreate($this);
    if($form->Check() === false) {
      $this->AddMessage('notice', 'Du måste fylla i alla fält.');
      $this->RedirectToController('Create');
    }
    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    $this->views->SetTitle('Skapa användare')
                ->AddInclude(__DIR__ . '/create.tpl.php', array('form' => $form->GetHTML()), 'primary')
                ->AddInclude(__DIR__ . '/sidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'], 
                  'user'=>$this->user,'controllers'=>$controllers), 'sidebar');
  }
  
  /**
   * Perform a creation of a user as callback on a submitted form.
   *
   * @param $form CForm the form that was submitted
   */
  public function DoCreate($form) { 
    if($form['password']['value'] != $form['password1']['value'] || empty($form['password']['value']) || empty($form['password1']['value'])) {
      $this->AddMessage('error', 'Lösenordet är tomt eller matchar inte.');
      $this->RedirectToController('create');
    } else if($this->user->Create($form['acronym']['value'], 
                           $form['password']['value'],
                           $form['name']['value'],
                           $form['email']['value']
                           )) {
      $this->AddMessage('success', "Välkommen {$this->user['name']}. Du har nu skapat en ny användare.");
      $this->user->Login($form['acronym']['value'], $form['password']['value']);
      $this->RedirectToController('profile');
    } else {
      $this->AddMessage('notice', "Du misslyckades med att skapa ny användare.");
      $this->RedirectToController('create');
    }
  }
 
  /**
   * Init the user database.
   */ 
  /*public function Manage() {
    $content = new CMUser();
    $content->Manage('install');
    $this->RedirectToController();
  }*/
}

?>