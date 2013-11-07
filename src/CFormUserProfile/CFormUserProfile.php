<?php
/**
 * A form for editing the user profile.
 * 
 * @package ZeldaCore
 */
class CFormUserProfile extends CForm {

  /**
   * Constructor
   */
  public function __construct($object, $user) {
    parent::__construct();
    $this->AddElement(new CFormElementText('acronym', array('readonly'=>true, 'label'=>'Användarnamn:', 'value'=>$user['acronym'])))
         ->AddElement(new CFormElementPassword('password', array('label'=>'Lösenord:')))
         ->AddElement(new CFormElementPassword('password1', array('label'=>'Lösenord igen:')))
         ->AddElement(new CFormElementSubmit('change_password', array('value'=>'Ändra lösenord', 'callback'=>array($object, 'DoChangePassword'))))
         ->AddElement(new CFormElementText('name', array('label'=>'Namn:', 'value'=>$user['name'], 'required'=>true)))
         ->AddElement(new CFormElementText('email', array('label'=>'E-post:', 'value'=>$user['email'], 'required'=>true)))
         ->AddElement(new CFormElementSubmit('save', array('value'=>'Spara', 'callback'=>array($object, 'DoProfileSave'))));
  } 
}

?>