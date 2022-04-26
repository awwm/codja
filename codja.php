<?php 
/*
Plugin Name: CODJA
Plugin URI: https://www.linkedin.com/in/abdulwahabpk/
Description: CODJA WordPress Full Stack Testing Specification - Test task
Version: 0.0.1
Author: Abdul Wahab
Author URI: https://www.freelancer.com/u/wahab1983pk
Text Domain: codja

*/

// If this file is called directly, abort. //
if ( ! defined( 'WPINC' ) ) {die;} // end if

// Let's Initialize Everything
if ( file_exists( plugin_dir_path( __FILE__ ) . 'core-init.php' ) ) {
require_once( plugin_dir_path( __FILE__ ) . 'core-init.php' );
}