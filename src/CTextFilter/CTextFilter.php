<?php
/**
 * Class for filtering user submitted data before displaying on page
 * 
 * @package ZeldaCore
 */
class CTextFilter {

/**
 * Properties
 */
public static $purify = null;

public static function filter($data,$filter) {
    switch($filter) {
        case 'htmlpurify': $data     = nl2p(self::purify($data)); break;
        case 'make_clickable': $data = nl2p(make_clickable(htmlEnt($data))); break;
        case 'bbcode': $data         = nl2p(bbcode2html(htmlEnt($data))); break;
        case 'markdownextra': $data  = self::markdownExtra($data); break;
        case 'smartypants': $data    = nl2p(self::smartyPantsTypographer($data)); break;
        case 'plain':
        default: $data = nl2p(htmlEnt($data)); break;
    }
    //$data = preg_replace('~\s?<p>(\s|&nbsp;)+</p>\s?~', '', $data);
    $data = preg_replace('|<p>(.*?)<p>|', '', $data);

    return $data;
}

/**
   * Clean your HTML with HTMLPurifier, create an instance of HTMLPurifier if it does not exists. 
   *
   * @param $text string the dirty HTML.
   * @return string as the clean HTML.
   */
  /* From CHTMLPurifier */
   private static function purify($text) {   
    if(!self::$purify) {
      require_once(__DIR__.'/htmlpurifier-4.5.0-standalone/HTMLPurifier.standalone.php');
      $config = HTMLPurifier_Config::createDefault();
      $config->set('Cache.DefinitionImpl', null);
      self::$purify = new HTMLPurifier($config);
    }
    return self::$purify->purify($text);
}

/**
 * Format text according to Markdown och Markdown extra syntax.
 *
 * @param string $text the text that should be formatted.
 * @param string $parser the parser method, can be Markdown_Parser och MarkdownExtra_Parser.
 * @return string as the formatted html-text.
 */
private static function markdownExtra($text) {
  require_once(__DIR__ . '/PHP-Markdown-Extra-1.2.7/markdown.php');
  return Markdown($text);
}


/**
 * Format text according to Smartypants syntax.
 *
 * @param string $text the text that should be formatted.
 * @param string $parser the parser method can be SmartyPants_Parser or SmartyPantsTypographer_Parser.
 * @return string as the formatted html-text.
 */
private static function smartyPantsTypographer($text) {
    require_once(__DIR__ . '/PHP-SmartyPants-Typographer-1.0.1/smartypants.php');
    return SmartyPants($text);
}

/**
 * Make clickable links from URLs in text.
 *
 * @param string text text to be converted.
 * @return string the formatted text.
 */
private static function make_clickable($text) {
    return preg_replace_callback(
      '#\b(?<![href|src]=[\'"])https?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#',
      create_function(
        '$matches',
        'return "<a href=\'{$matches[0]}\'>{$matches[0]}</a>";'
        ),
    $text
    );
}
  
/**
 * BBCode formatting converting to HTML.
 *
 * @param string text text to be converted.
 * @return string the formatted text.
 */
private static function bbcode2html($text) {
    $search = array( 
        '/\[b\](.*?)\[\/b\]/is', 
        '/\[i\](.*?)\[\/i\]/is', 
        '/\[u\](.*?)\[\/u\]/is', 
        '/\[img\](https?.*?)\[\/img\]/is', 
        '/\[url\](https?.*?)\[\/url\]/is', 
        '/\[url=(https?.*?)\](.*?)\[\/url\]/is' 
    );   
    $replace = array( 
        '<strong>$1</strong>', 
        '<em>$1</em>', 
        '<u>$1</u>', 
        '<img src="$1" />', 
        '<a href="$1">$1</a>', 
        '<a href="$1">$2</a>' 
    );     
    return preg_replace($search, $replace, $text);
  } 
}

/**
* http://stackoverflow.com/questions/7409512/new-line-to-paragraph-function
*
*/
function nl2p($string) {
  $paragraphs = '';
  
  foreach (explode("\n",  $string) as $line) {
    if (trim($line)) {
      $paragraphs .= '<p>' . $line . '</p>';
    }
  }
  return $paragraphs;
}

?>