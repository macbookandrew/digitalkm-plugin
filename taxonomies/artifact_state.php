<?php
/**
 * Artifact custom taxomony
 *
 * @package Digitalkm
 */

/**
 * Registers the `artifact_state` taxonomy,
 * for use with 'artifact'.
 */
function artifact_state_init() {
	register_taxonomy(
		'artifact_state', array( 'artifact' ), array(
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
				'name'                       => __( 'Location States', 'digitalkm-plugin' ),
				'singular_name'              => _x( 'Location State', 'taxonomy general name', 'digitalkm-plugin' ),
				'search_items'               => __( 'Search Location States', 'digitalkm-plugin' ),
				'popular_items'              => __( 'Popular Location States', 'digitalkm-plugin' ),
				'all_items'                  => __( 'All Location States', 'digitalkm-plugin' ),
				'parent_item'                => __( 'Parent Location State', 'digitalkm-plugin' ),
				'parent_item_colon'          => __( 'Parent Location State:', 'digitalkm-plugin' ),
				'edit_item'                  => __( 'Edit Location State', 'digitalkm-plugin' ),
				'update_item'                => __( 'Update Location State', 'digitalkm-plugin' ),
				'view_item'                  => __( 'View Location State', 'digitalkm-plugin' ),
				'add_new_item'               => __( 'New Location State', 'digitalkm-plugin' ),
				'new_item_name'              => __( 'New Location State', 'digitalkm-plugin' ),
				'separate_items_with_commas' => __( 'Separate Location States with commas', 'digitalkm-plugin' ),
				'add_or_remove_items'        => __( 'Add or remove Location States', 'digitalkm-plugin' ),
				'choose_from_most_used'      => __( 'Choose from the most used Location States', 'digitalkm-plugin' ),
				'not_found'                  => __( 'No Location States found.', 'digitalkm-plugin' ),
				'no_terms'                   => __( 'No Location States', 'digitalkm-plugin' ),
				'menu_name'                  => __( 'Location States', 'digitalkm-plugin' ),
				'items_list_navigation'      => __( 'Location States list navigation', 'digitalkm-plugin' ),
				'items_list'                 => __( 'Location States list', 'digitalkm-plugin' ),
				'most_used'                  => _x( 'Most Used', 'artifact_state', 'digitalkm-plugin' ),
				'back_to_items'              => __( '&larr; Back to Location States', 'digitalkm-plugin' ),
			),
			'show_in_rest'          => true,
			'rest_base'             => 'artifact_state',
			'rest_controller_class' => 'WP_REST_Terms_Controller',
		)
	);

}
add_action( 'init', 'artifact_state_init' );

/**
 * Sets the post updated messages for the `artifact_state` taxonomy.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `artifact_state` taxonomy.
 */
function artifact_state_updated_messages( $messages ) {

	$messages['artifact_state'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => __( 'Location State added.', 'digitalkm-plugin' ),
		2 => __( 'Location State deleted.', 'digitalkm-plugin' ),
		3 => __( 'Location State updated.', 'digitalkm-plugin' ),
		4 => __( 'Location State not added.', 'digitalkm-plugin' ),
		5 => __( 'Location State not updated.', 'digitalkm-plugin' ),
		6 => __( 'Location States deleted.', 'digitalkm-plugin' ),
	);

	return $messages;
}
add_filter( 'term_updated_messages', 'artifact_state_updated_messages' );
