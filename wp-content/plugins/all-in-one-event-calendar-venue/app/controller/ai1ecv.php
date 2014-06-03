<?php

/**
 * Venue extension controller
 *
 * @author     Time.ly Network Inc.
 * @since      2.0
 *
 * @package    AI1ECVENUE
 * @subpackage AI1ECVENUE.Controller
 */
class Ai1ec_Controller_Ai1ecv extends Ai1ec_Base_License_Controller {


	/* (non-PHPdoc)
	 * @see Ai1ec_Base_Extension_Controller::get_name()
	 */
	public function get_name() {
		return 'Venues';
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Base_Extension_Controller::get_machine_name()
	 */
	public function get_machine_name() {
		return 'venues';
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Base_Extension_Controller::get_version()
	 */
	public function get_version() {
		return AI1ECV_VERSION;
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Licence_Controller::get_file()
	 */
	public function get_file() {
		return AI1ECV_FILE;
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Base_License_Controller::get_license_label()
	 */
	public function get_license_label() {
		return 'Venues License Key';
	}

	/**
	 * Register the new taxonomy type: venues
	 */
	public function register_taxonomy(){
		// ========================================
		// = labels for event venues taxonomy     =
		// ========================================
		$events_venues_labels = array(
			'name'          => _x( 'Event Venues',
				'Event venues taxonomy', AI1ECV_PLUGIN_NAME ),
			'singular_name' => _x( 'Event Venue',
				'Event venues taxonomy (singular)', AI1ECV_PLUGIN_NAME )
		);

		// ======================================
		// = args for event venues taxonomy     =
		// ======================================
		$events_venues_args = array(
			'labels'       => $events_venues_labels,
			'hierarchical' => true,
			'rewrite'      => array( 'slug' => AI1ECV_TAXONOMY_NAME ),
			'capabilities' => array(
				'manage_terms' => 'manage_categories',
				'edit_terms'   => 'manage_categories',
				'delete_terms' => 'manage_categories',
				'assign_terms' => 'edit_ai1ec_events'
			)
		);

		// ======================================
		// = register event venues taxonomy     =
		// ======================================
		register_taxonomy(
			AI1ECV_TAXONOMY_NAME,
			array( AI1EC_POST_TYPE ),
			$events_venues_args
		);

	}

	/**
	 * Filter venue information to include Venue meta.
	 *
	 * @param string      $html  Original HTML.
	 * @param Ai1ec_Event $event Render target.
	 *
	 * @return string Optionally modified HTML.
	 */
	public function show_venues( $html, $event ) {
		$post_id = $event->get( 'post_id' );
		$terms   = wp_get_post_terms( $post_id, AI1ECV_TAXONOMY_NAME );
		$venues  = array();

		foreach ( $terms as $term ) {
			$taxonomy        = $this->_registry->get( 'model.venue', $term );
			$venue           = $taxonomy->to_array();
			$venue[ 'name' ] = $term->name;
			$venue[ 'id' ]   = $term->term_id;
			$venues[]        = $venue;
		}

		if ( empty( $venues ) ) {
			return $html;
		}
		$args   = compact( 'venues' );
		$loader = $this->_registry->get( 'theme.loader' );
		return $loader->get_file(
			'ai1ecv-event-single.twig',
			$args
		)->get_content();
	}

	/**
	 * Show drop-down menu with all venues
	 *
	 * @return string
	 */
	public function show_select_venue() {
		$terms   = get_terms(
				AI1ECV_TAXONOMY_NAME,
				array(
					'orderby'    => 'name',
					'hide_empty' => 0,
				) );

		$venues  = array();

		foreach ( $terms as $term ) {
			$taxonomy        = $this->_registry->get( 'model.venue', $term );
			$venue           = $taxonomy->to_array();
			$venue[ 'name' ] = $term->name;
			$venues[]        = $venue;
		}

		$select_options   = array();
		$select_options[] = array(
			'text'  => __( 'Choose', AI1ECV_PLUGIN_NAME ),
			'value' => null,
		);
		foreach ( $venues as $venue ) {
			$select_options[] = array(
				'text'  => $venue['name'],
				'value' => $venue['name'],
				'args'  => array(
					'data-address' => esc_attr( $venue['address'] ),
					'data-latitude' => esc_attr( $venue['latitude'] ),
					'data-longitude' => esc_attr( $venue['longitude'] )
				),
			);
		}

		// Assign parameters
		$args = array(
			'select_venue_title' => __( 'Select Venue:', AI1ECV_PLUGIN_NAME ),
			'select' => array(
				'id'      => 'ai1ec_select_venue',
				'args'    => array(
					'class' => 'ai1ec-form-control'
				),
				'options' => $select_options,
			)
		);

		$loader = $this->_registry->get( 'theme.loader' );
		$result = $loader->get_file(
			'ai1ecv-select-venue.twig',
			$args,
			true
		)->get_content();

		return $result;
	}

	/**
	 * Show checkbox for save venue
	 *
	 * @return string
	 */
	public function show_save_venue() {
		$args = array(
			'save_venue_title' => __( 'Save Current Venue', AI1ECV_PLUGIN_NAME ),
			'checkbox' => array(
				'id' => 'ai1ec_save_venue',
				'args' => array(
					'class' => 'ai1ec-form-control'
				),
			)
		);

		$loader = $this->_registry->get( 'theme.loader' );
		$result = $loader->get_file(
			'ai1ecv-save-venue.twig',
			$args,
			true
		)->get_content();

		return $result;
	}

	/**
	 * Save venue.
	 *
	 * @param Ai1ec_Event $event
	 * @return void
	 */
	public function save_venue( Ai1ec_Event $event = null ) {

		if (
			isset( $_POST['ai1ec_save_venue'] ) &&
			'1' == $_POST['ai1ec_save_venue']
		) {
			$venue   = $_POST['ai1ec_venue'];
			$address = $_POST['ai1ec_address'] = addslashes( $_POST['ai1ec_address'] );
			if ( ! empty( $venue ) && ! empty( $address ) ) {
				$existing = term_exists( $venue, AI1ECV_TAXONOMY_NAME );
				if ( empty( $existing ) ) {
					$existing = wp_insert_term( $venue, AI1ECV_TAXONOMY_NAME );

				}

				$this->_registry->get( 'view.admin.event-venue' )
					->created_events_venues( $existing['term_id'] );
			}
		}

		if ( null !== $event ) {
			$terms = array();
			if ( isset( $_POST['ai1ec_venue'] ) ) {
				$existing = term_exists(
					$_POST['ai1ec_venue'],
					AI1ECV_TAXONOMY_NAME
				);
				if ( isset( $existing['term_id'] ) && $existing['term_id'] > 0 ) {
					$terms = array( (int)$existing['term_id'] );
				}
				unset( $existing );
			}
			wp_set_post_terms(
				$event->get( 'post_id' ),
				$terms,
				AI1ECV_TAXONOMY_NAME
			);
			unset( $terms );
		}
	}

	/**
	 * Hide metabox Venue
	 */
	public function hide_metabox_venue() {
		remove_meta_box( 'events_venuesdiv', AI1EC_POST_TYPE, 'side' );
	}

	/**
	 * Show Venue details information to be showed into a modal
	 */
	public function show_venue_details() {
		$venue_id = $_POST['venue_id'];
		$address  = $_POST['map_address'];
		$venue    = $this->_registry->get( 'model.venue', $venue_id );
		$args     = $venue->to_array() + array(
			'name'        => $venue->get( 'name' ),
			'map_address' => $address,
		);
		$this->_registry->get( 'theme.loader' )->get_file(
			'ai1ecv-venue-details.twig',
			$args,
			false
		)->render();
		return Ai1ec_Http_Response_Helper::stop();
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Base_Extension_Controller::_set_settings()
	*/
	protected function _get_settings() {
		return array();
	}

	/**
	 * Register actions handlers
	 *
	 * @return void
	 */
	protected function _register_actions( Ai1ec_Event_Dispatcher $dispatcher ) {
		// Register handlers
		$dispatcher = $this->_registry->get( 'event.dispatcher' );

		$dispatcher->register_action(
			'init',
			array( 'controller.ai1ecv', 'register_taxonomy' )
		);
		$dispatcher->register_action(
			'admin_menu',
			array( 'controller.ai1ecv', 'hide_metabox_venue' )
		);
		$dispatcher->register_filter(
			'ai1ec_render_js',
			array( 'javascript.venues', 'add_js' ),
			10,
			2
		);
		$dispatcher->register_filter(
			'ai1ec_less_files',
			array( 'less.venues', 'add_less_files' )
		);
		$dispatcher->register_filter(
			'ai1ec_admin_pre_venue_html',
			array( 'controller.ai1ecv', 'show_select_venue' ),
			10,
			2
		);
		$dispatcher->register_filter(
			'ai1ec_admin_post_venue_html',
			array( 'controller.ai1ecv', 'show_save_venue' ),
			10,
			2
		);
		$dispatcher->register_action(
			'ai1ec_save_post',
			array( 'controller.ai1ecv', 'save_venue' )
		);
		$dispatcher->register_action(
			'created_events_venues',
			array( 'view.admin.event-venue', 'created_events_venues' )
		);
		$dispatcher->register_action(
			'events_venues_add_form_fields',
			array( 'view.admin.event-venue', 'events_venues_add_form_fields' )
		);
		$dispatcher->register_action(
			'events_venues_edit_form_fields',
			array( 'view.admin.event-venue', 'events_venues_edit_form_fields' )
		);
		$dispatcher->register_action(
			'shutdown',
			array( 'view.admin.event-venue', 'shutdown' )
		);
		$dispatcher->register_action(
			'manage_edit-events_venues_columns',
			array( 'view.admin.event-venue', 'manage_events_venues_columns' ),
			PHP_INT_MAX - 1
		);
		$dispatcher->register_action(
			'wp_ajax_aiecv_show_venue_details',
			array( 'controller.ai1ecv', 'show_venue_details' )
		);
		$dispatcher->register_action(
			'wp_ajax_nopriv_aiecv_show_venue_details',
			array( 'controller.ai1ecv', 'show_venue_details' )
		);
		$dispatcher->register_filter(
			'ai1ec_rendering_single_event_venues',
			array( 'controller.ai1ecv', 'show_venues' ),
			10,
			2
		);

	}

}