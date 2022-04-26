<?php
/*
*
*	***** CODJA *****
*
*	This file initializes all CODJA Core components
*	
*/
// If this file is called directly, abort. //
if (!defined('WPINC')) {
	die;
} // end if
// Define Our Constants
define('CODJA_CORE_INC', dirname(__FILE__) . '/assets/inc/');
define('CODJA_CORE_IMG', plugins_url('assets/img/', __FILE__));
define('CODJA_CORE_CSS', plugins_url('assets/css/', __FILE__));
define('CODJA_CORE_JS', plugins_url('assets/js/', __FILE__));
/*
*
*  Register CSS
*
*/
function codja_register_core_css()
{
	wp_enqueue_style('codja-fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css', null, '6.1.1');
	wp_enqueue_style('codja-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css', null, '5.1');
	wp_enqueue_style('codja-core', CODJA_CORE_CSS . 'codja-core.css', null, time(), 'all');
};
add_action('wp_enqueue_scripts', 'codja_register_core_css');
/*
*
*  Register JS/Jquery Ready
*
*/
function codja_register_core_js()
{
	// Register Core Plugin JS	
	wp_enqueue_script('jquery');
	wp_enqueue_script('codja-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js', 'jquery', '5.1', true);
	wp_enqueue_script('codja-core', CODJA_CORE_JS . 'codja-core.js', 'jquery', time(), true);
};
add_action('wp_enqueue_scripts', 'codja_register_core_js');
/*
*
*  Includes
*
*/
// Load the Functions
if (file_exists(CODJA_CORE_INC . 'codja-core-functions.php')) {
	require_once CODJA_CORE_INC . 'codja-core-functions.php';
}
// Load the ajax Request
if (file_exists(CODJA_CORE_INC . 'codja-ajax-request.php')) {
	require_once CODJA_CORE_INC . 'codja-ajax-request.php';
}
// Load the Shortcodes
if (file_exists(CODJA_CORE_INC . 'codja-shortcodes.php')) {
	require_once CODJA_CORE_INC . 'codja-shortcodes.php';
}
