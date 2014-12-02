<?php
/**
 * @author SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @link https://silexlab.org/
 */

namespace silex\session;

use \silex\Config;
use \silex\database\Database as DB;
use \silex\exception\CoreException;

/**
 * A simple, unified session wrapper for common session methods
 */
class Session
{
	/**
	 * @var bool
	 */
	private static $started = false;

	/**
	 * Set session configuration and start sessions
	 *
	 * @throws CoreException
	 */
	public static function start()
	{
		if (PHP_SAPI == 'cli')
			return;

		if (self::status() === PHP_SESSION_DISABLED)
			throw new CoreException('Sessions are disabled', 1, 'You can\'t use sessions with disabled sessions!');

		// session configuration
		if (!self::$started) {
			self::$started = true;

			ini_set('session.gc_maxlifetime', Config::get('session.autologout'));
			ini_set('session.gc_probability', Config::get('session.autologout_probability'));
			ini_set('session.gc_divisor', 100);
			ini_set('session.hash_function', 1);
			register_shutdown_function('session_write_close');
			session_name(Config::get('session.name'));
			session_set_cookie_params(Config::get('session.cookie_time'), '/', null, false, true);

			// TODO: support more handler and separate database
			// session handler
			session_set_save_handler(new handler\Database(DB::getAdapter(), 'session'), true);
		}

		// start session if none exists
		if (self::status() === PHP_SESSION_NONE)
			session_start();
	}

	/**
	 * Store an item in the session
	 *
	 * @param  string $key
	 * @param  mixed  $value
	 */
	public static function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}

	/**
	 * Retrieve an item from the session or return a default value
	 *
	 * @param  string $key
	 * @param  mixed  $default optional
	 * @return mixed
	 */
	public static function get($key, $default = null)
	{
		return (isset($_SESSION[$key]) ? $_SESSION[$key] : $default);
	}

	/**
	 * Determine if an item exists in the session
	 *
	 * @param  string $key
	 * @return bool
	 */
	public static function has($key)
	{
		return isset($_SESSION[$key]);
	}

	/**
	 * Remove an item from the session
	 *
	 * @param string $key
	 */
	public static function forget($key)
	{
		unset($_SESSION[$key]);
	}

	/**
	 * Remove all items from the session
	 */
	public static function flush()
	{
		session_unset();
	}

	/**
	 * Regenerate the session ID
	 *
	 * @param  bool $deleteOldSession optional
	 * @return bool
	 */
	public static function regenerate($deleteOldSession = false)
	{
		return session_regenerate_id($deleteOldSession);
	}

	/**
	 * Get the session status
	 *
	 * @return int
	 */
	public static function status()
	{
		return session_status();
	}

	/**
	 * Destroy the session
	 */
	public static function destroy()
	{
		self::flush();
		session_destroy();
	}

	/**
	 * Destroy and start a new session
	 */
	public static function restart()
	{
		self::destroy();
		session_start();
	}
}
