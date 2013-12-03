<?php

/**
 * A test controller for themes.
 * 
 * @package ZeldaCore
 */
class CCTheme extends CObject implements IController {

  /**
   * Constructor
   */
  public function __construct() { parent::__construct(); 
    $this->views->AddStyle('body:hover{background:#fff url('.$this->request->base_url.'themes/grid/grid_12_60_20.png) repeat-y center top;}');
  }

  /**
   * Display what can be done with this controller.
   */
  public function Index() {
    // Get a list of all kontroller methods
    $rc = new ReflectionClass(__CLASS__);
    $methods = $rc->getMethods(ReflectionMethod::IS_PUBLIC);
    $items = array();
    foreach($methods as $method) {
      if($method->name != '__construct' && $method->name != '__destruct' && $method->name != 'Index') {
        $items[] = $this->request->controller . '/' . mb_strtolower($method->name);
      }
   }

    $this->views->SetTitle('Theme')
                ->AddInclude(__DIR__ . '/index.tpl.php', array(
                  'theme_name' => $this->config['theme']['name'],
                  'methods' => $items,
                ));
  }

  /**
   * Put content in some regions.
   */
  public function SomeRegions() {
    $this->views->SetTitle('Visa innehåll i några regioner')
                ->AddString('This is the primary region', array(), 'primary');
                
    if(func_num_args()) {
      foreach(func_get_args() as $val) {
        $this->views->AddString("This is region: $val", array(), $val)
                    ->AddStyle('#'.$val.'{background-color:hsla(0,0%,90%,0.5);}');
      }
    }
  }

  /**
   * Put content in all regions.
   */
  public function AllRegions() {
    $this->views->SetTitle('Visa innehåll för alla regioner');
    foreach($this->config['theme']['regions'] as $val) {
      $this->views->AddString("This is region: $val", array(), $val)
                  ->AddStyle('#'.$val.'{background-color:hsla(0,0%,90%,0.5);}');
    }
  }
}

?>