<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

require_once 'lib/util/Cache.class.php';

/**
 * Loads all the classes
 */
class Autoloader {
	protected static $directories = [];
	protected static $index = [];
	protected static $ignoreList = [];
	protected static $namespaceList = [];

	/**
	 * Register this autoloader
	 */
	public static function register() {
		// Are we registered already?
		if (!defined('SILEX_AUTOLOADER')) {
			define('SILEX_AUTOLOADER', true);

			// Ignore these directories
			$modules = 'lib/module/modules';
			self::$ignoreList = [
				$modules
			];

			// Search for more autoloader settings in modules
			// TODO: Cache this
			foreach (scandir($modules) as $module) {
				if (is_file($modules.'/'.$module.'/autoloader.json')) {
					$settings = json_decode(file_get_contents($modules.'/'.$module.'/autoloader.json'));

					// add paths to ignoreList
					if (isset($settings->ignore)) {
						self::$ignoreList = array_merge(self::$ignoreList, (array)$settings->ignore);
					}

					// add namespaces
					if (isset($settings->namespace)) {
						foreach ($settings->namespace as $namespace => $path) {
							self::$namespaceList[$namespace] = $path;
						}
					}
				}
			}

			// Index php classes
			self::checkCache();

			// And now we have an autoloader
			spl_autoload_register(['self', 'autoload']);
		}
	}

	/**
	 * Loads the class
	 * @param string $className
	 */
	public static function autoload($className) {
		// handle namespace if namespace
		if (strpos($className, '\\') !== false) {
			$ns = explode('\\', $className);

			if (array_key_exists($ns[0], self::$namespaceList)) {
				require_once Dir::ROOT.self::$namespaceList[$ns[0]].
					substr(str_replace('\\', '/', $className), strlen($ns[0])).
					'.php';
			}
		// handle indexed classes
		} else if (isset(self::$index[$className]))
			require_once Dir::ROOT.self::$index[$className];
	}

	protected static function checkCache() {
		$cacheFile = 'autoload-index';

		self::$index = Cache::_(function() {
			self::indexClasses(preg_replace('/(.*)\/$/', '$1', Dir::LIB));
			return self::$index;
		}, 'autoload-index');
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
