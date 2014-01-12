<?php
/**
* Site configuration, this file is changed by user per site.
*
*/
ob_start();
/*
* Set level of error reporting
*/
error_reporting(-1);
ini_set('display_errors', 1);

/**
* Set what to show as debug or developer information in the get_debug() theme helper.
*/
$ze->config['debug']['zelda'] = false;
$ze->config['debug']['session'] = false;
$ze->config['debug']['timer'] = true;
$ze->config['debug']['db-num-queries'] = true;
$ze->config['debug']['db-queries'] = true;

/**
* Set database(s).
*/
$ze->config['database'][0]['dsn'] = 'sqlite:' . ZELDA_SITE_PATH . '/data/.ht.sqlite';

/**
* What type of urls should be used?
* 
* default      = 0      => index.php/controller/method/arg1/arg2/arg3
* clean        = 1      => controller/method/arg1/arg2/arg3
* querystring  = 2      => index.php?q=controller/method/arg1/arg2/arg3
*/
$ze->config['url_type'] = 1;

/**
* Set a base_url to use another than the default calculated
*/
$ze->config['base_url'] = null;

/**
* How to hash password of new users, choose from: plain, md5salt, md5, sha1salt, sha1.
*/
$ze->config['hashing_algorithm'] = 'sha1salt';

/**
* Allow or disallow creation of new user accounts.
*/
$ze->config['create_new_users'] = true;

/*
* Define session name
*/
$ze->config['session_name'] = preg_replace('/[:\.\/-_]/', '', __DIR__);
$ze->config['session_key']  = 'zelda';

/*
* Define server timezone
*/
$ze->config['timezone'] = 'Europe/Stockholm';

/*
* Define internal character encoding
*/
$ze->config['character_encoding'] = 'UTF-8';

/*
* Define language
*/
$ze->config['language'] = 'en';

/**
* Define the controllers, their classname and enable/disable them.
*
* The array-key is matched against the url, for example: 
* the url 'developer/dump' would instantiate the controller with the key "developer", that is 
* CCDeveloper and call the method "dump" in that class. This process is managed in:
* $ze->FrontControllerRoute();
* which is called in the frontcontroller phase from index.php.
*/
$ze->config['controllers'] = array(
  'index'     => array('enabled' => true,'class' => 'CCIndex'),
  'developer' => array('enabled' => true,'class' => 'CCDeveloper'),
  'guestbook' => array('enabled' => true,'class' => 'CCGuestbook'),
  'content'   => array('enabled' => true,'class' => 'CCContent'),
  'blog'      => array('enabled' => true,'class' => 'CCBlog'),
  'page'      => array('enabled' => true,'class' => 'CCPage'),
  'user'      => array('enabled' => true,'class' => 'CCUser'),
  'akp'       => array('enabled' => true,'class' => 'CCAdminControlPanel'),
  'theme'     => array('enabled' => true,'class' => 'CCTheme'),
  'module'    => array('enabled' => true,'class' => 'CCModules'),
  'my'        => array('enabled' => true,'class' => 'CCMycontroller'),
);

/**
 * Define a routing table for urls.
 *
 * Route custom urls to a defined controller/method/arguments
 */
$ze->config['routing'] = array(
  'home' => array('enabled' => true, 'url' => 'index/index'),
);

/**
 * Define menus. Variables in my-navbar are defined in theme folder: site/mytheme/my_config.php
 *
 * Create hardcoded menus and map them to a theme region through $ze->config['theme'].
 */
$ze->config['menus'] = array(
  'navbar' => array(
    'home'      => array('label' => 'Hem', 'url'      => 'home'),
    'modules'   => array('label' => 'Moduler', 'url'  => 'module'),
    'content'   => array('label' => 'Innehåll', 'url' => 'content'),
    'guestbook' => array('label' => 'Gästbok', 'url'  => 'guestbook'),
    'blog'      => array('label' => 'Blogg', 'url'    => 'blog'),
    'akp'       => array('label' => 'Admin', 'url'    => 'akp'),
  ),
  'admin' => array(
    'modules'   => array('label' => 'Modulhanterare', 'url' => 'module'),
  ),
  'my-navbar' => array(
    'home'      => array('label' => $home, 'url'      => 'my'),
    'page'      => array('label' => $page, 'url'      => 'my/page'),
    'blog'      => array('label' => $blog, 'url'      => 'my/blog'),
    'guestbook' => array('label' => $guestbook, 'url' => 'my/guestbook'),
  ),
);

/**
 * Settings for the theme. The theme may have a parent theme.
 *
 * When a parent theme is used the parent's functions.php will be included before the current
 * theme's functions.php. The parent stylesheet can be included in the current stylesheet
 * by an @import clause. See site/themes/mytheme for an example of a child/parent theme.
 * Template files can reside in the parent or current theme, the CLydia::ThemeEngineRender()
 * looks for the template-file in the current theme first, then it looks in the parent theme.
 *
 * There are two useful theme helpers defined in themes/functions.php.
 *  theme_url($url): Prepends the current theme url to $url to make an absolute url. 
 *  theme_parent_url($url): Prepends the parent theme url to $url to make an absolute url. 
 *
 * path: Path to current theme, relativly LYDIA_INSTALL_PATH, for example themes/grid or site/themes/mytheme.
 * parent: Path to parent theme, same structure as 'path'. Can be left out or set to null.
 * stylesheet: The stylesheet to include, always part of the current theme, use @import to include the parent stylesheet.
 * template_file: Set the default template file, defaults to default.tpl.php.
 * regions: Array with all regions that the theme supports.
 * menu_to_region: Array mapping menus to regions.
 * data: Array with data that is made available to the template file as variables. 
 * 
 * The name of the stylesheet is also appended to the data-array, as 'stylesheet' and made 
 * available to the template files.
 */
$ze->config['theme'] = array(
  // The name of the theme in the themes directory
  'path'            => 'site/themes/mytheme',
  //'path'          => 'themes/core',
  //'path'            => 'themes/grid',
  'parent'          => 'themes/core',
  'stylesheet'      => 'style.css',
  'template_file'   => 'index.tpl.php',   // Default template file, else use default.tpl.php
  // A list of valid theme regions
  'regions' => array('navbar', 'flash','featured-first','featured-middle','featured-last',
    'primary','sidebar','triptych-first','triptych-middle','triptych-last',
    'footer-column-one','footer-column-two','footer-column-three','footer-column-four',
    'footer',
  ),
  // Add static entries for use in the template file. Variables is defined in my_config.php in site/themes/mytheme.
  'menu_to_region' => array('my-navbar'=>'navbar', 'admin'=>'adminmenu'),
  'data'           => array(
    'header'          => $header,
    'slogan'          => $slogan,
    'favicon'         => 'favicon.png',
    'logo'            => 'logo.png',
    'logo_width'      => $logo_width,
    'logo_height'     => $logo_height,
    'footer'          => '<p>Copyright &copy; '.date('Y').' <span class="darker">|</span> '.$name.' <span class="darker">|</span> <a href="http://'.$linkurl.'" target="_blank">'.$linktext.'</a> <span class="darker">|</span> <a href="mailto:'.$email.'">'.$emailtext.'</a> <span class="darker">|</span> '.$footertext.'</p>',
  ),
);

?>