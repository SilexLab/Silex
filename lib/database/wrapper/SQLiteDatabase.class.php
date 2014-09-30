<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

/**
 * MySQL PDO wrapper and driver
 */
class SQLiteDatabase extends Database {
	public function connect($host = '', $username = '', $password = '', $database = '', $port = 0) {
		// Store information
		$this->database = $database;

		// Default port
		if (!$port)
			$port = 3306;

		$dsn = 'sqlite:'.$database.';';

		try {
			// Create PDO
			$this->pdo = new PDO($dsn);
		} catch(PDOException $e) {
			throw new DatabaseException('Failed to connect to SQLite file '.$database, $this);
		}
	}

	public function exists($table, $where) {
		return (bool)$this->query('SELECT 1 FROM `'.$table.'` WHERE '.$where.' LIMIT 1')->rowCount();
	}

	// database information

	public function isSupported() {
		return (extension_loaded('PDO') && extension_loaded('pdo_sqlite'));
	}

	public function getID() {
		return 'sqlite';
	}
}
