<?php
/**
 * Plugin Name: All-in-One Event Calendar Super Widget by Time.ly
 * Plugin URI: http://time.ly/
 * Description: A Super widget extension for All-in-One Event Calendar
 * Author: Time.ly Network Inc.
 * Author URI: http://time.ly/
 * Version: 1.0.6
 * Text Domain: all-in-one-event-calendar-super-widget
 * Domain Path: /language
 */

// Initialize constants
define( 'AI1ECSW_PLUGIN_NAME', 'all-in-one-event-calendar-super-widget' );
define( 'AI1ECSW_PATH',        dirname( __FILE__ ) );
define( 'AI1ECSW_VERSION',     '1.0.6' );
define( 'AI1ECSW_URL',         plugins_url( '', __FILE__ ) );
define( 'AI1ECSW_FILE',        __FILE__ );

function ai1ec_super_widget( Ai1ec_Registry_Object $registry ) {
	$app = $registry->get( 'bootstrap.registry.application' );
	$app->set( 'super_widget_basepath', plugins_url( '', __FILE__ ) );
	$registry->extension_acknowledge( AI1ECSW_PLUGIN_NAME, AI1ECSW_PATH );
	$registry->get( 'controller.ai1ecsw' )->init( $registry );
}

// on activation all plugins are loaded but plugins_loaded has not been triggered.
function ai1ec_super_widget_activation() {
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
				AI1ECSW_PLUGIN_NAME
			),
			E_USER_ERROR
		);
	}
	require_once AI1ECSW_PATH . DIRECTORY_SEPARATOR . 'app' .
		DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR .
		'ai1ecsw.php';
	// no need to register this, we are redirected afterwards.
	$controller = new Ai1ec_Controller_Ai1ecsw();
	$method_exists = method_exists( $controller, 'check_compatibility' );
	if ( ! $method_exists || ! $controller->check_compatibility( AI1EC_VERSION ) ) {
		$message = __(
			'Could not activate the Super Widget add-on: All-in-One Event Calendar version %s or higher is required.',
			AI1ECSW_PLUGIN_NAME
		);
		$version = $method_exists ? $controller->minimum_core_required() : '2.0.8';
		$message = sprintf( $message, $version );
		return trigger_error( $message, E_USER_ERROR );
	}
	$controller->show_settings( $ai1ec_registry );
}

register_activation_hook( __FILE__, 'ai1ec_super_widget_activation' );
add_action( 'ai1ec_loaded', 'ai1ec_super_widget' );