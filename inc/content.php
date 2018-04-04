<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DKM_Content extends DKM_Plugin {
	function __construct() {

		/** Content filters */
		add_filter( 'the_content', array( $this, 'artifact_metadata' ), 5 );

		/** Image filters */
		add_action( 'save_post_artifact', array( $this, 'artifact_thumbnail' ), 15, 3 );

		/** Shortcodes */
		add_shortcode( 'dkm_timeline', array( $this, 'timeline' ) );
	}

	/**
	 * Add metadata to content
	 * @param  string $content HTML content
	 * @return string HTML content with metadata prepended
	 */
	function artifact_metadata( $content ) {
		if ( is_singular( 'artifact' ) || is_post_type_archive( 'artifact' ) || is_tax( array( 'category', 'post_tag', 'artifact_country', 'artifact_state', 'artifact_county', 'artifact_city', 'artifact_subject', ) ) ) {
			ob_start();
			include( 'metadata-artifact-top.php' );
			$content = ob_get_clean() . $content;

			ob_start();
			include( 'metadata-artifact-bottom.php' );
			$content .= ob_get_clean();
		}

		return $content;
	}

	/**
	 * Save first gallery image to featured image
	 * @param  integer int     $post_ID  WP post ID
	 * @param  object  WP_Post $post WP_Post
	 * @param  boolean bool    $update  Whether this is an existing post being updated or not
	 * @return boolean Whether post metadata was updated with thumbainl ID
	 */
	function artifact_thumbnail( int $post_ID, WP_Post $post, bool $update ) {
		$gallery_images = get_field( 'images', $post_ID, false );
		if ( ! empty( $gallery_images ) ) {
			update_post_meta( $post_ID, '_thumbnail_id', $gallery_images[0], true );
		}
	}

	/**
	 * Build TimelineJS3 timeline
	 * @param  array  $attributes Shortcode attributes
	 * @return string HTML content
	 */
	function timeline( $attributes ) {
		$shortcode_attributes = shortcode_atts( array (
		), $attributes );

		wp_enqueue_style( 'timeline-js3' );
		wp_enqueue_script( 'timeline-js3' );
		wp_add_inline_script( 'timeline-js3', 'var timeline = new TL.Timeline("timeline-embed", "' . get_rest_url( NULL, '/dkm/v1/timeline/' ) . '");' );

		ob_start();
		echo '<div id="timeline-embed"></div>';
		return ob_get_clean();
	}
}
