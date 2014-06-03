<?php

/**
 * Interactive Frontend extension front controller.
 *
 * @author     Time.ly Network Inc.
 * @since      2.0
 *
 * @package    AI1ECFI
 * @subpackage AI1ECFI.Controller
 */
class Ai1ec_Controller_Ai1ecfi extends Ai1ec_Base_License_Controller {


	/* (non-PHPdoc)
	 * @see Ai1ec_Base_Extension_Controller::get_name()
	 */
	public function get_name() {
		return 'Facebook Connect';
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Base_Extension_Controller::get_machine_name()
	 */
	public function get_machine_name() {
		return 'facebook_integration';
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Base_Extension_Controller::get_version()
	 */
	public function get_version() {
		return AI1ECFI_VERSION;
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Licence_Controller::get_file()
	 */
	public function get_file() {
		return AI1ECFI_FILE;
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Base_License_Controller::get_license_label()
	 */
	public function get_license_label() {
		return __( 'Facebook License Key', AI1ECFI_PLUGIN_NAME );
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Base_License_Controller::add_tabs()
	 */
	public function add_tabs( array $tabs ) {
		$tabs = parent::add_tabs( $tabs );
		$tabs['extensions']['items']['facebook'] = __(
			'Facebook',
			AI1ECFI_PLUGIN_NAME
		);
		return $tabs;
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Base_Extension_Controller::_set_settings()
	 */
	protected function _get_settings() {
		return array(
			'facebook_import_private' => array(
				'type' => 'bool',
				'version'  => AI1ECFI_VERSION,
				'renderer' => array(
					'class' => 'checkbox',
					'tab'   => 'extensions',
					'item'  => 'facebook',
					'label' => __(
						'Include <strong>private</strong> events when importing from Facebook',
						AI1ECFI_PLUGIN_NAME
					)
				),
				'value'  => false,
			),
			'facebook_import_declined' => array(
				'type' => 'bool',
				'version'  => AI1ECFI_VERSION,
				'renderer' => array(
					'class' => 'checkbox',
					'tab'   => 'extensions',
					'item'  => 'facebook',
					'label' => __(
						'Include <strong>declined</strong> events when importing from Facebook',
						AI1ECFI_PLUGIN_NAME
					)
				),
				'value'  => false,
			),
			'facebook_import_draft' => array(
				'type' => 'bool',
				'version'  => AI1ECFI_VERSION,
				'renderer' => array(
					'class' => 'checkbox',
					'tab'   => 'extensions',
					'item'  => 'facebook',
					'label' => __(
						'Import events from Facebook as <strong>pending</strong> events',
						AI1ECFI_PLUGIN_NAME
					)
				),
				'value'  => false,
			),
		);
	}

	/**
	 * @return array
	 */
	protected static function _get_schema( $prefix ) {
		$table_name = $prefix . 'ai1ec_facebook_users';
		$sql = "CREATE TABLE $table_name (
				user_id bigint(20) NOT NULL,
				user_name varchar(255) NOT NULL,
				user_pic varchar(255) NOT NULL,
				subscribed tinyint(1) NOT NULL DEFAULT '0',
				type varchar(20) NOT NULL,
				tag varchar(255) NOT NULL DEFAULT '',
				category varchar(255) NOT NULL DEFAULT '',
				comments_enabled tinyint(1) NOT NULL DEFAULT '1',
				map_display_enabled tinyint(1) NOT NULL DEFAULT '0',
				last_synced timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
				PRIMARY KEY  (user_id),
				KEY subscribers (type(2),subscribed)
				) DEFAULT CHARSET=utf8;";
		$table_users_events = $prefix . 'ai1ec_facebook_users_events';
		$sql .= "CREATE TABLE $table_users_events (
				user_id bigint(20) unsigned NOT NULL,
				eid bigint(20) unsigned NOT NULL,
				start int(10) UNSIGNED NOT NULL,
				PRIMARY KEY  (user_id,eid)
				) DEFAULT CHARSET=utf8;";
		return array(
			'schema'  => $sql,
			'tables'  => array(
				$table_name,
				$table_users_events,
			),
		);
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Base_Extension_Controller::_register_actions()
	 */
	protected function _register_actions( Ai1ec_Event_Dispatcher $dispatcher ) {
		$dispatcher->register_filter(
			'ai1ec_calendar_feeds',
			array( 'calendar-feeds.facebook', 'add_facebook_tab' )
		);
		$dispatcher->register_filter(
			'ai1ec_render_js',
			array( 'javascript.facebook', 'add_js' ),
			10,
			2
		);
		// add ajax action here otherwise they are never called
		$dispatcher->register_action(
			'wp_ajax_ai1ec_refresh_events',
			array( 'calendar-feeds.facebook', 'refresh_events_ajax' )
		);
		// Set the AJAX action to dismiss the notice.
		$dispatcher->register_action(
			'wp_ajax_ai1ec_facebook_cron_dismiss',
			array( 'calendar-feeds.facebook', 'dismiss_notice_ajax' )
		);
		// Set the AJAX action to refresh Facebook Graph Objects
		$dispatcher->register_action(
			'wp_ajax_ai1ec_refresh_facebook_objects',
			array( 'calendar-feeds.facebook', 'refresh_facebook_ajax' )
		);
		// Set AJAX action to remove a subscribed user
		$dispatcher->register_action(
			'wp_ajax_ai1ec_remove_subscribed',
			array( 'calendar-feeds.facebook', 'remove_subscribed_ajax' )
		);
		// Set AJAX action to refresh multiselect
		$dispatcher->register_action(
			'wp_ajax_ai1ec_refresh_multiselect',
			array( 'calendar-feeds.facebook', 'refresh_multiselect' )
		);
		// Refresh tokens to export to pages.
		$dispatcher->register_action(
			'wp_ajax_ai1ec_refresh_tokens',
			array( 'calendar-feeds.facebook', 'refresh_tokens_ajax' )
		);

		// Add the "Export to facebook" widget.
		$dispatcher->register_action(
			'post_submitbox_misc_actions',
			array( 'calendar-feeds.facebook', 'render_export_box' )
		);
		// Add the "Export to facebook" functionality.
		$dispatcher->register_action(
			'ai1ec_save_post',
			array( 'calendar-feeds.facebook', 'handle_save_event' )
		);
		// Add the select to filter events in the "All events" page
		$dispatcher->register_action(
			'restrict_manage_posts',
			array( 'legacy.facebook.class-ai1ec-facebook-custom-bulk-action', 'facebook_filter_restrict_manage_posts' )
		);
		// Add action to handle export to facebook
		$dispatcher->register_action(
			'load-edit.php',
			array( 'legacy.facebook.class-ai1ec-facebook-custom-bulk-action', 'facebook_custom_bulk_action' )
		);
		// Add action to filter data
		$dispatcher->register_action(
			'posts_where',
			array( 'legacy.facebook.class-ai1ec-facebook-custom-bulk-action', 'facebook_filter_posts_where' )
		);
	}
}
