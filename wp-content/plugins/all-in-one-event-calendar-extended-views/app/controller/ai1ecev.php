<?php

/**
 * Interactive Frontend extension front controller.
 *
 * @author     Time.ly Network Inc.
 * @since      2.0
 *
 * @package    AI1ECEV
 * @subpackage AI1ECEV.Controller
 */
class Ai1ec_Controller_Ai1ecev extends Ai1ec_Base_License_Controller {


	/* (non-PHPdoc)
	 * @see Ai1ec_Base_Extension_Controller::get_name()
	 */
	public function get_name() {
		return 'Extended Views';
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Base_Extension_Controller::get_machine_name()
	 */
	public function get_machine_name() {
		return 'extended_views';
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Base_Extension_Controller::get_version()
	 */
	public function get_version() {
		return AI1ECEV_VERSION;
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Licence_Controller::get_file()
	 */
	public function get_file() {
		return AI1ECEV_FILE;
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Base_License_Controller::get_license_label()
	 */
	public function get_license_label() {
		return 'Extended Views License Key';
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Base_License_Controller::add_tabs()
	 */
	public function add_tabs( array $tabs ) {
		$tabs = parent::add_tabs( $tabs );
		$tabs['extensions']['items']['extended_views'] = Ai1ec_I18n::__( 'Extended Views' );
		return $tabs;
	}

	/**
	 * Initializes the extension.
	 *
	 * @param Ai1ec_Registry_Object $registry
	 */
	public function init( Ai1ec_Registry_Object $registry ) {
		parent::init( $registry );
		$this->_add_views( $registry->get( 'model.settings-view' ) );
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Base_Extension_Controller::on_deactivation()
	 */
	public function on_deactivation() {
		parent::on_deactivation();
		$view_model = $this->_registry->get( 'model.settings-view' );
		$view_model->remove( 'posterboard' );
		$view_model->remove( 'stream' );
	}

	/*
	 * Add viewing events shortcodes
	 *
	 * @return string
	 */
	public function viewing_events_shortcodes() {
		$loader = $this->_registry->get( 'theme.loader' );
		return $loader->get_file( 'viewing-events-shortcodes.twig' )
			->get_content();
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Base_Extension_Controller::_set_settings()
	 */
	protected function _get_settings() {
		return array(
			'posterboard_events_per_page' => array(
				'value' => 30,
				'type'  => 'int',
				'renderer' => array(
					'class'     => 'input',
					'tab'       => 'extensions',
					'item'      => 'extended_views',
					'label'     => Ai1ec_I18n::__( 'Posterboard pages show at most' ),
					'type'      => 'append',
					'append'    => 'events',
					'validator' => 'numeric',
				)
			),
			'stream_events_per_page' => array(
				'value' => 30,
				'type'  => 'int',
				'renderer' => array(
					'class'     => 'input',
					'tab'       => 'extensions',
					'item'      => 'extended_views',
					'label'     => Ai1ec_I18n::__( 'Stream pages show at most' ),
					'type'      => 'append',
					'append'    => 'events',
					'validator' => 'numeric',
				)
			),
			'posterboard_tile_min_width' => array(
				'value' => 240,
				'type'  => 'int',
				'renderer' => array(
					'class'     => 'input',
					'tab'       => 'extensions',
					'item'      => 'extended_views',
					'label'     => Ai1ec_I18n::__( 'Posterboard tile minimum width' ),
					'type'      => 'append',
					'append'    => 'px',
					'validator' => 'numeric',
				)
			)
		);
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Base_Extension_Controller::_register_actions()
	 */
	protected function _register_actions( Ai1ec_Event_Dispatcher $dispatcher ) {
		$dispatcher->register_filter(
			'ai1ec_render_js',
			array( 'javascript.extended_views', 'add_js' ),
			10,
			2
		);

		// Add new LESS file to parse queue.
		$dispatcher->register_filter(
			'ai1ec_less_files',
			array( 'less.extended_views', 'add_less_files' )
		);
		// Inject new LESS tab panes.
		$dispatcher->register_filter(
			'ai1ec_less_variables_tabs',
			array( 'less.extended_views', 'add_less_variables_tabs' )
		);
		// Inject new LESS variables from file.
		$dispatcher->register_filter(
			'ai1ec_less_variables',
			array( 'less.extended_views', 'add_less_variables' )
		);
		// Add LESS constants.
		$dispatcher->register_filter(
			'ai1ec_less_constants',
			array( 'less.extended_views', 'add_less_constants' )
		);
		// Inject new fonts.
		$dispatcher->register_filter(
			'ai1ec_font_options',
			array( 'less.extended_views', 'add_font_options' )
		);
		// Add shortcodes
		$dispatcher->register_filter(
			'ai1ec_viewing_events_shortcodes',
			array( 'controller.ai1ecev', 'viewing_events_shortcodes' )
		);
	}

	/**
	 * Register view types provided by an extension.
	 *
	 * @param Ai1ec_Settings_View $view_settings View settings management model.
	 *
	 * @return void
	 */
	protected function _add_views( Ai1ec_Settings_View $view_settings ) {
		$view_settings->add(
			array(
				'name'     => 'posterboard',
				'default'  => false,
				'enabled'  => true,
				'longname' => Ai1ec_I18n::__( 'Posterboard' ),
			)
		);
		$view_settings->add(
			array(
				'name'     => 'stream',
				'default'  => false,
				'enabled'  => true,
				'longname' => Ai1ec_I18n::__( 'Stream' ),
			)
		);
	}
}
