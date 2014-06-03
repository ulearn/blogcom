<?php

/**
 * @author time.ly
 *
 * This class handles the strategy used by the Facebook Graph Object Collection to  query for user events.
 */

class Ai1ec_Facebook_User_Query_Events_Strategy extends Ai1ec_Facebook_Query_Abstract implements Query_Events_Strategy_Interface {
	
	protected $_privacy = " and  (privacy = 'OPEN' OR privacy = 'FRIENDS') ";
	
	protected $_rsvp = " and rsvp_status != 'declined' ";

	/**
	 * (non-PHPdoc)
	 * @see Query_Events_Strategy_Interface::query_events()
	 */
	public function query_events( Ai1ec_Facebook_Proxy $facebook, array $users, $timestamp ) {
		$events = array();
		$registry = Ai1ec_Facebook_Factory::get_registry();
		$settings = $registry->get( 'model.settings' );
		if ( true === $settings->get( 'facebook_import_private' ) ) {
			$this->_privacy = '';
		}
		if ( true === $settings->get( 'facebook_import_declined' ) ) {
			$this->_rsvp = '';
		}
		// Create the fql query.
		$fql = $this->generate_fql_multiquery_to_get_events_details( $users, $timestamp );

		try {
			$events = $facebook->api( array(
				'method' => 'fql.multiquery',
				'queries' => $fql,
			) );
		} catch ( WP_FacebookApiException $e ) {
			throw $e;
		}
		// Normalize the events
		$events = $this->convert_multi_query_resultset( $events );
		// When an event has a page as venue, we must get the data from the page.
		$events = $this->update_events_with_page_id_as_venues( $facebook, $events );
		return $events;
	}

	/**
	 * Generate the fql query to get the details of user events
	 *
	 * @param array $users
	 *
	 * @param int $timestamp
	 *
	 * @return array an array of fql queries.
	 */
	private function generate_fql_multiquery_to_get_events_details( array $users, $timestamp ) {
		$fql = array();
		// When we make a query we must convert
		$time = Ai1ec_Facebook_Event::get_facebook_actual_time_for_events( $timestamp );

		foreach( $users as $id ) {
			$fql[$id] =
				"SELECT
					eid,
					name,
					description,
					start_time,
					end_time,
					venue,
					location,
					update_time,
					timezone,
					has_profile_pic,
					pic_big
				FROM
					event
				WHERE
					eid IN (SELECT eid FROM event_member WHERE uid = $id {$this->_rsvp} ) AND start_time > $time {$this->_privacy}";
		}
		return $fql;
	}
}
