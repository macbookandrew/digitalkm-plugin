<?php
/**
 * Artifact custom taxomony
 *
 * @package Digitalkm
 */

/**
 * Registers the `artifact_county` taxonomy,
 * for use with 'artifact'.
 */
function artifact_county_init() {
	register_taxonomy(
		'artifact_county', array( 'artifact' ), array(
			'hierarchical'          => false,
			'public'                => true,
			'show_in_nav_menus'     => true,
			'show_ui'               => true,
			'show_admin_column'     => false,
			'query_var'             => true,
			'rewrite'               => true,
			'capabilities'          => array(
				'manage_terms' => 'edit_posts',
				'edit_terms'   => 'edit_posts',
				'delete_terms' => 'edit_posts',
				'assign_terms' => 'edit_posts',
			),
			'labels'                => array(
				'name'                       => __( 'Location Counties', 'digitalkm-plugin' ),
				'singular_name'              => _x( 'Location County', 'taxonomy general name', 'digitalkm-plugin' ),
				'search_items'               => __( 'Search Location Counties', 'digitalkm-plugin' ),
				'popular_items'              => __( 'Popular Location Counties', 'digitalkm-plugin' ),
				'all_items'                  => __( 'All Location Counties', 'digitalkm-plugin' ),
				'parent_item'                => __( 'Parent Location County', 'digitalkm-plugin' ),
				'parent_item_colon'          => __( 'Parent Location County:', 'digitalkm-plugin' ),
				'edit_item'                  => __( 'Edit Location County', 'digitalkm-plugin' ),
				'update_item'                => __( 'Update Location County', 'digitalkm-plugin' ),
				'view_item'                  => __( 'View Location County', 'digitalkm-plugin' ),
				'add_new_item'               => __( 'New Location County', 'digitalkm-plugin' ),
				'new_item_name'              => __( 'New Location County', 'digitalkm-plugin' ),
				'separate_items_with_commas' => __( 'Separate Location Counties with commas', 'digitalkm-plugin' ),
				'add_or_remove_items'        => __( 'Add or remove Location Counties', 'digitalkm-plugin' ),
				'choose_from_most_used'      => __( 'Choose from the most used Location Counties', 'digitalkm-plugin' ),
				'not_found'                  => __( 'No Location Counties found.', 'digitalkm-plugin' ),
				'no_terms'                   => __( 'No Location Counties', 'digitalkm-plugin' ),
				'menu_name'                  => __( 'Location Counties', 'digitalkm-plugin' ),
				'items_list_navigation'      => __( 'Location Counties list navigation', 'digitalkm-plugin' ),
				'items_list'                 => __( 'Location Counties list', 'digitalkm-plugin' ),
				'most_used'                  => _x( 'Most Used', 'artifact_county', 'digitalkm-plugin' ),
				'back_to_items'              => __( '&larr; Back to Location Counties', 'digitalkm-plugin' ),
			),
			'show_in_rest'          => true,
			'rest_base'             => 'artifact_county',
			'rest_controller_class' => 'WP_REST_Terms_Controller',
		)
	);

}
add_action( 'init', 'artifact_county_init' );

/**
 * Sets the post updated messages for the `artifact_county` taxonomy.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `artifact_county` taxonomy.
 */
function artifact_county_updated_messages( $messages ) {

	$messages['artifact_county'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => __( 'Location County added.', 'digitalkm-plugin' ),
		2 => __( 'Location County deleted.', 'digitalkm-plugin' ),
		3 => __( 'Location County updated.', 'digitalkm-plugin' ),
		4 => __( 'Location County not added.', 'digitalkm-plugin' ),
		5 => __( 'Location County not updated.', 'digitalkm-plugin' ),
		6 => __( 'Location Counties deleted.', 'digitalkm-plugin' ),
	);

	return $messages;
}
add_filter( 'term_updated_messages', 'artifact_county_updated_messages' );
