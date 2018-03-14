<?php

$DKM_Helper = new DKM_Helper();

if ( get_field( 'images' ) ) {
	echo '<section id="images" class="meta">
	<h2>Images</h2>';
	foreach ( get_field( 'images' ) as $image ) { ?>
		<figure>
			<?php echo wp_get_attachment_image( $image['ID'], array( 500, 500 ) ); ?>
			<figcaption><?php echo $image['description']; ?></figcaption>
		</figure>
		<?php
	}
	# TODO: style as a horizontal slider?
	echo '</section>';
}

$link_to_full_resource = get_field( 'link_to_full_resource' );
if ( $link_to_full_resource ) {
	echo '<p><a class="button" id="link-to-full-resource" href="' . $link_to_full_resource . '">View Full Resource</a></p>';
}

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
			echo '<div id="geoJSONMap' . get_the_ID() . '" class="geo-json-map" data-locationInfo=\'' . $map . '\'></div>';

			wp_enqueue_style( 'leaflet' );
			wp_enqueue_script( 'coordinates-map' );
		}

	echo '</section>';
}

$type = $DKM_Helper->get_artifact_tax_html( get_the_ID(), 'category', 'Type' );
if ( $type ) {
	echo '<section id="type" class="meta">
		<h2>Type</h2>
		<p>' . $type . '</p>
	</section>';
}

$topics = $DKM_Helper->get_artifact_tax_html( get_the_ID(), 'post_tag', 'Topics' );
if ( $type ) {
	echo '<section id="topics" class="meta">
		<h2>Topics</h2>
		<p>' . $topics . '</p>
	</section>';
}

$subject = $DKM_Helper->get_artifact_tax_html( get_the_ID(), 'artifact_subject', 'Subject' );
if ( $subject ) {
	echo '<section id="subject" class="meta">
		<h2>Subject</h2>
		<p>' . $subject . '</p>
	</section>';
}

if ( strlen( get_the_content() ) > 0 ) {
	echo '<h2 id="description">Description</h2>';
}
