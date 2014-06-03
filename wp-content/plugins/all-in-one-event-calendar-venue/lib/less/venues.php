<?php

/**
 * The class which adds LESS code for Venues.
 *
 * @author     Time.ly Network Inc.
 * @since      2.0
 *
 * @package    AI1EC
 * @subpackage AI1EC.Less
 */
class Ai1ecv_Less_Interactive_Frontend {

	/**
	 * Add LESS files to parse.
	 *
	 * @param array  $files
	 *
	 * @return array
	 */
	public function add_less_files( array $files ) {
		$files[] = 'venue-details.less';
		return $files;
	}
}