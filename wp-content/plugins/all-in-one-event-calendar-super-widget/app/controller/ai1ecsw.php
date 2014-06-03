<?php

/**
 * Interactive Frontend extension front controller.
 *
 * @author     Time.ly Network Inc.
 * @since      2.0
 *
 * @package    AI1ECSW
 * @subpackage AI1ECSW.Controller
 */
class Ai1ec_Controller_Ai1ecsw extends Ai1ec_Base_License_Controller {


	/* (non-PHPdoc)
	 * @see Ai1ec_Base_Extension_Controller::get_name()
	 */
	public function get_name() {
		return 'SuperWidget';
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Base_Extension_Controller::get_machine_name()
	 */
	public function get_machine_name() {
		return 'super_widget';
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Base_Extension_Controller::get_version()
	 */
	public function get_version() {
		return AI1ECSW_VERSION;
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Licence_Controller::get_file()
	 */
	public function get_file() {
		return AI1ECSW_FILE;
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Base_License_Controller::get_license_label()
	 */
	public function get_license_label() {
		return 'Super Widget License Key';
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Base_License_Controller::add_tabs()
	 */
	public function add_tabs( array $tabs ) {
		$tabs = parent::add_tabs( $tabs );
		$tabs['extensions']['items']['super_widget'] = Ai1ec_I18n::__( 'Super Widget' );
		return $tabs;
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Base_Extension_Controller::_set_settings()
	 */
	protected function _get_settings() {
		return array(
			'superwidget' => array(
				'type' => 'html',
				'version'  => AI1ECSW_VERSION,
				'renderer' => array(
					'class' => 'html-sw',
					'tab'   => 'extensions',
					'item'  => 'super_widget',
				),
				'value'  => null,
			)
		);
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Base_Extension_Controller::_register_actions()
	 */
	protected function _register_actions( Ai1ec_Event_Dispatcher $dispatcher ) {
		// ==================================
		// = Add the hook to render the js  =
		// ==================================
		if ( isset( $_GET['ai1ec_super_widget'] ) ) {
			// now get the addedd classes
			add_filter( 'ai1ec_is_ajax', '__return_true' );
			$dispatcher->register_action(
				'template_redirect',
				array( 'javascript.super-widget', 'render_web_widget' ),
				1
			);
		
		}
	}
}
