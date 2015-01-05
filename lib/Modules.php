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
	 * Redirect static called methods to the loader
	 *
	 * @param string $name
	 * @param array $arguments
	 * @throws CoreException
	 */
	public static function __callStatic($name, $arguments)
	{
		if (!Silex::getApp()->getModules())
			throw new CoreException('The modules aren\'t loaded via a module loader', 1);

		return Silex::getApp()->getModules()->{$name}(...$arguments);
	}
}
