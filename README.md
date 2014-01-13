Zelda, a PHP-based, MVC-inspired Content Management Framework
=============================================================
This is a Content Managemant Framework created in the course "php mvc" on Blekinge Tekniska Högskola (Blekinge Institute of Technology), Sweden.

Requirements
------------
To run this framework, you need a web server (Apache) with PHP version of 5.3 or higher. Database used, is sqLite.

Instructions for installation
-----------------------------
1) Download framework from git hub: [https://github.com/vanjaanderson/Zelda](https://github.com/vanjaanderson/Zelda).
Or clone it with command: <code>git clone git://github.com/vanjaanderson/Zelda.git</code> from your terminal. This step is certainly done.

2) Put files in desired folder on your web server, and make sure the <code>site/data</code> folder is writable. In your terminal, write command: <code>cd zelda; chmod 777 site/data</code>.

3) Open website in a web-browser and read in-built instructions on how to init database and required tables. Modules are setup with this link (from within Zelda): [/modules/install/](modules/install). Predefined user root/root is created. For security reasons, change username and password, see **Create Read Update Delete**.

Configuration (advanced)
------------------------
In <code>site/config.php</code>, you can enable/disable debug info and controller settings, and other advanced preferences. You can configure navbars, urls , custom theme, stylesheet settings and a lot more...

Customize your theme
--------------------
In <code>site/themes/mytheme</code>, you find files to customize your website. 




To-Do
-----
* Implement MySql database.
* Module for image insertion.
* Customization directly to database. 
* More to come...

Revision history
----------------
* v1.0    - 13 januari 2014 - Examination of project Zelda CMF
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