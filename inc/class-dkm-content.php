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
	}

	/**
	 * Add metadata to content
	 *
	 * @param  string $content HTML content.
	 * @return string HTML content with metadata prepended
	 */
	public function artifact_metadata( string $content ) {
		if ( is_singular( 'artifact' ) || is_post_type_archive( 'artifact' ) || is_tag() || is_category() || is_tax( array( 'category', 'post_tag', 'artifact_country', 'artifact_state', 'artifact_county', 'artifact_city', 'artifact_subject' ) ) ) {
			ob_start();
			include 'metadata-artifact-top.php';
			$content = ob_get_clean() . $content;

			ob_start();
			include 'metadata-artifact-bottom.php';
			$content .= ob_get_clean();
		}

		if ( 'mayor' === get_post_type() ) {
			$birth_date = get_field( 'item_begin_date' );
			if ( ! empty( $birth_date ) ) {
				$death_date = get_field( 'item_end_date' );

				$dkm_helper = new DKM_Helper();
				$lifetime = '<p class="meta">Born ' . $dkm_helper->format_date_range( $birth_date );
				if ( ! empty( $death_date ) ) {
					$lifetime .= '; Died ' . $dkm_helper->format_date_range( $death_date );
				}
				$lifetime .= '</p>';
				$content = $lifetime . $content;
			}
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
	 * Embed TimelineJS3 timeline
	 *
	 * @return string HTML content
	 */
	public function timeline_shortcode() {
		$timeline_options = '{hash_bookmark: true}';

		wp_enqueue_style( 'timeline-js3' );
		wp_enqueue_script( 'timeline-js3' );
		wp_add_inline_script( 'timeline-js3', 'var timeline = new TL.Timeline("timeline-embed", "' . get_rest_url( null, '/dkm/v1/timeline/' ) . '", ' . $timeline_options . ');' );

		ob_start();
		echo '<div id="timeline-embed"></div>';
		return ob_get_clean();
	}
}
