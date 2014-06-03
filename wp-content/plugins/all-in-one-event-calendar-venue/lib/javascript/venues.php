<?php

/**
 * The class which adds Venues javascript.
 *
 * @author     Time.ly Network Inc.
 * @since      2.0
 *
 * @package    AI1ECVENUE
 * @subpackage AI1ECVENUE.Lib.Javascript
 */
class Ai1ecv_Javascript extends Ai1ec_Base {

	/**
	 * Adds the email notifications files if the page is the calendar feeds one.
	 *
	 * @param array  $files
	 * @param string $page_to_load
	 *
	 * @return array
	 */
	public function add_js( array $files, $page_to_load ) {

		if ( 'add_new_event.js' === $page_to_load ) {
			$files[] = AI1ECV_PATH . '/public/js/add_new_event_venue.js';
		} else if ( 'event_category.js' === $page_to_load ) {
			$files[] = AI1ECV_PATH . '/public/js/event_venue.js';
		} else if ( 'event.js' === $page_to_load ) {
			$files[] = AI1ECV_PATH . '/public/js/pages/event.js';
		}


		return $files;

	}

}