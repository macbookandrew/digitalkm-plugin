<?php

/**
 * Registers the `artifact_subject` taxonomy,
 * for use with 'artifact'.
 */
function artifact_subject_init() {
	register_taxonomy( 'artifact_subject', array( 'artifact' ), array(
		'hierarchical'      => true,
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
			'name'                       => __( 'Subjects', 'digitalkm-plugin' ),
			'singular_name'              => _x( 'Subject', 'taxonomy general name', 'digitalkm-plugin' ),
			'search_items'               => __( 'Search Subjects', 'digitalkm-plugin' ),
			'popular_items'              => __( 'Popular Subjects', 'digitalkm-plugin' ),
			'all_items'                  => __( 'All Subjects', 'digitalkm-plugin' ),
			'parent_item'                => __( 'Parent Subject', 'digitalkm-plugin' ),
			'parent_item_colon'          => __( 'Parent Subject:', 'digitalkm-plugin' ),
			'edit_item'                  => __( 'Edit Subject', 'digitalkm-plugin' ),
			'update_item'                => __( 'Update Subject', 'digitalkm-plugin' ),
			'view_item'                  => __( 'View Subject', 'digitalkm-plugin' ),
			'add_new_item'               => __( 'New Subject', 'digitalkm-plugin' ),
			'new_item_name'              => __( 'New Subject', 'digitalkm-plugin' ),
			'separate_items_with_commas' => __( 'Separate Subjects with commas', 'digitalkm-plugin' ),
			'add_or_remove_items'        => __( 'Add or remove Subjects', 'digitalkm-plugin' ),
			'choose_from_most_used'      => __( 'Choose from the most used Subjects', 'digitalkm-plugin' ),
			'not_found'                  => __( 'No Subjects found.', 'digitalkm-plugin' ),
			'no_terms'                   => __( 'No Subjects', 'digitalkm-plugin' ),
			'menu_name'                  => __( 'Subjects', 'digitalkm-plugin' ),
			'items_list_navigation'      => __( 'Subjects list navigation', 'digitalkm-plugin' ),
			'items_list'                 => __( 'Subjects list', 'digitalkm-plugin' ),
			'most_used'                  => _x( 'Most Used', 'artifact_subject', 'digitalkm-plugin' ),
			'back_to_items'              => __( '&larr; Back to Subjects', 'digitalkm-plugin' ),
		),
		'show_in_rest'      => true,
		'rest_base'         => 'artifact_subject',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	) );

}
add_action( 'init', 'artifact_subject_init' );

/**
 * Sets the post updated messages for the `artifact_subject` taxonomy.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `artifact_subject` taxonomy.
 */
function artifact_subject_updated_messages( $messages ) {

	$messages['artifact_subject'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => __( 'Subject added.', 'digitalkm-plugin' ),
		2 => __( 'Subject deleted.', 'digitalkm-plugin' ),
		3 => __( 'Subject updated.', 'digitalkm-plugin' ),
		4 => __( 'Subject not added.', 'digitalkm-plugin' ),
		5 => __( 'Subject not updated.', 'digitalkm-plugin' ),
		6 => __( 'Subjects deleted.', 'digitalkm-plugin' ),
	);

	return $messages;
}
add_filter( 'term_updated_messages', 'artifact_subject_updated_messages' );
