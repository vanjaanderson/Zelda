<?php
/**
 * Controller for development and testing purpose, helpful methods for the developer.
 * 
 * @package ZeldaCore
 */

class CCDeveloper extends CObject implements IController {
  /**
   * Constructor
   */
  public function __construct() {
    parent::__construct();
  }

  /**
  * Implementing interface IController. All controllers must have an index action.
   */
  public function Index() {  
    $this->Menu();
    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    $this->views->SetTitle('Utvecklarkontroller')
                //->AddInclude(__DIR__ . '/index.tpl.php', array(), 'primary')
                ->AddInclude(__DIR__ . '/sidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'], 
                  'user'=>$this->user,'controllers'=>$controllers), 'sidebar');
  }

  /**
    * Display all items of the CObject.
    */
   public function DisplayObject() {   
    $this->Menu();
    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    $this->views->SetTitle('Utvecklarkontroller')
                //->AddInclude(__DIR__ . '/index.tpl.php', array(), 'primary')
                ->AddInclude(__DIR__ . '/sidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'], 
                  'user'=>$this->user,'controllers'=>$controllers), 'sidebar');
      
    $this->data['main'] .= <<<EOD
<h2>Dumpning av innehåll i CDeveloper</h2>
<p>Här är innehållet i kontrollern CDeveloper.</p>
EOD;
      $this->data['main'] .= '<pre>' . htmlentities(print_r($this, true)) . '</pre>';
   }

  /**
    * Create a list of links in the supported ways.
   */
  public function Links() {  
    $this->Menu();
    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    $this->views->SetTitle('Utvecklarkontroller')
                //->AddInclude(__DIR__ . '/index.tpl.php', array(), 'primary')
                ->AddInclude(__DIR__ . '/sidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'], 
                  'user'=>$this->user,'controllers'=>$controllers), 'sidebar');
    
    $url = 'developer/links';
    $current      = $this->request->CreateUrl($url);

    $this->request->cleanUrl = false;
    $this->request->querystringUrl = false;    
    $default      = $this->request->CreateUrl($url);
    
    $this->request->cleanUrl = true;
    $clean        = $this->request->CreateUrl($url);    
    
    $this->request->cleanUrl = false;
    $this->request->querystringUrl = true;    
    $querystring  = $this->request->CreateUrl($url);
    
    $this->data['main'] .= <<<EOD
<h2>CRequest::CreateUrl()</h2>
<p>Här är en lista på alla urls som skapas med metoden CreateUrl() i kontrollern CRequest.</p>
<ul>
<li><a href='$current'>Aktuell url-inställning</a>
<li><a href='$default'>Förinställd url-inställning</a>
<li><a href='$clean'>Enklaste url-utseendet</a>
<li><a href='$querystring'>Query-string url</a>
</ul>
<p>Här kan du testa olika url-inställningar.</p>
EOD;
  }

  /**
    * Create a method that shows the menu, same for all methods
   */
  private function Menu() {  
    $menu = array('developer', 'developer/index', 'developer/links', 'developer/display-object');
    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    $this->views->SetTitle('Utvecklarkontroller')
                //->AddInclude(__DIR__ . '/index.tpl.php', array(), 'primary')
                ->AddInclude(__DIR__ . '/sidebar.tpl.php', array('is_authenticated'=>$this->user['isAuthenticated'], 
                  'user'=>$this->user,'controllers'=>$controllers), 'sidebar');
    
    $html = null;
    foreach($menu as $val) {
      $html .= "<li><a href='" . $this->request->CreateUrl($val) . "'>$val</a>";  
    }
    
    $this->data['title'] = "Utvecklarkontroller";
    $this->data['main'] = <<<EOD
<h1>Utvecklarkontroller</h1>
<p>Detta kan du göra:</p>
<ul>
$html
</ul>
EOD;
  } 
}

?>