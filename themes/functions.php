<?php
/**
* Helpers for theming, available for all themes in their template files and functions.php.
* This file is included right before the themes own functions.php
*/

/**
* Print debuginformation from the framework.
 */
function get_debug() {
  // Only if debug is wanted.
  $ze = CZelda::Instance(); 
  if(empty($ze->config['debug'])) {
    return;
  }
  
  // Get the debug output
  $html = null;
  if(isset($ze->config['debug']['db-num-queries']) && $ze->config['debug']['db-num-queries'] && isset($ze->db)) {
    $flash = $ze->session->GetFlash('database_numQueries');
    $flash = $flash ? "$flash + " : null;
    $html .= "<div class='infobox'><p>Databasen gjorde $flash" . $ze->db->GetNumQueries() . " förfrågan / förfrågningar.</p>";
  }    
  if(isset($ze->config['debug']['db-queries']) && $ze->config['debug']['db-queries'] && isset($ze->db)) {
    $flash = $ze->session->GetFlash('database_queries');
    $queries = $ze->db->GetQueries();
    if($flash) {
      $queries = array_merge($flash, $queries);
    }
    $html .= "<p>Databasen gjorde nedanstående förfrågningar:</p><pre class='red'>" . implode('<br/><br/>', $queries) . "</pre>";
  }    
  if(isset($ze->config['debug']['timer']) && $ze->config['debug']['timer']) {
    $html .= "<p>Sidan laddades på " . round(microtime(true) - $ze->timer['first'], 5)*1000 . " msek.</p>";
  }    
  if(isset($ze->config['debug']['zelda']) && $ze->config['debug']['zelda']) {
    $html .= "<hr><h3>Debuginformation</h3><p>Innehåll i CZelda:</p><pre>" . htmlent(print_r($ze, true)) . "</pre>";
  }    
  if(isset($ze->config['debug']['session']) && $ze->config['debug']['session']) {
    $html .= "<hr><h3>SESSION</h3><p>Innehåll i CZelda->session:</p><pre>" . htmlent(print_r($ze->session, true)) . "</pre>";
    $html .= "<p>Innehåll i \$_SESSION:</p><pre>" . htmlent(print_r($_SESSION, true)) . "</pre></div>";
  }    
  return $html;
}

/**
 * Get messages stored in flash-session.
 */
function get_messages_from_session() {
  $messages = CZelda::Instance()->session->GetMessages();
  $html = null;
  if(!empty($messages)) {
    foreach($messages as $val) {
      $valid = array('info', 'notice', 'success', 'warning', 'error', 'alert');
      $class = (in_array($val['type'], $valid)) ? $val['type'] : 'info';
      $html .= "<div class='$class'>{$val['message']}</div>\n";
    }
  }
  return $html;
}

/**
 * Login menu. Creates a menu which reflects if user is logged in or not.
 */
function login_menu() {
  $ze = CZelda::Instance();
  if($ze->user['isAuthenticated']) {
    $items = "<a href='" . create_url('user/profile') . "'><img class='gravatar' src='" . get_gravatar(20) . "' alt=''> " . $ze->user['acronym'] . "</a> ";
    if($ze->user['hasRoleAdministrator']) {
      $items .= "<a href='" . create_url('akp') . "'>akp</a> ";
    }
    $items .= " <span class='grey'>|</span> <a href='" . create_url('user/logout') . "'>logga ut</a> ";
  } else {
    $items = "<a href='" . create_url('user/login') . "'>logga in</a> ";
  }
  return "<nav id='login-menu'>$items</nav>";
}

/**
* Get a gravatar based on the user's email.
*/
function get_gravatar($size=null) {
  return 'http://www.gravatar.com/avatar/' . md5(strtolower(trim(CZelda::Instance()->user['email']))) . '.jpg?r=pg&amp;d=wavatar&amp;' . ($size ? "s=$size" : null);
}

/**
 * Escape data to make it safe to write in the browser.
 */
function esc($str) {
  return htmlEnt($str);
}

/**
 * Filter data according to a filter. Uses CMContent::Filter()
 *
 * @param $data string the data-string to filter.
 * @param $filter string the filter to use.
 * @returns string the filtered string.
 */
function filter_data($data, $filter) {
  return CMContent::Filter($data, $filter);
}

/**
 * Display diff of time between now and a datetime. 
 *
 * @param $start datetime|string
 * @returns string
 */
function time_diff($start) {
  return formatDateTimeDiff($start);
}

/**
* Create a url by prepending the base_url.
*/
function base_url($url=null) {
  return CZelda::Instance()->request->base_url . trim($url, '/');
}

/**
 * Create a url to an internal resource.
 *
 * @param string the whole url or the controller. Leave empty for current controller.
 * @param string the method when specifying controller as first argument, else leave empty.
 * @param string the extra arguments to the method, leave empty if not using method.
 */
function create_url($urlOrController=null, $method=null, $arguments=null) {
  return CZelda::Instance()->request->CreateUrl($urlOrController, $method, $arguments);
}

/**
* Prepend the theme_url, which is the url to the current theme directory.
*/
function theme_url($url) {
  $ze = CZelda::Instance();
  return "{$ze->request->base_url}themes/{$ze->config['theme']['name']}/{$url}";
}

/**
* Return the current url.
*/
function current_url() {
  return CZelda::Instance()->request->current_url;
}

/**
* Render all views.
*
* @param $region string the region to draw the content in.
*/
function render_views($region='default') {
  return CZelda::Instance()->views->Render($region);
}

/**
* Check if region has views. Accepts variable amount of arguments as regions.
*
* @param $region string the region to draw the content in.
*/
function region_has_content($region='default' /*...*/) {
  return CZelda::Instance()->views->RegionHasView(func_get_args());
}

?>