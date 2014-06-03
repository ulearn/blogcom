<?php
/**
 * Plugin Name: All-in-One Event Calendar Facebook Integration by Time.ly
 * Plugin URI: http://time.ly/
 * Description: <a href="https://www.facebook.com" target="_blank" alt="Facebook, a social network">Facebook</a> integration for All-in-One Event Calendar
 * Author: Time.ly Network Inc.
 * Author URI: http://time.ly/
 * Version: 1.1.2
 * Text Domain: all-in-one-event-calendar-facebook-integration
 * Domain Path: /language
 */

// Initialize constants
define( 'AI1ECFI_PLUGIN_NAME', 'all-in-one-event-calendar-facebook-integration' );
define( 'AI1ECFI_PATH',        dirname( __FILE__ ) );
define( 'AI1ECFI_VERSION',     '1.1.2' );
define( 'AI1ECFI_URL',         plugins_url( '', __FILE__ ) );
define( 'AI1ECFI_FILE',        __FILE__ );

function ai1ec_facebook_integration( Ai1ec_Registry_Object $registry ) {
	$registry->extension_acknowledge( AI1ECFI_PLUGIN_NAME, AI1ECFI_PATH );
	Ai1ec_Facebook_Factory::set_registry( $registry );
	$registry->get( 'controller.ai1ecfi' )->init( $registry );
}

// on activation all plugins are loaded but plugins_loaded has not been triggered.
function ai1ec_facebook_activation() {
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
				AI1ECFI_PLUGIN_NAME 
			) ,
			E_USER_ERROR
		);
	}
	require_once AI1ECFI_PATH . DIRECTORY_SEPARATOR . 'app' .
		DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR .
		'ai1ecfi.php';
	// no need to register this, we are redirected afterwards.
	$controller = new Ai1ec_Controller_Ai1ecfi();
	$method_exists = method_exists( $controller, 'check_compatibility' );
	if ( ! $method_exists || ! $controller->check_compatibility( AI1EC_VERSION ) ) {
		$message = __( 
				'Could not activate the Facebook Connect add-on: All-in-One Event Calendar version %s or higher is required.', 
				AI1ECFI_PLUGIN_NAME 
			);
		$version = $method_exists ? $controller->minimum_core_required() : '2.0.8';
		$message = sprintf( $message, $version );
		return trigger_error( $message, E_USER_ERROR );
	}
	$controller->show_settings( $ai1ec_registry );
}

register_activation_hook( __FILE__, 'ai1ec_facebook_activation' );
add_action( 'ai1ec_loaded', 'ai1ec_facebook_integration' );