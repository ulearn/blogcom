<?php

/**
 * Event venue admin view snippets renderer.
 *
 * @author     Time.ly Network Inc.
 * @since      2.0
 *
 * @package    AI1ECVENUE
 * @subpackage AI1ECVENUE.View.Admin
 */
class Ai1ecv_View_Admin_EventVenue extends Ai1ec_Base {

	/**
	 * We use this call to initialize assets specific for venues
	 *
	 * @param array $columns Array with event_category columns
	 *
	 * @return array Array params array untouched
	 */
	public function manage_events_venues_columns( $columns ) {
		wp_enqueue_media();
		unset( $columns['description'] );
		return $columns;
	}

	public function created_events_venues( $term_id ){
		$this->_store_meta( $term_id );
	}

	/**
	 * A callback method, triggered when the rendering is complete
	 *
	 * @return void Method does not return.
	 */
	public function shutdown() {
		if (
			! isset( $_POST['action'] )
			|| strcasecmp( 'editedtag', $_POST['action'] ) != 0
			|| ! isset( $_POST['taxonomy'] )
			|| strcasecmp( AI1ECV_TAXONOMY_NAME, $_POST['taxonomy'] ) != 0
			|| ! isset( $_POST['tag_ID'] )
		) {
			return;
		}
		$this->_store_meta( $_POST['tag_ID'] );
	}

	/**
	 * Store metadata information about the venue
	 *
	 * @param $term_id
	 */
	protected function _store_meta( $term_id ) {
		$venue = $this->_registry->get( 'model.venue', $term_id );

		// Set parameters
		$address = null;
		if ( isset( $_POST['ai1ec_address'] ) ) {
			$address = $_POST['ai1ec_address'];
		}

		// Set venue data
		$venue->set_address( $address );
		if ( isset( $_POST['ai1ecv_venue-description'] ) ) {
			$venue->set_description( $_POST['ai1ecv_venue-description'] );
		}
		if ( isset( $_POST['ai1ecv_venue-contact-name'] ) ) {
			$venue->set_contact_name( $_POST['ai1ecv_venue-contact-name'] );
		}
		if ( isset( $_POST['ai1ecv_venue-phone'] ) ) {
			$venue->set_phone( $_POST['ai1ecv_venue-phone'] );
		}
		if ( isset( $_POST['ai1ecv_venue-email'] ) ) {
			$venue->set_email( $_POST['ai1ecv_venue-email'] );
		}
		if ( isset( $_POST['ai1ecv_venue-url'] ) ) {
			$venue->set_url( $_POST['ai1ecv_venue-url'] );
		}
		if ( isset( $_POST['ai1ecv_venue-capacity'] ) ) {
			$venue->set_capacity( $_POST['ai1ecv_venue-capacity'] );
		}
		if ( isset( $_POST['ai1ecv_venue-handicap'] ) ) {
			$venue->set_handicap( true );
		}
		if ( isset( $_POST['ai1ecv_venue-parking'] ) ) {
			$venue->set_parking( $_POST['ai1ecv_venue-parking'] );
		}
		if ( ! empty( $_POST['ai1ec_venue-image-url'] ) ) {
			$venue->set_image( $_POST['ai1ec_venue-image-url'] );
		} else if ( isset( $_POST['ai1ec_venue-image-url-remove'] ) ) {
			$venue->set_image( null );
		}
		if ( isset( $_POST['ai1ec_longitude'] ) ) {
			$venue->set_longitude( $_POST['ai1ec_longitude'] );
		}
		if ( isset( $_POST['ai1ec_latitude'] ) ) {
			$venue->set_latitude( $_POST['ai1ec_latitude'] );
		}
		if ( isset( $_POST['ai1ec_google_map'] ) ) {
			$venue->set( 'google_map', true );
		}
		if ( isset( $_POST['ai1ec_city'] ) ) {
			$venue->set( 'city', $_POST['ai1ec_city'] );
		}
		if ( isset( $_POST['ai1ec_province'] ) ) {
			$venue->set( 'province', $_POST['ai1ec_province'] );
		}
		if ( isset( $_POST['ai1ec_postal_code'] ) ) {
			$venue->set( 'postal_code', $_POST['ai1ec_postal_code'] );
		}
		if ( isset( $_POST['ai1ec_province'] ) ) {
			$venue->set( 'country', $_POST['ai1ec_country'] );
		}
		wp_update_term(
			$term_id,
			AI1ECV_TAXONOMY_NAME,
			array(
				'description' => $venue->encode_description(),
			)
		);
	}

	/**
	 * Edit category form
	 *
	 * @param $term
	 *
	 * @return void
	 */
	public function events_venues_edit_form_fields( $term ) {

		$taxonomy = $this->_registry->get( 'model.venue', $term );
		$loader   = $this->_registry->get( 'theme.loader' );
		// =================================================
		// = Display event location details and Google map =
		// =================================================

		$file = $loader->get_file(
			'venues.twig',
			$taxonomy->to_array() + array( 'type' => 'tr' ),
			true
		);
		$file->render();

		// Venue image
		$image = $taxonomy->get( 'image' );
		$style = 'style="display:none"';

		if ( null !== $image ) {
			$style = '';
		}

		$args = array(
			'image_src'    => $image,
			'image_style'  => $style,
			'section_name' => __( 'Venue Image', AI1ECV_PLUGIN_NAME ),
			'label'        => __( 'Add Image', AI1ECV_PLUGIN_NAME ),
			'remove_label' => __( 'Remove Image', AI1ECV_PLUGIN_NAME ),
			'description'  => __(
				'Assign an optional image to the venue. Recommended size: landscape, minimum 600&times;350 pixels.',
				AI1ECV_PLUGIN_NAME
			),
			'edit'         => true,
		);

		$loader->get_file(
			'venues-image.twig',
			$args,
			true
		)->render();
	}

	/**
	 * Add category form
	 *
	 * @return void
	 */
	public function events_venues_add_form_fields() {

		$loader = $this->_registry->get( 'theme.loader' );

		// Category color
		$args   = array(
			'address'      => '',
			'description'  => '',
			'contact_name' => '',
			'phone'        => '',
			'email'        => '',
			'url'          => '',
			'capacity'     => '',
			'handicap'     => false,
			'parking'      => '',
			'type'         => 'div'
		);

		$file   = $loader->get_file(
			'venues.twig',
			$args,
			true
		);
		


		$file->render();

		// Venue image
		$args  = array(
			'image_src'    => '',
			'image_style'  => 'style="display:none"',
			'section_name' => __( 'Venue Image', AI1ECV_PLUGIN_NAME ),
			'label'        => __( 'Add Image', AI1ECV_PLUGIN_NAME),
			'description'  => __(
				'Assign an optional image to the venue. Recommended size: square, minimum 400&times;400 pixels.',
				AI1ECV_PLUGIN_NAME ),
			'edit'         => false,
		);

		$file   = $loader->get_file(
			'venues-image.twig',
			$args,
			true
		);

		$file->render();

	}

}
