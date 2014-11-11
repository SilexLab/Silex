<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class Modules {
	const MODULE_FILE = 'module.php';
	private static $modules = [];
	private static $groups = [];
	private static $registered = [];
	private static $methods = [];
	private static $init = false;

	/**
	 * Initialize modules
	 * @param string $modulesPath
	 */
	public static function init($modulesPath) {
		if (!self::$init) {
			foreach (scandir($modulesPath) as $module) {
				if (is_file($modulesPath.$module.'/'.self::MODULE_FILE)) {
					require_once $modulesPath.$module.'/'.self::MODULE_FILE;
					$class = preg_replace('/\./', '_', $module);

					$obj = new $class;
					if ($obj instanceof IModule) {
						self::$modules[$module] = $obj;
						if ($obj->getModuleGroup())
							self::$groups[$obj->getModuleGroup()][] = $module;
					}
					unset($obj);
				}
			}
			self::$init = true;
		}
	}

	/**
	 * Get a method registered by a module
	 * @param  string $method
	 * @param  array  $args
	 * @return mixed
	 */
	public static function callMethod($method, $args) {
		return isset(self::$methods[$method]) ? self::$modules[self::$methods[$method]]->callMethod($method, $args) : null;
	}

	public static function get($module) {
		return isset(self::$modules[$module]) ? self::$modules[$module] : null;
	}

	/**
	 * Get the status of a module
	 *  1 = enabled
	 *  0 = disabled
	 * -1 = not installed
	 * @param  string $module module name
	 * @return int
	 */
	public static function status($module) {
		if (array_key_exists($module, self::$modules) || array_key_exists($module, self::$groups)) {
			// TODO: check in database if module is enabled or disabled
			if (true)
				return 1;
			return 0;
		}
		return -1;
	}

	/**
	 * Load module(s) and register in the system
	 * @param string $module
	 * @param string $source
	 */
	public static function load($module = '', $source = '') {
		// TODO: don't load/register disabled modules (database)
		if (empty($module)) {
			foreach (self::prioritySort(self::$modules) as $module => $n) {
				self::load($module, $module);
			}
		} else {
			$m = self::$modules[$module];

			// Register methods
			$methods = $m->getMethods();
			if ($methods) {
				foreach ($methods as $method) {
					if (isset(self::$methods[$method]))
						continue;
					self::$methods[$method] = $module;
				}
			}

			// Get parents
			if ($m->getParents()) {
				foreach ($m->getParents() as $parent => $importance) {
					if (!in_array($parent, self::$registered)) {
						if (array_key_exists($parent, self::$modules) && $parent != $source)
							self::load($parent, $source);
						else if (!array_key_exists($parent, self::$modules) && $importance == 'required')
							return;
					}
				}
			}

			if (!in_array($module, self::$registered)) {
				$m->load();
				self::$registered[] = $module;
			}
		}
	}

	/**
	 * Sort by priority
	 * (the output array does not contain objects)
	 * @param  array $modules
	 * @return array
	 */
	private static function prioritySort(array $modules) {
		$hold = [];
		$holdDefault = [];

		// Get priority
		foreach ($modules as $name => $object) {
			$priority = $object->getPriority();
			if ($priority <= -1)
				$holdDefault[$name] = $priority;
			else
				$hold[$name] = $priority;
		}

		// Sort by priority
		asort($hold);

		// Add default priorities at the end
		return array_merge($hold, $holdDefault);
	}
}
