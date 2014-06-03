<?php

/**
 * Model used for storing/retrieving venues.
 *
 * @instantiator new
 * @author       Time.ly Network, Inc.
 * @since        2.0
 * @package      AI1ECVENUE
 * @subpackage   AI1ECVENUE.Model
 */
class Ai1ecv_Venue extends Ai1ec_Base {

	/**
	 * @var int the current venue id
	 */
	protected $_id = null;

	/**
	 * @var array the loaded venue values
	 */
	protected $_value = null;

	/**
	 * @var string the venue name
	 */
	protected $_name = null;

	/**
	 * Constructor
	 *
	 * @param Ai1ec_Registry_Object $registry the global registry instane
	 * @param int $data the venue id
	 */
	public function __construct(
		Ai1ec_Registry_Object $registry,
		$data     = null
	) {
		parent::__construct( $registry );

		if ( null === $data ) {
			$this->_value = array();
		}

		if ( is_numeric( $data ) ) {
			$data = (int)$data;
			$this->_load_from_id( $data );
			$this->_id = $data;
		}

		if ( is_object( $data ) ) {
			$this->_load_from_term( $data );
			$this->_id = $data->term_id;
		}
	}

	/**
	 * Load the specified venue information
	 *
	 * @param $term object the term instance
	 */
	protected function _load_from_term( $term ){
		$this->_name  = $term->name;
		$value        = $this->decode_description( $term->description );
		$this->_value = $value;
	}

	/**
	 * Load the specified venue information
	 *
	 * @param $term_id int id of the venue
	 */
	protected function _load_from_id( $term_id ){
		$this->_load_from_term( get_term( $term_id, AI1ECV_TAXONOMY_NAME ) );
	}

	/**
	 * Wrapper to get property value.
	 *
	 * @param string $property Name of property to get.
	 *
	 * @return mixed Actual property.
	 */
	public function get( $property ) {

		if ( ! $this->_value ) {
			return null;
		}
		if ( 'name' === strtolower( $property ) ) {
			return $this->_name;
		}
		if ( ! isset( $this->_value[$property] ) ) {
			return null;
		}

		return $this->_value[ $property ];
	}

	/**
	 * Wrapper to set property value.
	 *
	 * @param string $property Name of property to set.
	 * @param mixed $value Value of property to set.
	 */
	public function set( $property, $value ) {
		$this->_value[ $property ] = $value;
	}

	/**
	 * Decode the string that contains venue information
	 *
	 * @param $string string the encoded string
	 * @return array the decoded values
	 */
	protected function decode_description( $string ){
		return unserialize( base64_decode( $string ) );
	}

	/**
	 * Encode values to be stored into the taxonomy description
	 *
	 * @return string the encoded string with values
	 */
	public function encode_description(){
		return base64_encode( serialize( stripslashes_deep( $this->_value ) ) );
	}

	/**
	 * Set the Address
	 *
	 * @param $value string the value to set
	 */
	public function set_address( $value ){
		$this->set( 'address', $value );
	}

	/**
	 * Set the Contact name
	 *
	 * @param $value string the value to set
	 */
	public function set_contact_name( $value ){
		$this->set( 'contact_name', $value );
	}

	/**
	 * Set the Phone
	 *
	 * @param $value string the value to set
	 */
	public function set_phone( $value ){
		$this->set( 'phone', $value );
	}

	/**
	 * Set the Email
	 *
	 * @param $value string the value to set
	 */
	public function set_email( $value ){
		$this->set( 'email', $value );
	}

	/**
	 * Set the URL
	 *
	 * @param $value string the value to set
	 */
	public function set_url( $value ){
		$this->set( 'url', $value );
	}

	/**
	 * Set the Capacity
	 *
	 * @param $value string the value to set
	 */
	public function set_capacity( $value ){
		$this->set( 'capacity', $value );
	}

	/**
	 * Set the Handicap Accessible
	 *
	 * @param $value string the value to set
	 */
	public function set_handicap( $value ){
		$this->set( 'handicap', $value );
	}

	/**
	 * Set the Parking
	 *
	 * @param $value string the value to set
	 */
	public function set_parking( $value ){
		$this->set( 'parking', $value );
	}

	/**
	 * Set the Image
	 *
	 * @param $value string the value to set
	 */
	public function set_image( $value ){
		$this->set( 'image', $value );
	}

	/**
	 * Set description
	 *
	 * @param $value string the value to set
	 */
	public function set_description( $value ){
		$this->set( 'description', $value );
	}

	/**
	 * Set Latitude
	 *
	 * @param $value string the value to set
	 */
	public function set_latitude( $value ){
		$this->set( 'latitude', $value );
	}

	/**
	 * Set longitude
	 *
	 * @param $value string the value to set
	 */
	public function set_longitude( $value ){
		$this->set( 'longitude', $value );
	}

	/**
	 * Return the venues as an associative array
	 *
	 * @return array the array with all the venues information
	 *
	 */
	public function to_array(){
		$handicap = false;
		if ( 1 === (int)$this->get( 'handicap' ) ) {
			$handicap = true;
		}

		return array(
			'address'      => $this->get( 'address' ),
			'description'  => $this->get( 'description' ),
			'contact_name' => $this->get( 'contact_name' ),
			'phone'        => $this->get( 'phone' ),
			'email'        => $this->get( 'email' ),
			'url'          => $this->get( 'url' ),
			'capacity'     => $this->get( 'capacity' ),
			'handicap'     => $handicap,
			'parking'      => $this->get( 'parking' ),
			'image'        => $this->get( 'image' ),
			'latitude'     => $this->get( 'latitude' ),
			'longitude'    => $this->get( 'longitude' ),
			'google_map'   => $this->get( 'google_map' ),
			'city'         => $this->get( 'city' ),
			'country'      => $this->get( 'country' ),
			'province'     => $this->get( 'province' ),
			'postal_code'  => $this->get( 'postal_code' ),
		);
	}

}