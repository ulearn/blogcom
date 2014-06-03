<?php

/**
 * The class which handles csv and ics file import.
 *
 * @author     Time.ly Network Inc.
 * @since      2.0
 *
 * @package    AI1ECCF
 * @subpackage AI1ECCF.Plugin
 */
class Ai1eccf_Plugin extends Ai1ec_Connector_Plugin {

	/**
	 * @constant string Name of request input field holding submitted file details.
	 */
	const NAME_OF_FILE_INPUT = 'ai1ec_file_input';

	/**
	 * @constant string Name of the submit button that start the upload
	 */
	const NAME_OF_SUBMIT = 'ai1ec_file_submit';

	/**
	 * @constant string Name of the textearea field where the user can paste
	 * the code to import directly
	 */
	const NAME_OF_TEXTAREA = 'ai1ec_upload_textarea';

	protected $variables = array(
		'id' => 'csv',
	);

	/**
	 * @var int number of imported events
	 */
	private $_count;

	/**
	 * Handles any action the plugin requires when the users makes a POST
	 * in the calendar feeds page.
	 */
	public function handle_feeds_page_post(){
		if ( isset( $_POST[self::NAME_OF_SUBMIT] ) ) {
			$count = 0;

			if ( ! empty( $_FILES[self::NAME_OF_FILE_INPUT]['name'] ) ) {
				$count += $this->import_from_file();
			}
			if ( ! empty( $_POST[self::NAME_OF_TEXTAREA] ) ) {
				// Bug http://core.trac.wordpress.org/ticket/18322
				// Double quotes are auto escaped from wordpress
				$count += $this->import_from_string(
					stripslashes( $_POST[self::NAME_OF_TEXTAREA] ) );
			}
			$this->_count = $count;
		}
	}

	/**
	 * @return string CSV
	 */
	public function get_tab_title() {
		return __( 'CSV', AI1ECCF_PLUGIN_NAME );
	}

	/**
	 * Renders the content of the tab, where all the action takes place.
	 *
	 */
	public function render_tab_content(){
		$this->render_opening_div_of_tab();

		$factory = $this->_registry->get(
			'factory.html'
		);

		$file_input = array(
			'id'    => self::NAME_OF_FILE_INPUT,
			'type'  => 'file',
			'name'  => self::NAME_OF_FILE_INPUT
		);

		$submit     = array(
			'id'    => self::NAME_OF_SUBMIT,
			'type'  => 'submit',
			'class' => 'button-primary',
			'name'  => self::NAME_OF_SUBMIT,
			'value' =>  __( 'Submit Events', AI1ECCF_PLUGIN_NAME )
		);

		$textarea   = array(
			'name'  => self::NAME_OF_TEXTAREA,
			'rows'  => 6,
			'id'    => self::NAME_OF_TEXTAREA

		);

		$category_select = $factory->create_select2_multiselect(
			array(
				'name'        => 'ai1ec_file_upload_feed_category[]',
				'id'          => 'ai1ec_file_upload_feed_category',
				'use_id'      => true,
				'type'        => 'category',
				'placeholder' => __( 'Categories (optional)',
					AI1ECCF_PLUGIN_NAME ),
			),
			get_terms( 'events_categories', array( 'hide_empty' => false ) )
		);

		$select_tags = $factory->create_select2_input(
			array (
				'id' => 'ai1ec_file_upload_feed_tags'
			)
		);

		$message = false;
		if ( isset( $this->_count ) ) {
			$text = __( 'No events were found', AI1ECCF_PLUGIN_NAME );
			if ( $this->_count > 0 ) {
				$text = sprintf(
					_n(
						'Imported %s event',
						'Imported %s events',
						$this->_count,
						AI1ECCF_PLUGIN_NAME
					),
					$this->_count
				);
			}
			$message = $text;
		}

		$args = array(
			"category_select" => $category_select,
			"tags"            => $select_tags,
			"submit"          => $submit,
			"file_input"      => $file_input,
			"textarea"        => $textarea
		);
		if ( false !== $message ) {
			$args['message'] = $message;
		}

		$loader   = $this->_registry->get( 'theme.loader' );
		$template = $loader->get_file(
			'ai1eccf-file-upload.twig',
			$args,
			true
		);

		$template->render();

		$this->render_closing_div_of_tab();
	}

	/**
	 * Let the plugin display an admin notice if neede.
	 *
	 */
	public function display_admin_notices(){

	}

	/**
	 * Run the code that cleans up the DB and CRON functions the plugin
	 * has installed.
	 */
	public function run_uninstall_procedures(){

	}

