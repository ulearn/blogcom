<?php

/**
 * Handles rendering interactive frontend shortcode.
 *
 * @author       Time.ly Network, Inc.
 * @since        2.0
 * @package      Ai1ECIF
 * @subpackage   Ai1ECIF.View
 */
class Ai1ec_Frontend_Shortcode extends Ai1ec_Base {

	/**
	 * Returns the html for the shortcode.
	 *
	 * @return string
	 */
	public function shortcode() {
		$page = $this->_registry->get( 'model.settings' )
			->get( 'calendar_page_id' );
		if ( true === is_page( $page ) ) {
			return '';
		}
		$this->_registry->get( 'css.frontend' )
			->add_link_to_html_for_frontend();
		$this->_registry->get( 'controller.javascript' )
			->add_link_to_render_js(
				Ai1ec_Javascript_Controller::CALENDAR_PAGE_JS,
				false
			);
		$html  = '<div class="timely">';
		$html .= $this->_registry->get( 'view.frontend' )
			->get_html_for_contribution_buttons();
		$html .= '</div>';
		return $html;
	}

}