/*
**********************************************************************************
	main.js
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
	Author: Vanja Maria Anderson
	Description: A collection of scripts in my webbtemplate Vason
	Date: 2014-06-28
	Version: 1.0
	Website: http://vanjaanderson.com
	Development: https://github.com/vanjaanderson/Vason
********************************************************************************** 
*/
jQuery(document).ready(function() {
	// Write year in span#date
	var D = new Date();
  	var Y = D.getFullYear();
  	// Write year innerhtml
  	$('#date').html(Y);
  	// Put login- and logout-links to the right (see style.css)
  	$('a[href$="login.php"]').attr('id', 'login');
  	$('a[href$="logout.php"]').attr('id', 'logout');
  	// Hide logout link by default
  	$('a[href$="logout.php"]').css('display', 'none');
});
