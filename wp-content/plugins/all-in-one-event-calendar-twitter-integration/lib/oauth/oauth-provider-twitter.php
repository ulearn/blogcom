<?php

/**
 * Twitter OAuth provider
 *
 * @author     Timely Network Inc
 * @since      2013.05.29
 *
 * @package    AllInOneEventCalendar
 * @subpackage AllInOneEventCalendar.Lib.OAuth
 */
class Ai1ecti_Oauth_Provider_Twitter implements Ai1ecti_Oauth_Provider {

	/**
	 * @var Ai1ec_Registry_Object|null
	 */
	protected $_registry = null;

	/**
	 * @var Ai1ecti_TwitterOAuth Twitter library implementing Twitter-specific OAuth/1.0(a)
	 */
	protected $_oauth    = null;

	/**
	 * @var Ai1ec_Session_Model Instance of pseudo-session object
	 */
	protected $_state    = null;

	/**
	 * Constructor
	 *
	 * @param Ai1ec_Registry_Object $registry
	 *
	 * @return void
	 */
	public function __construct( Ai1ec_Registry_Object $registry ) {
		$this->_registry = $registry;

		if ( null === $this->_reinit_connector() ) {
			throw new Ai1ecti_Oauth_Exception( 'Twitter provider not configured' );
		}

		$this->_state = $this->_registry->get( 'model.session' );
	}

	public function send_message( array $token, $message ) {
		$this->_reinit_connector(
			$token['oauth_token'],
			$token['oauth_token_secret']
		);
		$result = $this->_oauth->post(
			'statuses/update',
			array(
				'status' => $message,
			)
		);
		if ( ! isset( $result->id_str ) ) {
			return false;
		}
		return $result->id_str;
	}

	public function get_name() {
		return __( 'Twitter', AI1ECTI_PLUGIN_NAME );
	}

	public function prepare() {
		$secret  = $this->_state->create();
		$r_token = $this->_oauth->getRequestToken(
			$this->_get_callback_url( $secret )
		);
		if (
			! $r_token ||
			empty( $r_token['oauth_token_secret'] ) ||
			! $this->_state->set( $r_token )
		) {
			return false;
		}
		$this->_secret = $secret;
		return true;
	}

	public function auth_redirect() {
		if (
			! $this->_state->key( $this->_secret ) ||
			false === ( $token = $this->_state->get() )
		) {
			return false;
		}
		$a_uri = $this->_oauth->getAuthorizeURL( $token['oauth_token'] );
		if ( empty( $a_uri ) ) {
			return false;
		}
		return $a_uri;
	}

	public function validate( array $response ) {
		if ( ! isset( $response['oauth_itoken'] ) ) {
			return false;
		}
		$this->_state->key( $response['oauth_itoken'] );
		$r_token = $this->_state->get();
		if (
			empty( $r_token ) ||
			$response['oauth_token'] !== $r_token['oauth_token']
		) {
			return false;
		}
		$this->_response = $response;
		return true;
	}

	public function get_token() {
		$this->_state->key( $this->_response['oauth_itoken'] );
		$r_token = $this->_state->get_last();
		$this->_reinit_connector(
			$r_token['oauth_token'],
			$r_token['oauth_token_secret']
		);
		return $this->_oauth->getAccessToken( $this->_response['oauth_verifier'] );
	}

	public function get_details( $token ) {
		$this->_reinit_connector(
			$token['oauth_token'],
			$token['oauth_token_secret']
		);
		$verification = $this->_oauth->get( 'account/verify_credentials' );
		$settings     = $this->_oauth->get( 'account/settings' );
		$details      = array(
			'user_login'     => 'twitter/' . $verification->id,
			'display_name'   => $verification->name,
			'ai1ec_timezone' => $settings->time_zone->tzinfo_name,
			'id'             => $verification->id,
		);
		return $details;
	}

	public function get_ref( $token ) {
		if ( ! is_array( $token ) || ! isset( $token['user_id'] ) ) {
			throw new Ai1ecti_Oauth_Exception( 'Invalid token supplied' );
		}
		return $token['user_id'];
	}

	public function get_expiration( $token ) {
		if ( ! is_array( $token ) || ! isset( $token['oauth_token_secret'] ) ) {
			throw new Ai1ecti_Oauth_Exception( 'Invalid token supplied' );
		}
		return '+10 years';
	}

	/**
	 * _reinit_connector method
	 *
	 * (Re)initialize Twitter connection.
	 *
	 * @return Ai1ecti_TwitterOAuth Instance of Twitter OAuth/1.0(a) client
	 */
	protected function _reinit_connector( $token = null, $secret = null ) {
		$settings     = $this->_registry->get( 'model.settings' );
		$twitter_id   = $settings->get( 'oauth_twitter_id' );
		$twitter_pass = $settings->get( 'oauth_twitter_pass' );

		if ( empty( $twitter_id ) || empty( $twitter_pass ) ) {
			return false;
		}
		$this->_oauth = $this->_registry->get(
			'twitter-php-sdk.twitteroauth',
			$twitter_id,
			$twitter_pass,
			$token,
			$secret
		);
		return $this->_oauth;
	}

	/**
	 * _get_action_url method
	 *
	 * Get URL to use for API querying.
	 *
	 * @param string $path Partial query path to suffix to base URI
	 *
	 * @return string Absolute URI to query
	 */
	protected function _get_action_url( $path ) {
		return 'http://api.twitter.com/' . ltrim( $path, '/' );
	}

	/**
	 * _get_callback_url method
	 *
	 * Get URI of callback page, where user shall land from provider.
	 *
	 * @param string $secret Secret particle to include in return URI
	 *
	 * @return string Callback URI to send to supplier
	 */
	protected function _get_callback_url( $secret ) {
		$options = array(
			'controller'     => 'ai1ec_oauth_controller',
			'action'         => 'handle_request',
			'oauth_provider' => 'twitter',
			'oauth_itoken'   => $secret,
		);
		return add_query_arg( $options, site_url() );
	}

}