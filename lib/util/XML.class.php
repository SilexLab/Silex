<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

/**
 * Simple SimpleXML wrapper
 */
class XML {
	protected $xmlObj;

	/**
	 * Create a new SimpleXML object
	 * @param string $xml
	 * @param bool   $isString optional
	 */
	public function __construct($xml, $isString = false) {
		if($isString)
			$this->xmlObj = simplexml_load_string($xml);
		else
			$this->xmlObj = simplexml_load_file($xml);

		if(!$this->xmlObj)
			throw new CoreException('Failed to load XML');
	}

	public function __get($name) {
		return $this->xmlObj->{$name};
	}

	public function __call($name, $arguments) {
		return call_user_func_array([$this->xmlObj, $name], empty($arguments) ? null : $arguments);
	}

	/**
	 * Return the SimpleXML object
	 * @return  SimpleXMLElement
	 */
	public function get() {
		return $this->xmlObj;
	}

	public function asArray() {
		return UArray::toArray($this->xmlObj);
	}
}
