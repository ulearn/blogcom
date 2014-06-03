<?php

/**
 * Redirect to OAuth target URL.
 *
 * @author     Time.ly Network Inc.
 * @since      1.0
 *
 * @package    AI1ECTI
 * @subpackage AI1ECTI.Http.Response.Render.Oauth
 */
class Ai1ec_Render_Strategy_Oauth extends Ai1ec_Http_Response_Render_Strategy {

	/**
	 * Redirect to target URL and exit.
	 *
	 * @param array $params Arbitrary parameters with `url` amongst them.
	 *
	 * @return void
	 */
    public function render( array $params ) {
		return Ai1ec_Http_Response_Helper::redirect( $params['url'], 302 );
	}

}
