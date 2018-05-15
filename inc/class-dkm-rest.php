<?php
/**
 * REST API addons
 *
 * @package Digitalkm
 */

/**
 * REST API addons
 *
 * @package Digitalkm
 */
class DKM_Rest extends DKM_Plugin {

	/**
	 * Kick things off
	 *
	 * @private
	 */
	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'custom_routes' ) );
	}

	/**
	 * Add custom route for timeline JSON
	 */
	public function custom_routes() {
		// Timeline: handle specific IDs.
		register_rest_route(
			'dkm/v1', '/timeline/(?P<id>\d+)', array(
				'methods'  => WP_REST_Server::READABLE,
				'callback' => array( $this, 'get_one_item_timeline' ),
			)
		);

		// Timeline: handle CPT items.
		register_rest_route(
			'dkm/v1', '/timeline/post-type/(?P<cpt>[a-zA-Z]+)', array(
				'methods'  => WP_REST_Server::READABLE,
				'callback' => array( $this, 'get_cpt_items_timeline' ),
			)
		);

		// Timeline: handle all.
		register_rest_route(
			'dkm/v1', '/timeline/', array(
				'methods'  => WP_REST_Server::READABLE,
				'callback' => array( $this, 'get_all_items_timeline' ),
			)
		);

		// Map: handle all.
		register_rest_route(
			'dkm/v1', '/storymap/', array(
				'methods'  => WP_REST_Server::READABLE,
				'callback' => array( $this, 'get_all_items_storymap' ),
			)
		);

	}

	/**
	 * Format date for TimelineJS
	 *
	 * @param  string string $input_date Ymd-formatted date to be split up.
	 * @return array  Formatted date array for TimelineJS
	 */
	private function format_date( string $input_date ) {
		$date = DateTime::createFromFormat( 'Ymd', $input_date );
		return array(
			'day'   => $date->format( 'd' ),
			'month' => $date->format( 'm' ),
			'year'  => $date->format( 'Y' ),
		);
	}

	/**
	 * Set defaut query args for timeline
	 *
	 * @param  array [ $extra_args = array()] Query args to override defaults.
	 * @return array Query args
	 */
	private function get_query_args( $extra_args = array() ) {
		$defaults = array(
			'post_type'      => array( 'artifact', 'mayor' ),
			'posts_per_page' => -1,
			'order'          => 'ASC',
			'orderby'        => 'meta_value_num',
			'meta_key'       => 'item_begin_date',
			'meta_query'     => array(
				'relation' => 'OR',
				array(
					'key'     => 'item_begin_date',
					'compare' => 'EXISTS',
				),
				array(
					'key'     => 'item_end_date',
					'compare' => 'EXISTS',
				),
				array(
					'key'     => 'mayoral_service_dates',
					'compare' => 'EXISTS',
				),
			),
		);

		return wp_parse_args( $extra_args, $defaults );
	}

	/**
	 * Return storymap JSON data
	 *
	 * @param  array array $query_args Additional query args.
	 * @return array Array with event data
	 */
	private function get_storymap_data( array $query_args ) {

		$results = array(
			'storymap' => array(
				'map_type'     => 'osm:standard',
				'map_as_image' => false,
				'slides'       => array(),
			),
		);

		$artifacts = new WP_Query( $query_args );
		if ( $artifacts->have_posts() ) {
			while ( $artifacts->have_posts() ) {
				$artifacts->the_post();

				$map = get_field( 'map' );
				if ( ! empty( $map ) ) {

					$this_event = array(
						'text' => array(
							'headline' => get_the_title(),
							'text'     => apply_filters( 'the_content', get_the_content() ),
						),
					);

					$video_url = get_field( 'video_url' );
					if ( ! empty( $video_url ) ) {
						$this_event['media'] = array(
							'url'  => $video_url,
							'link' => get_permalink(),
						);
					} elseif ( has_post_thumbnail() ) {
						$this_event['media'] = array(
							'url'     => get_the_post_thumbnail_url( get_the_ID(), 'timeline-image-lg' ),
							'caption' => get_the_title( get_post_thumbnail_id() ),
						);
					}

					$locations = json_decode( $map );
					foreach ( $locations->features as $feature ) {
						if ( 'Point' === $feature->geometry->type ) {
							$this_event['location']['lon']  = $feature->geometry->coordinates[0];
							$this_event['location']['lat']  = $feature->geometry->coordinates[1];
							$this_event['location']['line'] = true;
							$this_event['location']['zoom'] = 8;
						} elseif ( count( $feature->geometry->coordinates[0] ) > 1 ) {
							$this_event['location']['lon']  = $feature->geometry->coordinates[0][0][0];
							$this_event['location']['lat']  = $feature->geometry->coordinates[0][0][1];
							$this_event['location']['line'] = true;
							$this_event['location']['zoom'] = 8;
						}

						$results['storymap']['slides'][] = $this_event;
					}
				}
			}
		}

		return $results;
	}

	/**
	 * Return timeline JSON data
	 *
	 * @param  array array $query_args Additional query args.
	 * @return array Array with event data
	 */
	private function get_timeline_data( array $query_args ) {
		$artifacts = new WP_Query( $query_args );
		global $post;

		$results = array( 'events' => array() );

		if ( $artifacts->have_posts() ) {
			while ( $artifacts->have_posts() ) {
				$artifacts->the_post();

				$this_event = array(
					'unique_id' => $post->post_name,
					'text'      => array(
						'headline' => get_the_title(),
						'text'     => apply_filters( 'the_content', get_the_content() ),
					),
				);

				$video_url = get_field( 'video_url' );
				if ( ! empty( $video_url ) ) {
					$this_event['media'] = array(
						'url'  => $video_url,
						'link' => get_permalink(),
					);
				} elseif ( has_post_thumbnail() ) {
					$this_event['media'] = array(
						'url'       => get_the_post_thumbnail_url( $post, 'timeline-image-lg' ),
						'title'     => get_the_title( get_post_thumbnail_id() ),
						'thumbnail' => get_the_post_thumbnail_url( $post, 'timeline-thumbnail' ),
						'link'      => get_permalink(),
					);
				}

				// Handle artifacts and mayors differently.
				if ( 'artifact' === get_post_type() ) {
					$this_event['group'] = 'Historical Items';

					$begin_date = get_field( 'item_begin_date' );
					$end_date   = get_field( 'item_end_date' );

					if ( ! empty( $begin_date ) ) {
						$this_event['start_date'] = $this->format_date( $begin_date );
					}
					if ( ! empty( $end_date ) ) {
						$this_event['end_date'] = $this->format_date( $end_date );
					}

					$results['events'][] = $this_event;
				} elseif ( 'mayor' === get_post_type() ) {
					$this_event['group'] = 'Mayors';

					$service_dates = get_field( 'mayoral_service_dates' );
					foreach ( $service_dates as $date ) {
						$this_event['unique_id'] = $post->post_name . '-' . $date['begin_date'];
						if ( ! empty( $date['begin_date'] ) ) {
							$this_event['start_date'] = $this->format_date( $date['begin_date'] );
						}
						if ( ! empty( $date['end_date'] ) ) {
							$this_event['end_date'] = $this->format_date( $date['end_date'] );
						}
						$results['events'][] = $this_event;
					}
				}
			}
		}

		return $results;
	}

	/**
	 * Get all timeline data
	 *
	 * @param  object WP_REST_Request $request Request from client.
	 * @return string JSON data
	 */
	public function get_all_items_timeline( WP_REST_Request $request ) {
		$query_args = $this->get_query_args();
		return $this->get_timeline_data( $query_args );
	}

	/**
	 * Get a single artifact timeline data
	 *
	 * @param  object WP_REST_Request $request Request from client.
	 * @return string JSON data
	 */
	public function get_one_item_timeline( WP_REST_Request $request ) {
		$query_args = $this->get_query_args( array( 'post_id' => $request['id'] ) );
		return $this->get_timeline_data( $query_args );
	}

	/**
	 * Get timeline data for a specific CPT
	 *
	 * @param  object WP_REST_Request $request Request from client.
	 * @return string JSON data
	 */
	public function get_cpt_items_timeline( WP_REST_Request $request ) {
		$query_args = $this->get_query_args( array( 'post_type' => esc_attr( $request['cpt'] ) ) );
		return $this->get_timeline_data( $query_args );
	}

	/**
	 * Get all timeline data
	 *
	 * @param  object WP_REST_Request $request Request from client.
	 * @return string JSON data
	 */
	public function get_all_items_storymap( WP_REST_Request $request ) {
		$query_args = $this->get_query_args();
		return $this->get_storymap_data( $query_args );
	}

}
