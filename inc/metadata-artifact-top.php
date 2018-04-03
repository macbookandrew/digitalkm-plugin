<?php

$DKM_Helper = new DKM_Helper();

$images = get_field( 'images' );
if ( count( $images ) > 0 ) {
	wp_enqueue_style( 'flickity' );
	wp_enqueue_script( 'flickity' );

	echo '<section id="images">
	<h2>Images</h2>
	<div class="image-carousel" data-flickity=\'{ "autoPlay": true }\'>';
	foreach ( $images as $image ) {
		echo '<figure>
			<a href="' . $image['url'] . '">' . wp_get_attachment_image( $image['ID'], array( 300, 300 ) ) . '</a>
			<figcaption>' . $image['description'] . '</figcaption>
		</figure>';
	}
	echo '</div>';

	$link_to_full_resource = get_field( 'link_to_full_resource' );
	if ( $link_to_full_resource ) {
		echo '<p class="text-center"><a class="button" id="link-to-full-resource" href="' . $link_to_full_resource . '">View Full Resource</a></p>';
	}

	echo '</section>';
}
?>

<aside class="sidebar left">
	<?php
	if ( get_field( 'item_begin_date' ) ) {
		$begin_date = get_field( 'item_begin_date' );
		$end_date = get_field( 'item_end_date' );

		echo '<section id="dates" class="meta">
		<h2>Date</h2>
		<p>'. $DKM_Helper->format_date_range( $begin_date, $end_date ) . '</p>
		<p><a href="' . home_url() . '/timeline/#' . $DKM_Helper->get_timeline_range_query( $begin_date, $end_date ) . '&postid-' . get_the_ID() . '" class="button">See on Timeline</a></p>
		</section>';
	}

	$street_address = get_field( 'street_address' );
	$address_format = get_field( 'address_format' );
	$cities = get_field( 'city' );
	$counties = get_field( 'county' );
	$states = get_field( 'state' );
	$countries = get_field( 'country' );
	$map = get_field( 'map' );

	if ( $street_address || $cities || $counties || $states || $countries || $coordinates ) {
		echo '<section id="location" class="meta">
		<h2>Location</h2>';
			if ( $street_address ) {
				echo '<p><strong>Street Address</strong>: ' . $street_address;
				if ( $address_format['label'] !== 'na' ) {
					echo ' <span class="small">' . $street_address['value'] . '</span>';
				}
				echo '</p>';
			}

			if ( $cities ) {
				echo $DKM_Helper->get_artifact_tax_html( get_the_ID(), 'artifact_city', 'City' );
			}

			if ( $counties ) {
				echo $DKM_Helper->get_artifact_tax_html( get_the_ID(), 'artifact_county', 'County' );
			}

			if ( $states ) {
				echo $DKM_Helper->get_artifact_tax_html( get_the_ID(), 'artifact_state', 'State' );
			}

			if ( $countries ) {
				echo $DKM_Helper->get_artifact_tax_html( get_the_ID(), 'artifact_country', 'Country' );
			}

			if ( $map ) {
				wp_enqueue_style( 'leaflet' );
				wp_enqueue_script( 'leaflet' );
				wp_enqueue_script( 'coordinates-map' );

				echo '<div id="geoJSONMap' . get_the_ID() . '" class="geo-json-map" data-locationInfo=\'' . $map . '\'></div>';
			}

		echo '</section>';
	}
	?>
</aside>

<main class="content">
	<?php
	if ( strlen( get_the_content() ) > 0 ) {
		echo '<h2 id="description">Description</h2>';
	}
