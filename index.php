<?php
/**
 * All requests routed through here. This is an overview of what actaully happens during
 * a request.
 *
 * @package ZeldaCore
 */

// ---------------------------------------------------------------------------------------
//
// PHASE: BOOTSTRAP
//
define('ZELDA_INSTALL_PATH', dirname(__FILE__));
define('ZELDA_SITE_PATH', ZELDA_INSTALL_PATH . '/site');

require(ZELDA_INSTALL_PATH.'/src/bootstrap.php');

$ze = CZelda::Instance();

// ---------------------------------------------------------------------------------------
//
// PHASE: FRONTCONTROLLER ROUTE
//
$ze->FrontControllerRoute();

// ---------------------------------------------------------------------------------------
//
// PHASE: THEME ENGINE RENDER
//
$ze->ThemeEngineRender();

?>