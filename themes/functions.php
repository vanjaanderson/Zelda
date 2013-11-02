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
    $html .= "<div class='info'><p>Databasen gjorde " . $ze->db->GetNumQueries() . " förfrågan / förfrågningar.</p>";
  }    
  if(isset($ze->config['debug']['db-queries']) && $ze->config['debug']['db-queries'] && isset($ze->db)) {
    $html .= "<p>Databasen gjorde nedanstående förfrågan:</p><pre class='bigger red'>" . implode('<br/><br/>', $ze->db->GetQueries()) . "</pre>";
  }    
  if(isset($ze->config['debug']['zelda']) && $ze->config['debug']['zelda']) {
    $html .= "<hr><h3>Debuginformation</h3><p>Innehållet i CZelda:</p><pre>" . htmlent(print_r($ze, true)) . "</pre></div>";
  }      
  return $html;
}

/**
* Create a url by prepending the base_url.
*/
function base_url($url=null) {
  return CZelda::Instance()->request->base_url . trim($url, '/');
}

/**
* Create a url to an internal resource.
*/
function create_url($url=null) {
  return CZelda::Instance()->request->CreateUrl($url);
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
*/
function render_views() {
  return CZelda::Instance()->views->Render();
}

?>