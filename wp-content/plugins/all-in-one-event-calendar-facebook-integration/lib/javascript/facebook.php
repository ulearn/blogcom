<?php

/**
 * The class which adds facebook javascript.
 *
 * @author     Time.ly Network Inc.
 * @since      2.0
 *
 * @package    AI1EC
 * @subpackage AI1EC.Facebook
 */
class Ai1ec_Javascript_Facebook extends Ai1ec_Base {

	/**
	 * Adds the facebook files if the page is the calendar feeds one.
	 * 
	 * @param array  $files
	 * @param string $page_to_load
	 * 
	 * @return array
	 */
	public function add_js( array $files, $page_to_load ) {
		if ( Ai1ec_Javascript_Controller::CALENDAR_FEEDS_PAGE === $page_to_load ) {
			$files[] = AI1ECFI_PATH . '/public/js/pages/facebook.js';
		}
		if ( Ai1ec_Javascript_Controller::ADD_NEW_EVENT_PAGE === $page_to_load ) {
			$files[] = AI1ECFI_PATH . '/public/js/pages/facebook_export.js';
		}
		return $files;
	}

}