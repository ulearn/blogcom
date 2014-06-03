<?php

/**
 * The concrete class for posterboard view.
 *
 * @author     Time.ly Network Inc.
 * @since      2.0
 *
 * @package    AI1EC
 * @subpackage AI1EC.View
 */
class Ai1ec_Calendar_View_Posterboard extends Ai1ec_Calendar_View_Agenda {

	/* (non-PHPdoc)
	 * @see Ai1ec_Calendar_View_Abstract::get_name()
	*/
	public function get_name() {
		return 'posterboard';
	}

	/**
	 * Add Posterboard-specific arguments to template.
	 *
	 * @param array $args
	 * @return array
	 */
	public function get_extra_template_arguments( array $args ) {
		$settings = $this->_registry->get( 'model.settings' );
		$args['tile_min_width'] = $settings->get( 'posterboard_tile_min_width' );
		return $args;
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Calendar_View_Abstract::_add_view_specific_runtime_properties()
	*/
	protected function _add_view_specific_runtime_properties(
		Ai1ec_Event $event
	) {
		parent::_add_view_specific_runtime_properties( $event );
		$taxonomy = $this->_registry->get( 'view.event.taxonomy' );
		$event->set_runtime(
			'category_bg_color',
			$taxonomy->get_category_bg_color( $event )
		);
		$event->set_runtime(
			'category_text_color',
			$taxonomy->get_category_text_color( $event )
		);
	}
}
