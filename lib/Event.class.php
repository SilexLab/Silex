<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

/**
 * Simple event listener
 */
class Event {
	/**
	 * $events = ['hook' => [['callback1', priority], ['callback2', priority], ...]]
	 */
	private static $events = [];

	/**
	 * Register an function for this hook
	 * @param string   $hook
	 * @param callable $callback
	 */
	public static function listen($hook, callable $callback, $priority = 0) {
		self::$events[$hook][] = [$callback, $priority];
	}

	/**
	 * Fire an event
	 * @param string $hook
	 * @param array  $args optional
	 */
	public static function fire($hook, array $args = []) {
		if (isset(self::$events[$hook])) {
			// additional call parameters
			//$args = func_get_args();
			//array_shift($args);

			// sort listeners
			usort(self::$events[$hook], function($a, $b) {
				if ($a[1] > $b[1] && $a[1] != 0) return -1;
				if ($a[1] < $b[1] && $b[1] != 0) return 1;
				return 0;
			});

			// call the registered functions
			foreach (self::$events[$hook] as $listener) {
				call_user_func_array($listener[0], $args);
			}
		}
	}
}
