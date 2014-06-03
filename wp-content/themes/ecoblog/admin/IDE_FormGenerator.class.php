<?php

	/*
		Copyright 2009, idesigneco.com
		http://idesigneco.com
	*/


class IDE_FormGenerator {

	private $_form_attribs = null;
	private $_form_elements = array();
	private static $_counter = 0;
	private $_separators = array();
	private $_data = array();
	private $_invalids = array();
	private $_print_invalids = false;

	private static $_css_class = array(	// css classes for elements
		'form' => 'ide_form',
		'submit' => 'button',
		'button' => 'button',
		'button2' => 'button',
		'checkbox' => 'chk',
		'invalid' => 'msg',
		'info' => 'info',
		'text' => 'regular-text',
		'section' => 'section',
		'tabs' => 'tabs'
	);
	
	private static $_no_separators = array(
		'hidden' => true,
	);

	function __construct($attribs = null, $title = null) {
		$this->_form_attribs = $attribs;
		$this->_title = $title;
		$this->separator('<p class="field">', '</p>');
	}

	// ----------------------------------------------------------------------

	// form elements to generate
	function elements($section = null, $elements) {
		$this->_form_elements[] = array($section, $elements);
	}

	// html that encloses each element
	public function separator($start_tag = null, $end_tag = null) {
		$this->_separators = array($start_tag, $end_tag);
	}

	// arrat of data to be filled into the form elements
	public function data($data = null) {
		$this->_data = $data;
	}

	// print error messages too?
	public function printErrors($print_invalids) {
		$this->_print_invalids = $print_invalids;
	}
	
	// print the form
	public function generate() {
		$html = '<form '.self::_getAttributes('form', $this->_form_attribs).'><div>'.($this->_title ? '<h1>'.$this->_title.'</h1>' : '');

			foreach($this->_form_elements as $section) {
				// section
				if(!empty($section[0]['id'])) {
					$html.= '<div id="section-'.$section[0]['id'].'" class="'.self::$_css_class['section'].'">';
					$html.= '<h2 class="title">'.$section[0]['name'].'</h2>';

					if(!empty($section[0]['info']))
						$html.= '<p class="section_info">'.$section[0]['info'].'</p>';
				}

				if(is_array($section[1]))
				foreach($section[1] as $e_name => $e) {
						// separator tag start
						if(isset($this->_separators[0]) && !isset(self::$_no_separators[$e['type']])) $html.= $this->_separators[0];

						// id
						if(!isset($e['attribs']['id'])) {
							$e['attribs']['id'] = $e['type'].'-'.$e_name.self::$_counter;
							self::$_counter++;
						}

						// value
						if(!isset($e['value'])) {
							$e['value'] = '';
						}

						// data
						if(isset($this->_data[$e_name])) {
							$e['data'] = $this->_data[$e_name];	// raw data

							switch($e['type']) {
								case 'text':
								case 'textarea':
									$e['value'] = self::_sanitizeText($this->_data[$e_name]);	// data to be printed
								break;
							}
						}

						// label
						if(isset($e['label']))	$html.= self::_getLabel($e['attribs']['id'], $e['label']);

						// prepend html
						if(isset($e['before'])) $html.= $e['before'];

						// actual element
						$method = '_g'.$e['type'];
						if(method_exists('IDE_FormGenerator', $method)) {
							$e['attribs']['name'] = $e_name;
							$html.=self::$method($e)."\n";
						}

						// append html
						if(isset($e['after'])) $html.= '<span>'.$e['after'].'</span>';

						// info
						if(!empty($e['info'])) {
							$html.='<span class="'.self::$_css_class['info'].'">'.$e['info'].'</span>';
						}

						// print error messages?
						if($this->_print_invalids) {
							if(array_search($e_name, $this->_invalids) !== false) {
								$html.='<p class="'.self::$_css_class['invalid'].'">'.(isset($e['error']) ? $e['error'] : 'x').'</p>';
							}
						}

						// separator tag end
						if(isset($this->_separators[1]) && !isset(self::$_no_separators[$e['type']])) $html.= $this->_separators[1];
				}

				$html.= (!empty($section[0]['id']) ? '</div>' : '');

			}

		$html.= '</div></form>';

		echo $html;
	}

