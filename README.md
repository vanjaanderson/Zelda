Zelda, a PHP-based, MVC-inspired Content Management Framework
=============================================================
This is a Content Managemant Framework created in the course "php mvc" on Blekinge Tekniska Högskola (Blekinge Institute of Technology), Sweden.

Requirements
------------
To run this framework, you need a web server (Apache) with PHP version of 5.3 or higher. Database used, is sqlite, and is automatically installed in the framework.

Instructions for installation
-----------------------------
1. Download framework from git hub: [https://github.com/vanjaanderson/Zelda](https://github.com/vanjaanderson/Zelda). Or clone it with command: `git clone git://github.com/vanjaanderson/Zelda.git` from your terminal.

2. Put files in desired directory on your web server, and make sure the `site/data` directory is writable. In your terminal, write command: `cd Zelda; chmod 777 site/data`.

3. Uncomment row `#RewriteBase /Zelda/` to `RewriteBase /Zelda/` in file .htaccess, if needed.
<pre>
&lt;IfModule mod_rewrite.c>
&nbsp;RewriteEngine on
&nbsp;<span style="color:teal">#RewriteBase /Zelda/</span>
&nbsp;RewriteCond %{REQUEST_FILENAME} !-f
&nbsp;RewriteCond %{REQUEST_FILENAME} !-d
&nbsp;RewriteRule (.*) index.php/$1 [NC,L]
&lt;/IfModule>
</pre>

4. Open website in a browser and instructions start automatically. Some modules have to be setup and you do it with this link (from within Zelda): [modules/install](/Zelda-master/modules/install/).

5. Now you can log in with `root/root`.
 
Configuration (advanced)
------------------------
In `site/config.php`, you can enable/disable debug info and controller settings, and other advanced preferences. You can configure navbars, urls , custom theme, stylesheet settings and a lot more...

Customize your theme
--------------------
In `site/themes/mytheme`, you find files to customize your website: `my_config.php` and `my_style.css`.

Variable `$p_number` holds the id-number for the page you want to view as default. Id-numbers for pages may be seen on [/page/viewall/](/Zelda-master/page/viewall/). Default number is `1` and will be used even if variable is left empty.      

*Id numbers in parentheses:*    
<div style="box-shadow:0px 0px 10px gray; padding:6px 0 1px 6px; margin: 8px 0px 24px 0px;">
	<ul>
		<li>(1) Välkommen till Zelda, av root <span style="font-size:0.92em; color:teal;">| redigera | visa</span></li>
		<li>(4) Testsida CTextFilter, av root <span style="font-size:0.92em; color:teal;">| redigera | visa</span></li>
	</ul>
</div>  

Change id number in this row (*my_config.php*):
<pre>
// Page to view as index page
$p_number	= '';    // Change page (number) to view.
</pre> 

###Navigation menu
You can change text in the navigation menu tabs in *my_config.php*:

<pre>
// Text in nav tabs
$page        = 'Exempelsida';  // Page page
$blog        = 'Min blogg';    // Blog page
$guestbook   = 'Min gästbok'   // Guestbook page
</pre>

###Header
In header, you can change title text, slogan text and dimensions of the logo (*my_config.php*):
<pre>
// Text in header
$header     	= 'Zelda';                       // Title text
$slogan     	= 'Välkommen till mitt CMF!';    // Slogan text
$logo_name      = 'logo.png';                    // Change only if you change name on the logo image
$logo_width 	= '';                            // Width of logo (optional)
$logo_height    = '300';                         // Height of logo (optional)
</pre>

To change logo, simply replace `logo.png` in the same directory (*site/themes/mytheme*) or rename the logo image in variable `$logo_name`.

###Footer
In footer, there are some data that you easily can change (*my_config.php*):  
Footertext, name of the creator, links *(urls, linktext)*, and e-mail *(adress and e-mail text)*.
<pre>
// Text in footer
$footertext     = 'Detta är min examinationsuppgift i kursen phpmvc';
$name           = 'Vanja Anderson';     // Your name (as shown in copyright text in footer)

$linkurl        = 'vanjaanderson.com';  // URL to a link, without http:// (yoursite.com)
$linktext       = 'Min hemsida';        // Text for the link

$email          = 'vason@hotmail.se';   // Your e-mail address
$emailtext      = 'Min e-post';         // Text for the link to your e-mail address
</pre>

To enable/disable debug information in footer, change in `my_style.css`:
<pre>
/* Debug info in footer */
#debug {display: none }        /* To hide debug info, change display: block to display: none or vice versa */
</pre>

###Design 
To change the look of your site, open file `my_style.css` where you can adjust color settings.

Predefined html colors to use: *aqua, black, blue, fuchsia, gray, green, lime, maroon, navy, olive, orange, purple, red, silver, teal, white and yellow*. You change text between curly brackets and after semi colon: {background-color: `orange` }. Hex- and RGB-colors can be used as well. Descriptions to the right. 

<pre>
/* Outside content area */
html{background-color: orange }                                 /* Main background-color */
body{background-color: rgba(255,255,255,0.6) }                  /* Background-color in body */

/* Content area */
#inner-wrap-main{background-color: rgba(255,255,255,0.8) }      /* Background-color in the content area */
body{color: }                                                   /* Text-color in the content area */
a{color: teal }                                                 /* Content link color */
a:hover{color: orange }                                         /* Content hover link color */
h1,h2,h3,h4,h5 {color: black }                                  /* Color of the headings */

/* Header area */
#outer-wrap-header{background-color: teal }                     /* Background-color in the header area */
#site-title{color: yellow }                                     /* Color of the title */
#site-slogan{color: rgba(255,255,255,0.4) }                     /* Color of the slogan */

/* Navigation bar */
#navbar ul.menu li a{background-color: }                        /* Background-color on tabs in navigation bar */
#navbar ul.menu li a{color: yellow }                            /* Text-color on tabs in navigation bar */

#navbar ul.menu li a:hover{background-color: rgba(0,0,0,0.2) }  /* Background-color on hovered tab in navigation bar */
#navbar ul.menu li a:hover{color: yellow }                      /* Text-color on hovered tab in navigation bar */

#navbar ul.menu li a.selected{background-color: #FFF8EE }       /* Background-color on selected tab in navigation bar */
#navbar ul.menu li a.selected{color: black }                    /* Text-color on selected tab in navigation bar */

#navbar ul.menu li a.selected:hover{background-color: }         /* Hovered background-color on selected tab in navigation bar */
#navbar ul.menu li a.selected:hover{color: orange }             /* Hovered text-color on selected tab in navigation bar */

/* Footer area */
#outer-wrap-footer{background-color: teal }                     /* Background-color in footer area */
#footer{color: white }                                          /* Text-color in the footer area */
#footer a{color: yellow }                                       /* Link-color in the footer area */
#footer a:hover{color: orange }                                 /* Hover link-color in footer area */

blockquote:before {color: teal }                                /* Color of quotationmark in blockquote */
</pre>

###Create pages and blogposts
When logged in as root/root (or other authorized user), you can create content in the upper left menu: [/content/create/](/Zelda-master/content/create/). You can also create content from page or blog view.

In the field *(Typ av innehåll (post eller page):&lowast;)*, you simply type post for blog post or page for page. Fields with &lowast; are required.

To-Do
-----
* Implement MySql database.
* Module for image insertion.
* Customization directly to database. 
* More to come...

Change Log
----------------
* v1.0    - 29 januari 2014 - Examination of project Zelda CMF
* v0.2.24 - 09 december 2013 - Dokumentera koden med phpdoc och modulhanteraren 
* v0.2.23 - 08 december 2013 - Skapa en webbplats med Zelda 
* v0.2.22 - 08 december 2013 - Installationsfasen 
* v0.2.21 - 07 december 2013 - En modulhanterare till Zelda 
* v0.2.20 - 03 december 2013 - Hantera statiskt innehåll i temat
* v0.2.19 - 03 december 2013 - Vertikalt grid med typografi
* v0.2.18 - 02 december 2013 - Koppla innehåll till regioner
* v0.2.17 - 02 december 2013 - Grid och layout regioner
* v0.2.16 - 01 december 2013 - Nytt tema baserat på LESS
* v0.2.15 - 19 november 2013 - Filtrera innehåll med HTMLPurifier
* v0.2.14 - 18 november 2013 - Formattera innehåll enligt BBCode
* v0.2.13 - 18 november 2013 - Spara allt, filtrera och formattera vid utskrift
* v0.2.12 - 10 november 2013 - Presentera innehållet som sida och blogg
* v0.2.11 - 10 november 2013 - Hantera innehållet på en webbplats, dess "content"
* v0.2.10 - 9 november 2013 - Skapa ny användare
* v0.2.09 - 8 november 2013 - Validera fälten i postade formulär
* v0.2.08 - 8 november 2013 - Lagra lösenordet säkert och flexibelt
* v0.2.07 - 7 november 2013 - Integrera med Gravatar
* v0.2.06 - 7 november 2013 - Formulär för användarens profil
* v0.2.05 - 6 november 2013 - Stöd för hantering av formulär
* v0.2.04 - 6 november 2013 - Visa tillgängliga kontrollers med Reflection
* v0.2.03 - 6 november 2013 - Användaren som en del av CZelda
* v0.2.02 - 6 november 2013 - Användare tillhör en eller flera grupper.
* v0.2.01 - 5 november 2013 - CMUser, en modell för användare.
* v0.1.9 - 2 november 2013 - En modell för gästboken.
* v0.1.8 - 2 november 2013 - Skicka meddelanden mellan sidanrop via sessionen.
* v0.1.7 - 1 november 2013 - Separera HTML från kontrollern med vyer.
* v0.1.6 - 28 october 2013 - Separera SQL-satserna från PHP-koden.
* v0.1.5 - 28 october 2013 - Ett gränssnitt mot databasen.
* v0.1.4 - 28 october 2013 - Gästboken sparar till databas.
* v0.1.3 - 27 october 2013 - En controller för en gästbok.
* v0.1.2 - 20 october 2013 - En gemensam basklass för kontrollers.
* v0.1.1 - 17 october 2013 - Städa och publicera koden på github.
* v0.1.0 - 12 october 2013 - First version of Zelda - inspired by Mikael Roos tutorial Lydia.