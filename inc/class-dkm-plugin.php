<?php
/**
 * Main plugin class
 *
 * @package Digitalkm
 */

/**
 * Main plugin class
 *
 * @package Digitalkm
 */
class DKM_Plugin {
	/**
	 * Plugin version
	 */
	public function version() {
		return '1.0.0';
	}

	/**
	 * Get plugin directory
	 *
	 * @return string path to this plugin directory
	 */
	private function get_plugin_dir() {
		return dirname( DKM_PLUGIN_FILE );
	}

	/**
	 * Get plugin directory URL
	 *
	 * @return string URL to this plugin directory
	 */
	private function get_plugin_dir_url() {
		return plugin_dir_url( DKM_PLUGIN_FILE );
	}

	/**
	 * TimelineJS3 version
	 *
	 * @var string
	 */
	private $timeline_version = '3.5.4';

	/**
	 * Main instance
	 *
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
	 *
	 * @private
	 */
	public function __construct() {
		$this->includes();

		/** Frontend assets */
		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );

		/** ACF JSON save points */
		add_filter( 'acf/settings/save_json', array( $this, 'acf_json_save_point' ) );
		add_filter( 'acf/settings/load_json', array( $this, 'acf_json_load_point' ) );

		/** Tax queries */
		add_action( 'pre_get_posts', array( $this, 'include_all_post_types' ) );

		/** Options page */
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );

		/** Misc */
		add_filter( 'upload_mimes', array( $this, 'mime_types' ) );
	}

	/**
	 * Registers a new options page under Settings.
	 */
	public function add_options_page() {
		return acf_add_options_page(
			array(
				'page_title' => 'DigitalKM Settings',
				'menu_title' => 'DigitalKM Settings',
				'menu_slug'  => 'dkm-settings',
				'capability' => 'manage_options',
				'redirect'   => false,
			)
		);
	}

	/**
	 * Add CPTs, taxonomies, helpers, etc.
	 */
	public function includes() {
		// Artifact CPT.
		require $this->get_plugin_dir() . '/post-types/artifact.php';
		require $this->get_plugin_dir() . '/taxonomies/artifact_country.php';
		require $this->get_plugin_dir() . '/taxonomies/artifact_state.php';
		require $this->get_plugin_dir() . '/taxonomies/artifact_county.php';
		require $this->get_plugin_dir() . '/taxonomies/artifact_city.php';
		require $this->get_plugin_dir() . '/taxonomies/artifact_subject.php';

		// Mayor CPT.
		require $this->get_plugin_dir() . '/post-types/mayor.php';

		// Plugin files.
		require $this->get_plugin_dir() . '/inc/class-dkm-content.php';
		require $this->get_plugin_dir() . '/inc/class-dkm-helper.php';
		require $this->get_plugin_dir() . '/inc/class-dkm-rest.php';

		new DKM_Content();
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
		wp_enqueue_script( 'leaflet', $this->get_plugin_dir_url() . 'assets/js/leaflet.min.js', null, '1.3.1', true );
		wp_enqueue_script( 'coordinates-map', $this->get_plugin_dir_url() . 'assets/js/coordinates-map.min.js', array( 'leaflet' ), $this->version(), true );

		/** TimelineJS3 */
		wp_register_style( 'timeline-js3', $this->get_plugin_dir_url() . 'vendor/timeline/compiled/css/timeline.css', array(), $this->timeline_version );
		wp_register_script( 'timeline-js3', $this->get_plugin_dir_url() . 'vendor/timeline/compiled/js/timeline-min.js', array(), $this->timeline_version, true );

		/** StoryMap */
		wp_register_style( 'storymap', 'https://cdn.knightlab.com/libs/storymapjs/latest/css/storymap.css' );
		wp_register_script( 'storymap', 'https://cdn.knightlab.com/libs/storymapjs/latest/js/storymap-min.js' );
	}

	/**
	 * Include all CPTs when loading a default tax archive
	 *
	 * @param  object WP_Query $query WP_Query.
	 * @return object WP_Query
	 */
	public function include_all_post_types( WP_Query $query ) {
		if ( $query->is_main_query() && ( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) ) {
			// Get all post types.
			$post_types = get_post_types();
			$query->set( 'post_type', $post_types );
		}

		return $query;
	}

	/**
	 * Set ACF local JSON save directory
	 *
	 * @param  string $path ACF local JSON save directory.
	 * @return string ACF local JSON save directory
	 */
	public function acf_json_save_point( $path ) {
		return $this->get_plugin_dir() . '/acf-json';
	}

	/**
	 * Set ACF local JSON open directory
	 *
	 * @param  array $path ACF local JSON open directory.
	 * @return array ACF local JSON open directory
	 */
	public function acf_json_load_point( $path ) {
		$paths[] = $this->get_plugin_dir() . '/acf-json';
		return $paths;
	}

	/**
	 * Allow SVG file uploads
	 *
	 * @param  array $mime_types Array of allowed mime types.
	 * @return array modified array
	 */
	public function mime_types( $mime_types ) {
		$mime_types['svg'] = 'image/svg+xml';
		return $mime_types;
	}

}
