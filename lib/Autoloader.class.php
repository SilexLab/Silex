<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

/**
 * Loads all the classes
 */
class Autoloader {
	protected static $directories = [];
	protected static $index = [];
	protected static $ignoreList = [];

	/**
	 * Register this autoloader
	 */
	public static function register() {
		// Are we registered already?
		if(!defined('SILEX_AUTOLOADER')) {
			define('SILEX_AUTOLOADER', true);

			// Tell PHP to use us
			spl_autoload_register(['self', 'autoload']);

			// Ignore these directories
			self::$ignoreList = [
				'lib/modules',
				// no more wildcards
				'lib/smarty/plugins',
				'lib/smarty/sysplugins'
			];

			// Index php classes
			self::indexClasses(preg_replace('/(.*)\/$/', '$1', REL_LIB));
		}
	}

	/**
	 * Loads the class
	 * @param string $className
	 */
	public static function autoload($className) {
		if(defined('SILEX_AUTOLOADER')) {
			if(isset(self::$index[$className]))
				require_once(DIR_ROOT.self::$index[$className]);
		}
	}

	/**
	 * Indexes all php classes in the specified directory
	 * @param string $dir
	 */
	protected static function indexClasses($dir) {
		foreach(scandir($dir) as $file) {
			// is this a php class?
			if(is_file($dir.'/'.$file) && preg_match('/([a-zA-Z0-9_]+)\.class\.php/', $file, $fileMatches)) {
				// Add this file
				if(!isset(self::$index[$fileMatches[1]]))
					self::$index[$fileMatches[1]] = $dir.'/'.$file;

			// is this a not-ignored directory?
			// ignore '.', '..' and all other directories wich start with a dot
			} else if(is_dir($dir.'/'.$file) && !preg_match('/(^\.{1,2}$)|(^\.(.*))/', $file)) {
				if(!in_array($dir.'/'.$file, self::$ignoreList))
					self::indexClasses($dir.'/'.$file);
			}
		}
	}
}
