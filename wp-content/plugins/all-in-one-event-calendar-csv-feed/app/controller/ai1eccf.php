<?php

/**
 * CSV Feed extension front controller.
 *
 * @author     Time.ly Network Inc.
 * @since      2.0
 *
 * @package    AI1ECCF
 * @subpackage AI1ECCF.Controller
 */
class Ai1ec_Controller_Ai1eccf extends Ai1ec_Base_License_Controller {

	/**
	 * Get label to be used for license input field.
	 *
	 * @return string Localized label field.
	 */
	public function get_license_label() {
		return __( 'CSV Feed - License Key', AI1ECCF_PLUGIN_NAME );
	}

	/**
	 * Get the long name of the extension
	 */
	public function get_name() {
		return 'CSV Import';
	}

	/**
	 * Get the machine name of the extension
	 */
	public function get_machine_name() {
		return 'csv_feed';
	}

	/**
	 * Get the version of the extension
	 */
	public function get_version() {
		return AI1ECCF_VERSION;
	}

	/**
	 * Get the name of the main plugin file
	 */
	public function get_file() {
		return AI1ECCF_FILE;
	}

	/**
	 * Add extension specific settings
	 */
	protected function _get_settings() {
		return array();
	}

	/**
	 * Register action/filters/shortcodes for the extension
	 *
	 * @param Ai1ec_Event_Dispatcher $dispatcher
	 */
	protected function _register_actions(Ai1ec_Event_Dispatcher $dispatcher) {
		$dispatcher->register_filter(
			'ai1ec_calendar_feeds',
			array( 'controller.ai1eccf', 'create_plugin' )
		);
	}

	public function create_plugin( $feeds ) {
		$feeds[] = $this->_registry->get( 'calendar-feeds.csv' );
		return $feeds;
	}

}