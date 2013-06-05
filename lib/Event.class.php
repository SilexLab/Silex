<?php
/**
 * @author    Patrick Kleinschmidt (NoxNebula) <noxifoxi@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

/**
 * Simple event listener
 */
class Event {
	/**
	 * $events = ['hook' => ['function 1', 'function 2', ...]]
	 */
	private static $events = [];

	/**
	 * Register an function for this hook
	 * @param string   $hook
	 * @param callable $callback
	 */
	public static function register($hook, callable $callback) {
		self::$events[$hook][] = $callback;
	}

	/**
	 * Call a hook and their registered functions
	 * @param string $hook
	 * @param mixed  [...] more arguments
	 */
	public static function call($hook) {
		if(isset(self::$events[$hook])) {
			// additional call parameters
			// you can pass references by using Event::call('hook', [&$refence]);
			$args = func_get_args();
			array_shift($args);

			// call the registered functions
			foreach(self::$events[$hook] as $function) {
				call_user_func_array($function, $args);
			}
		}
	}
}
