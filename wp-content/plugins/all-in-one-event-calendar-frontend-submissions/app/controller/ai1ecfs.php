<?php

/**
 * Front-End Submissions extension front controller.
 *
 * @author     Time.ly Network Inc.
 * @since      2.0
 *
 * @package    AI1ECFS
 * @subpackage AI1ECFS.Controller
 */
class Ai1ec_Controller_Ai1ecfs extends Ai1ec_Base_License_Controller {

	/* (non-PHPdoc)
	 * @see Ai1ec_Base_Extension_Controller::get_name()
	 */
	public function get_name() {
		return 'Front End Event Submission';
	}

	public function get_license_label() {
		return __( 'Front End Submissions License Key', AI1ECFS_PLUGIN_NAME );
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Base_Extension_Controller::get_machine_name()
	 */
	public function get_machine_name() {
		return 'front_end_event_submission';
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Base_Extension_Controller::get_version()
	 */
	public function get_version() {
		return AI1ECFS_VERSION;
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Licence_Controller::get_file()
	 */
	public function get_file() {
		return AI1ECFS_FILE;
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Base_License_Controller::add_tabs()
	*/
	public function add_tabs( array $tabs ) {
		$tabs = parent::add_tabs( $tabs );
		$tabs['extensions']['items']['interactive'] = Ai1ec_I18n::__( 'Front End Submissions' );
		return $tabs;
	}

	/**
	 * Send an e-mail to the admin and another to the user if form passes
	 * validation.
	 */
	public function add_ics_feed_frontend() {
		$check = $this->_validate_form();

		$check['nonce'] = wp_nonce_field(
			'ai1ec_submit_ics_form',
			AI1EC_POST_TYPE,
			true,
			false
		);

		if ( true === $check['success'] ) {
			$settings = $this->_registry->get( 'model.settings' );
			$_POST = stripslashes_deep( $_POST );
			$translations = $this->_get_translations();
			$notification_for_admin = $this->_registry->get(
				'notification.email',
				$settings->get( 'admin_mail_body' ),
				array( get_option( 'admin_email' ) ),
				$settings->get( 'admin_mail_subject' )
			);
			$notification_for_user = $this->_registry->get(
				'notification.email',
				$settings->get( 'user_mail_body' ),
				array( $_POST['ai1ec_submitter_email'] ),
				$settings->get( 'user_mail_subject' )
			);
			$notification_for_admin->set_translations( $translations );
			$notification_for_admin->send();
			$notification_for_user->set_translations( $translations );
			$notification_for_user->send();
			$_POST = add_magic_quotes( $_POST );
		}

		$json = $this->_registry->get( 'http.response.render.strategy.json' );
		$json->render( array( 'data' => $check ) );
	}

	/**
	 * Returns the translations array
	 *
	 * @return array
	 */
	protected function _get_translations() {
		$categories = isset( $_POST['ai1ec_categories'] ) ? $_POST['ai1ec_categories'] : array();
		foreach ( $categories as &$cat ) {
			$term = get_term( $cat, 'events_categories' );
			$cat = $term->name;
		}
		$translations = array(
			'[feed_url]'   => $_POST['ai1ec_calendar_url'],
			'[categories]' => implode( ', ' , $categories ),
			'[user_email]' => $_POST['ai1ec_submitter_email'],
			'[site_title]' => get_bloginfo( 'name' ),
			'[site_url]'   => site_url(),
			'[feeds_url]'  => admin_url( AI1EC_FEED_SETTINGS_BASE_URL . '#ics' ),
		);
		return $translations;
	}

	/**
	 * Validates the add new feed url form
	 *
	 * @return array
	 */
	protected function _validate_form() {
		$settings = $this->_registry->get( 'model.settings' );
		$response = array( 'success' => true );
		// Check nonce.
		if (
			! isset( $_POST[AI1EC_POST_TYPE] ) ||
			! wp_verify_nonce( $_POST[AI1EC_POST_TYPE], 'ai1ec_submit_ics_form' )
		) {
			$response['message'] = __( 'Access denied.', AI1EC_PLUGIN_NAME );
			$response['success'] = false;
			return $response;
		}

		// Check CAPTCHA.
		$key = $settings->get( 'recaptcha_public_key' );
		if ( ! is_user_logged_in() &&
			! empty( $key ) ) {
			$captcha = $this->_registry->get( 'captcha.validator' );
			$check = $captcha->validate();
			if( false === $check['success'] ) {
				$response['success'] = false;
				$response['message'] = $check['message'];
				return $response;
			}
		}
		$response['message'] = __( 'Your suggestion was submitted to a site administrator for review.', AI1EC_PLUGIN_NAME );
		return $response;
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Base_Extension_Controller::_set_settings()
	 */
	protected function _get_settings() {
		return array(
			'show_create_event_button' => array(
				'type' => 'bool',
				'version'  => AI1ECFS_VERSION,
				'renderer' => array(
					'class' => 'checkbox',
					'tab'   => 'extensions',
					'item'  => 'interactive',
					'label' => __(
						'Show <strong>Post Your Event</strong> button above the calendar to privileged users',
						AI1ECFS_PLUGIN_NAME
					)
				),
				'value'  => true,
			),
			'show_front_end_create_form' => array(
				'type' => 'bool',
				'version'  => AI1ECFS_VERSION,
				'renderer' => array(
					'class' => 'checkbox',
					'tab'   => 'extensions',
					'item'  => 'interactive',
					'label' => __(
						'Clicking <strong>Post Your Event</strong> opens the <span class="ai1ec-tooltip-toggle"
						data-original-title="If this is deselected, authorized users logged in to your site will be directed to the backend event creation page.">front end event submission form</span>',
						AI1ECFS_PLUGIN_NAME
					)
				),
				'value'  => true,
			),
			'allow_anonymous_submissions' => array(
				'type' => 'bool',
				'version'  => AI1ECFS_VERSION,
				'renderer' => array(
					'class' => 'checkbox',
					'tab'   => 'extensions',
					'item'  => 'interactive',
					'label' => __(
						'Allow <strong>anonymous users</strong>  to submit events for review',
						AI1ECFS_PLUGIN_NAME
					)
				),
				'value'  => false,
			),
			'allow_anonymous_uploads' => array(
				'type' => 'bool',
				'version'  => AI1ECFS_VERSION,
				'renderer' => array(
					'class' => 'checkbox',
					'tab'   => 'extensions',
					'item'  => 'interactive',
					'label' => __(
						'Allow anonymous users to <strong>upload images</strong> for their events',
						AI1ECFS_PLUGIN_NAME
					),
				),
				'value'  => false,
			),
			'show_add_calendar_button' => array(
				'type' => 'bool',
				'version'  => AI1ECFS_VERSION,
				'renderer' => array(
					'class' => 'checkbox',
					'tab'   => 'extensions',
					'item'  => 'interactive',
					'label' => __(
						'Enable <strong>Add Your Feed</strong>  button to allow visitors to suggest event feeds',
						AI1ECFS_PLUGIN_NAME
					),
				),
				'value'  => false,
			),
			'recaptcha_public_key' => array(
				'type'    => 'string',
				'version' => AI1ECFS_PLUGIN_NAME,
				'renderer' => array(
					'class' => 'input',
					'tab'   => 'extensions',
					'item'  => 'interactive',
					'type'  => 'normal',
					'label' => __(
						'reCAPTCHA public key:',
						AI1ECFS_PLUGIN_NAME
					),
				),
				'value' => '',
			),
			'recaptcha_private_key' => array(
				'type'    => 'string',
				'version' => AI1ECFS_PLUGIN_NAME,
				'renderer' => array(
					'class' => 'input',
					'tab'   => 'extensions',
					'item'  => 'interactive',
					'type'  => 'normal',
					'label' => __(
						'reCAPTCHA private key:',
						AI1ECFS_PLUGIN_NAME
					),
				),
				'value' => '',
			),
			'admin_mail_subject' => array(
				'type' => 'string',
				'version' => AI1ECFS_PLUGIN_NAME,
				'renderer' => array(
					'class'    => 'textarea',
					'tab'      => 'extensions',
					'item'     => 'interactive',
					'label'    => Ai1ec_I18n::__( 'Subject of the mail sent to admin when new feed is submitted:' ),
					'type'     => 'normal',
					'rows'     => 6,
				),
				'value' => '[[site_title]] New iCalendar (.ics) feed submitted for review',
			),
			'admin_mail_body' => array(
				'type' => 'string',
				'version' => AI1ECFS_PLUGIN_NAME,
				'renderer' => array(
					'class'    => 'textarea',
					'tab'      => 'extensions',
					'item'     => 'interactive',
					'label'    => Ai1ec_I18n::__( 'Body of the mail sent to admin when new feed is submitted:' ),
					'type'     => 'normal',
					'rows'     => 6,
				),
				'value' => "A visitor has submitted their calendar feed for review:\n\niCalendar feed URL: [feed_url]\nCategories: [categories]\n\nTo add this feed to your calendar, visit your Calendar Feeds admin screen and add it as an ICS feed:\n[feeds_url]\n\nPlease respond to this user by e-mail ([user_email]) to let them know whether or not their feed is approved.\n\n[site_title]\n[site_url]",
			),
			'user_mail_subject' => array(
				'type' => 'string',
				'version' => AI1ECFS_PLUGIN_NAME,
				'renderer' => array(
					'class'    => 'textarea',
					'tab'      => 'extensions',
					'item'     => 'interactive',
					'label'    => Ai1ec_I18n::__( 'Subject of the mail sent to the user when new feed is submitted:' ),
					'type'     => 'normal',
					'rows'     => 6,
				),
				'value' => '[[site_title]] Thanks for your calendar submission',
			),
			'user_mail_body' => array(
				'type' => 'string',
				'version' => AI1ECFS_PLUGIN_NAME,
				'renderer' => array(
					'class'    => 'textarea',
					'tab'      => 'extensions',
					'item'     => 'interactive',
					'label'    => Ai1ec_I18n::__( 'Body of the mail sent to the user when new feed is submitted:' ),
					'type'     => 'normal',
					'rows'     => 6,
				),
				'value' => "We have received your calendar submission. We will review it shortly and let you know if it is approved.\n\nThere is a small chance that your submission was lost in a spam trap. If you don't hear from us soon, please resubmit.\n\nThanks,\n[site_title]\n[site_url]",
			),
			'is_venue_required' => array(
				'type' => 'bool',
				'version'  => AI1ECFS_VERSION,
				'renderer' => array(
					'class' => 'checkbox',
					'tab'   => 'extensions',
					'item'  => 'interactive',
					'label' => __(
						'Venue name',
						AI1ECFS_PLUGIN_NAME
					),
				),
				'value'  => false,
			),
			'is_address_required' => array(
				'type' => 'bool',
				'version'  => AI1ECFS_VERSION,
				'renderer' => array(
					'class' => 'checkbox',
					'tab'   => 'extensions',
					'item'  => 'interactive',
					'label' => __(
						'Address',
						AI1ECFS_PLUGIN_NAME
					),
				),
				'value'  => false,
			),
			'is_description_required' => array(
				'type' => 'bool',
				'version'  => AI1ECFS_VERSION,
				'renderer' => array(
					'class' => 'checkbox',
					'tab'   => 'extensions',
					'item'  => 'interactive',
					'label' => __(
						'Description',
						AI1ECFS_PLUGIN_NAME
					),
				),
				'value'  => false,
			),
			'is_organizer_name_required' => array(
				'type' => 'bool',
				'version'  => AI1ECFS_VERSION,
				'renderer' => array(
					'class' => 'checkbox',
					'tab'   => 'extensions',
					'item'  => 'interactive',
					'label' => __(
						'Organizer name',
						AI1ECFS_PLUGIN_NAME
					),
				),
				'value'  => false,
			),
			'is_organizer_email_required' => array(
				'type' => 'bool',
				'version'  => AI1ECFS_VERSION,
				'renderer' => array(
					'class' => 'checkbox',
					'tab'   => 'extensions',
					'item'  => 'interactive',
					'label' => __(
						'Organizer email',
						AI1ECFS_PLUGIN_NAME
					),
				),
				'value'  => false,
			),
			'is_phonenumber_required' => array(
				'type' => 'bool',
				'version'  => AI1ECFS_VERSION,
				'renderer' => array(
					'class' => 'checkbox',
					'tab'   => 'extensions',
					'item'  => 'interactive',
					'label' => __(
						'Phone number',
						AI1ECFS_PLUGIN_NAME
					),
				),
				'value'  => false,
			),
			'is_contact_required' => array(
				'type' => 'bool',
				'version'  => AI1ECFS_VERSION,
				'renderer' => array(
					'class' => 'checkbox',
					'tab'   => 'extensions',
					'item'  => 'interactive',
					'label' => __(
						'External website URL',
						AI1ECFS_PLUGIN_NAME
					),
				),
				'value'  => false,
			)
		);
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Base_Extension_Controller::_register_actions()
	 */
	protected function _register_actions( Ai1ec_Event_Dispatcher $dispatcher ) {
		// Register handlers
		$dispatcher->register_action(
			'wp_ajax_ai1ec_front_end_create_event_form',
			array( 'view.frontend', 'get_front_end_create_event_form' )
		);
		$dispatcher->register_action(
			'wp_ajax_ai1ec_front_end_submit_event',
			array( 'view.frontend', 'submit_front_end_create_event_form' )
		);
		// Add new LESS file to parse queue.
		$dispatcher->register_filter(
			'ai1ec_less_files',
			array( 'less.interactive-frontend', 'add_less_files' )
		);
		$dispatcher->register_action(
			'wp_ajax_nopriv_ai1ec_add_ics_frontend',
			array( 'controller.ai1ecif', 'add_ics_feed_frontend' )
		);
		$dispatcher->register_action(
			'wp_ajax_ai1ec_add_ics_frontend',
			array( 'controller.ai1ecif', 'add_ics_feed_frontend' )
		);

		$settings = $this->_registry->get( 'model.settings' );
		if ( $settings->get( 'allow_anonymous_submissions' ) ) {
			$dispatcher->register_action(
				'wp_ajax_nopriv_ai1ec_front_end_create_event_form',
				array( 'view.frontend', 'get_front_end_create_event_form' )
			);
			$dispatcher->register_action(
				'wp_ajax_nopriv_ai1ec_front_end_submit_event',
				array( 'view.frontend', 'submit_front_end_create_event_form' )
			);
		}
		$dispatcher->register_filter(
			'ai1ec_contribution_buttons',
			array( 'view.frontend', 'get_html_for_contribution_buttons' )
		);
		$dispatcher->register_filter(
			'ai1ec_render_js',
			array( 'javascript.interactive-frontend', 'add_js' ),
			10,
			2
		);
		$dispatcher->register_shortcode(
			'ai1ec_interactive_frontend',
			array( 'view.frontend.shortcode', 'shortcode' )
		);
	}
}
