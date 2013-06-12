<?php
/**
 * @author    Patrick Kleinschmidt (NoxNebula) <noxifoxi@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

/**
 * a simple, unified session wrapper for common session methods
 */
class Session {
	public static function start() {
		if(self::status() === PHP_SESSION_DISABLED)
			throw new CoreException('Sessions are disabled', 1, 'You can\'t use sessions with disabled sessions!');

		// session configuration
		if(!defined('SILEX_SESSION')) {
			define('SILEX_SESSION', true);

			ini_set('session.gc_maxlifetime', Silex::getConfig()->get('session.autologout'));
			ini_set('session.gc_probability', Silex::getConfig()->get('session.autologout_probability'));
			ini_set('session.gc_divisor', 100);
			ini_set('session.hash_function', 1);
			register_shutdown_function('session_write_close');
			session_name(Silex::getConfig()->get('session.name'));
			session_set_cookie_params(Silex::getConfig()->get('session.cookie_time'), '/', null, false, true);

			// session handler | TODO: support more
			session_set_save_handler(new SessionDatabaseHandler(Silex::getDB(), 'session'), true);
		}

		// start session if none exists
		if(self::status() === PHP_SESSION_NONE)
			session_start();
	}

	/**
	 * store an item in the session
	 * @param  string $key
	 * @param  mixed  $value
	 */
	public static function set($key, $value) {
		$_SESSION[$key] = $value;
	}

	/**
	 * retrieve an item from the session or return a default value
	 * @param  string $key
	 * @param  mixed  $default optional
	 * @return mixed
	 */
	public static function get($key, $default = null) {
		return (isset($_SESSION[$key]) ? $_SESSION[$key] : $default);
	}

	/**
	 * determine if an item exists in the session
	 * @param  string $key
	 * @return bool
	 */
	public static function has($key) {
		return isset($_SESSION[$key]);
	}

	/**
	 * remove an item from the session
	 * @param string $key
	 */
	public static function forget($key) {
		unset($_SESSION[$key]);
	}

	/**
	 * remove all items from the session
	 */
	public static function flush() {
		session_unset();
	}

	/**
	 * regenerate the session ID
	 * @param  bool $deleteOldSession optional
	 * @return bool
	 */
	public static function regenerate($deleteOldSession = false) {
		return session_regenerate_id($deleteOldSession);
	}

	/**
	 * get the session status
	 * @return int
	 */
	public static function status() {
		return session_status();
	}

	/**
	 * destroy the session
	 */
	public static function destroy() {
		self::flush();
		session_destroy();
	}

	/**
	 * destroy and start a new session
	 */
	public static function restart() {
		self::destroy();
		session_start();
	}
}
