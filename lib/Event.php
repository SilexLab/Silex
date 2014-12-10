<?php
/**
 * @author SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @link https://silexlab.org/
 */

namespace silex;

/**
 * Simple event listener
 */
class Event
{
	/**
	 * $events = ['hook' => [['callback1', priority], ['callback2', priority], ...]]
	 * @var array $events
	 */
	private static $events = [];

	/**
	 * Register an function for this hook
	 *
	 * @param string $hook
	 * @param callable $callback
	 * @param int $priority optional
	 */
	public static function listen($hook, callable $callback, $priority = 0)
	{
		self::$events[$hook][] = [$callback, $priority];
	}

	/**
	 * Fire an event
	 * @param string $hook
	 * @param array $params variadic
	 */
	public static function fire($hook, ...$params)
	{
		if (isset(self::$events[$hook])) {
			// sort listeners
			usort(self::$events[$hook], function($a, $b) {
				if ($a[1] > $b[1] && $a[1] != 0) return -1;
				if ($a[1] < $b[1] && $b[1] != 0) return 1;
				return 0;
			});

			// call the registered callables
			foreach (self::$events[$hook] as $listener) {
				$listener[0](...$params);
			}
		}
	}
}
