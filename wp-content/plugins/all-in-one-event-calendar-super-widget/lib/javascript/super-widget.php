<?php

/**
 * Handles Super Widget.
 *
 * @author     Time.ly Network Inc.
 * @since      2.0
 *
 * @package    AI1EC
 * @subpackage AI1EC.Javascript
 */
class Ai1ec_Javascript_Super_Widget extends Ai1ec_Base {
	
	
	/**
	 * Renders everything that's needed for the web widget
	 *
	 */
	public function render_web_widget() {
		header( 'Content-Type: application/javascript' );
		// Aggressive caching to save future requests from the same client.
		$etag = '"' . md5( __FILE__ . AI1EC_VERSION ) . '"';
		header( 'ETag: ' . $etag );
		header(
			'Expires: ' . gmdate( 'D, d M Y H:i:s', time() + 31536000 ) . ' GMT'
		);
		header( 'Cache-Control: public, max-age=31536000' );
	
		if (
			empty( $_SERVER['HTTP_IF_NONE_MATCH'] ) ||
			$etag !== stripslashes( $_SERVER['HTTP_IF_NONE_MATCH'] )
		) {
			$app            = $this->_registry->get(
				'bootstrap.registry.application'
			);
			$basepath       = $app->get( 'super_widget_basepath' );
			$jsdir          = $basepath . '/public/js/';
			$jscontroller   = $this->_registry->get( 'controller.javascript' );
			$css_controller = $this->_registry->get( 'css.frontend' );
			$require_main   = $jsdir . 'require.js';
			$data_main      = $jsdir . 'main_widget.js';
			$translation    = $jscontroller->get_frontend_translation_data();
			$permalink      = get_permalink(
				$this->_registry->get( 'model.settings' )
					->get( 'calendar_page_id' )
			);
			$css_url        = $css_controller->get_css_url();

			$translation['calendar_url'] = $permalink;
			// Let extensions add their scripts.
			$extension_urls = array();
			$extension_urls = apply_filters(
				'ai1ec_render_js',
				$extension_urls,
				'main_widget.js'
			);
			$translation['extension_urls'] = $extension_urls;
			$translation_module = $jscontroller->create_require_js_module(
				Ai1ec_Javascript_Controller::FRONTEND_CONFIG_MODULE,
				$translation
			);
			$config         = $jscontroller->create_require_js_module(
				'ai1ec_config',
				$jscontroller->get_translation_data()
			);
			// get jquery
			$jquery = $jscontroller->get_jquery_version_based_on_browser(
				$_SERVER['HTTP_USER_AGENT']
			);
			$calendar = $jscontroller->get_module(
				'scripts/calendar.js'
			);
			$event = $jscontroller->get_module(
				'scripts/calendar/event.js'
			);
			$domready = $jscontroller->get_module(
				'domReady.js'
			);
			$frontend = $jscontroller->get_module(
				'scripts/common_scripts/frontend/common_frontend.js'
			);
			echo <<<JS
			/******** Called once Require.js has loaded ******/
			// This needs to be global
			function timely_scriptLoadHandler() {
				// Load translations modules
				$translation_module
				$config
				$jquery
				$calendar
				$event
				$domready
				$frontend
			}
			(function() {
				if( typeof timely === 'undefined' ) {
					var timely_script_tag = document.createElement( 'script' );
					timely_script_tag.setAttribute( "type","text/javascript" );
					timely_script_tag.setAttribute( "src", "$require_main" );
					timely_script_tag.setAttribute( "data-main", "$data_main" );
					timely_script_tag.async = true;
					if ( timely_script_tag.readyState ) {
						timely_script_tag.onreadystatechange = function () { // For old versions of IE
							if ( this.readyState == 'complete' || this.readyState == 'loaded' ) {
								timely_scriptLoadHandler();
							}
						};
					} else { // Other browsers
						timely_script_tag.onload = timely_scriptLoadHandler;
					}
					( document.getElementsByTagName( "head" )[0] || document.documentElement ).appendChild( timely_script_tag );
				} else {
					timely.require( ['main_widget'] );
					timely_scriptLoadHandler();
				}
				var timely_css = document.createElement( 'link' );
				timely_css.setAttribute( "type", "text/css" );
				timely_css.setAttribute( "rel", "stylesheet" );
				timely_css.setAttribute( "href", "$css_url" );
				( document.getElementsByTagName( "head" )[0] || document.documentElement ).appendChild( timely_css );
			})(); // We call our anonymous function immediately
JS;
		} else {
			// Not modified!
			status_header( 304 );
		}
		exit( 0 );
	}

}