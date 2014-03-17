<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

abstract class Style implements ITemplatable {
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
	 * get the dotted template name
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
			if(!empty((string)$cssFile->{'css-file'}))
				$this->cssFiles[] = (string)$cssFile->{'css-file'};

}

	/**
	 * @return string
	 */
	protected final function getPath() {
		return DIR_STYLE.$this->getName().'/';
	}

	/**
	 * @return string
	 */
	protected final function getRelativePath() {
		return REL_STYLE.$this->getName().'/';
	}

	public final function getTitle() {
		return $this->title;
	}

	public final function getTemplateArray() {
		return [
			'title' => $this->getTitle(),
			'name' => $this->getName(),
			'path' => $this->getPath(),
			'relative_path' => $this->getRelativePath(),
			'css_files' => $this->cssFiles,
			'object' => $this,
		];
	}
}
