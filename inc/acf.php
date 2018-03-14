<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DKM_acf extends DKM_Plugin {
	public function __construct() {

		/** ACF JSON save points */
		add_filter( 'acf/settings/save_json', array( $this, 'acf_json_save_point' ) );
		add_filter( 'acf/settings/load_json', array( $this, 'acf_json_load_point' ) );
	}

	/**
	 * Set ACF local JSON save directory
	 * @param  string $path ACF local JSON save directory
	 * @return string ACF local JSON save directory
	 */
	public function acf_json_save_point( $path ) {
		return plugin_dir_path( __FILE__ ) . '/acf-json';
	}


	/**
	 * Set ACF local JSON open directory
	 * @param  array $path ACF local JSON open directory
	 * @return array ACF local JSON open directory
	 */
	public function acf_json_load_point( $path ) {
		$paths[] = plugin_dir_path( __FILE__ ) . '/acf-json';
		return $paths;
	}

}
