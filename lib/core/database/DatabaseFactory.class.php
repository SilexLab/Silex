<?php
/**
 * @author    Patrick Kleinschmidt (NoxNebula) <noxifoxi@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

/**
 * PDO Factory
 */
class DatabaseFactory {
	private static $databaseWrapper = [
		'mysql' => 'MySQLDatabase'
	];

	/**
	 * Create a new database
	 */
	public static function initDatabase($dbWrapper, $dbHost, $dbUser, $dbPassword, $dbName, $dbPort) {
		if(!isset(self::$databaseWrapper[$dbWrapper]))
			throw new CoreException('Database wrapper not supported', 0, 'The database wrapper "'.$dbWrapper.'" isn\'t supported.');
			
		$db = new self::$databaseWrapper[$dbWrapper]($dbHost, $dbUser, $dbPassword, $dbName, $dbPort);

		if(!($db instanceof Database) || !$db->isSupported())
			throw new CoreException('Failed to create a database object.', 0, 'Failed to create the database object. Either there was a connection error or the DB type isn\'t supported.');

		return $db;
	}
}
