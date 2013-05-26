<?php
/**
 * @author    Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

/**
 * PDO Wrapper. Super class, will be extended by driver specific subclasses
 */
abstract class Database {

	protected $username = '';
	protected $password = '';
	protected $host = '';
	protected $port = 0;
	protected $database = '';
	protected $queryCount = 0;

	/**
	 * @var PDO
	 */
	protected $pdo = null;

	/**
	 * @param string $host     SQL server's host name/IP
	 * @param string $username User name for login
	 * @param string $password Password for the user
	 * @param string $database Database name
	 * @param int    $port     Port number
	 */
	public function __construct($host = '', $username = '', $password = '', $database = '', $port = 0) {
		// Store
		$this->host = $host;
		$this->username = $username;
		$this->password = $password;
		$this->database = $database;
		$this->port = $port;

		$this->connect();
	}

	/**
	 * Connect to the SQL server
	 * @return void
	 */
	abstract public function connect();

	/**
	 * Is this database type supported?
	 * @return bool
	 */
	abstract public function isSupported();

	/**
	 * Get the ID of the last inserted row
	 */
	public function getInsertedID() {
		try {
			return $this->pdo->lastInsertId();
		} catch(PDOException $e) {
			throw new DatabaseException('Failed to fetch last inserted ID.', $this);
		}
	}

	/**
	 * @param string $query
	 * @return PreparedStatement
	 * @throws DatabaseException
	 */
	public function prepare($query) {
		try {
			$pdoStatement = $this->pdo->prepare($query);
			if($pdoStatement instanceof PDOStatement) {
				return new PreparedStatement($this, $pdoStatement, $query);
			}
		} catch(PDOException $e) {
			throw new DatabaseException('Failed to prepare statement.', $this);
		}
	}

	/**
	 * @param $query
	 * @return PreparedStatement
	 * @throws DatabaseException
	 */
	public function query($query) {
		try {
			$pdoStatement = $this->pdo->query($query);
			$this->incrementQueryCount();
			if($pdoStatement instanceof PDOStatement) {
				return new PreparedStatement($this, $pdoStatement, $query);
			}
		} catch(PDOException $e) {
			throw new DatabaseException('Failed to execute query.', $this);
		}
	}

	/**
	 * @return string
	 */
	public function getDbType() {
		return get_class($this);
	}

	/**
	 * @return string
	 */
	public function getVersion() {
		try {
			if($this->pdo !== null) {
				return $this->pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
			}
		} catch(PDOException $e) {
			// Just return 'unknown'
		}
		return 'unknown';
	}

	/**
	 * Returns the number of the last error.
	 * @return int
	 */
	public function getErrorNumber() {
		if($this->pdo !== null) {
			return $this->pdo->errorCode();
		}
		return 0;
	}

	/**
	 * Returns the description of the last error.
	 * @return string
	 */
	public function getErrorDesc() {
		if($this->pdo !== null) {
			if(isset($this->pdo->errorInfo()[2]))
				return $this->pdo->errorInfo()[2];
		}
		return '';
	}

	/**
	 * @return string
	 */
	public function getDatabase() {
		return $this->database;
	}

	/**
	 * @return int
	 */
	public function getQueryCount() {
		return $this->queryCount;
	}

	/**
	 * @return string
	 */
	public function getUsername() {
		return $this->username;
	}

	public function incrementQureyCount() {
		$this->queryCount++;
	}
}
