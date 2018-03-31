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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DKM_Plugin {

	/*
	 * Plugin version
	 */
	public function version() {
		return '1.0.0';
	}

	/**
	 * Get plugin directory
	 * @return string path to this plugin directory
	 */
	private function get_plugin_dir() {
		return dirname( __FILE__ );
	}

	/**
	 * Get plugin directory URL
	 * @return string URL to this plugin directory
	 */
	private function get_plugin_dir_url() {
		return plugin_dir_url( __FILE__ );
	}

	/**
	 * Main instance
	 * @return main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Main constructor
	 * @private
	 */
	public function __construct() {
		$this->includes();

		/** Frontend assets */
		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );

		/** ACF JSON save points */
		add_filter( 'acf/settings/save_json', array( $this, 'acf_json_save_point' ) );
		add_filter( 'acf/settings/load_json', array( $this, 'acf_json_load_point' ) );

		/** Content filters */
		add_filter( 'the_content', array( new DKM_Content(), 'artifact_metadata' ), 5 );
	}

	/**
	 * Add CPTs, taxonomies, helpers, etc.
	 */
	public function includes() {
		require( $this->get_plugin_dir() . '/post-types/artifact.php' );
		require( $this->get_plugin_dir() . '/taxonomies/artifact_country.php' );
		require( $this->get_plugin_dir() . '/taxonomies/artifact_state.php' );
		require( $this->get_plugin_dir() . '/taxonomies/artifact_county.php' );
		require( $this->get_plugin_dir() . '/taxonomies/artifact_city.php' );
		require( $this->get_plugin_dir() . '/taxonomies/artifact_subject.php' );

		require( $this->get_plugin_dir() . '/inc/content.php' );

		require( $this->get_plugin_dir() . '/inc/helpers.php' );

		require( $this->get_plugin_dir() . '/inc/rest-api.php' );
		new DKM_Rest();
	}

	/**
	 * Register frontend assets
	 */
	public function register_assets() {
		/** Flickity carousel */
		wp_register_style( 'flickity', $this->get_plugin_dir_url() . 'assets/css/flickity.min.css', array(), '2.0.11' );
		wp_register_script( 'flickity', $this->get_plugin_dir_url() . 'assets/js/flickity.pkgd.min.js', array(), '2.0.11', true );

		/** Leaflet and map */
		wp_register_style( 'leaflet', $this->get_plugin_dir_url() . 'assets/css/leaflet.min.css', array(), '1.3.1' );
		wp_enqueue_script( 'leaflet', $this->get_plugin_dir_url() . 'assets/js/leaflet.min.js', NULL, '1.3.1', true );
		wp_enqueue_script( 'coordinates-map', $this->get_plugin_dir_url() . 'assets/js/coordinates-map.min.js', array( 'leaflet' ), $this->version(), true );
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

$DKM = new DKM_Plugin();
