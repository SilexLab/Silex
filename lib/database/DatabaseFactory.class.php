<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

/**
 * PDO Factory
 */
class DatabaseFactory {
	/**
	 * @var array $databaseWrapper
	 */
	private static $databaseWrapper = [];

	/**
	 * Handle database wrappers
	 * @param  string $dbWrapper
	 * @param  string $dbHost
	 * @param  string $dbUser
	 * @param  string $dbPassword
	 * @param  string $dbName
	 * @param  int    $dbPort
	 * @return Database
	 */
	public static function initDatabase($dbWrapper, $dbHost, $dbUser, $dbPassword, $dbName, $dbPort) {
		if (!defined('CLASS_DATABASE_FACTORY')) {
			define('CLASS_DATABASE_FACTORY', true);
			// Find available wrappers
			foreach (scandir(Dir::LIB.'database/wrapper/') as $wrapper) {
				if (is_file(Dir::LIB.'database/wrapper/'.$wrapper) && preg_match('/^(([a-zA-Z0-9]+)Database).class.php$/', $wrapper, $databaseMatch)) {
					$class = $databaseMatch[1];
					$db = new $class();
					if ($db instanceof Database)
						self::$databaseWrapper[$db->getID()] = $db;
	
					// Clear object
					unset($db);
				}
			}
		}

		// Check wrapper
		if (!isset(self::$databaseWrapper[$dbWrapper]))
			throw new CoreException('Database wrapper not supported', 0, 'The database wrapper "'.$dbWrapper.'" isn\'t supported.');
		
		// Connect to database
		$db = self::$databaseWrapper[$dbWrapper];
		$db->connect($dbHost, $dbUser, $dbPassword, $dbName, $dbPort);

		// Does it work?
		if (!($db instanceof Database) || !$db->isSupported())
			throw new CoreException('Failed to create a database object.', 0, 'Failed to create the database object. Either there was a connection error or the DB type isn\'t supported.');

		// Clear all instances
		self::$databaseWrapper = [];

		return $db;
	}
}
