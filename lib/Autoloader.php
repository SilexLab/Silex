<?php
/**
 * @author SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @link https://silexlab.org/
 */

namespace silex;

/**
 * Autoloader class for Silex
 */
class Autoloader
{
	/**
	 * Register the the autoloader method
	 *
	 * @link http://php.net/manual/en/function.spl-autoload-register.php
	 */
	public static function register()
	{
		spl_autoload_register(['self', 'autoload']);
	}

	/**
	 * The autoloader
	 * registered by Autoloader::register()
	 *
	 * @param string $class The name of the class which should be loaded
	 */
	public static function autoload($class)
	{
		$namespace = explode('\\', $class);
		if ($namespace[0] == __NAMESPACE__) {
			// Handle silex namespace
			// TODO: Handle file not found error
			require_once str_replace('\\', '/', mb_substr($class, mb_strlen(__NAMESPACE__) + 1)) . '.php';
		} else {
			// Handle other registered namespaces
		}
	}
}
