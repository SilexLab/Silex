<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

abstract class Style implements ITemplatable {
	protected $title = '';
	protected $cssFiles = [];
	protected $cssAsync = [];
	protected $jsFiles = [];

	/**
	 * init the style
	 */
	public function __construct() {
		$this->readConfig();
		Event::listen('silex.construct.before_modules', [$this, 'prepare']);
	}

	/**
	 * do some stuff before loading
	 * @return void
	 */
	public abstract function prepare();

	/**
	 * get the dotted template name
	 * @return string
	 */
	public abstract function getName();

	/**
	 * reads the style config and stores values
	 */
	public function readConfig() {
		$config = new XML($this->getPath().'style.xml');

		// Read values
		$this->title = (string)$config->title;

		// CSS and JS
		$this->cssFiles = (array)$config->{'css-files'}->file;
		$this->cssAsync = (array)$config->{'css-async'}->file;
		$this->jsFiles = (array)$config->{'js-files'}->file;
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
			'url_path' => Silex::getConfig()->get('url.base').$this->getRelativePath(),
			'css_files' => $this->cssFiles,
			'css_async' => $this->cssAsync,
			'js_files' => $this->jsFiles,
			'object' => $this
		];
	}
}
