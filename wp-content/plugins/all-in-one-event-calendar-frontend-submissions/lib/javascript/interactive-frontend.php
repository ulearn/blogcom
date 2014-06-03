<?php

/**
 * The class which adds interactive frontend javascript.
 *
 * @author     Time.ly Network Inc.
 * @since      2.0
 *
 * @package    AI1ECFS
 * @subpackage AI1ECFS.Lib
 */
class Ai1ecfs_Javascript_Interactive_Frontend extends Ai1ec_Base {

	/**
	 * Adds interactive frontend javascript
	 *
	 * @param array  $files
	 * @param string $page_to_load
	 *
	 * @return array
	 */
	public function add_js( array $files, $page_to_load ) {
		if ( Ai1ec_Javascript_Controller::CALENDAR_PAGE_JS === $page_to_load ) {
			$files[] = AI1ECFS_PATH . '/public/js/pages/front_end_create_event_form.js';
			$files[] = AI1ECFS_PATH . '/public/js/pages/submit_ics_modal.js';
		}
		if ( 'admin_settings.js' === $page_to_load) {
			$files[] = AI1ECFS_PATH . '/public/js/pages/admin_settings.js';
		}
		return $files;
	}
}