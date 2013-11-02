<?php
/**
* Helpers for theming, available for all themes in their template files and functions.php.
* This file is included right before the themes own functions.php
*/

/**
* Print debuginformation from the framework.
 */
function get_debug() {
  $ze = CZelda::Instance();
  $html = null;
  
  if(isset($ze->config['debug']['db-num-queries']) && $ze->config['debug']['db-num-queries'] && isset($ze->db)) {
    $html .= "<p>Database made " . $ze->db->GetNumQueries() . " queries.</p>";
  }    
  if(isset($ze->config['debug']['db-queries']) && $ze->config['debug']['db-queries'] && isset($ze->db)) {
    $html .= "<p>Database made the following queries.</p><pre>" . implode('<br/><br/>', $ze->db->GetQueries()) . "</pre>";
  }    
  if(isset($ze->config['debug']['lydia']) && $ze->config['debug']['lydia']) {
    $html .= "<hr><h3>Debuginformation</h3><p>The content of CZelda:</p><pre>" . htmlent(print_r($ze, true)) . "</pre>";
  }    
  return $html;
}

/**
* Create a url by prepending the base_url.
*/
function base_url($url) {
  return CZelda::Instance()->request->base_url . trim($url, '/');
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

?>