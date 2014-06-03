<?php

/**
 * Manages Facebook meta entries
 *
 * @author     Time.ly Network, Inc.
 * @since      2.0
 * @package    Ai1EC
 * @subpackage Ai1EC.Facebook
 */
class Ai1ec_Facebook_Meta extends Ai1ec_Base {
	
	/**
	 * @var Ai1ec_Meta_Post
	 */
	protected $_meta;

	/**
	 * @param Ai1ec_Registry_Object $registry
	 */
	public function __construct( Ai1ec_Registry_Object $registry ) {
		parent::__construct( $registry );
		$this->_meta = $this->_registry->get( 'model.meta-post' );
	}

	/**
	 * Gets facebook meta data from postmeta.
	 * 
	 * @param string $event_id
	 * 
	 * @return array 
	 */
	public function get_facebook_meta( $event_id ) {
		return array(
			'facebook_eid'    => $this->_meta->get( $event_id, '_ai1ec_facebook_eid' ),
			'facebook_status' => $this->_meta->get( $event_id, '_ai1ec_facebook_status' ),
			'facebook_user'   => $this->_meta->get( $event_id, '_ai1ec_facebook_user' ),
		);
	}

	/**
	 * Saves Facebook eid to meta
	 * 
	 * @param string $event_id
	 * @param string $value
	 * 
	 * @return boolean
	 */
	public function save_facebook_eid( $event_id, $value ) {
		return $this->_save_value( $event_id, '_ai1ec_facebook_eid', $value );
	}

	/**
	 * Save Facebook status to meta.
	 * 
	 * @param string $event_id
	 * @param string $value
	 * 
	 * @return boolean
	 */
	public function save_facebook_status( $event_id, $value ) {
		return $this->_save_value( $event_id, '_ai1ec_facebook_status', $value );
	}

	/**
	 * Save facebook user to meta.
	 * 
	 * @param string $event_id
	 * @param string $value
	 * 
	 * @return boolean
	 */
	public function save_facebook_user( $event_id, $value ) {
		return $this->_save_value( $event_id, '_ai1ec_facebook_user', $value );
	}

	/**
	 * Delete all entries from meta.
	 * 
	 * @param string $event_id
	 */
	public function delete_post_meta( $event_id ) {
		$this->_meta->delete( $event_id, '_ai1ec_facebook_eid' );
		$this->_meta->delete( $event_id, '_ai1ec_facebook_status' );
		$this->_meta->delete( $event_id, '_ai1ec_facebook_user' );
	}

	/**
	 * Save a generic key to meta.
	 * 
	 * @param string $event_id
	 * @param string $key
	 * @param string $value
	 * 
	 * @return boolean
	 */
	protected function _save_value( $event_id, $key, $value ) {
		return $this->_meta->set( $event_id, $key, $value );
	}
}