<?php

class DKM_Rest extends DKM_Plugin {

	/**
	 * Kick things off
	 * @private
	 */
	function __construct() {
		add_action( 'rest_api_init', array( $this, 'timeline_route' ) );
	}

	/**
	 * Add custom route for timeline JSON
	 */
	public function timeline_route() {
		// Specific IDs
		register_rest_route( 'dkm/v1', '/timeline/(?P<id>\d+)', array(
			'methods'	=> WP_REST_Server::READABLE,
			'callback'	=> array( $this, 'get_one_artifact' ),
		) );

		// All
		register_rest_route( 'dkm/v1', '/timeline/', array(
			'methods'	=> WP_REST_Server::READABLE,
			'callback'	=> array( $this, 'get_all_artifacts' ),
		) );

	}

	/**
	 * Set defaut query args for timeline
	 * @param  array [$extra_args = array()] Query args to override defaults
	 * @return array Query args
	 */
	private function get_query_args( $extra_args = array() ) {
		$defaults = array(
			'post_type'			=> 'artifact',
			'order'				=> 'ASC',
			'orderby' 			=> 'meta_value_num',
			'meta_key'			=> 'item_begin_date',
			'meta_query'        => array(
				'relation'  => 'OR',
				array(
					'key'       => 'item_begin_date',
					'compare'   => 'EXISTS',
				),
				array(
					'key'       => 'item_end_date',
					'compare'   => 'EXISTS',
				),
			),
		);

		return wp_parse_args( $extra_args, $defaults );
	}

	/**
	 * Return timeline JSON data
	 * @param object WP_REST_Request $request Request from client
	 */
	private function get_timeline_data( $query_args ) {
		$artifacts = new WP_Query( $query_args );

		$results = array( 'events' => array(), );

		if ( $artifacts->have_posts() ) {
			while ( $artifacts->have_posts() ) {
				$artifacts->the_post();

				$this_event = array(
					'unique_id' => get_the_ID(),
					'text'			=> array(
						'headline'	=> get_the_title(),
						'text'		=> get_the_excerpt(),
					),
				);

				$begin_date = get_field( 'item_begin_date' );
				$end_date = get_field( 'item_end_date' );

				if ( ! empty( $begin_date ) ) {
					$begin_date = DateTime::createFromFormat( 'Ymd', $begin_date );
					$this_event['start_date'] = array(
						'day'	=> $begin_date->format( 'd' ),
						'month'	=> $begin_date->format( 'm' ),
						'year'	=> $begin_date->format( 'Y' ),
					);
				}
				if ( ! empty( $end_date ) ) {
					$end_date = DateTime::createFromFormat( 'Ymd', $end_date );
					$this_event['end_date'] = array(
						'day'	=> $end_date->format( 'd' ),
						'month'	=> $end_date->format( 'm' ),
						'year'	=> $end_date->format( 'Y' ),
					);
				}

				if ( has_post_thumbnail() ) {
					$this_event['media'] = array(
						'url'   => get_the_post_thumbnail_url(),
						'title' => get_the_title( get_post_thumbnail_id() ),
					);
				}
				$results['events'][] = $this_event;
			}
		}

		return $results;
	}

	/**
	 * Get all timeline data
	 * @param  object WP_REST_Request $request Request from client
	 * @return string JSON data
	 */
	public function get_all_artifacts( WP_REST_Request $request ) {
		$query_args = $this->get_query_args( array( 'posts_per_page' => -1, ) );
		return $this->get_timeline_data( $query_args );
	}

	/**
	 * Get a single artifact timeline data
	 * @param  object WP_REST_Request $request Request from client
	 * @return string JSON data
	 */
	public function get_one_artifact( WP_REST_Request $request ) {
		$query_args = $this->get_query_args( array( 'post_id' => $request['id'], ) );
		return $this->get_timeline_data( $query_args );
	}

}