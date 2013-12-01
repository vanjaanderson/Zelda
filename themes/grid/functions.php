<?php
/**
* Helpers for the template file.
*/

/**
 * Add static entries for use in the template file. 
 */
$ze->data['header']       = 'Zelda Grid';
$ze->data['slogan']       = 'A PHP-based MVC-inspired CMF';
$ze->data['favicon']      = theme_url('favicon_32x32.png');
$ze->data['logo']         = theme_url('logo_300x260.png');
$ze->data['logo_width']   = 300;
$ze->data['logo_height']  = 260;
$ze->data['footer'] = <<<EOD
<p>Footer: &copy; 2013 |&nbsp;<a href="http://vanjaanderson.com" target="_blank">Vanja Anderson</a></p>   
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

?>