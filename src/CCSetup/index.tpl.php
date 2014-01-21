<?php
/**
* Checking environments before installing Zelda.
*
* @package ZeldaCore
*/

// Minimum PHP version that is required to run this framework.
$minPhpVersion = '5.3.0';

// Check 1: Compare php version on server with required version.
if (version_compare(phpversion(), $minPhpVersion, '<')) {
    $check1 = '<p class="error">Sorry, PHP version must at least be '.$minPhpVersion.'! <span style="float:right;font-style:italic;font-weight:bold;color:red;">&mdash;</span><br />
    Check version of PHP on your web server.</p>';
} 
else {
	$check1 = '<p class="success">Version of PHP is ('.phpversion().'). <span style="float:right;font-style:italic;font-weight:bold;color:green;">OK</span></p>';
}

// Check 2: Check if data directory is writable.
if (!is_writable('site/data')) {
	$check2 = '<p class="error">Directory site/data must be writable. <span style="float:right;font-style:italic;font-weight:bold;color:red;">&mdash;</span><br />
	<a href=' . $_SERVER['PHP_SELF'] . '>Load page to check again</a></p>';
}
else {
	$check2 = '<p class="success">Directory site/data is writable. <span style="float:right;font-style:italic;font-weight:bold;color:green;">OK</span></p>';
}

// Check 3: Check if you can use database att all.
if (!defined('PDO::ATTR_DRIVER_NAME')) {
	$check3 = '<p class="error">Sorry, you can not run sqlite on this environment! <span style="float:right;font-style:italic;font-weight:bold;color:red;">&mdash;</span>';
}
else {
	$check3 = '<p class="success">You may run sqlite on this web server. <span style="float:right;font-style:italic;font-weight:bold;color:green;">OK</span></p>';
}

?>

<h1>Zelda, a PHP-based, MVC-inspired Content Management Framework</h1>

<p>This is a Content Managemant Framework created in the course "php mvc" on Blekinge Tekniska Högskola (Blekinge Institute of Technology), Sweden.<p>

<h3>Requirements</h3>
<p>To run this framework, you need a web server (Apache) with PHP version of 5.3 or higher. Database used, is sqlite, and is automatically installed in the framework.</p>
<?=$check1?>
<?=$check3?>

<h3>Instructions for installation</h3>
<ol>
<li>Download framework from git hub: <a href="https://github.com/vanjaanderson/Zelda">https://github.com/vanjaanderson/Zelda</a>. Or clone it from your terminal with command:</li>

<blockquote>
	<code>git clone git://github.com/vanjaanderson/Zelda.git</code>
</blockquote>

<li>Put files in desired directory on your web server, and make sure the <code>site/data</code> directory is writable. In your terminal, write command:</li>

<blockquote>
	<code>cd Zelda; chmod 777 site/data</code>
</blockquote>

<?=$check2?>

<li>Uncomment row <code style="color:gray">#RewriteBase /Zelda/</code> to <code style="color:gray">RewriteBase /Zelda/</code> in file .htaccess, if needed.</li>
<pre>
&lt;IfModule mod_rewrite.c>
  RewriteEngine on
  <span style="color:teal">#RewriteBase /Zelda/</span>
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteRule (.*) index.php/$1 [NC,L]
&lt;/IfModule>
</pre>

<li>Open website in a browser, log in with root/root and install modules. Modules are setup with this link (from within Zelda):</li>

<blockquote>
	<code> <a href="<?=create_url('module/install/')?>">install modules</a><br />Predefined user root/root is created</code>
</blockquote>

</ol>

<h3>Configuration (advanced)</h3>
<p>In <code>site/config.php</code>, you can enable/disable debug info and controller settings, and other advanced preferences. You can configure navbars, urls , custom theme, stylesheet settings and a lot more...</p>

<h3>Customize your theme</h3>
<p>In <code>site/themes/mytheme</code>, you find files to customize your website: <code>my_config.php</code> and <code>my_style.css</code>.</p>

<p>Variable <code>$p_number</code> holds the id-number for the page you want to view as default. Id-numbers for pages may be seen on <a href="<?=create_url('page/viewall/')?>">view pages</a>. Default number is <code>1</code> and will be used even if variable is left empty.</p>     

<strong>Id numbers in parentheses:</strong><br />
<div style="box-shadow:0px 0px 10px gray; padding:6px 0 1px 6px; margin: 8px 0px 24px 0px;">
	<ul>
		<li>(1) Välkommen till Zelda, av root <span style="font-size:0.92em; color:teal;">| redigera | visa</span></li>
		<li>(4) Testsida CTextFilter, av root <span style="font-size:0.92em; color:teal;">| redigera | visa</span></li>

	</ul>
