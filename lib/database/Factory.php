<?php
/**
 * @author SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @link https://silexlab.org/
 */

namespace silex\database;

use silex\exception\DatabaseException;

/**
 * A factory class which find and load the database adapter
 */
class Factory
{
	/**
	 * Find and load database adapter via $config
	 * @param array $config Array which contains the database config
	 * @throws DatabaseException
	 */
	public static function init($config)
	{
		// find adapter
		$adapter = $config->database->adapter;
		if (is_file('lib/database/' . $adapter . '/Adapter.php')) {
			$class = __NAMESPACE__ . '\\' . $adapter . '\\Adapter';
			Database::init(new $class($config->database->host,
				$config->database->user,
				$config->database->password,
				$config->database->name,
				$config->database->port
				)
			);
		} else {
			throw new DatabaseException('Database adapter "' . $adapter . '" does not exist.', 1);
		}
	}
}
