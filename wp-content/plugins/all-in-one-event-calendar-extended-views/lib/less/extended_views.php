<?php

/**
 * The class which adds LESS variables and theme option tabs for extended views.
 *
 * @author     Time.ly Network Inc.
 * @since      2.0
 *
 * @package    AI1EC
 * @subpackage AI1EC.Facebook
 */
class Ai1ec_Less_Extended_Views extends Ai1ec_Base {


	/**
	 * Add LESS files to parse.
	 *
	 * @param array  $files
	 *
	 * @return array
	 */
	public function add_less_files( array $files ) {
		$files[] = 'extended_views.less';
		return $files;
	}

	/**
	 * Add tabs to theme options.
	 *
	 * @param array  $tabs
	 *
	 * @return array
	 */
	public function add_less_variables_tabs( array $tabs ) {
		$tabs['posterboard'] = array(
			'name' => Ai1ec_I18n::__( 'Posterboard view' ),
		);
		$tabs['stream'] = array(
			'name' => Ai1ec_I18n::__( 'Stream view' ),
		);
		return $tabs;
	}

	/**
	 * Add LESS variables to theme options.
	 *
	 * @param array  $variables
	 *
	 * @return array
	 */
	public function add_less_variables( array $variables ) {
		// Load extension-specific LESS variables.
		$loader = $this->_registry->get( 'theme.loader' );
		$file = $loader->get_file( 'less/user_variables_ev.php', array(), false );

		// Merge new variables into old ones.
		return $variables + $file->get_content();
	}

	/**
	 * Add LESS constants to variable array.
	 *
	 * @param array  $variables
	 *
	 * @return array
	 */
	public function add_less_constants( array $variables ) {
		// Add local resource URLs.
		$variables['fontdir_default_ev'] =
			'~"' . AI1ECEV_URL . '/public/themes-ai1ec/vortex/font"';

		return $variables;
	}

	/**
	 * Add new fonts used by extended views.
	 *
	 * @param array  $fonts
	 *
	 * @return array
	 */
	public function add_font_options( array $fonts ) {
		$fonts['League Gothic'] =
			'"League Gothic", Impact, "Arial Black", Arial, sans-serif';

		// Merge new variables into old ones.
		return $fonts;
	}

}
