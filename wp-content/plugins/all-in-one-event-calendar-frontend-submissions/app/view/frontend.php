<?php

/**
 * View representing an interactive frontend.
 *
 * @author       Time.ly Network, Inc.
 * @since        2.0
 * @package      Ai1ECIF
 * @subpackage   Ai1ECIF.View
 */
class Ai1ecfs_Frontend extends Ai1ec_Base {

	/**
	 * Handle AJAX request to display front-end create event form content.
	 *
	 * @return null
	 */
	public function get_front_end_create_event_form() {
		$settings = $this->_registry->get( 'model.settings' );
		$system   = $this->_registry->get( 'date.system' );
		$loader   = $this->_registry->get( 'theme.loader' );

		$date_format_pattern = $system->get_date_pattern_by_key(
			$settings->get( 'input_date_format' )
		);
		$week_start_day      = get_option( 'start_of_week' );
		$input_24h_time      = $settings->get( 'input_24h_time' );
		$cat_select          = $this->get_html_for_category_selector();
		$tag_select          = $this->get_html_for_tag_selector();
		$form_action         = admin_url(
			'admin-ajax.php?action=ai1ec_front_end_submit_event'
		);
		$default_image       = null;

		if (
			! is_user_logged_in() &&
			$settings->get( 'allow_anonymous_submissions' ) &&
			$settings->get( 'recaptcha_key' ) !== ''
		) {
			$recaptcha_key = $settings->get( 'recaptcha_public_key' );
		} else {
			$recaptcha_key = false;
		}

		$allow_uploads = is_user_logged_in() ||
			$settings->get( 'allow_anonymous_submissions' ) &&
			$settings->get( 'allow_anonymous_uploads' );

		$nonce_field = wp_nonce_field(
			'ai1ec_front_end_form',
			AI1EC_POST_TYPE,
			true,
			false
		);

		$required_fields = array();
		$required_fields['is_venue_required'] = $settings->get( 'is_venue_required' );
		$required_fields['is_address_required'] = $settings->get( 'is_address_required' );
		$required_fields['is_description_required'] = $settings->get( 'is_description_required' );
		$required_fields['is_organizer_name_required'] = $settings->get( 'is_organizer_name_required' );
		$required_fields['is_organizer_email_required'] = $settings->get( '' );
		$required_fields['is_phonenumber_required'] = $settings->get( 'is_phonenumber_required' );
		$required_fields['is_contact_required'] = $settings->get( 'is_contact_required' );

		$hide_additional_fields = true;
		if(
			true === $required_fields['is_phonenumber_required'] ||
			true === $required_fields['is_contact_required']
		) {
			$hide_additional_fields = false;
		}

		$args = array(
			'date_format_pattern'    => $date_format_pattern,
			'week_start_day'         => $week_start_day,
			'input_24h_time'         => $input_24h_time,
			'cat_select'             => $cat_select,
			'tag_select'             => $tag_select,
			'form_action'            => $form_action,
			'interactive_gmaps'      => ! $settings->get( 'disable_autocompletion' ),
			'default_image'          => $default_image,
			'recaptcha_key'          => $recaptcha_key,
			'allow_uploads'          => $allow_uploads,
			'timezone_expr'          => $system->get_gmt_offset_expr(),
			'require_disclaimer'     => $settings->get( 'require_disclaimer' ),
			'disclaimer'             => $settings->get( 'disclaimer' ),
			'nonce_field'            => $nonce_field,
			'required_fields'        => $required_fields,
			'hide_additional_fields' => $hide_additional_fields
		);

		$loader->get_file( 'create-event-form.twig', $args, false )
			   ->render();
		exit;
	}

