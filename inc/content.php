<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DKM_Content {
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
}
