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

		/** ACF JSON save points */
		$acf = new DKM_acf();

		/** Frontend assets */
		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );

		/** Content filters */
		add_filter( 'the_content', array( new DKM_Content(), 'artifact_metadata' ), 5 );
	}

	/**
	 * Add CPTs, taxonomies, helpers, etc.
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

		require( DKM_PLUGIN_DIR . '/inc/acf.php' );
	}

	/**
	 * Register frontend assets
	 */
	public function register_assets() {
		/** Leaflet */
		wp_register_style( 'leaflet', 'https://unpkg.com/leaflet@1.3.1/dist/leaflet.css' );
		wp_register_script( 'leaflet', 'https://unpkg.com/leaflet@1.3.1/dist/leaflet.js' );

		wp_register_script( 'coordinates-map', DKM_PLUGIN_DIR_URL . 'assets/js/coordinates-map.min.js', array( 'leaflet' ), $this->version, true );
	}
}

$DKM = new DKM_Plugin();
