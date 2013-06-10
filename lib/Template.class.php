<?php
/**
 * @author    Patrick Kleinschmidt (NoxNebula) <noxifoxi@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class Template {
	private $smarty = null;
	private $caching = true;
	private $templateDirs = [];

	/**
	 * @param mixed $dirs
	 * @param bool  $caching optional
	 */
	public function __construct($dirs, $caching = true) {
		$this->templateDirs = (array)$dirs;

		$this->smarty = new Smarty();

		// set cache/compile settings
		$this->caching = $caching;
		$this->smarty->caching = $caching;
		$this->smarty->setCacheDir(DIR_CACHE);
		$this->smarty->setCompileDir(DIR_CACHE.'template/');
	}

	/**
	 * assign variables to the template
	 * @param array $vars
	 */
	public function assign(array $vars) {
		$this->smarty->assign($vars);
	}

	/**
	 * display the template
	 * @param string $template
	 */
	public function display($template) {
		$this->makeSettings();
		$this->smarty->display($template);
	}

	/**
	 * parse the template
	 * @param  string $template
	 * @return string
	 */
	public function parse($template) {
		$this->makeSettings();
		return $this->smarty->fetch($template);
	}

	/**
	 * add a directory to search for templates
	 * @param mixed $directory
	 * @param bool  $primary   optional
	 */
	public function addDir($directory, $primary = true) {
		if($primary)
			$this->templateDirs = array_merge((array)$directory, $this->templateDirs);
		else
			$this->templateDirs = array_merge($this->templateDirs, (array)$directory);
	}

	private function makeSettings() {
		$this->smarty->setTemplateDir($this->templateDirs);
	}
}
