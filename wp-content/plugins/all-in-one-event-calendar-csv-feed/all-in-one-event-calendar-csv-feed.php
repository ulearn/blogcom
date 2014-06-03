<?php

/**
 * Plugin Name: All-in-One Event Calendar CSV Feed by Time.ly
 * Plugin URI: http://time.ly/extension/csv-feed
 * Description: Famous All-in-One Event Calendar extension giving you possibility to import CSV feeds of events
 * Author: Time.ly Network Inc.
 * Author URI: http://time.ly/
 * Version: 1.0.2
 * Text Domain: all-in-one-event-calendar-csv-feed
 * Domain Path: /language
 */

define( 'AI1ECCF_PLUGIN_NAME', 'all-in-one-event-calendar-csv-feed' );
define( 'AI1ECCF_PATH',        dirname( __FILE__ ) );
define( 'AI1ECCF_URL',         plugins_url( '', __FILE__ ) );
define( 'AI1ECCF_FILE',        __FILE__ );
define( 'AI1ECCF_VERSION',     '1.0.2' );

function ai1ec_csv_feed( Ai1ec_Registry_Object $registry ) {
	$registry->extension_acknowledge( AI1ECCF_PLUGIN_NAME, AI1ECCF_PATH );
	load_plugin_textdomain(
		AI1ECCF_PLUGIN_NAME,
		false,
		basename( AI1ECCF_PATH )
	);
	$registry->get( 'controller.ai1eccf' )->init( $registry );
}

// on activation all plugins are loaded but plugins_loaded has not been triggered.
function ai1ec_csv_feed_activation() {
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
				AI1ECCF_PLUGIN_NAME
			)
		);
	}
	require_once AI1ECCF_PATH . DIRECTORY_SEPARATOR . 'app' .
		DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR .
		'ai1eccf.php';
	// no need to register this, we are redirected afterwards.
	$controller = new Ai1ec_Controller_Ai1eccf();
	$controller->show_settings( $ai1ec_registry );
}

register_activation_hook( __FILE__, 'ai1ec_csv_feed_activation' );
add_action( 'ai1ec_loaded', 'ai1ec_csv_feed' );