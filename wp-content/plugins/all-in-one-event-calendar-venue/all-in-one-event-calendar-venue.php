<?php

/**
 * Plugin Name: All-in-One Event Calendar Venues by Time.ly
 * Plugin URI: http://time.ly/extension/venue
 * Description: All-in-One Event Calendar add-on for managing venues that can be featured with your events.
 * Author: Time.ly Network Inc.
 * Author URI: http://time.ly/
 * Version: 1.0.14
 * Text Domain: all-in-one-event-calendar-venue
 * Domain Path: /language
 */

define( 'AI1ECV_PLUGIN_NAME',   'all-in-one-event-calendar-venue' );
define( 'AI1ECV_PATH',          dirname( __FILE__ ) );
define( 'AI1ECV_TAXONOMY_NAME', 'events_venues' );
define( 'AI1ECV_VERSION',       '1.0.14' );
define( 'AI1ECV_URL',           plugins_url( '', __FILE__ ) );
define( 'AI1ECV_FILE',          __FILE__ );

function ai1ec_venue( Ai1ec_Registry_Object $registry ) {
	$registry->extension_acknowledge( AI1ECV_PLUGIN_NAME, AI1ECV_PATH );
	load_plugin_textdomain(
		AI1ECV_PLUGIN_NAME,
		false,
		basename( AI1ECV_PATH )
	);
	$registry->get( 'controller.ai1ecv' )->init( $registry );
}

// on activation all plugins are loaded but plugins_loaded has not been triggered.
function ai1ec_venue_activation() {
	global $ai1ec_registry;
	// if no global registry is set, core is not active
	// i could have checked for existance of extension class but class_exist calls are not reliable
	if (
		null === $ai1ec_registry ||
		! ( $ai1ec_registry instanceof Ai1ec_Registry_Object )
	) {
		return trigger_error(
			__(
				'All In One Event Calendar must be installed to activate extensions',
				AI1ECV_PLUGIN_NAME
			),
			E_USER_ERROR
		);
	}
	require_once AI1ECV_PATH . DIRECTORY_SEPARATOR . 'app' .
		DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR .
		'ai1ecv.php';
	// no need to register this, we are redirected afterwards.
	$controller = new Ai1ec_Controller_Ai1ecv();
	$method_exists = method_exists( $controller, 'check_compatibility' );
	if ( ! $method_exists || ! $controller->check_compatibility( AI1EC_VERSION ) ) {
		$message = __(
			'Could not activate the Venues add-on: All-in-One Event Calendar version %s or higher is required.',
			AI1ECV_PLUGIN_NAME
		);
		$version = $method_exists ? $controller->minimum_core_required() : '2.0.8';
		$message = sprintf( $message, $version );
		return trigger_error( $message, E_USER_ERROR );
	}
	$controller->show_settings( $ai1ec_registry );
}

register_activation_hook( __FILE__, 'ai1ec_venue_activation' );
add_action( 'ai1ec_loaded', 'ai1ec_venue' );