<?php
/**
 * @author    Patrick Kleinschmidt (NoxNebula) <noxifoxi@gmail.com>. Rewritten by Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
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

			// Index all directories, but ignore some
			self::$directories = [
				'*'
			];
			self::$ignoreList = [
			];

			// Index files
			self::indexFiles();
		}
	}

	/**
	 * Loads the class
	 * @param string $className
	 */
	public static function autoload($className) {
		if(defined('SILEX_AUTOLOADER')) {
			if(isset(self::$index[$className]))
				require_once(DIR_LIB.self::$index[$className]);
		}
	}

	/**
	 * Indexes all files in the specified directories
	 */
	protected static function indexFiles() {
		// Go through the directories
		foreach(self::$directories as $curDir) {
			// Wildcard?
			if(preg_match('/^(.*)\*$/', $curDir, $matches)) {
				$curDir = $matches[1];

				// Add trailing slash if necessary
				if(!empty($curDir) && !preg_match('/^(.*)\/$/', $curDir))
					$curDir .= '/';

				// Search for files
				foreach(scandirr(DIR_LIB.$curDir) as $curFile) {
					if(is_file(DIR_LIB.$curDir.$curFile) && preg_match('/([a-zA-Z0-9_]+)\.class\.php/', $curFile, $fileMatches)) {
						// Is ignored?
						foreach (self::$ignoreList as $i) { // TODO: Do this better
							if(preg_match('/^'.$i.'\//', $curDir.$curFile))
								continue 2;
						}
						// Add file
						if(!isset(self::$index[$fileMatches[1]]))
							self::$index[$fileMatches[1]] = $curDir.$curFile;
					}
				}
			} else {
				// Search for files
				foreach(scandir(DIR_LIB.$curDir) as $curFile) {
					// Add trailing slash if necessary
					if(!preg_match('/^(.+)\/$/', $curDir))
						$curDir .= '/';

					if(is_file(DIR_LIB.$curDir.$curFile) && preg_match('/([a-zA-Z0-9_]+)\.class\.php/', $curFile, $fileMatches)) {
						// Add file
						if(!isset(self::$index[$fileMatches[1]]))
							self::$index[$fileMatches[1]] = $curDir.$curFile;
					}
				}
			}
		}
	}
}
