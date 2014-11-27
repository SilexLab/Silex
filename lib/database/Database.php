<?php
/**
 * @author SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @link https://silexlab.org/
 */

namespace silex\database;

/**
 * Static wrapper for database adapter
 */
class Database
{
	/**
	 * @var null|DatabaseInterface Holds the database adapter object passed by init(...)
	 */
	protected static $db = null;

	public static function init(AdapterInterface $database)
	{
		self::$db = $database;
	}

	public static function __callStatic($name, $arguments)
	{
		return self::$db->{$name}(...$arguments);
	}
}
