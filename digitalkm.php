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

/**
 * Format date range
 * @param  string $begin_date Ymd-formatted begin date
 * @param  string $end_date   Ymd-formatted end date
 * @return string human-formatted date range
 */
function format_date_range( $begin_date, $end_date = NULL ) {
	$begin = new DateTime();
	$begin->setDate( substr( $begin_date, 0, 4 ), substr( $begin_date, 4, 2 ), substr( $begin_date, 6, 2 ) );
	$formatted_date = $begin->format( 'F j, Y' );

	// end date
	if ( ! is_null( $end_date ) && ! empty( $end_date ) ) {
		$end = new DateTime();
		$end->setDate( substr( $end_date, 0, 4 ), substr( $end_date, 4, 2 ), substr( $end_date, 6, 2 ) );

		// format is based on distance between dates
		if ( $begin->format( 'Y' ) !== $end->format( 'Y' ) ) {
			$formatted_date .= '&ndash;' . $end->format( 'F j, Y' );
		} elseif ( $begin->format( 'm' ) !== $end->format( 'm' ) ) {
			$formatted_date = $begin->format( 'F j' ) . '&ndash;' . $end->format( 'F j, Y' );
		} elseif ( $begin->format( 'd' ) !== $end->format( 'd' ) ) {
			$formatted_date = $begin->format ( 'F j' ) . '&ndash;' . $end->format( 'j, Y' );
		}
	}

	return $formatted_date;
}
