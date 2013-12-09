<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

/**
 * MySQL PDO wrapper and driver
 */
class MySQLDatabase extends Database {
	/**
	 * Connect to the SQL server
	 * @throws DatabaseException
	 * @return void
	 */
	public function connect() {
		// Default port
		if(!$this->port)
			$this->port = 3306;

		$dsn = 'mysql:host='.$this->host.';port='.$this->port.';dbname='.$this->database.';';
		$options = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'];

		try {
			// Create PDO
			$this->pdo = new PDO($dsn, $this->username, $this->password, $options);
		} catch(PDOException $e) {
			throw new DatabaseException('Failed to connect to MySQL server '.$this->host, $this);
		}
	}

	/**
	 * Is this database type supported?
	 * @return bool
	 */
	public function isSupported() {
		return (extension_loaded('PDO') && extension_loaded('pdo_mysql'));
	}

	/**
	 * What's the id of the wrapper?
	 * @return string
	 */
	public function getID() {
		return 'mysql';
	}
}