	/**
	 * Tries to import data from an ics or csv file
	 *
	 * @return int
	 */
	private function import_from_file() {

		$v              = false;
		$file_extension = strtolower(
			substr( $_FILES[self::NAME_OF_FILE_INPUT]['name'], -3 ) );

		if ( $file_extension === 'csv' ) {
			$ical_cnv = new iCalcnv();
			$ical_cnv->setConfig(
				array(
					'inputfilename'   => basename(
						$_FILES[self::NAME_OF_FILE_INPUT]['tmp_name']
					),
					'inputdirectory'  => dirname(
						$_FILES[self::NAME_OF_FILE_INPUT]['tmp_name']
					),
					'outputobj'       => TRUE,
					'extension_check' => FALSE
				)
			);

			$v = $ical_cnv->csv2iCal();
		} else if ( $file_extension === 'ics' ) {
			// create new instance
			$v = new vcalendar();
			$v->parse( file_get_contents(
				$_FILES[self::NAME_OF_FILE_INPUT]['tmp_name'] ) );
		}

		$id       = $_FILES[self::NAME_OF_FILE_INPUT]['name'] .
			'-' . date( 'Y-m-d-H:i:s' );
		$feed     = $this->create_feed_instance( $id );

		$comments = ( isset( $_POST['ai1ec_file_upload_comments_enabled'] ) )
			? 'open'
			: 'closed' ;
		$show_map = ( isset( $_POST['ai1ec_file_upload_map_display_enabled'] ) )
			? 1
			: 0;

		$ics      = $this->_registry->get( 'import-export.ics' );

		$count    = $ics->add_vcalendar_events_to_db( $v, array(
			'feed'           => $feed,
			'comment_status' => $comments,
			'do_show_map'    => $show_map
			)
		);

		return $count;
	}

	/**
	 * Create a feed instance
	 *
	 * @param string $id
	 * @return stdClass
	 */
	private function create_feed_instance( $id ) {
		$keep_tag_category = (int) isset(
			$_POST['ai1ec_file_upload_add_tag_categories'] );
		$categories = empty( $_POST['ai1ec_file_upload_feed_category'] )
			? ''
			: implode( ',', $_POST['ai1ec_file_upload_feed_category'] );
		$tags = empty( $_POST['ai1ec_file_upload_feed_tags'] )
			? array()
			: explode( ',', $_POST['ai1ec_file_upload_feed_tags'] );
		$tags_array = array();
		if ( ! empty( $tags ) ) {
			foreach ( $tags as $tag_name ) {
				$tag = get_term_by( 'name', $tag_name, 'events_tags' );
				// if no tag is found, create it
				if ( false === $tag ) {
					$term         = wp_insert_term( $tag_name, 'events_tags' );
					if ( ! is_wp_error( $term ) ) {
						$tags_array[] = (int)$term['term_id'];
					}
				} else {
					$tags_array[] = $tag->term_id;
				}
			}
		}
		$feed                       = new stdClass();
		$feed->feed_category        = $categories;
		$feed->feed_tags            = implode( ',', $tags_array );
		$feed->feed_url             = $id;
		$feed->feed_id              = $id;
		$feed->keep_tags_categories = $keep_tag_category;
		$feed->feed_imported_file   = true;
		return $feed;
	}

	/**
	 * Tries to import data treating it either as csv or as ics.
	 *
	 * @param string $data
	 * @return int the number of imported objetcs
	 */
	private function import_from_string( $data ) {

		$ics = $this->_registry->get( 'import-export.ics' );

		$id       = __(
				'textarea_import',
				AI1EC_PLUGIN_NAME
			) . '-' . date( 'Y-m-d-H:i:s' );
		$feed     = $this->create_feed_instance( $id );
		$comments = isset( $_POST['ai1ec_file_upload_comments_enabled'] )
			? 'open'
			: 'closed';
		$show_map = isset( $_POST['ai1ec_file_upload_map_display_enabled'] )
			? 1
			: 0;

		$ical_cnv = new iCalcnv();

		$ical_cnv->setConfig( array(
			'outputobj'       => true,
			'string_to_parse' => $data,
			)
		);

		$v     = $ical_cnv->csv2iCal();

		$count = $ics->add_vcalendar_events_to_db( $v, array(
			'feed'           => $feed,
			'comment_status' => $comments,
			'do_show_map'    => $show_map
			)
		);

		if ( 0 === $count ) {
			// create new instance
			$v = new vcalendar();
			$v->parse( $data );

			$count = $ics->add_vcalendar_events_to_db( $v, array(
				'feed'           => $feed,
				'comment_status' => $comments,
				'do_show_map'    => $show_map
				)
			);
		}

		return $count;
	}
}