<?php
/**
 * Plugin Name: All-in-One Event Calendar Frontend Submissions by Time.ly
 * Plugin URI: http://time.ly/
 * Description: Front End Submissions for the All-in-One Event Calendar include Front-End event and calendar feed contribution.
 * Author: Time.ly Network Inc.
 * Author URI: http://time.ly/
 * Version: 1.0.8
 * Text Domain: all-in-one-event-calendar-frontend-submissions
 * Domain Path: /language
 */

// Initialize constants
define( 'AI1ECFS_PLUGIN_NAME', 'all-in-one-event-calendar-frontend-submissions' );
define( 'AI1ECFS_PATH',        dirname( __FILE__ ) );
define( 'AI1ECFS_VERSION',     '1.0.8' );
define( 'AI1ECFS_URL',         plugins_url( '', __FILE__ ) );
define( 'AI1ECFS_FILE',        __FILE__ );

function ai1ec_frontend_submissions( Ai1ec_Registry_Object $registry ) {
	$registry->extension_acknowledge( AI1ECFS_PLUGIN_NAME, AI1ECFS_PATH );
	load_plugin_textdomain(
		AI1ECFS_PLUGIN_NAME,
		false,
		basename( AI1ECFS_PATH )
	);
	$registry->get( 'controller.ai1ecfs' )->init( $registry );
}

// on activation all plugins are loaded but plugins_loaded has not been triggered.
function ai1ec_frontend_submission_activation() {
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
				AI1ECFS_PLUGIN_NAME
			)
		);
	}
	require_once AI1ECFS_PATH . DIRECTORY_SEPARATOR . 'app' .
		DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR .
		'ai1ecfs.php';
	// no need to register this, we are redirected afterwards.
	$controller = new Ai1ec_Controller_Ai1ecfs();
	$controller->show_settings( $ai1ec_registry );
}

register_activation_hook( __FILE__, 'ai1ec_frontend_submission_activation' );
add_action( 'ai1ec_loaded', 'ai1ec_frontend_submissions', 9 );