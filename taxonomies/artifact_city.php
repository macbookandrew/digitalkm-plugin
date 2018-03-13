<?php

/**
 * Registers the `artifact_city` taxonomy,
 * for use with 'artifact'.
 */
function artifact_city_init() {
	register_taxonomy( 'artifact_city', array( 'artifact' ), array(
		'hierarchical'      => false,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_ui'           => true,
		'show_admin_column' => false,
		'query_var'         => true,
		'rewrite'           => true,
		'capabilities'      => array(
			'manage_terms'  => 'edit_posts',
			'edit_terms'    => 'edit_posts',
			'delete_terms'  => 'edit_posts',
			'assign_terms'  => 'edit_posts',
		),
		'labels'            => array(
			'name'                       => __( 'Location Cities', 'digitalkm-plugin' ),
			'singular_name'              => _x( 'Location City', 'taxonomy general name', 'digitalkm-plugin' ),
			'search_items'               => __( 'Search Location Cities', 'digitalkm-plugin' ),
			'popular_items'              => __( 'Popular Location Cities', 'digitalkm-plugin' ),
			'all_items'                  => __( 'All Location Cities', 'digitalkm-plugin' ),
			'parent_item'                => __( 'Parent Location City', 'digitalkm-plugin' ),
			'parent_item_colon'          => __( 'Parent Location City:', 'digitalkm-plugin' ),
			'edit_item'                  => __( 'Edit Location City', 'digitalkm-plugin' ),
			'update_item'                => __( 'Update Location City', 'digitalkm-plugin' ),
			'view_item'                  => __( 'View Location City', 'digitalkm-plugin' ),
			'add_new_item'               => __( 'New Location City', 'digitalkm-plugin' ),
			'new_item_name'              => __( 'New Location City', 'digitalkm-plugin' ),
			'separate_items_with_commas' => __( 'Separate Location Cities with commas', 'digitalkm-plugin' ),
			'add_or_remove_items'        => __( 'Add or remove Location Cities', 'digitalkm-plugin' ),
			'choose_from_most_used'      => __( 'Choose from the most used Location Cities', 'digitalkm-plugin' ),
			'not_found'                  => __( 'No Location Cities found.', 'digitalkm-plugin' ),
			'no_terms'                   => __( 'No Location Cities', 'digitalkm-plugin' ),
			'menu_name'                  => __( 'Location Cities', 'digitalkm-plugin' ),
			'items_list_navigation'      => __( 'Location Cities list navigation', 'digitalkm-plugin' ),
			'items_list'                 => __( 'Location Cities list', 'digitalkm-plugin' ),
			'most_used'                  => _x( 'Most Used', 'artifact_city', 'digitalkm-plugin' ),
			'back_to_items'              => __( '&larr; Back to Location Cities', 'digitalkm-plugin' ),
		),
		'show_in_rest'      => true,
		'rest_base'         => 'artifact_city',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	) );

}
add_action( 'init', 'artifact_city_init' );

/**
 * Sets the post updated messages for the `artifact_city` taxonomy.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `artifact_city` taxonomy.
 */
function artifact_city_updated_messages( $messages ) {

	$messages['artifact_city'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => __( 'Location City added.', 'digitalkm-plugin' ),
		2 => __( 'Location City deleted.', 'digitalkm-plugin' ),
		3 => __( 'Location City updated.', 'digitalkm-plugin' ),
		4 => __( 'Location City not added.', 'digitalkm-plugin' ),
		5 => __( 'Location City not updated.', 'digitalkm-plugin' ),
		6 => __( 'Location Cities deleted.', 'digitalkm-plugin' ),
	);

	return $messages;
}
add_filter( 'term_updated_messages', 'artifact_city_updated_messages' );
