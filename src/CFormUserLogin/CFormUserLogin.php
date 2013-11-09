<?php
/**
 * A form to login the user profile.
 * 
 * @package ZeldaCore
 */
class CFormUserLogin extends CForm {

  /**
   * Constructor
   */
  public function __construct($object) {
    parent::__construct();
    $this->AddElement(new CFormElementText('acronym', array('label'=>'Användarnamn:')))
         ->AddElement(new CFormElementPassword('password', array('label'=>'Lösenord:')))
         ->AddElement(new CFormElementSubmit('login', array('value'=>'Logga in', 'callback'=>array($object, 'DoLogin'))));

  	$this->SetValidation('acronym', array('not_empty'))
         ->SetValidation('password', array('not_empty'));
  }
}

?>