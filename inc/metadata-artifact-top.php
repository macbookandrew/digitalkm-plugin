<?php
/**
 * Metadata for top of artifact single view
 *
 * @package Digitalkm
 */

$dkm_helper = new DKM_Helper();

$images = get_field( 'images' );
if ( ! empty( $images ) ) {
	wp_enqueue_style( 'flickity' );
	wp_enqueue_script( 'flickity' );

	echo '<section id="images">
	<h2>Images</h2>
	<div class="image-carousel" data-flickity=\'{ "autoPlay": true }\'>';
	foreach ( $images as $image ) {
		echo '<figure>
			<a href="' . esc_url( $image['url'] ) . '">' . wp_get_attachment_image( $image['ID'], array( 300, 300 ) ) . '</a>
			<figcaption>' . wp_kses( $image['description'], wp_kses_allowed_html( 'post' ) ) . '</figcaption>
		</figure>';
	}
	echo '</div>';

	$link_to_full_resource = get_field( 'link_to_full_resource' );
	if ( $link_to_full_resource ) {
		echo '<p class="text-center"><a class="button" id="link-to-full-resource" href="' . esc_url( $link_to_full_resource ) . '">View Full Resource</a></p>';
	}

	echo '</section>';
} elseif ( ! empty( get_field( 'video_url' ) ) ) {
	echo '<section id="images">
	<h2>Video</h2>
	' . wp_oembed_get( esc_url( get_field( 'video_url' ) ) ) . '
	</section>'; // WPCS: XSS ok.
}
?>

<aside class="sidebar left">
	<?php
	global $post;

	if ( is_singular() && empty( $images ) && has_post_thumbnail() ) {
		digitalkm_post_thumbnail();
	}

	if ( get_field( 'item_begin_date' ) ) {
		$begin_date = get_field( 'item_begin_date' );
		$end_date   = get_field( 'item_end_date' );

		echo '<section id="dates" class="meta">
		<h2>Date</h2>
		<p>' . esc_attr( $dkm_helper->format_date_range( $begin_date, $end_date ) ) . '</p>
		<p><a href="' . esc_url( home_url() ) . '/timeline/#event-' . esc_url( $post->post_name ) . '" class="button">See on Timeline</a></p>
		</section>';
	}

	$street_address = get_field( 'street_address' );
	$address_format = get_field( 'address_format' );
	$cities         = get_field( 'city' );
	$counties       = get_field( 'county' );
	$states         = get_field( 'state' );
	$countries      = get_field( 'country' );
	$map            = get_field( 'map' );

	if ( $street_address || $cities || $counties || $states || $countries || $map ) {
		echo '<section id="location" class="meta">
		<h2>Location</h2>';
		if ( $street_address ) {
			echo '<p><strong>Street Address</strong>: ' . wp_kses( $street_address, wp_kses_allowed_html( 'post' ) );
			if ( 'na' !== $address_format['label'] ) {
				echo ' <span class="small">' . wp_kses( $street_address['value'], wp_kses_allowed_html( 'post' ) ) . '</span>';
			}
			echo '</p>';
		}

		if ( $cities ) {
			echo wp_kses( $dkm_helper->get_artifact_tax_html( get_the_ID(), 'artifact_city', 'City' ), wp_kses_allowed_html( 'post' ) );
		}

		if ( $counties ) {
			echo wp_kses( $dkm_helper->get_artifact_tax_html( get_the_ID(), 'artifact_county', 'County' ), wp_kses_allowed_html( 'post' ) );
		}

		if ( $states ) {
			echo wp_kses( $dkm_helper->get_artifact_tax_html( get_the_ID(), 'artifact_state', 'State' ), wp_kses_allowed_html( 'post' ) );
		}

		if ( $countries ) {
			echo wp_kses( $dkm_helper->get_artifact_tax_html( get_the_ID(), 'artifact_country', 'Country' ), wp_kses_allowed_html( 'post' ) );
		}

		if ( $map ) {
			wp_enqueue_style( 'leaflet' );
			wp_enqueue_script( 'leaflet' );
			wp_enqueue_script( 'coordinates-map' );

			echo '<div id="geoJSONMap' . esc_attr( get_the_ID() ) . '" class="geo-json-map" data-locationInfo=\'' . esc_attr( $map ) . '\'></div>';
		}

		echo '</section>';
	}
	?>
</aside>

<main class="content">
	<?php
	if ( 'artifact' === get_post_type() && strlen( get_the_content() ) > 0 ) {
		echo '<h2 id="description">Description</h2>';
	}
