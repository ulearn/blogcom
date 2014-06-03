<?php

/**
 * The concrete command that use twitter auth.
 *
 * @author     Time.ly Network Inc.
 * @since      2.0
 *
 * @package    AI1EC
 * @subpackage AI1EC.Command
 */
class Ai1ecti_Command_Twitter_Oauth extends Ai1ec_Command {

	/**
	 * NOTICE: {@see self::is_this_to_execute} for details, why input is trusted
	 * and not check for injections.
	 */
	public function do_execute() {
		$provider = $this->_registry->get( 'oauth.oauth-provider-twitter' );

		if ( isset( $_GET['denied'] ) ) {
			throw new Ai1ecti_Oauth_Exception(
				__( 'Authorization was rejected', AI1ECTI_PLUGIN_NAME )
			);
		}
		// user returning from provider
		if ( isset( $_GET['oauth_token'] ) || isset( $_GET['code'] ) ) {
			if ( ! $provider->validate( $_GET ) ) {
				throw new Ai1ecti_Oauth_Exception(
					__( 'Invalid callback', AI1ECTI_PLUGIN_NAME )
				);
			}
			$this->persist( $provider->get_token() );
			return array(
				'url' => admin_url( AI1EC_SETTINGS_BASE_URL ),
			);
		}
		// new request - prepare and redirect
		if ( ! $provider->prepare() ) {
			throw new Ai1ecti_Oauth_Exception(
				__( 'Provider unavailable', AI1ECTI_PLUGIN_NAME )
			);
		}
		$location = $provider->auth_redirect();
		if ( false !== $location ) {
			return array(
				'url' => $location,
			);
		}
		throw new Ai1ecti_Oauth_Exception(
			__( 'Invalid workflow', AI1ECTI_PLUGIN_NAME )
		);
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Command_Save_Abstract::set_render_strategy()
	 */
	public function set_render_strategy( Ai1ec_Request_Parser $request ) {
		$this->_render_strategy = $this->_registry->get(
			'http.response.render.strategy.oauth'
		);
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Command::is_this_to_execute()
	*/
	public function is_this_to_execute() {
		if ( isset( $_REQUEST['ai1ec_oauth'] ) ) {
			return true;
		}
		if (
			isset( $_GET['controller'] ) &&
			'ai1ec_oauth_controller' === $_GET['controller'] &&
			isset( $_GET['oauth_provider'] ) &&
			'twitter' === $_GET['oauth_provider']
		) {
			return true;
		}
		return false;
	}


	/**
	 * Store token in permanent store
	 *
	 * @param  mixed $token Provider-specific token value
	 * @return bool         Success
	 */
	public function persist( $token ) {
		$option  = $this->_registry->get( 'model.option' );
		return $option->set( 'ai1ec_oauth_tokens', $token );
	}
}