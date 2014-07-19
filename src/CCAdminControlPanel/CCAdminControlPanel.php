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
    $content = new CMContent();
    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    $this->views->SetTitle('AKP: Admin KontrollPanel')
                ->AddInclude(__DIR__ . '/index.tpl.php', array(), 'primary')
                ->AddInclude(__DIR__ . '/../adminsidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'], 
                  'user'=>$this->user,'controllers'=>$controllers,'contents'=>$content->ListAll(array('type'=>'post', 'order-by'=>'title', 'order-order'=>'DESC')),), 'sidebar');
  } 

/**
 * New from 2014-05-17
 */

/**
   * View and edit user profile.
   */
  public function Users($id = null) {
    $content = new CMContent();
    $users = new CMAdminControlPanel();
    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    if(isset($id)) {
    $allgroups = $users->ListAllGroups(); 
    $memberships = $users->GetGroupMemberships($id);
    $form = new CFormAdminUserProfile($this, $users->GetUser($id), $allgroups, $memberships);
    $form->Check();

    $this->views->SetTitle('User Profile')
                ->AddInclude(__DIR__ . '/edituser.tpl.php', array(
                  'is_authenticated'=>$this->user['isAuthenticated'], 
                  'user'=>$this->user,
                  'edituser' => $users->GetUser($id),
                  'profile_form'=>$form->GetHTML(),
                ))
                ->AddInclude(__DIR__ . '/../sidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'],'user'=>$this->user,'controllers'=>$controllers,'contents'=>$content->ListAll(array('type'=>'post', 'order-by'=>'title', 'order-order'=>'DESC')),), 'sidebar');
    } else {
    $this->views->SetTitle('User Profile')
                ->AddInclude(__DIR__ . '/users.tpl.php', array(
                  'is_authenticated'=>$this->user['isAuthenticated'], 
                  'user'=>$this->user,
                  'allusers' => $users->ListAllUsers(),
                ))
                ->AddInclude(__DIR__ . '/../sidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'],'user'=>$this->user,'controllers'=>$controllers,'contents'=>$content->ListAll(array('type'=>'post', 'order-by'=>'title', 'order-order'=>'DESC')),), 'sidebar');
    }
  }
  
  
  /**
   * View and edit groups.
   */
  public function Groups($id = null) {
    $content = new CMContent();
    $groups = new CMAdminControlPanel();
    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    if(isset($id)) {
    $form = new CFormGroupProfile($this, $groups->GetGroup($id));
    $form->Check();
    $this->views->SetTitle('Group Profile')
                ->AddInclude(__DIR__ . '/editgroup.tpl.php', array(
                  'is_authenticated'=>$this->user['isAuthenticated'], 
                  'user'=>$this->user,
                  'editgroup' => $groups->GetGroup($id),
                  'group_form'=>$form->GetHTML(),
                ))
                ->AddInclude(__DIR__ . '/../sidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'],'user'=>$this->user,'controllers'=>$controllers,'contents'=>$content->ListAll(array('type'=>'post', 'order-by'=>'title', 'order-order'=>'DESC')),), 'sidebar');
    } else {
    $this->views->SetTitle('Group Profiles')
                ->AddInclude(__DIR__ . '/groups.tpl.php', array(
                  'is_authenticated'=>$this->user['isAuthenticated'], 
                  'user'=>$this->user,
                  'allgroups' => $groups->ListAllGroups(),
                ))
                ->AddInclude(__DIR__ . '/../sidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'],'user'=>$this->user,'controllers'=>$controllers,'contents'=>$content->ListAll(array('type'=>'post', 'order-by'=>'title', 'order-order'=>'DESC')),), 'sidebar');
    }
  }

  /**
   * Change the password.
   */
  public function DoChangePassword($form) {
    if($form['password']['value'] != $form['password1']['value'] || empty($form['password']['value']) || empty($form['password1']['value'])) {
      $this->AddMessage('error', 'Password does not match or is empty.');
    } else {
      $this->edituser = new CMAdminControlPanel();
      $ret = $this->edituser->ChangePassword($form['password']['value'],$form['id']['value']);
      $this->AddMessage($ret, 'Saved new password.', 'Failed updating password.');
    }
    $this->RedirectToController('users/'.$form['id']['value']);
  }
  

  /**
   * Save updates to profile information.
   */
  public function DoProfileSave($form) {
    $this->edituser = new CMAdminControlPanel();
    $ret = $this->edituser->Save($form['name']['value'], $form['email']['value'], $form['id']['value'], $form['groups']);
    $this->AddMessage($ret, 'Saved profile.', 'Failed saving profile.');
    $this->RedirectToController('users/'.$form['id']['value']);
  }
  

  /**
   * Save updates to group information.
   */
  public function DoGroupSave($form) {
    $this->editgroup = new CMAdminControlPanel();
    $ret = $this->editgroup->SaveGroup($form['acronym']['value'], $form['name']['value'], $form['id']['value']);
    $this->AddMessage($ret, 'Saved group.', 'Failed saving profile.');
    $this->RedirectToController('groups/'.$form['id']['value']);
  }
  

  /**
   * Create a new user.
   */
  public function Create() {
    $content = new CMContent();
    $form = new CFormUserCreate($this);
    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    if($form->Check() === false) {
      $this->AddMessage('notice', 'You must fill in all values.');
      $this->RedirectToController('Create');
    }
    $this->views->SetTitle('Create user')
                ->AddInclude(__DIR__ . '/create.tpl.php', array('form' => $form->GetHTML()), 'primary')
                ->AddInclude(__DIR__ . '/../sidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'],'user'=>$this->user,'controllers'=>$controllers,'contents'=>$content->ListAll(array('type'=>'post', 'order-by'=>'title', 'order-order'=>'DESC')),), 'sidebar');
  }
  

  /**
   * Create a new user.
   */
  public function CreateGroup() {
    $content = new CMContent();
    $form = new CFormGroupCreate($this);
    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    if($form->Check() === false) {
      $this->AddMessage('notice', 'You must fill in all values.');
      $this->RedirectToController('CreateGroup');
    }
    $this->views->SetTitle('Create group')
                ->AddInclude(__DIR__ . '/creategroup.tpl.php', array('form' => $form->GetHTML()), 'primary')
                ->AddInclude(__DIR__ . '/../sidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'],'user'=>$this->user,'controllers'=>$controllers,'contents'=>$content->ListAll(array('type'=>'post', 'order-by'=>'title', 'order-order'=>'DESC')),), 'sidebar');
  }

  /**
   * Perform a creation of a user as callback on a submitted form.
   *
   * @param $form CForm the form that was submitted
   */
  public function DoCreate($form) {
    if($form['password']['value'] != $form['password1']['value'] || empty($form['password']['value']) || empty($form['password1']['value'])) {
      $this->AddMessage('error', 'Password does not match or is empty.');
      $this->RedirectToController('create');
    } else if($this->user->Create($form['acronym']['value'], 
                           $form['password']['value'],
                           $form['name']['value'],
                           $form['email']['value']
                           )) {
      $this->AddMessage('success', "You have successfully created an account for {$form['name']['value']}.");
      $this->RedirectToController('users');
    } else {
      $this->AddMessage('notice', "Failed to create an account.");
      $this->RedirectToController('create');
    }
  }
  
  /**
   * Delete a user as callback on a submitted form.
   *
   * @param $form CForm the form that was submitted
   */
  public function DoDeleteUser($form) {
    if($this->user->DeleteUser($form['id']['value'])) {
      $this->AddMessage('success', "You have successfully deleted the user");
      $this->RedirectToController('users');
    } else {
      $this->AddMessage('notice', "Failed to delete user.");
      $this->RedirectToController('users');
    }
  }

  /**
   * Perform a creation of a group as callback on a submitted form.
   *
   * @param $form CForm the form that was submitted
   */
  public function DoCreateGroup($form) {   
    $acp = new CMAdminControlPanel();
    if($acp->CreateGroup($form['acronym']['value'], 
                              $form['name']['value']
                  )) {
      $this->AddMessage('success', "You have successfully created the group {$form['name']['value']}.");
      $this->RedirectToController('groups');
    } else {
      $this->AddMessage('notice', "Failed to create an account.");
      $this->RedirectToController('creategroup');
    }
  }

  /**
   * Delete a group as callback on a submitted form.
   *
   * @param $form CForm the form that was submitted
   */
  public function DoDeleteGroup($form) {   
    $acp = new CMAdminControlPanel();
    if($acp->DeleteGroup($form['id']['value'])) {
      $this->AddMessage('success', "You have successfully deleted the group");
      $this->RedirectToController('groups');
    } else {
      $this->AddMessage('notice', "Failed to delete group.");
      $this->RedirectToController('groups');
    }
  }
}
?>