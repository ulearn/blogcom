<?php

/**
 * Renderer of settings page OAuth token secret input option.
 *
 * @author       Time.ly Network, Inc.
 * @instantiator new
 * @since        1.0
 *
 * @package      Ai1ECTI
 * @subpackage   Ai1ECTI.Html
 */
class Ai1ec_Html_Setting_OauthSecret extends Ai1ec_Html_Setting_Input {

	/**
	 * Append authentication link when token is present.
	 *
	 * @param string $output Initial render.
	 *
	 * @return string Final render output.
	 */
	public function render( $output = '' ) {
		if (
			isset( $this->_args['renderer']['oauth_url'] ) &&
			! empty( $this->_args['value'] )
		) {
			$follow_link = __(
				'Follow <a href="%s" target="_blank">this link</a> to authorize this app to post to Twitter.',
				AI1ECTI_PLUGIN_NAME
			);
			$follow_link = sprintf(
				$follow_link,
				$this->_args['renderer']['oauth_url']
			);
			$this->_args['renderer']['help'] .= '<br>' . $follow_link;
		}
		return parent::render( $output );
	}

}