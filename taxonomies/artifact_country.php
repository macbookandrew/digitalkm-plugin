<?php
/**
 * Artifact custom taxomony
 *
 * @package Digitalkm
 */

/**
 * Registers the `artifact_country` taxonomy,
 * for use with 'artifact'.
 */
function artifact_country_init() {
	register_taxonomy(
		'artifact_country', array( 'artifact' ), array(
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
				'name'                       => __( 'Location Countries', 'digitalkm-plugin' ),
				'singular_name'              => _x( 'Location Country', 'taxonomy general name', 'digitalkm-plugin' ),
				'search_items'               => __( 'Search Location Countries', 'digitalkm-plugin' ),
				'popular_items'              => __( 'Popular Location Countries', 'digitalkm-plugin' ),
				'all_items'                  => __( 'All Location Countries', 'digitalkm-plugin' ),
				'parent_item'                => __( 'Parent Location Country', 'digitalkm-plugin' ),
				'parent_item_colon'          => __( 'Parent Location Country:', 'digitalkm-plugin' ),
				'edit_item'                  => __( 'Edit Location Country', 'digitalkm-plugin' ),
				'update_item'                => __( 'Update Location Country', 'digitalkm-plugin' ),
				'view_item'                  => __( 'View Location Country', 'digitalkm-plugin' ),
				'add_new_item'               => __( 'New Location Country', 'digitalkm-plugin' ),
				'new_item_name'              => __( 'New Location Country', 'digitalkm-plugin' ),
				'separate_items_with_commas' => __( 'Separate Location Countries with commas', 'digitalkm-plugin' ),
				'add_or_remove_items'        => __( 'Add or remove Location Countries', 'digitalkm-plugin' ),
				'choose_from_most_used'      => __( 'Choose from the most used Location Countries', 'digitalkm-plugin' ),
				'not_found'                  => __( 'No Location Countries found.', 'digitalkm-plugin' ),
				'no_terms'                   => __( 'No Location Countries', 'digitalkm-plugin' ),
				'menu_name'                  => __( 'Location Countries', 'digitalkm-plugin' ),
				'items_list_navigation'      => __( 'Location Countries list navigation', 'digitalkm-plugin' ),
				'items_list'                 => __( 'Location Countries list', 'digitalkm-plugin' ),
				'most_used'                  => _x( 'Most Used', 'artifact_country', 'digitalkm-plugin' ),
				'back_to_items'              => __( '&larr; Back to Location Countries', 'digitalkm-plugin' ),
			),
			'show_in_rest'          => true,
			'rest_base'             => 'artifact_country',
			'rest_controller_class' => 'WP_REST_Terms_Controller',
		)
	);

}
add_action( 'init', 'artifact_country_init' );

/**
 * Sets the post updated messages for the `artifact_country` taxonomy.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `artifact_country` taxonomy.
 */
function artifact_country_updated_messages( $messages ) {

	$messages['artifact_country'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => __( 'Location Country added.', 'digitalkm-plugin' ),
		2 => __( 'Location Country deleted.', 'digitalkm-plugin' ),
		3 => __( 'Location Country updated.', 'digitalkm-plugin' ),
		4 => __( 'Location Country not added.', 'digitalkm-plugin' ),
		5 => __( 'Location Country not updated.', 'digitalkm-plugin' ),
		6 => __( 'Location Countries deleted.', 'digitalkm-plugin' ),
	);

	return $messages;
}
add_filter( 'term_updated_messages', 'artifact_country_updated_messages' );
