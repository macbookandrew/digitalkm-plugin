<?php
/**
 * Plugin Name:     DigitalKM
 * Plugin URI:      https://digitalkm.org
 * Description:     Digital KM Functionality
 * Author:          AndrewRMinion Design
 * Author URI:      https://andrewrminion.com
 * Text Domain:     digitalkm
 * Domain Path:     /languages
 * Version:         1.0.0
 *
 * @package         Digitalkm
 */

if ( ! function_exists( 'add_filter' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

// Define PLUGIN_FILE.
if ( ! defined( 'DKM_PLUGIN_FILE' ) ) {
	define( 'DKM_PLUGIN_FILE', __FILE__ );
}

// Include the main class.
if ( ! class_exists( 'FreeMinistryTools' ) ) {
	include_once dirname( __FILE__ ) . '/inc/class-dkm-plugin.php';
	new DKM_Plugin();
}
