<?php
/**
 * This class handles the creation of objects.
 *
 * @author The Seed Network
 *
 *
 */
class Ai1ec_Facebook_Factory {
	const CURRENT_USER            = 'Ai1ec_Facebook_Current_User';
	const TAB                     = 'Ai1ec_Facebook_Tab';
	const GRAPH_OBJECT_COLLECTION = 'Ai1ec_Facebook_Graph_Object_Collection';
	const GRAPH_OBJECT            = 'Ai1ec_Facebook_Graph_Object';
	const FACEBOOK_APP            = 'Ai1ec_Facebook_Application';
	const EVENT                   = 'Ai1ec_Facebook_Event';
	const CUSTOM_BULK_ACTION      = 'Ai1ec_Facebook_Custom_Bulk_Action';
	// The name of the plugin table
	const FB_DB_TABLE             = 'ai1ec_facebook_users';
	// The name of the evnts table
	const AI1EC_EVENTS_TABLE      = 'ai1ec_events';
	// The name of the user-events table
	const FB_USER_EVENTS_TABLE    = 'ai1ec_facebook_users_events';

	/**
	 * @var Ai1ec_Registry_Object
	 */
	static protected $_registry;

	/**
	 * @param Ai1ec_Registry_Object $registry
	 */
	static public function set_registry( Ai1ec_Registry_Object $registry ) {
		self::$_registry = $registry;
	}

	/**
	 * @return Ai1ec_Registry_Object
	 */
	static public function get_registry() {
		return self::$_registry;
	}

	/**
	 *
	 * @param Ai1ec_Facebook_Proxy $facebook
	 * @return Ai1ec_Facebook_Current_User
	 */
	static public function get_facebook_user_instance( Ai1ec_Facebook_Proxy $facebook ) {
		$class = self::CURRENT_USER;
		return new $class( $facebook );
	}
	/**
	 * @return Ai1ec_Facebook_Tab
	 */
	static public function get_facebook_tab_instance() {
		$class = self::TAB;
		return new $class( self::$_registry );
	}
	/**
	 *
	 * @param array $ids the ids of the facebook graph object that will form the collection
	 * @return Ai1ec_Facebook_Graph_Object_Collection
	 */
	static public function get_facebook_graph_object_collection( array $ids ) {
		$class = self::GRAPH_OBJECT_COLLECTION;
		return new $class( self::$_registry, $ids );
	}
	/**
	 * @param array $pages
	 * @return Ai1ec_Generic_Html_Tag
	 */
	static public function create_export_to_pages_html( array $pages, $current_user ) {
		$container = Ai1ec_Helper_Factory::create_generic_html_tag( 'div' );
		$container->add_class( 'ai1ec-page-choices' );
		$container->set_text(
			__(
				'Create event for:',
				AI1EC_PLUGIN_NAME )
		);
		$radio = Ai1ec_Helper_Factory::create_bootstrap_radio_instance(
			$current_user->get_name(),
			Ai1ecFacebookConnectorPlugin::EXPORT_PAGE_RADIO_NAME,
			$current_user->get_id(),
			array( 'checked' => 'checked' )
		);
		$container->add_renderable_children( $radio );
		foreach ( $pages as $page ) {
			$radio = Ai1ec_Helper_Factory::create_bootstrap_radio_instance(
				$page['name'],
				Ai1ecFacebookConnectorPlugin::EXPORT_PAGE_RADIO_NAME,
				$page['id']
			);
			$container->add_renderable_children( $radio );
		}
		return $container;
	}

