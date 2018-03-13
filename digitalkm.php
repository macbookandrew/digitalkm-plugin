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

define( 'DKM_PLUGIN_FILE', __FILE__ );
define( 'DKM_PLUGIN_DIR', dirname( __FILE__ ) );
define( 'DKM_PLUGIN_DIR_URL', plugin_dir_url( DKM_PLUGIN_FILE ) );

class DKM_Plugin {

	/*
	 * Plugin version
	 *
	 * @var string
	 */
	public $version = '1.0.0';

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
	 * Add custom post type and taxonomies
	 */
	public function includes() {
		require( DKM_PLUGIN_DIR . '/post-types/artifact.php' );
		require( DKM_PLUGIN_DIR . '/taxonomies/artifact_country.php' );
		require( DKM_PLUGIN_DIR . '/taxonomies/artifact_state.php' );
		require( DKM_PLUGIN_DIR . '/taxonomies/artifact_county.php' );
		require( DKM_PLUGIN_DIR . '/taxonomies/artifact_city.php' );
		require( DKM_PLUGIN_DIR . '/taxonomies/artifact_subject.php' );

		require( DKM_PLUGIN_DIR . '/inc/content.php' );

		require( DKM_PLUGIN_DIR . '/inc/helpers.php' );
	}

	/**
	 * Register frontend assets
	 */
	public function register_assets() {
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
