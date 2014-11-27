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
	 * @var array
	 */
	private static $namespaces = [];

	/**
	 * @var array
	 */
	private static $rules = [];

	/**
	 * Register the the autoloader method
	 *
	 * @link http://php.net/manual/en/function.spl-autoload-register.php
	 */
	public static function register()
	{
		spl_autoload_register(['self', 'autoload']);
		self::addNamespace(__NAMESPACE__, '');
	}

	/**
	 * The autoloader
	 * registered by Autoloader::register()
	 *
	 * @param string $class The name of the class which should be loaded
	 * @throws Exception
	 */
	public static function autoload($class)
	{
		$ns = explode('\\', $class);
		if (array_key_exists($ns[0], self::$namespaces)) {
			$path = '';

			// Search for a matching rule | TODO: Find a faster alternative to this algorithm
			foreach (self::$rules as $rule => $callable) {
				if (strpos($class, $rule) === 0) {
					$path = $callable($class);
					break;
				}
			}

			// Parse file
			$file = self::$namespaces[$ns[0]] . str_replace('\\', '/', mb_substr($path ? $path : $class, mb_strlen($ns[0]) + 1)) . '.php';

			// TODO: Handle file not found error
			require_once $file;
		} else {
			throw new \Exception('The high level namespace "' . $ns[0] . '" is not registered', 1);
		}
	}

	/**
	 * Add a rule to an existing high level namespace
	 *
	 * @param string $namespace Subnamespace to apply that rule on
	 * @param callable $rule A callable wich parses the string
	 * @return bool Success
	 */
	public static function addRule($namespace, callable $rule)
	{
		if (!array_key_exists(explode('\\', $namespace)[0], self::$namespaces)
			|| array_key_exists($namespace, self::$rules))
			return false;

		self::$rules[$namespace] = $rule;
		return true;
	}

	/**
	 * Register a new high level namespace
	 *
	 * @param string $namespace
	 * @param string $path Path to that high level namespace (relative from lib/)
	 * @return bool Success
	 */
	public static function addNamespace($namespace, $path)
	{
		if (!array_key_exists($namespace, self::$namespaces)) {
			self::$namespaces[$namespace] = $path;
			return true;
		}
		return false;
	}
}
