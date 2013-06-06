<?php
/**
 * @author    Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */
 
/**
 * Smarty wrapper
 */
class TemplateEngine {
	/**
	 * @var Smarty
	 */
	protected $smarty = null;
	protected $caching = true;
	protected $templateDirectories = [];

	/**
	 * @param array $templateDirectories
	 * @param bool  $caching
	 */
	public function __construct($templateDirectories, $caching = true) {
		$this->smarty = new Smarty();
		$this->caching = $caching;
		if(!$this->caching)
			$this->smarty->caching = false;

		$this->smarty->setTemplateDir($templateDirectories);
		$this->smarty->setPluginsDir([
			// Smarty's own plugins
			DIR_SMARTY.'sysplugins/',
			DIR_SMARTY.'plugins/',
			// Our plugins
			DIR_LIB.'smartyPlugins/',
		]);
		$this->smarty->setCacheDir(DIR_CACHE);
		$this->smarty->setCompileDir(DIR_CACHE.'template/');
	}

	/**
	 * @param array $data
	 */
	public function assign($data) {
		$this->smarty->assign($data);
	}

	/**
	 * @param string $templateName
	 */
	public function show($templateName) {
		$this->smarty->display($templateName);
	}

	/**
	 * @param string $templateName
	 * @return string
	 */
	public function parse($templateName) {
		return $this->smarty->fetch($templateName);
	}

}
