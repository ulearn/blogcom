<?php

/**
 * The class which proxies facebook calls.
 *
 * @author     Time.ly Network Inc.
 * @since      2.0
 *
 * @package    AI1EC
 * @subpackage AI1EC.Facebook
 */
class Ai1ec_Facebook_Proxy {

	// an exception caused by authentication
	const OAUTHEXCEPTION         = 'OAuthException';

	/**
	 * @var Ai1ec_Registry_Object
	 */
	protected $_registry;

	/**
	 * @var Facebook_WP_Extend_Ai1ec
	 */
	protected $_facebook;

	public function __construct( Ai1ec_Registry_Object $registry, $config ) {
		$this->_registry = $registry;
		$this->_facebook = new Facebook_WP_Extend_Ai1ec( $config );
	}

	/**
	 * Proxy the calls to the main class. 
	 * Had to use this because of http://3v4l.org/pdkhp
	 * 
	 * @param string $name
	 * @param array $arguments
	 *
	 * @return mixed
	 */
	public function __call( $name , array $arguments  ) {
		$throwable = NULL;
		try {
			return call_user_func_array( array( $this->_facebook, $name ), $arguments );
		} catch ( WP_FacebookApiException $exception ) {
			if ( self::OAUTHEXCEPTION === $exception->getType() ) {
				$this->_registry->get( 'calendar-feeds.facebook' )
					->do_facebook_logout();
			}
			$throwable = $exception;
		}
		throw $throwable;
	}

}
