<?php

	/*
		Copyright 2009, idesigneco.com
		http://idesigneco.com
	*/


class IDE_Validator {

	public static function validate($method, $data, $arguments = null) {

		$method = '_'.$method;

		if(method_exists('IDE_Validator', $method)) {
			return self::$method($data, $arguments);
		}
	}

	private static function _notEmpty($data) {
		$data = trim($data);
		if($data) return true;
		return false;
	}

	private static function _isNumeric($data) {
		return is_numeric($data);
	}

	private static function _isAlpha($data) {
		   return eregi('[^a-z]', $data) ? false : true;
	}

	private static function _isAlphaNumeric($data) {
		return eregi('[^a-z0-9]', $data) ? false : true;
	}

	private static function _inLengthRange($data, $lengths) {
		$data = trim($data);
		return (strlen($data) >= $lengths[0] && strlen($data) <= $lengths[1]);
	}
	
	private static function _longerThan($data, $length) {
		$data = trim($data);
		return (strlen($data) >= $length);
	}
	
	private static function _shorterThan($data, $length) {
		$data = trim($data);
		return (strlen($data) <= $length);
	}
	
	private static function _isEmail($data) {
		if(preg_match('/\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i', $data))
			return true;
		else
			return false;
	}

}

?>