	/**
	 * Handle AJAX request for submission of front-end create event form.
	 *
	 * @return null
	 */
	public function submit_front_end_create_event_form() {
		$settings          = $this->_registry->get( 'model.settings' );
		$message           = null;
		$error             = false;
		$html              = '';
		$default_error_msg =
			__(
				'There was an error creating your event. Please try again or contact the site administrator for help.',
				AI1ECFS_PLUGIN_NAME
			);

		$valid = $this->validate_front_end_create_event_form( $message );

		// If valid submission, proceed with event creation.
		if ( $valid ) {
			// Determine post publish status.
			if ( current_user_can( 'publish_ai1ec_events' ) ) {
				$post_status = 'publish';
			} else if ( current_user_can( 'edit_ai1ec_events' ) ) {
				$post_status = 'pending';
			} else if ( $settings->get( 'allow_anonymous_submissions' ) ) {
				$post_status = 'pending';
			}

			// Strip slashes if ridiculous PHP setting magic_quotes_gpc is enabled.
			foreach ( $_POST as $param_name => $param ) {
				if (
					'ai1ec' === substr( $param_name, 0, 5 ) &&
					is_scalar( $param )
				) {
					$_POST[$param_name] = stripslashes( $param );
				}
			}

			// Build post array from submitted data.
			$post = array(
				'post_type'    => AI1EC_POST_TYPE,
				'post_author'  => get_current_user_id(),
				'post_title'   => $_POST['post_title'],
				'post_content' => $_POST['post_content'],
				'post_status'  => $post_status,
			);


			// Copy posted event data to new empty event array.
			$event                  = array();
			$event['post']          = $post;
			$event['categories']    = isset( $_POST['ai1ec_categories'] )    ? $_POST['ai1ec_categories']                 : array();
			$event['tags']          = isset( $_POST['ai1ec_tags'] )          ? explode( ',', $_POST['ai1ec_tags'] )       : array();
			$event['allday']        = isset( $_POST['ai1ec_all_day_event'] ) ? (bool) $_POST['ai1ec_all_day_event']       : 0;
			$event['instant_event'] = isset( $_POST['ai1ec_instant_event'] ) ? (bool) $_POST['ai1ec_instant_event']       : 0;
			$event['start']         = isset( $_POST['ai1ec_start_time'] )    ? $_POST['ai1ec_start_time']                 : '';
			$event['address']       = isset( $_POST['ai1ec_address'] )       ? $_POST['ai1ec_address']                    : '';
			$event['show_map']      = isset( $_POST['ai1ec_google_map'] )    ? (bool) $_POST['ai1ec_google_map']          : 0;

			// Set end date
			if( $event['instant_event'] ) {
				$event['end'] = $event['start'] + 1800;
			} else {
				$event['end'] = isset( $_POST['ai1ec_end_time'] ) ? $_POST['ai1ec_end_time'] : '';
			}

			$scalar_field_list = array(
				'ai1ec_venue'         => FILTER_SANITIZE_STRING,
				'ai1ec_cost'          => FILTER_SANITIZE_STRING,
				'ai1ec_is_free'       => FILTER_SANITIZE_NUMBER_INT,
				'ai1ec_ticket_url'    => FILTER_VALIDATE_URL,
				'ai1ec_contact_name'  => FILTER_SANITIZE_STRING,
				'ai1ec_contact_phone' => FILTER_SANITIZE_STRING,
				'ai1ec_contact_email' => FILTER_VALIDATE_EMAIL,
				'ai1ec_contact_url'   => FILTER_VALIDATE_URL,
			);
			foreach ( $scalar_field_list as $scalar_field => $field_filter ) {
				$scalar_value = filter_input(
					INPUT_POST,
					$scalar_field,
					$field_filter
				);
				if ( ! empty( $scalar_value ) ) {
					$use_name         = substr( $scalar_field, 6 );
					$event[$use_name] = $scalar_value;
				}
			}

			// Save the event to the database.
			try {
				$entity = $this->_registry->get( 'model.event', $event );
				$entity->save();

				// Check if uploads are enabled and there is an uploaded file.
				if ( ( is_user_logged_in() ||
				       $settings->get( 'allow_anonymous_submissions' ) &&
				       $settings->get( 'allow_anonymous_uploads' ) ) &&
				     ! empty( $_FILES['ai1ec_image']['name'] ) ) {
					require_once( ABSPATH . 'wp-admin/includes/image.php' );
					require_once( ABSPATH . 'wp-admin/includes/file.php' );
					require_once( ABSPATH . 'wp-admin/includes/media.php' );
					$attach_id = media_handle_upload( 'ai1ec_image', $entity->get( 'post_id' ) );
					if ( is_int( $attach_id ) ) {
						update_post_meta( $entity->get( 'post_id' ), '_thumbnail_id', $attach_id );
					}
				}

				// @TODO: Send the mail notifications

				if ( current_user_can( 'publish_ai1ec_events' ) ) {
					$message   = sprintf(
						__( 'Thank you for your submission. Your event <em>%s</em> was published successfully.', AI1ECFS_PLUGIN_NAME ),
						$post['post_title']
					);
					$link_text = __( 'View Your Event', AI1ECFS_PLUGIN_NAME );
					$link_url  = get_permalink( $entity->get( 'post_id' ) );
				} else {
					$message   = sprintf(
						__( 'Thank you for your submission. Your event <em>%s</em> will be reviewed and published once approved.', AI1ECFS_PLUGIN_NAME ),
						$post['post_title']
					);
					$link_text = __( 'Back to Calendar', AI1ECFS_PLUGIN_NAME );
					$link_url  = get_permalink( $settings->get( 'calendar_page_id' ) );
				}
			}
			catch ( Exception $e ) {
				trigger_error(
					sprintf(
						__( 'There was an error during event creation: %s', AI1ECFS_PLUGIN_NAME ),
						$e->getMessage()
					),
					E_USER_WARNING
				);
				$error = true;
				$message = $default_error_msg;
			}

			$args = array(
				'message_type'      => $error ? 'danger' : 'success',
				'message'           => $message,
				'link_text'         => $link_text,
				'link_url'          => $link_url,
				'post_event_title'  => __( 'Post Your Event', AI1ECFS_PLUGIN_NAME ),
				'post_author_title' => __( 'Post Another', AI1ECFS_PLUGIN_NAME ),
			);

			$html = $this->_registry->get( 'theme.loader' )->get_file(
				'create-event-message.twig',
				$args,
				false
			)->get_content();
		}
		// Form submission was invalid.
		else {
			$error = true;
		}

		$response = array(
			'error'   => $error,
			'message' => $message,
			'html'    => $html,
		);
		$xml = $this->_registry->get( 'http.response.render.strategy.xml' );

		$xml->render( array( 'data' => $response ) );
	}

