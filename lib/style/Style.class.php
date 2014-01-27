<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

abstract class Style {
	protected $title = '';
	protected $cssFiles = [];

	/**
	 * init the style
	 */
	public function __construct() {
		$this->readConfig();
	}

	/**
	 * register the style
	 * @return void
	 */
	public abstract function register();

	/**
	 * @return string
	 */
	public abstract function getName();

	/**
	 * reads the style config and stores values
	 */
	public function readConfig() {
		$xml = simplexml_load_file($this->getPath().'style.xml');

		// Read values
		$this->title = (string)$xml->title;

		foreach($xml->{'css-files'} as $cssFile)
			$this->cssFiles[] = (string)$cssFile->{'css-file'};
	}

	/**
	 * @return string
	 */
	protected function getPath() {
		return DIR_STYLE.$this->getName().'/';
	}
} 