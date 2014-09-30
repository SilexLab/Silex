<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

/**
 * MySQL PDO wrapper and driver
 */
class MySQLDatabase extends Database {
	public function connect($host = '', $username = '', $password = '', $database = '', $port = 0) {
		if (!$port) $port = 3306;
		$this->database = $database;

		$options = [
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		];

		try {
			$this->pdo = new PDO('mysql:host='.$host.';port='.$port.';dbname='.$database.';charset=utf8', $username, $password, $options);
		} catch(PDOException $e) {
			throw new DatabaseException('Failed to connect to MySQL server '.$host, $this);
		}
	}

	public function exists($table, $where) {
		return (bool)$this->query('SELECT 1 FROM `'.$table.'` WHERE '.$where.' LIMIT 1')->rowCount();
	}

	// database information

	public function isSupported() {
		return (extension_loaded('PDO') && extension_loaded('pdo_mysql'));
	}

	public function getID() {
		return 'mysql';
	}
}
