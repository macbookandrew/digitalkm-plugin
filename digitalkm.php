<?php
/**
 * Plugin Name:     DigitalKM
 * Plugin URI:      https://digitalkm.org
 * Description:     Digital KM Functionality
 * Author:          AndrewRMinion Design
 * Author URI:      https://andrewrminion.com
 * Text Domain:     digitalkm
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Digitalkm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add custom post type
 */
require( plugin_dir_path( __FILE__ ) . '/post-types/artifact.php' );
require( plugin_dir_path( __FILE__ ) . '/taxonomies/artifact_country.php' );
require( plugin_dir_path( __FILE__ ) . '/taxonomies/artifact_state.php' );
require( plugin_dir_path( __FILE__ ) . '/taxonomies/artifact_county.php' );
require( plugin_dir_path( __FILE__ ) . '/taxonomies/artifact_city.php' );
require( plugin_dir_path( __FILE__ ) . '/taxonomies/artifact_subject.php' );

/**
 * Set ACF local JSON save directory
 * @param  string $path ACF local JSON save directory
 * @return string ACF local JSON save directory
 */
if ( ! function_exists( 'dkm_acf_json_save_point' ) ) {
function dkm_acf_json_save_point( $path ) {
	return plugin_dir_path( __FILE__ ) . '/acf-json';
}
}
add_filter( 'acf/settings/save_json', 'dkm_acf_json_save_point' );

/**
 * Set ACF local JSON open directory
 * @param  array $path ACF local JSON open directory
 * @return array ACF local JSON open directory
 */
if ( ! function_exists( 'dkm_acf_json_load_point' ) ) {
function dkm_acf_json_load_point( $path ) {
	$paths[] = plugin_dir_path( __FILE__ ) . '/acf-json';
	return $paths;
}
}
add_filter( 'acf/settings/load_json', 'dkm_acf_json_load_point' );

