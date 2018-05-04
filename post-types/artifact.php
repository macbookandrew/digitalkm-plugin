<?php
/**
 * Register artifact CPT
 *
 * @package Digitalkm
 */

/**
 * Registers the `artifact` post type.
 */
function artifact_init() {
	register_post_type(
		'artifact', array(
			'labels'                => array(
				'name'                  => __( 'Historical Artifacts', 'digitalkm' ),
				'singular_name'         => __( 'Historical Artifact', 'digitalkm' ),
				'all_items'             => __( 'All Historical Artifacts', 'digitalkm' ),
				'archives'              => __( 'Historical Artifact Archives', 'digitalkm' ),
				'attributes'            => __( 'Historical Artifact Attributes', 'digitalkm' ),
				'insert_into_item'      => __( 'Insert into Historical Artifact', 'digitalkm' ),
				'uploaded_to_this_item' => __( 'Uploaded to this Historical Artifact', 'digitalkm' ),
				'featured_image'        => _x( 'Featured Image', 'artifact', 'digitalkm' ),
				'set_featured_image'    => _x( 'Set featured image', 'artifact', 'digitalkm' ),
				'remove_featured_image' => _x( 'Remove featured image', 'artifact', 'digitalkm' ),
				'use_featured_image'    => _x( 'Use as featured image', 'artifact', 'digitalkm' ),
				'filter_items_list'     => __( 'Filter Historical Artifacts list', 'digitalkm' ),
				'items_list_navigation' => __( 'Historical Artifacts list navigation', 'digitalkm' ),
				'items_list'            => __( 'Historical Artifacts list', 'digitalkm' ),
				'new_item'              => __( 'New Historical Artifact', 'digitalkm' ),
				'add_new'               => __( 'Add New', 'digitalkm' ),
				'add_new_item'          => __( 'Add New Historical Artifact', 'digitalkm' ),
				'edit_item'             => __( 'Edit Historical Artifact', 'digitalkm' ),
				'view_item'             => __( 'View Historical Artifact', 'digitalkm' ),
				'view_items'            => __( 'View Historical Artifacts', 'digitalkm' ),
				'search_items'          => __( 'Search Historical Artifacts', 'digitalkm' ),
				'not_found'             => __( 'No Historical Artifacts found', 'digitalkm' ),
				'not_found_in_trash'    => __( 'No Historical Artifacts found in trash', 'digitalkm' ),
				'parent_item_colon'     => __( 'Parent Historical Artifact:', 'digitalkm' ),
				'menu_name'             => __( 'Historical Artifacts', 'digitalkm' ),
			),
			'public'                => true,
			'hierarchical'          => true,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'supports'              => array( 'title', 'editor', 'comments', 'revisions', 'author', 'excerpt', 'page-attributes', 'thumbnail', 'post-formats' ),
			'has_archive'           => true,
			'rewrite'               => true,
			'query_var'             => true,
			'menu_icon'             => 'dashicons-book-alt',
			'taxonomies'            => array( 'category', 'post_tag', 'artifact_country', 'artifact_state', 'artifact_county', 'artifact_city', 'artifact_subject' ),
			'show_in_rest'          => true,
			'rest_base'             => 'artifact',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		)
	);

}
add_action( 'init', 'artifact_init' );

/**
 * Sets the post updated messages for the `artifact` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `artifact` post type.
 */
function artifact_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['artifact'] = array(
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Historical Artifact updated. <a target="_blank" href="%s">View Historical Artifact</a>', 'digitalkm' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'digitalkm' ),
		3  => __( 'Custom field deleted.', 'digitalkm' ),
		4  => __( 'Historical Artifact updated.', 'digitalkm' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Historical Artifact restored to revision from %s', 'digitalkm' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // WPCS: CSRF ok.
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Historical Artifact published. <a href="%s">View Historical Artifact</a>', 'digitalkm' ), esc_url( $permalink ) ),
		7  => __( 'Historical Artifact saved.', 'digitalkm' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Historical Artifact submitted. <a target="_blank" href="%s">Preview Historical Artifact</a>', 'digitalkm' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9  => sprintf(
			/* translators: %1$s: Publish box date format, see https://secure.php.net/date %2$s: Post permalink */
			__( 'Historical Artifact scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Historical Artifact</a>', 'digitalkm' ),
			date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink )
		),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Historical Artifact draft updated. <a target="_blank" href="%s">Preview Historical Artifact</a>', 'digitalkm' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'artifact_updated_messages' );