	/**
	 *
	 * @return Ai1ec_Generic_Html_Tag
	 */
	static public function create_refresh_token_button() {
		$timely = Ai1ec_Helper_Factory::create_generic_html_tag( 'div' );
		$timely->add_class( 'ai1ec-refresh-fb-pages' );
		$refresh_tokens = Ai1ec_Helper_Factory::create_generic_html_tag( 'button' );
		$refresh_tokens->set_attribute( 'type', 'button' );
		$refresh_tokens->set_id( 'ai1ec-refresh-fb-pages' );
		$refresh_tokens->add_class(
			'ai1ec-btn ai1ec-btn-default ai1ec-btn-xs ai1ec-text-success'
		);
		$refresh_tokens->set_text(
			'<i class="ai1ec-fa ai1ec-fa-refresh ai1ec-fa-fw"></i> ' .
			__( "Refresh list of pages", AI1EC_PLUGIN_NAME )
		);
		$refresh_tokens->set_attribute(
			'data-loading-text',
			'<i class="ai1ec-fa ai1ec-fa-refresh ai1ec-fa-fw ai1ec-fa-spin"></i> ' .
			__( 'Refreshing…', AI1EC_PLUGIN_NAME )
		);
		$timely->add_renderable_children( $refresh_tokens );
		return $timely;
	}
	/**
	 *
	 * @param int $id the id of the Facebook Graph Object
	 *
	 * @return Ai1ec_Facebook_Graph_Object
	 */
	static public function get_facebook_graph_object( $id ) {
		$class = self::GRAPH_OBJECT;
		return new $class( $id );
	}
	/**
	 * Returns the plugin table with Wordpress prefix
	 *
	 * @return string the plugin table
	 */
	static public function get_plugin_table() {
		global $wpdb;
		return $wpdb->prefix . self::FB_DB_TABLE;
	}
	/**
	* Returns the events table with Wordpress prefix
	*
	* @return string the plugin table
	*/
	static public function get_events_table() {
		global $wpdb;
		return $wpdb->prefix . self::AI1EC_EVENTS_TABLE;
	}
	/**
	 * Generate the correct strategy object for getting events.
	 *
	 * @param string $type the type of Facebook Graph Object we are creating the strategy for
	 *
	 * @return Query_Events_Strategy_Interface
	 */
	static public function generate_strategy_for_querying_events( $type ) {
		// Facebook pages and users implement the same strategy.
		if( $type === Ai1ec_Facebook_Graph_Object_Collection::FB_PAGE ) {
			$type = Ai1ec_Facebook_Graph_Object_Collection::FB_USER;
		}
		$type = ucfirst( $type );
		$class = "Ai1ec_Facebook_{$type}_Query_Events_Strategy";
		return new $class();
	}
	/**
	 * * Generate the correct strategy object for syncing objects.
	 *
	 * @param string $type the type of Facebook Graph Object we are creating the strategy for
	 *
	 * @return Sync_Objects_From_Facebook_Strategy_Interface an object that implement the interface
	 */
	static public function generate_sync_object_strategy( $type ) {
		$type = ucfirst( $type );
		$class = "Ai1ec_Facebook_{$type}_Sync_Object_From_Facebook_Strategy";
		return new $class();
	}
	/**
	 * Returns the user_events table with the wordpress prefix
	 *
	 * @return string
	 */
	static public function get_user_events_table() {
		global $wpdb;
		return $wpdb->prefix . self::FB_USER_EVENTS_TABLE;
	}
	/**
	 * Return a Facebook object.
	 *
	 * @return Ai1ec_Facebook_Event
	 */
	static public function get_facebook_event_instance() {
		$class = self::EVENT;
		return new $class( self::$_registry );
	}
	/**
	 * Return a Facebook application instance
	 *
	 * @param string $app_id
	 *
	 * @param string $secret
	 *
	 * @return Ai1ec_Facebook_Application
	 */
	static public function get_facebook_application_instance( $app_id, $secret ) {
		$class = self::FACEBOOK_APP;
		return new $class( $app_id, $secret );
	}
	/**
	 * Return a Facebook custom bulk action instance
	 *
	 * @return Ai1ec_Facebook_Custom_Bulk_Action
	 */
	static public function get_facebook_custom_bulk_action_instance( Ai1ecFacebookConnectorPlugin $facebook_plugin ) {
		$class = self::CUSTOM_BULK_ACTION;
		return new $class( $facebook_plugin );
	}
}
