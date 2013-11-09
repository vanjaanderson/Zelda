<?php
/**
 * A form for creating a new user.
 * 
 * @package ZeldaCore
 */
class CFormUserCreate extends CForm {

  /**
   * Constructor
   */
  public function __construct($object) {
    parent::__construct();
    $this->AddElement(new CFormElementText('acronym', array('label'=>'Användarnamn:', 'required'=>true)))
         ->AddElement(new CFormElementPassword('password', array('label'=>'Lösenord:', 'required'=>true)))
         ->AddElement(new CFormElementPassword('password1', array('required'=>true, 'label'=>'Upprepa lösenord:')))
         ->AddElement(new CFormElementText('name', array('required'=>true, 'label'=>'Namn:')))
         ->AddElement(new CFormElementText('email', array('required'=>true, 'label'=>'E-post:')))
         ->AddElement(new CFormElementSubmit('create', array('value'=>'Skapa', 'callback'=>array($object, 'DoCreate'))));
         
    $this->SetValidation('acronym', array('not_empty'))
         ->SetValidation('password', array('not_empty'))
         ->SetValidation('password1', array('not_empty'))
         ->SetValidation('name', array('not_empty'))
         ->SetValidation('email', array('not_empty'));
  } 
}

?>
