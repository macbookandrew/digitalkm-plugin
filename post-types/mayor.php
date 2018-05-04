<?php
/**
 * Register mayor CPT
 *
 * @package Digitalkm
 */

/**
 * Registers the `mayor` post type.
 */
function mayor_init() {
	register_post_type(
		'mayor', array(
			'labels'                => array(
				'name'                  => __( 'Mayors', 'digitalkm' ),
				'singular_name'         => __( 'Mayor', 'digitalkm' ),
				'all_items'             => __( 'All Mayors', 'digitalkm' ),
				'archives'              => __( 'Mayor Archives', 'digitalkm' ),
				'attributes'            => __( 'Mayor Attributes', 'digitalkm' ),
				'insert_into_item'      => __( 'Insert into Mayor', 'digitalkm' ),
				'uploaded_to_this_item' => __( 'Uploaded to this Mayor', 'digitalkm' ),
				'featured_image'        => _x( 'Featured Image', 'mayor', 'digitalkm' ),
				'set_featured_image'    => _x( 'Set featured image', 'mayor', 'digitalkm' ),
				'remove_featured_image' => _x( 'Remove featured image', 'mayor', 'digitalkm' ),
				'use_featured_image'    => _x( 'Use as featured image', 'mayor', 'digitalkm' ),
				'filter_items_list'     => __( 'Filter Mayors list', 'digitalkm' ),
				'items_list_navigation' => __( 'Mayors list navigation', 'digitalkm' ),
				'items_list'            => __( 'Mayors list', 'digitalkm' ),
				'new_item'              => __( 'New Mayor', 'digitalkm' ),
				'add_new'               => __( 'Add New', 'digitalkm' ),
				'add_new_item'          => __( 'Add New Mayor', 'digitalkm' ),
				'edit_item'             => __( 'Edit Mayor', 'digitalkm' ),
				'view_item'             => __( 'View Mayor', 'digitalkm' ),
				'view_items'            => __( 'View Mayors', 'digitalkm' ),
				'search_items'          => __( 'Search Mayors', 'digitalkm' ),
				'not_found'             => __( 'No Mayors found', 'digitalkm' ),
				'not_found_in_trash'    => __( 'No Mayors found in trash', 'digitalkm' ),
				'parent_item_colon'     => __( 'Parent Mayor:', 'digitalkm' ),
				'menu_name'             => __( 'Mayors', 'digitalkm' ),
			),
			'public'                => true,
			'hierarchical'          => true,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'supports'              => array( 'title', 'editor', 'comments', 'revisions', 'author', 'excerpt', 'page-attributes', 'thumbnail', 'post-formats' ),
			'has_archive'           => true,
			'rewrite'               => true,
			'query_var'             => true,
			'menu_icon'             => 'dashicons-businessman',
			'taxonomies'            => array( 'category', 'post_tag' ),
			'show_in_rest'          => true,
			'rest_base'             => 'mayor',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		)
	);

}
add_action( 'init', 'mayor_init' );

/**
 * Sets the post updated messages for the `mayor` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `mayor` post type.
 */
function mayor_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['mayor'] = array(
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Mayor updated. <a target="_blank" href="%s">View Mayor</a>', 'digitalkm' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'digitalkm' ),
		3  => __( 'Custom field deleted.', 'digitalkm' ),
		4  => __( 'Mayor updated.', 'digitalkm' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Mayor restored to revision from %s', 'digitalkm' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // WPCS: CSRF ok.
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Mayor published. <a href="%s">View Mayor</a>', 'digitalkm' ), esc_url( $permalink ) ),
		7  => __( 'Mayor saved.', 'digitalkm' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Mayor submitted. <a target="_blank" href="%s">Preview Mayor</a>', 'digitalkm' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9  => sprintf(
			/* translators: %1$s: Publish box date format, see https://secure.php.net/date %2$s: Post permalink */
			__( 'Mayor scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Mayor</a>', 'digitalkm' ),
			date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink )
		),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Mayor draft updated. <a target="_blank" href="%s">Preview Mayor</a>', 'digitalkm' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'mayor_updated_messages' );