</div>

<p>Change id number in this row (<em>my_config.php</em>):</p>
<pre>
// Page to view as index page
$p_number	= ''; // Change page (number) to view.
</pre> 

<h3>Navigation menu</h3>
<p>You can change text in the navigation menu tabs in <em>my_config.php</em>:</p>

<pre>
// Text in nav tabs
$page        = 'Exempelsida';  // Page page
$blog        = 'Min blogg';    // Blog page
$guestbook   = 'Min gästbok'   // Guestbook page
</pre>

<h3>Header</h3>
<p>In header, you can change title text, slogan text and dimensions of the logo (<em>my_config.php</em>):</p>
<pre>
// Text in header
$header     	= 'Zelda';     // Title text
$slogan     	= 'Välkommen till mitt CMF!';    // Slogan text

// Change only if you change name on the logo image
$logo_name      = 'logo.png';  
$logo_width 	= ';          // Width of logo (optional)
$logo_height    = '300';       // Height of logo (optional)
</pre>

<p>To change logo, simply replace <code>logo.png</code> in the same directory (<em>site/themes/mytheme</em>) or rename the logo image in variable <code>$logo_name</code>.</p>

<h3>Footer</h3>
<p>In footer, there are some data that you easily can change (<em>my_config.php</em>):<br />
Footertext, name of the creator, links <em>(urls, linktext)</em>, and e-mail <em>(adress and e-mail text)</em>.</p>
<pre>
// Text in footer
$footertext     = 'Detta är min examinationsuppgift i kursen phpmvc';

// Your name (as shown in copyright text in footer)
$name           = 'Vanja Anderson';     

// URL to a link, without http:// (yoursite.com)
$linkurl        = 'vanjaanderson.com'; 

// Text for the link 
$linktext       = 'Min hemsida';        

// Your e-mail address
$email          = 'vason@hotmail.se';

// Text for the link to your e-mail address   
$emailtext      = 'Min e-post';         
</pre>

<p>To enable/disable debug information in footer, change in <code>my_style.css</code>:</p>
<pre>
/* Debug info in footer */

/* To hide debug info, change display: block to display: none 
or vice versa */
#debug {display: none }        
</pre>

<h3>Design</h3>
<p>To change the look of your site, open file <code>my_style.css</code> where you can adjust color settings.</p>

<p>Predefined html colors to use: <em style="color:teal">aqua, black, blue, fuchsia, gray, green, lime, maroon, navy, olive, orange, purple, red, silver, teal, white</em> or <em style="color:teal">yellow</em>. You change text between curly brackets and after semi colon: {background-color: <code>orange</code> }. Hex- and RGB-colors can be used as well. Descriptions to the right.</p>

<pre>
/************************/
/* Outside content area */
/************************/
/* Main background-color */
html{background-color: orange }
/* Background-color in body */ 
body{background-color: rgba(255,255,255,0.6) } 

/****************/
/* Content area */
/****************/
/* Background-color in the content area */
#inner-wrap-main{background-color: rgba(255,255,255,0.8) } 

/* Text-color in the content area */
body{color: } 

/* Content link color */
a{color: teal } 

/* Content hover link color */ 
a:hover{color: orange } 

/* Color of the headings */
h1,h2,h3,h4,h5 {color: black } 

/***************/
/* Header area */
/***************/
/* Background-color in the header area */
#outer-wrap-header{background-color: teal } 

/* Color of the title */
#site-title{color: yellow } 

/* Color of the slogan */
#site-slogan{color: rgba(255,255,255,0.4) } 

/******************/
/* Navigation bar */
/******************/
/* Background-color on tabs in navigation bar */
#navbar ul.menu li a{background-color: } 

/* Text-color on tabs in navigation bar */
#navbar ul.menu li a{color: yellow }  

/* Background-color on hovered tab in navigation bar */
#navbar ul.menu li a:hover{background-color: rgba(0,0,0,0.2) } 

/* Text-color on hovered tab in navigation bar */
#navbar ul.menu li a:hover{color: yellow } 

/* Background-color on selected tab in navigation bar */
#navbar ul.menu li a.selected{background-color: #FFF8EE } 

/* Text-color on selected tab in navigation bar */
#navbar ul.menu li a.selected{color: black } 

/* Hovered background-color on selected tab in navigation bar */
#navbar ul.menu li a.selected:hover{background-color: } 

