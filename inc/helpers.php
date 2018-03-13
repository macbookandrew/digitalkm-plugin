<?php
class DKM_Helper {
	/**
	 * Format date range
	 * @param  string $begin_date Ymd-formatted begin date
	 * @param  string $end_date   Ymd-formatted end date
	 * @return string human-formatted date range
	 */
	public function format_date_range( $begin_date, $end_date = NULL ) {
		$begin = new DateTime();
		$begin->setDate( substr( $begin_date, 0, 4 ), substr( $begin_date, 4, 2 ), substr( $begin_date, 6, 2 ) );
		$formatted_date = $begin->format( 'F j, Y' );

		// end date
		if ( ! is_null( $end_date ) && ! empty( $end_date ) ) {
			$end = new DateTime();
			$end->setDate( substr( $end_date, 0, 4 ), substr( $end_date, 4, 2 ), substr( $end_date, 6, 2 ) );

			// format is based on distance between dates
			if ( $begin->format( 'Y' ) !== $end->format( 'Y' ) ) {
				$formatted_date .= '&ndash;' . $end->format( 'F j, Y' );
			} elseif ( $begin->format( 'm' ) !== $end->format( 'm' ) ) {
				$formatted_date = $begin->format( 'F j' ) . '&ndash;' . $end->format( 'F j, Y' );
			} elseif ( $begin->format( 'd' ) !== $end->format( 'd' ) ) {
				$formatted_date = $begin->format ( 'F j' ) . '&ndash;' . $end->format( 'j, Y' );
			}
		}

		return $formatted_date;
	}

	/**
	 * Get query parameter for date range
	 * @param  string $begin_date Ymd-formatted begin date
	 * @param  string $end_date   Ymd-formatted end date
	 * @return string date range query parameter
	 */
	public function get_timeline_range_query( $begin_date, $end_date = NULL ) {
		$begin = new DateTime();
		$begin->setDate( substr( $begin_date, 0, 4 ), substr( $begin_date, 4, 2 ), substr( $begin_date, 6, 2 ) );
		$query_string = 'begindate=' . $begin->format( 'Y-m-d' );

		// end date
		if ( ! is_null( $end_date ) && ! empty( $end_date ) ) {
			$end = new DateTime();
			$end->setDate( substr( $end_date, 0, 4 ), substr( $end_date, 4, 2 ), substr( $end_date, 6, 2 ) );

			$query_string .= '&enddate=' . $end->format( 'Y-m-d' );
		}

		return $query_string;
	}

}
