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
  if(isset($ze->config['debug']['display-zelda'])) {
    $html = "<hr><h3>Debuginformation</h3><p>The content of CZelda:</p><pre>" . htmlent(print_r($ze, true)) . "</pre>";
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
* Return the current url.
*/
function current_url() {
  return CZelda::Instance()->request->current_url;
}

?>