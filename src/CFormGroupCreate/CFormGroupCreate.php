<?php
/**
* A form for creating a new group.
* 
* @package LatteCore
*/
class CFormGroupCreate extends CForm {

  /**
   * Constructor
   */
  public function __construct($object) {
    parent::__construct();
    $this->AddElement(new CFormElementText('acronym', array('label'=>'Användarnamn:', 'required'=>true)))
         ->AddElement(new CFormElementText('name', array('label'=>'Namn:', 'required'=>true)))
         ->AddElement(new CFormElementSubmit('create', array('value'=>'Skapa', 'callback'=>array($object, 'DoCreateGroup'))));
         
    $this->SetValidation('acronym', array('not_empty'))
         ->SetValidation('name', array('not_empty'));
  }
  
}