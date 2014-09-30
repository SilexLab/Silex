<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

// Static wrapper
class Template {
	private static $template = null;
	private static $init = false;

	/**
	 * @param mixed $dirs
	 * @param bool  $caching optional
	 */
	public static function init($dirs, $caching = true) {
		if(!self::$init) {
			self::$template = new TemplateO($dirs, $caching);
			self::$init = true;
		}
	}

	/**
	 * assign variables to the template
	 * @param array $vars
	 */
	public static function assign(array $vars) {
		self::$template->assign($vars);
	}

	/**
	 * display the template
	 * @param string $template
	 */
	public static function display($template) {
		self::$template->display($template);
	}

	/**
	 * parse the template
	 * @param  string $template
	 * @return string
	 */
	public static function parse($template) {
		return self::$template->parse($template);
	}

	/**
	 * add a directory to search for templates
	 * @param mixed $directory
	 * @param bool  $primary   optional
	 */
	public static function addDir($directory, $primary = true) {
		self::$template->addDir($directory, $primary);
	}

	public static function getVars($var = null) {
		return self::$template->getVars($var);
	}
}
