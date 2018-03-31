<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DKM_Content extends DKM_Plugin {
	function __construct() {

		/** Content filters */
		add_filter( 'the_content', array( $this, 'artifact_metadata' ), 5 );

		/** Shortcodes */
		add_shortcode( 'dkm_timeline', array( $this, 'timeline' ) );
	}

	/**
	 * Add metadata to content
	 * @param  string $content HTML content
	 * @return string HTML content with metadata prepended
	 */
	function artifact_metadata( $content ) {
		if ( 'artifact' === get_post_type() ) {
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
