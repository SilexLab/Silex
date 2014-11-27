<?php
/**
 * @author SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @link https://silexlab.org/
 */

namespace silex;

use silex\exception\CoreException;

class Modules
{
	/**
	 * ModuleLoader Object
	 *
	 * @var ModuleLoader
	 */
	protected static $loader = null;

	/**
	 * Load the modules via ModuleLoader
	 *
	 * @param ModuleLoader $loader
	 * @throws CoreException
	 */
	public static function load(ModuleLoader $loader)
	{
		self::$loader = $loader;

		if (!self::$loader->load())
			throw new CoreException('Modules could not loaded', 1);
	}

	/**
	 * Redirect static called methods to the loader
	 *
	 * @param string $name
	 * @param array $arguments
	 * @throws CoreException
	 */
	public static function __callStatic($name, $arguments)
	{
		if (!self::$loader)
			throw new CoreException('The modules aren\'t loaded via a module loader', 1);

		return self::$loader->{$name}(...$arguments);
	}
}
