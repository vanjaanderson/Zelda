<?php
/**
* A form to manage content.
* 
* @package ZeldaCore
*/
class CFormContent extends CForm {

  /**
   * Properties
   */
  private $content;

  /**
   * Constructor
   */
  public function __construct($content) {
    parent::__construct();
    $this->content = $content;

    // $out_allgroups = array('Everybody');
    // foreach($groups as $ogroup) {
    //   $out_allgroups[$ogroup['id']] = 'Member of: '.$ogroup['name'];
    // }
    
    // $filter = array('plain'=>'plain','php'=>'php','html'=>'html','htmlpurify'=>'htmlpurify','make_clickable'=>'make_clickable','bbcode'=>'bbcode','markdown'=>'markdown','markdownextra'=>'markdownextra','smartypants'=>'smartypants','typographer'=>'typographer');

    $save = isset($content['id']) ? 'save' : 'create';
    $this->AddElement(new CFormElementHidden('id',          array('value'   =>$content['id'])))
         ->AddElement(new CFormElementText('title',         array('required'=>true, 'label'           =>'Rubrik:', 'value'                        =>$content['title'])))
         ->AddElement(new CFormElementText('slug',          array('required'=>true, 'label'           =>'Alias:', 'value'                         =>$content['slug'])))
         ->AddElement(new CFormElementTextarea('data',      array('label'   =>'Innehåll:', 'value'    =>$content['data'])))
         ->AddElement(new CFormElementText('type',          array('required'=>true, 'label'           =>"Typ av innehåll <em class='smaller'>(post eller page)</em>:", 'value'=>$content['type'])))
         ->AddElement(new CFormElementSelect('filter',      array('label'   =>'Filter:', 'value'      =>$content['filter'])))
         // ->AddElement(new CFormElementSelect('accesslevel', array('options' =>$out_allgroups, 'label' => 'Access level', 'value'                  => $content['accesslevel'])))
         // ->AddElement(new CFormElementSubmit($save,         array('value'   =>'Spara', 'callback'     =>array($this, 'DoSave'), 'callback-args'   =>array($content))))
         // ->AddElement(new CFormElementSubmit('delete',      array('value'   =>'Radera', 'callback'    =>array($this, 'DoDelete'), 'callback-args' =>array($content))));
         ->AddElement(new CFormElementSubmit($save, array('callback'=>array($this, 'DoSave'), 'callback-args'=>array($content))))
         ->AddElement(new CFormElementSubmit('delete', array('callback'=>array($this, 'DoDelete'), 'callback-args'=>array($content))));

    $this->SetValidation('title', array('not_empty'))
         ->SetValidation('slug', array('not_empty'))
         ->SetValidation('type', array('post_or_page'));
  }
  
  /**
   * Callback to save the form content to database.
   */
  public function DoSave($form, $content) {
    $content['id']     = $form['id']['value'];
    $content['title']  = $form['title']['value'];
    // $content['accesslevel'] = $form['accesslevel']['value'];
    $content['slug']   = $form['slug']['value'];
    $content['data']   = $form['data']['value'];
    $content['type']   = $form['type']['value'];
    $content['filter'] = $form['filter']['value'];
    return $content->Save();
  }

  /**
   * Callback to delete the content.
   */
  public function DoDelete($form, $content) {
    $content['id'] = $form['id']['value'];
    $content->Delete();
    CZelda::Instance()->RedirectTo('content');
  }
}

?>