	/**
	 * Checks if the current front-end create event form submission is valid.
	 *
	 * @param  string  $message  Error message returned if form is invalid.
	 * @return boolean True if valid, false otherwise
	 */
	protected function validate_front_end_create_event_form( &$message ) {
		$settings = $this->_registry->get( 'model.settings' );

		// Check nonce.
		if ( isset( $_POST[AI1EC_POST_TYPE] ) &&
		     ! wp_verify_nonce( $_POST[AI1EC_POST_TYPE], 'ai1ec_front_end_form' ) ) {
			$message = __( 'Access denied.', AI1ECFS_PLUGIN_NAME );
			return false;
		}

		$recaptcha_public_key        = $settings->get( 'recaptcha_public_key');
		$allow_anonymous_submissions = $settings->get( 'allow_anonymous_submissions' );

		// Check CAPTCHA.
		if ( ! is_user_logged_in() &&
			 ! empty( $recaptcha_public_key ) &&
			   $allow_anonymous_submissions ) {

			$captcha = $this->_registry->get( 'captcha.validator' );
			$response = $captcha->validate();
			if( false === $response['success'] ) {
				$message = $response['message'];
				return false;
			}
		}

		// Check permission based on settings.
		if ( ! current_user_can( 'edit_ai1ec_events' ) &&
		     ! $allow_anonymous_submissions ) {
			$message = __(
				'You do not have permission to create events.',
				AI1ECFS_PLUGIN_NAME
			);
			return false;
		}

		// Ensure uploaded file is an image.
		if ( ! empty( $_FILES['ai1ec_image']['name'] ) ) {
			$is_image = 1 === preg_match(
				'/\.(jpg|jpe|jpeg|gif|png)$/i',
				$_FILES['ai1ec_image']['name']
			);
			if ( ! $is_image ) {
				$message = __(
					'Please upload a valid image file.',
					AI1ECFS_PLUGIN_NAME
				);
				return false;
			}
		}

		return true;
	}

	/**
	 * Generates the HTML for a category selector.
	 *
	 * @param  array  $selected_cat_ids Preselected category IDs
	 * @return string                   Markup for categories selector
	 */
	public function get_html_for_category_selector( $selected_cat_ids = array() ) {
		// Get categories. Add category color info to available categories.
		$categories = get_terms(
			'events_categories',
			array(
				'orderby' => 'name',
				'hide_empty' => 0,
			)
		);
		if ( empty( $categories ) ) {
			return '';
		}
		foreach ( $categories as &$cat ) {
			$cat->color = $this->_registry->get( 'model.taxonomy' )
					->get_category_color( $cat->term_id );
		}

		$args = array(
			'categories'       => $categories,
			'selected_cat_ids' => $selected_cat_ids,
			'id'               => 'ai1ec_categories',
			'name'             => 'ai1ec_categories[]',
		);
		$html = $this->_registry->get( 'theme.loader' )->get_file(
			'categories-select.twig',
			$args,
			false
		)->get_content();
		return $html;
	}