	function validate() {
		$invalids = array();

		$data = array();
		

		foreach($this->_form_elements as $sections)
		foreach($sections[1] as $e_name => $e) {
			$data[$e_name] = isset($this->_data[$e_name]) ? $this->_data[$e_name] : '';
			if(isset($e['validation'])) {		// validation rules exist for this element?
				$validation = $e['validation'];
				foreach($validation as $rule=>$args) {	// go through all rules
					if(!$rule && $args) {
						$rule = $args;
						$args = null;
					}
					if(!IDE_Validator::validate($rule, isset($this->_data[$e_name]) ? $this->_data[$e_name] : '', $args)) {	// validate
						$invalids[] = $e_name;
						break;
					}
				}
			}
		}
		$this->_invalids = $invalids;
		
		return $data;
	}
	
	function setErrors($errors) {
		$this->_invalids = array_merge($this->_invalids, $errors);
	}

	function isValid() {
		if(count($this->_invalids) > 0)
			return false;
		else
			return true;
	}

	// ----------------------------------------------------------------------

	private static function _ghidden($element = null) {
		return '<input type="hidden" '.self::_getAttributes('hidden', $element['attribs']).' value="'.$element['value'].'" />';
	}

	private static function _gtext($element = null) {
		return '<input type="text" '.self::_getAttributes('text', $element['attribs']).' value="'.$element['value'].'" />';
	}

	private static function _gfile($element = null) {
		return '<input type="file" '.self::_getAttributes('text', $element['attribs']).' value="'.$element['value'].'" />';
	}

	private static function _gpassword($element = null) {
		return '<input type="password" '.self::_getAttributes('password', $element['attribs']).' value="'.$element['value'].'" />';
	}

	private static function _gtextarea($element = null) {
		return '<textarea '.self::_getAttributes('textarea', $element['attribs']).'>'.$element['value'].'</textarea>';
	}

	private static function _gsubmit($element = null) {
		return '<input type="submit" '.self::_getAttributes('submit', $element['attribs']).' value="'.$element['value'].'" />';
	}

	private static function _gbutton($element = null) {
		return '<input type="button" '.self::_getAttributes('button', $element['attribs']).' value="'.$element['value'].'" />';
	}

	private static function _gbutton2($element = null) {
		return '<button '.self::_getAttributes('button2', $element['attribs']).'>'.$element['value'].'</button>';
	}

	private static function _gcheckbox($element = null) {
		return '<input type="checkbox" '.self::_getAttributes('checkbox', $element['attribs']).' value="'.$element['value'].'"'.(isset($element['data']) && $element['data'] == $element['value'] ? ' checked="true"' : '').' />';
	}

	private static function _gselect($element = null) {
		$selected = '';

		if(isset($element['value']))
			$selected = $element['value'];
		if(isset($element['data']))
			$selected = $element['data'];

		$s = '';
		if(isset($element['attribs']['options'])) {
			$options = $element['attribs']['options'];
			foreach($options as $k=>$v) {
				$s.='<option value="'.$k.'"'.($selected == $k ? ' selected="true"' : '').'>'.$v.'</option>';
			}
			unset($element['attribs']['options']);
		}

		$s = '<select '.self::_getAttributes('select', $element['attribs']).'>'.$s;
		$s.= '</select>';

		return $s;
	}


	// ----------------------------------------------------------------------


	private static function _getLabel($for_id = null, $caption) {
		return '<label'.($for_id ? ' for="'.$for_id.'"' : '').'>'.$caption.'</label>';
	}

	private static function _sanitizeText($text) {
		return htmlspecialchars($text);
	}

	private static function _getAttributes($element, $attribs = null) {
		$html = array();

		if($attribs) {

			foreach($attribs as $key=>$val) {
				$html[] = "$key=\"{$val}\"";
			}

			if(isset(self::$_css_class[$element]))
				$html[] = "class=\"".self::$_css_class[$element]."\"";

			return implode(' ', $html);
		}
	}



}

?>