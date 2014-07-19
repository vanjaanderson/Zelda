<?php
/**
* Helpers for theming, available for all themes in their template files and functions.php.
* This file is included right before the themes own functions.php
*/

/**
 * Get list of tools.
 */
function get_tools() {
  global $ze;
  return <<<EOD
    <p>Tools: 
      <a href="http://validator.w3.org/check/referer">html5</a>
      <a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3">css3</a>
      <a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css21">css21</a>
      <a href="http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance">unicorn</a>
      <a href="http://validator.w3.org/checklink?uri={$ze->request->current_url}">links</a>
      <!--<a href="http://validator.w3.org/i18n-checker/check?uri={$ze->request->current_url}">i18n</a>-->
      <a href="http://qa-dev.w3.org/i18n-checker/index?async=false&amp;docAddr={$ze->request->current_url}">i18n</a>
      <a href="http://csslint.net/">css-lint</a>
      <a href="http://jslint.com/">js-lint</a>
      <a href="http://jsperf.com/">js-perf</a>
      <a href="http://www.workwithcolor.com/hsl-color-schemer-01.htm">colors</a>
      <a href="http://dbwebb.se/style">style</a>
    </p>
    <p>Docs:
      <a href="http://www.w3.org/2009/cheatsheet">cheatsheet</a>
      <a href="http://dev.w3.org/html5/spec/spec.html">html5</a>
      <a href="http://www.w3.org/TR/CSS2">css2</a>
      <a href="http://www.w3.org/Style/CSS/current-work#CSS3">css3</a>
      <a href="http://php.net/manual/en/index.php">php</a>
      <a href="http://www.sqlite.org/lang.html">sqlite</a>
      <a href="http://www.blueprintcss.org/">blueprint</a>
    </p>
EOD;
}

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
    $html .= "<div id='debug'><p>Databasen gjorde $flash" . $ze->db->GetNumQueries() . " förfrågan / förfrågningar.</p>";
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
    $items = " <span class='grey login'>Välkommen</span> <img class='gravatar' src='" . get_gravatar(20) . "' alt=''> <a class='login' href='" . create_url('user/profile') . "'> " . $ze->user['acronym'] . "</a> ";
    $items .= " <span class='grey login'>|</span> <a class='login' href='" . create_url('user/logout') . "'>logga ut</a> ";
  } else {
    //$items = "<a href='" . create_url('user/login') . "'>logga in</a> ";
    $items = "";
  }
  return $items;
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
  return create_url(CZelda::Instance()->themeUrl . "/{$url}");
}

/**
 * Prepend the theme_parent_url, which is the url to the parent theme directory.
 *
 * @param $url string the url-part to prepend.
 * @returns string the absolute url.
 */
function theme_parent_url($url) {
  return create_url(CZelda::Instance()->themeParentUrl . "/{$url}");
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