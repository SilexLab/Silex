<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

/**
 * PDO wrapper. Super class, will be extended by driver specific subclasses
 */
abstract class Database {
	protected $database;
	protected $queryCount;

	// PDO object
	protected $pdo = null;

	/**
	 * @param string $host     SQL server's host name/IP
	 * @param string $username User name for login
	 * @param string $password Password for the user
	 * @param string $database Database name
	 * @param int    $port     Port number
	 */
	public function __construct() {}

	public function __get($name) {
		return $this->pdo->{$name};
	}

	public function __call($name, $arguments) {
		return call_user_func_array([$this->pdo, $name], empty($arguments) ? null : $arguments);
	}

	abstract public function connect($host = '', $username = '', $password = '', $database = '', $port = 0);

	public function query($query) {
		try {
			$pdoStatement = $this->pdo->query($query);
			$this->incrementQueryCount();
			if ($pdoStatement instanceof PDOStatement)
			 	return new DatabaseStatement($this, $pdoStatement, $query);
		} catch(PDOException $e) {
			throw new DatabaseException('Failed to execute query.', $this);
		}
	}

	public function prepare($query) {
		try {
			$pdoStatement = $this->pdo->prepare($query);
			if ($pdoStatement instanceof PDOStatement)
			 	return new DatabaseStatement($this, $pdoStatement, $query);
		} catch(PDOException $e) {
			throw new DatabaseException('Failed to prepare statement.', $this);
		}
	}

	abstract public function exists($table, $where);

	// database information

	abstract public function isSupported();

	abstract public function getID();
	
	public function getType() {
		return get_class($this);
	}

	public function getVersion() {
		try {
			if ($this->pdo !== null) {
				return $this->pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
			}
		} catch(PDOException $e) {}
		return 'unknown';
	}

	public function getErrorDesc() {
		if ($this->pdo !== null) {
			if (isset($this->pdo->errorInfo()[2]))
				return $this->pdo->errorInfo()[2];
		}
		return '';
	}

	public function getDatabase() {
		return $this->database;
	}

	public function getQueryCount() {
		return $this->queryCount;
	}

	public function incrementQueryCount() {
		$this->queryCount++;
	}
}
