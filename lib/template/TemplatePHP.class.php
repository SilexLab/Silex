<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

// PHP template wrapper
class TemplatePHP implements ITemplate {
	/**
	 * @param mixed $dirs
	 * @param bool  $caching optional
	 */
	public function __construct($dirs, $caching = true) {
	}

	/**
	 * assign variables to the template
	 * @param array $vars
	 */
	public function assign(array $vars) {
	}

	/**
	 * display the template
	 * @param string $template
	 */
	public function display($template) {
	}

	/**
	 * parse the template
	 * @param  string $template
	 * @return string
	 */
	public function parse($template) {
	}

	/**
	 * add a directory to search for templates
	 * @param mixed $directory
	 * @param bool  $primary   optional
	 */
	public function addDir($directory, $primary = true) {
	}

	public function getVars($var = null) {
	}
}