/* Hovered text-color on selected tab in navigation bar */
#navbar ul.menu li a.selected:hover{color: orange } 

/***************/
/* Footer area */
/***************/
/* Background-color in footer area */
#outer-wrap-footer{background-color: teal } 

/* Text-color in the footer area */
#footer{color: white } 

/* Link-color in the footer area */
#footer a{color: yellow } 

/* Hover link-color in footer area */
#footer a:hover{color: orange } 

/* Color of quotationmark in blockquote */
blockquote:before {color: teal } 
</pre>

<h3>Create pages and blog posts</h3>
<p>When logged in as root/root (or other authorized user), you can create content in the upper left menu: <a href="<?=create_url('content/create/')?>">/content/create/</a>. You can also create content from page or blog view.</p>

<p>In the field <em>(Typ av innehåll (post eller page):&lowast;)</em>, you simply type post for blog post or page for page. Fields with &lowast; are required.</p>

<h3>To-Do</h3>
<ul>
<li>Implement MySql database.</li>
<li>Module for image insertion.</li>
<li>Customization directly to database.</li>
<li>More to come...</li>
</ul>

<h3>Change Log</h3>
<ul>
<li>v1.0    - 13 januari 2014 - Examination of project Zelda CMF</li>
<li>v0.2.24 - 09 december 2013 - Dokumentera koden med phpdoc och modulhanteraren</li>
<li>v0.2.23 - 08 december 2013 - Skapa en webbplats med Zelda</li>
<li>v0.2.22 - 08 december 2013 - Installationsfasen</li>
<li>v0.2.21 - 07 december 2013 - En modulhanterare till Zelda</li>
<li>v0.2.20 - 03 december 2013 - Hantera statiskt innehåll i temat</li>
<li>v0.2.19 - 03 december 2013 - Vertikalt grid med typografi</li>
<li>v0.2.18 - 02 december 2013 - Koppla innehåll till regioner</li>
<li>v0.2.17 - 02 december 2013 - Grid och layout regioner</li>
<li>v0.2.16 - 01 december 2013 - Nytt tema baserat på LESS</li>
<li>v0.2.15 - 19 november 2013 - Filtrera innehåll med HTMLPurifier</li>
<li>v0.2.14 - 18 november 2013 - Formattera innehåll enligt BBCode</li>
<li>v0.2.13 - 18 november 2013 - Spara allt, filtrera och formattera vid utskrift</li>
<li>v0.2.12 - 10 november 2013 - Presentera innehållet som sida och blogg</li>
<li>v0.2.11 - 10 november 2013 - Hantera innehållet på en webbplats, dess "content"</li>
<li>v0.2.10 - 9 november 2013 - Skapa ny användare</li>
<li>v0.2.09 - 8 november 2013 - Validera fälten i postade formulär</li>
<li>v0.2.08 - 8 november 2013 - Lagra lösenordet säkert och flexibelt</li>
<li>v0.2.07 - 7 november 2013 - Integrera med Gravatar</li>
<li>v0.2.06 - 7 november 2013 - Formulär för användarens profil</li>
<li>v0.2.05 - 6 november 2013 - Stöd för hantering av formulär</li>
<li>v0.2.04 - 6 november 2013 - Visa tillgängliga kontrollers med Reflection</li>
<li>v0.2.03 - 6 november 2013 - Användaren som en del av CZelda</li>
<li>v0.2.02 - 6 november 2013 - Användare tillhör en eller flera grupper.</li>
<li>v0.2.01 - 5 november 2013 - CMUser, en modell för användare.</li>
<li>v0.1.9 - 2 november 2013 - En modell för gästboken.</li>
<li>v0.1.8 - 2 november 2013 - Skicka meddelanden mellan sidanrop via sessionen.</li>
<li>v0.1.7 - 1 november 2013 - Separera HTML från kontrollern med vyer.</li>
<li>v0.1.6 - 28 october 2013 - Separera SQL-satserna från PHP-koden.</li>
<li>v0.1.5 - 28 october 2013 - Ett gränssnitt mot databasen.</li>
<li>v0.1.4 - 28 october 2013 - Gästboken sparar till databas.</li>
<li>v0.1.3 - 27 october 2013 - En controller för en gästbok.</li>
<li>v0.1.2 - 20 october 2013 - En gemensam basklass för kontrollers.</li>
<li>v0.1.1 - 17 october 2013 - Städa och publicera koden på github.</li>
<li>v0.1.0 - 12 october 2013 - First version of Zelda - inspired by Mikael Roos tutorial Lydia.</li>
</ul>