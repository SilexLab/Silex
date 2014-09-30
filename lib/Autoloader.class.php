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
		if (!defined('SILEX_AUTOLOADER')) {
			define('SILEX_AUTOLOADER', true);

			// We are now an autoloader
			spl_autoload_register(['self', 'autoload']);

			// Ignore these directories
			self::$ignoreList = [
				'lib/modules',
				// no more wildcards
				'lib/smarty/plugins',
				'lib/smarty/sysplugins',
				'lib/smartyPlugins'
			];

			// Index php classes
			self::checkCache();
		}
	}

	/**
	 * Loads the class
	 * @param string $className
	 */
	public static function autoload($className) {
		if (isset(self::$index[$className]))
			require_once DROOT.self::$index[$className];
	}

	protected static function checkCache() {
		$cacheFile = 'autoload-index';

		// probably() changes the probably if it will use the cache file or run the indexing again
		if (file_exists(DCACHE.$cacheFile) && (DEBUG ? false : probably(90))) {
			self::$index = unserialize(file_get_contents(DCACHE.$cacheFile));
		} else {
			self::indexClasses(preg_replace('/(.*)\/$/', '$1', RLIB));
			if (!DEBUG)
				file_put_contents(DCACHE.$cacheFile, serialize(self::$index));
		}
	}

	/**
	 * Indexes all php classes in the specified directory
	 * @param string $dir
	 */
	protected static function indexClasses($dir) {
		foreach (scandir($dir) as $file) {
			// is this a php class?
			if (is_file($dir.'/'.$file) && preg_match('/^([a-zA-Z0-9_\-]+)\.class\.php$/', $file, $fileMatches)) {
				// Add this file
				if (!isset(self::$index[$fileMatches[1]]))
					self::$index[$fileMatches[1]] = $dir.'/'.$file;

			// is this a not-ignored directory?
			// ignore '.', '..' and all other directories wich start with a dot
			} else if (is_dir($dir.'/'.$file) && !preg_match('/^\.(.*)/', $file)) {
				// check ignore list
				if (!in_array($dir.'/'.$file, self::$ignoreList))
					self::indexClasses($dir.'/'.$file);
			}
		}
	}
}
