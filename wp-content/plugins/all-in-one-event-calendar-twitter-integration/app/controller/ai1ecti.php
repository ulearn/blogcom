<?php

/**
 * Twitter Integration extension front controller.
 *
 * @author     Time.ly Network Inc.
 * @since      2.0
 *
 * @package    AI1ECTI
 * @subpackage AI1ECTI.Controller
 */
class Ai1ec_Controller_Ai1ecti extends Ai1ec_Base_License_Controller {

	/**
	 * @var Ai1ec_Request_Parser Instance of the request parser
	 */
	protected $_request    = null;

	/**
	 * @var Ai1ec_Settings Instance of the settings model
	 */
	protected $_settings    = null;

	/* (non-PHPdoc)
	 * @see Ai1ec_Base_Extension_Controller::get_name()
	*/
	public function get_name() {
		return 'Twitter Integration';
	}
	
	/* (non-PHPdoc)
	 * @see Ai1ec_Base_Extension_Controller::get_machine_name()
	*/
	public function get_machine_name() {
		return 'twitter_integration';
	}
	
	/* (non-PHPdoc)
	 * @see Ai1ec_Base_Extension_Controller::get_version()
	*/
	public function get_version() {
		return AI1ECTI_VERSION;
	}
	
	/* (non-PHPdoc)
	 * @see Ai1ec_Licence_Controller::get_file()
	*/
	public function get_file() {
		return AI1ECTI_FILE;
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Base_License_Controller::get_license_label()
	*/
	public function get_license_label() {
		return 'Twitter License Key';
	}
	
	/* (non-PHPdoc)
	 * @see Ai1ec_Base_License_Controller::add_tabs()
	*/
	public function add_tabs( array $tabs ) {
		$tabs = parent::add_tabs( $tabs );
		$tabs['extensions']['items']['twitter'] = Ai1ec_I18n::__( 'Twitter' );
		return $tabs;
	}
	
	/**
	 * Initializes the extension.
	 *
	 * @param Ai1ec_Registry_Object $registry
	 */
	public function init( Ai1ec_Registry_Object $registry ) {
		parent::init( $registry );
		$this->_request  = $registry->get( 'http.request.parser' );
		$this->_settings = $registry->get( 'model.settings' );
		$this->_register_commands();
		$this->_register_cron();
	}

	/**
	 * Generate HTML box to be rendered on event editing page
	 *
	 * @return void Method does not return
	 */
	public function post_meta_box() {
		global $post;
		if ( ! $this->_registry->get( 'acl.aco' )->are_we_editing_our_post() ) {
			return NULL;
		}

		// Get Event by ID
		try {
			$event = $this->_registry->get( 'model.event', $post->ID );
		} catch (Ai1ec_Event_Not_Found_Exception $e) {
			$event = null;
		}

		if ( $event !== null ) {
			$meta      = '_ai1ec_post_twitter';
			$meta_post = $this->_registry->get( 'model.meta-post' );
			$status    = $meta_post->get( $event->get( 'post_id' ), $meta, false );
			$checked   = 'checked="checked"';
			if ( false === $status ) {
				$checked = null;
			}
			$args = array(
				'title'   => __( 'Post To Twitter' ),
				'checked' => $checked,
			);
			$this->_registry->get( 'theme.loader' )->get_file(
				'ai1ecti-post-meta-box.twig',
				$args,
				true
			)->render();
		}
	}

	/**
	 * Cron callback processing (retrieving and sending) pending messages
	 *
	 * @return int Number of messages posted to Twitter
	 */
	public function send_twitter_messages() {
		$pending    = $this->_get_pending_twitter_events();
		$successful = 0;

		foreach ( $pending as $event ) {
			try {
				if ( $this->_send_twitter_message( $event ) ) {
					++$successful;
				}
			} catch ( Exception $e ) {
				 // exception is ignored
			}
		}
		return $successful;
	}

	/**
	 * Retrieves a list of events matching Twitter notification time interval
	 *
	 * @return array List of Ai1ec_Event objects
	 */
	protected function _get_pending_twitter_events() {
		$parser   = $this->_registry->get( 'parser.frequency' );
		$search   = $this->_registry->get( 'model.search' );

		// Parse time interval
		$parser->parse( $this->_settings->get( 'twitter_notice_interval' ) );

		$interval = (int) $parser->to_seconds();
		$start    = $this->_registry->get( 'date.time', time() + $interval - 600 );
		$end      = $this->_registry->get( 'date.time', time() + $interval + 6600 );
		$events   = $search->get_events_between( $start, $end );

		return $events;
	}

	/**
	 * Checks and sends message to Twitter
	 *
	 * Upon successfully sending message - updates meta to reflect status change
	 *
	 * @return bool Success
	 *
	 * @throws Ai1ecti_Oauth_Exception In case of some error
	 */
	protected function _send_twitter_message( $event ) {
		$format = '[title], [date] @ [venue], [link] [hashtags]';
		$meta_post = $this->_registry->get( 'model.meta-post' );
		$status    = $meta_post->get(
			$event->get( 'post_id' ),
			'_ai1ec_post_twitter',
			array( 'not_requested' )
		);
		if ( is_array( $status ) ) {
			$status = (string)current( $status );
		}
		if ( 'pending' !== $status ) {
			return false;
		}
		$terms  = array_merge(
			wp_get_post_terms(
				$event->get( 'post_id' ),
				'events_categories'
			),
			wp_get_post_terms(
				$event->get( 'post_id' ),
				'events_tags'
			)
		);
		$terms = array();
		$hashtags = array();
		foreach ( $terms as $term ) {
			$hashtags[] = '#' . implode( '_', explode( ' ', $term->name ) );
		}
		$hashtags = implode( ' ', array_unique( $hashtags ) );
		$link     = get_permalink( $event->get( 'post' ) ) . $event->get( 'instance_id' );
		$message  = str_replace(
			array(
				'[title]',
				'[date]',
				'@ [venue]',
				'[link]',
				'[hashtags]',
			),
			array(
				$event->get( 'post' )->post_title,
				$event->get( 'start' ),
				$event->get( 'venue' ),
				$link,
				$hashtags,
			),
			$format
		);
		$message = trim(
			preg_replace(
				'/ ,/',
				',',
				preg_replace( '/\s+/', ' ', $message )
			)
		);
		$length = strlen( $message );
		$link_length = strlen( $link );
		if ( $link_length > 20 ) {
			$length += 20 - $link_length;
		}
		if ( $length > 140 ) {
			$message = substr(
				$message,
				0,
				strrpos(
					$message,
					' ',
					140 - $length
				)
			);
		}
		// instance of oauth twitter adapter
		$provider = $this->_registry->get( 'oauth.oauth-provider-twitter' );
		$status   = $provider->send_message(
			$this->_get_token(),
			$message
		);
		if ( ! $status ) {
			return false;
		}
		return $meta_post->update(
			$event->get( 'post_id' ),
			'_ai1ec_post_twitter',
			array( 'status' => 'sent', 'twitter_status_id' => $status )
		);
	}

	protected function _get_token() {
		$option  = $this->_registry->get( 'model.option' );
		$token = $option->get( 'ai1ec_oauth_tokens' );
		if ( ! isset( $token ) ) {
			throw new Ai1ecti_Oauth_Exception(
				'Token not available for twitter provider'
			);
		}
		return $token;
	}

	/**
	 * Register custom settings used by the extension to ai1ec general settings
	 * framework
	 *
	 * @return void
	 */
	protected function _get_settings() {
		$twitter_authorize_url = site_url( '?ai1ec_oauth=twitter' );

		return array(
			'oauth_twitter_id' => array(
				'type' => 'string',
				'renderer' => array(
					'class' => 'input',
					'tab'   => 'extensions',
					'item'  => 'twitter',
					'label' => __( 'Application Consumer Key:', AI1ECTI_PLUGIN_NAME ),
					'type'  => 'normal',
				),
				'value'  => '',
			),
			'oauth_twitter_pass' => array(
				'type' => 'string',
				'renderer' => array(
					'class' => 'oauth_secret',
					'tab'   => 'extensions',
					'item'  => 'twitter',
					'label' => __( 'Application Consumer Secret:', AI1ECTI_PLUGIN_NAME ),
					'type'  => 'normal',
					'help'  => sprintf( __(
							'Use "<em>%s</em>" URL for <strong>Callback URL</strong> when configuring your '
							. '<a href="https://dev.twitter.com/apps/new">Twitter application</a>. After creating '
							. 'the application, change the permissions required to <strong>Read and Write</strong> '
							. 'on the <strong>Settings</strong> tab in Twitter.',
							AI1ECTI_PLUGIN_NAME
						),
						$twitter_authorize_url
					),
					'oauth_url' => $twitter_authorize_url,
				),
				'value'  => '',
			),
			'twitter_notice_interval' => array(
				'type' => 'string',
				'renderer' => array(
					'class' => 'input-small',
					'tab'   => 'extensions',
					'item'  => 'twitter',
					'label' => __( 'Time to notification before event start:', AI1ECTI_PLUGIN_NAME ),
					'type'  => 'normal',
					'help'  => __(
						'Announcements will be posted to Twitter this long before start of event. '
							. 'Enter time in seconds (default behavior), or use suffixes, '
							. 'for example: <strong>3h</strong> = <em>3 hours</em>; '
							. '<strong>1d</strong> = <em>1 day</em>.',
						AI1ECTI_PLUGIN_NAME
					),
				),
				'value'  => '',
			),
		);
	}

	/**
	 * Register actions handlers
	 *
	 * @return void
	 */
	protected function _register_actions( Ai1ec_Event_Dispatcher $dispatcher ) {
		add_action(
			'ai1ec_send_twitter_messages',
			array( $this, 'send_twitter_messages' )
		);
		add_action(
			'post_submitbox_misc_actions',
			array( $this, 'post_meta_box' )
		);
	}

	/**
	 * Register commands handlers
	 *
	 * @return void
	 */
	protected function _register_commands() {
		$this->_registry->get( 'command.resolver', $this->_request )
			->add_command(
				$this->_registry->get(
					'command.twitter-oauth',
					$this->_request
				)
			);
	}

	/**
	 * Register cron handlers
	 *
	 * @return void
	 */
	protected function _register_cron() {
		return $this->_registry->get( 'scheduling.utility' )->reschedule(
			'ai1ec_send_twitter_messages',
			'hourly'
		);
	}

}