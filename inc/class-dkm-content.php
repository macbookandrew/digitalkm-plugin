<?php
/**
 * Adds content
 *
 * @package Digitalkm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds content
 *
 * @package Digitalkm
 */
class DKM_Content extends DKM_Plugin {
	/**
	 * Kick things off
	 *
	 * @private
	 */
	public function __construct() {

		/** Content filters */
		add_filter( 'the_content', array( $this, 'artifact_metadata' ), 5 );

		/** Image filters */
		add_action( 'acf/save_post', array( $this, 'artifact_thumbnail' ), 15 );
		add_action( 'after_setup_theme', array( $this, 'custom_image_sizes' ) );

		/** Shortcodes */
		add_shortcode( 'dkm_timeline', array( $this, 'timeline_shortcode' ) );
		add_shortcode( 'dkm_mayor_wall', array( $this, 'mayor_shortcode' ) );
	}

	/**
	 * Add metadata to content
	 *
	 * @param  string $content HTML content.
	 * @return string HTML content with metadata prepended
	 */
	public function artifact_metadata( string $content ) {
		if ( is_singular( array( 'artifact', 'mayor' ) ) || is_post_type_archive( array( 'artifact', 'mayor' ) ) || is_tag() || is_category() || is_tax( array( 'category', 'post_tag', 'artifact_country', 'artifact_state', 'artifact_county', 'artifact_city', 'artifact_subject' ) ) ) {
			ob_start();
			include 'metadata-artifact-top.php';
			$content = ob_get_clean() . $content;

			ob_start();
			include 'metadata-artifact-bottom.php';
			$content .= ob_get_clean();
		}

		return $content;
	}

	/**
	 * Save first gallery image to featured image
	 *
	 * @param  integer int $post_id  WP post ID.
	 * @return boolean Whether post metadata was updated with thumbainl ID
	 */
	public function artifact_thumbnail( int $post_id ) {
		$gallery_images = get_field( 'images', $post_id, false );
		if ( ! empty( $gallery_images ) ) {
			return update_post_meta( $post_id, '_thumbnail_id', $gallery_images[0] );
		}
	}

	/**
	 * Add custom image sizes
	 */
	public function custom_image_sizes() {
		add_image_size( 'timeline-thumbnail', 75, 75, true );
		add_image_size( 'timeline-image-sm', 150, 150 );
		add_image_size( 'timeline-image-md', 300, 300 );
		add_image_size( 'timeline-image-lg', 450, 450 );
		add_image_size( 'timeline-image-xl', 600, 600 );
	}

	/**
	 * Display all mayors
	 *
	 * @return string HTML content
	 */
	public function mayor_shortcode() {
		ob_start();

		$mayors       = array();
		$mayors_posts = get_posts(
			array(
				'post_type'      => 'mayor',
				'posts_per_page' => -1,
				'orderby'        => 'meta_value',
				'order'          => 'ASC',
				'meta_key'       => 'item_begin_date',
			)
		);

		foreach ( $mayors_posts as $mayor ) {
			$dkm_helper = new DKM_Helper();

			$service_dates = get_field( 'mayoral_service_dates', $mayor->ID );
			foreach ( $service_dates as $date ) {
				$mayors[ $date['begin_date'] ] = array(
					'ID'        => $mayor->ID,
					'permalink' => get_permalink( $mayor->ID ),
					'thumbnail' => get_the_post_thumbnail( $mayor->ID, 'timeline-image-md', array( 'alt' => get_the_title( $mayor->ID ) ) ),
					'title'     => get_the_title( $mayor->ID ),
					'dates'     => $dkm_helper->format_date_range( $date['begin_date'], $date['end_date'] ),
				);
			}
		}

		ksort( $mayors );

		if ( ! empty( $mayors ) ) {
			echo '<section class="mayor-wall shortcode">';
			foreach ( $mayors as $mayor ) {
				echo '<article class="post-id-' . esc_attr( $mayor['ID'] ) . ' mayor type-mayor status-publish hentry">
				<a href="' . esc_url( $mayor['permalink'] ) . '">' . wp_kses_post( $mayor['thumbnail'] ) . '</a>
				<h2><a href="' . esc_url( $mayor['permalink'] ) . '">' . esc_attr( $mayor['title'] ) . '</a></h2>
				<p class="meta">Served ' . esc_attr( $mayor['dates'] ) . '</p>
				<p><a class="button" href="' . esc_url( $mayor['permalink'] ) . '">Read More</a></p>
				</article>';
			}
			echo '</section>';
		}

		return ob_get_clean();
	}

	/**
	 * Embed TimelineJS3 timeline
	 *
	 * @param  array $attributes Shortcode attributes.
	 * @return string HTML content
	 */
	public function timeline_shortcode( $attributes ) {
		$shortcode_attributes = shortcode_atts(
			array(
				'rest_suffix' => '',
			), $attributes
		);

		$timeline_options = '{hash_bookmark: true}';

		wp_enqueue_style( 'timeline-js3' );
		wp_enqueue_script( 'timeline-js3' );
		wp_add_inline_script( 'timeline-js3', 'var timeline = new TL.Timeline("timeline-embed", "' . get_rest_url( null, '/dkm/v1/timeline/' . esc_attr( $shortcode_attributes['rest_suffix'] ) ) . '", ' . $timeline_options . ');' );

		ob_start();
		echo '<div id="timeline-embed"></div>';
		return ob_get_clean();
	}
}