	/**
	 * Generates the HTML for a tag selector.
	 *
	 * @param  array  $selected_tag_ids Preselected tag IDs
	 * @return string                   Markup for tag selector
	 */
	public function get_html_for_tag_selector( $selected_tag_ids = array() ) {
		// Get tags.
		$tags = get_terms(
			'events_tags',
			array(
				'orderby' => 'name',
				'hide_empty' => 0,
			)
		);
		if ( empty( $tags ) ) {
			return '';
		}

		// Build tags array to pass as JSON.
		$tags_json = array();
		foreach ( $tags as $term ) {
			$tag_obj       = new stdClass();
			$tag_obj->id   = $term->name;
			$tag_obj->text = $term->name;
			$tags_json[]   = $tag_obj;
		}
		$tags_json = json_encode( $tags_json );
		$tags_json = _wp_specialchars( $tags_json, 'single', 'UTF-8' );

		$args = array(
			'tags_json'        => $tags_json,
			'selected_tag_ids' => implode( ', ', $selected_tag_ids ),
			'id'               => 'ai1ec_tags',
			'name'             => 'ai1ec_tags',
		);
		$html = $this->_registry->get( 'theme.loader' )->get_file(
			'tags-select.twig',
			$args,
			false
		)->get_content();
		return $html;
	}

	/**
	 * Returns HTML for front-end contribution buttons, including modal skeleton
	 * for front-end forms if requested.
	 *
	 * @return string  HTML markup
	 */
	public function get_html_for_contribution_buttons() {
		$settings = $this->_registry->get( 'model.settings' );

		$modals   = $create_event_url = '';

		// ===================
		// = Post Your Event =
		// ===================
		$show_post_your_event =
			$settings->get( 'show_create_event_button' ) &&
			(
				current_user_can( 'edit_ai1ec_events' ) ||
				$settings->get( 'allow_anonymous_submissions' )
			);
		$show_front_end_create_form = $settings->get(
			'show_front_end_create_form'
		);

		if ( $show_post_your_event ) {
			// Show front-end creation button & modal skeleton.
			if ( $show_front_end_create_form ) {
				$modals .= $this->_registry->get( 'theme.loader' )->get_file(
					'create-event-modal.twig'
				)->get_content();
			} else { // Show button link to traditional back-end form.
				$create_event_url = esc_attr(
					admin_url( 'post-new.php?post_type=' . AI1EC_POST_TYPE )
				);
			}
		}

		// ==========================
		// = Add Your Calendar Feed =
		// ==========================
		$show_add_your_calendar = $settings->get( 'show_add_calendar_button' );

		if ( $show_add_your_calendar ) {
			if (
				! is_user_logged_in() &&
				'' !== $settings->get( 'recaptcha_key' )
			) {
				$recaptcha_key = $settings->get( 'recaptcha_public_key' );
			} else {
				$recaptcha_key = false;
			}

			$nonce_field = wp_nonce_field(
				'ai1ec_submit_ics_form',
				AI1EC_POST_TYPE,
				true,
				false
			);

			$modal_args = array(
				'categories'    => $this->get_html_for_category_selector(),
				'recaptcha_key' => $recaptcha_key,
				'nonce_field'   => $nonce_field,
			);

			$modals .= $this->_registry->get( 'theme.loader' )->get_file(
				'submit-ics-modal.twig',
				$modal_args,
				false
			)->get_content();
		}

		$args = array(
			'show_post_your_event'       => $show_post_your_event,
			'show_add_your_calendar'     => $show_add_your_calendar,
			'show_front_end_create_form' => $show_front_end_create_form,
			'modals'                     => $modals,
			'create_event_url'           => $create_event_url,
		);
		$html = $this->_registry->get( 'theme.loader' )->get_file(
			'contribution-buttons.twig',
			$args,
			false
		)->get_content();

		return $html;
	}

}
