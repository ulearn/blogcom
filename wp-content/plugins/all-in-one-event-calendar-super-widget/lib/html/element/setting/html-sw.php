<?php

/**
 * Renderer of settings page html.
 *
 * @author       Time.ly Network, Inc.
 * @instantiator new
 * @since        2.0
 * @package      Ai1EC
 * @subpackage   Ai1EC.Html
 */
class Ai1ec_Html_Setting_Html_Sw extends Ai1ec_Html_Setting_Html {
	
	/**
	 * Gets the arguments for the super-widget.twig page.
	 *
	 * @return array
	 */
	protected function get_superwidget_args() {
		return array(
			'siteurl' => site_url( '/?ai1ec_super_widget' ),
		);
	}
}