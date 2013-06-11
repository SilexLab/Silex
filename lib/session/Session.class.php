<?php
/**
 * @author    Patrick Kleinschmidt (NoxNebula) <noxifoxi@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class Session {
	public static function start() {
		if(defined('CLASS_SESSION'))
			return false;
		define('CLASS_SESSION', 1);

		// Session configuration
		ini_set('session.gc_maxlifetime', Silex::getConfig()->get('session.autologout'));
		ini_set('session.gc_probability', Silex::getConfig()->get('session.autologout_probability'));
		ini_set('session.gc_divisor', 100);
		ini_set('session.hash_function', 1);

		register_shutdown_function('session_write_close');

		session_name(Silex::getConfig()->get('session.name'));
		session_set_cookie_params(Silex::getConfig()->get('session.cookie_time'), '/', null, false, true);

		session_set_save_handler(new SessionDatabaseHandler(Silex::getDB(), 'session'), true);

		// start session
		session_start();
	}

	/**
	 * @param  string $key
	 * @param  mixed  $value
	 */
	public static function set($key, $value) {
		$_SESSION[$key] = $value;
	}

	/**
	 * @param  string $key
	 * @param  mixed  $default optional
	 * @return mixed
	 */
	public static function get($key, $default = null) {
		return (array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default);
	}

	/**
	 * @param  string $key
	 * @return bool
	 */
	public static function has($key) {
		return array_key_exists($key, $_SESSION);
	}

	/**
	 * @param string $key
	 */
	public static function remove($key) {
		unset($_SESSION[$key]);
	}
}