<?php
/**
 * Plugin Name: All-in-One Event Calendar Twitter Integration by Time.ly
 * Plugin URI: http://time.ly/
 * Description: The twitter integration for timely calendar
 * Author: Time.ly Network Inc.
 * Author URI: http://time.ly/
 * Version: 1.0.7
 * Text Domain: all-in-one-event-calendar-twitter-integration
 * Domain Path: /language
 */

// Initialize constants
define( 'AI1ECTI_PLUGIN_NAME', 'all-in-one-event-calendar-twitter-integration' );
define( 'AI1ECTI_PATH',        dirname( __FILE__ ) );
define( 'AI1ECTI_VERSION',     '1.0.7' );
define( 'AI1ECTI_URL',         plugins_url( '', __FILE__ ) );
define( 'AI1ECTI_FILE',        __FILE__ );

function ai1ec_twitter_integration( Ai1ec_Registry_Object $registry ) {
	$registry->extension_acknowledge( AI1ECTI_PLUGIN_NAME, AI1ECTI_PATH );
	$registry->get( 'controller.ai1ecti' )->init( $registry );
}

// on activation all plugins are loaded but plugins_loaded has not been triggered.
function ai1ec_twitter_integration_activation() {
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
				AI1ECTI_PLUGIN_NAME
			)
		);
	}
	require_once AI1ECTI_PATH . DIRECTORY_SEPARATOR . 'app' .
		DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR .
		'ai1ecti.php';
	// no need to register this, we are redirected afterwards.
	$controller = new Ai1ec_Controller_Ai1ecti();
	$controller->show_settings( $ai1ec_registry );
}

register_activation_hook( __FILE__, 'ai1ec_twitter_integration_activation' );
add_action( 'ai1ec_loaded', 'ai1ec_twitter_integration', 9 );