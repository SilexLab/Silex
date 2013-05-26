<?php
/**
 * @author    Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

/**
 * PDO wrapper for prepared statements
 */
class PreparedStatement {

	/**
	 * @var Database
	 */
	protected $db = null;

	/**
	 * @var PDOStatement
	 */
	protected $pdoStatement = null;

	protected $query = '';
	protected $parameters = '';

	/**
	 * @param Database     $db
	 * @param PDOStatement $pdoStatement
	 * @param string       $query
	 */
	public function __construct(Database $db, PDOStatement $pdoStatement, $query = '') {
		$this->db = $db;
		$this->pdoStatement = $pdoStatement;
		$this->query = $query;
	}

	/**
	 * Call PDO functions
	 * @param string $name
	 * @param array  $arguments
	 * @return mixed
	 * @throws DatabaseException
	 * @throws CoreException
	 */
	public function __call($name, $arguments) {
		if(!method_exists($this->pdoStatement, $name)) {
			throw new CoreException('Unknown method \''.$name.'\'');
		}
		try {
			return call_user_func([$this->pdoStatement, $name], $arguments);
		} catch(PDOException $e) {
			throw new DatabaseException('Could not handle prepared statement: '.$e->getMessage(), $this->db, $this);
		}
	}

	/**
	 * @param array $parameters
	 * @return PreparedStatement
	 * @throws DatabaseException
	 */
	public function execute($parameters = []) {
		$this->parameters = $parameters;
		$this->db->incrementQueryCount();

		try {
			if(emptry($parameters))
				$this->pdoStatement->execute();
			else
				$this->pdoStatement->execute($parameters);
		} catch(PDOException $e) {
			throw new DatabaseException('Could not execute prepared statement: '.$e->getMessage(), $this->db, $this);
		}

		// Return this for chained method calls
		return $this;
	}

	/**
	 * Fetch the next row
	 * @param int $type
	 * @see PDOPreparedStatement::fetch()
	 * @return mixed
	 */
	public function fetchArray($type = null) {
		if($type === null)
			$type = PDO::FETCH_ASSOC;
		return $this->pdoStatement->fetch($type);
	}

	/**
	 * Fetch all rows
	 * @param int $type
	 * @return array
	 */
	public function fetchAllArray($type = null) {
		$return = [];
		while($cur = $this->fetchArray($type)) {
			$return[] = $cur;
		}
		return $return;
	}

	/**
	 * Fetch next row as object
	 * @return stdClass
	 */
	public function fetchObject() {
		$row = $this->fetchArray();
		if($row !== false)
			return (object)$row;

		return null;
	}

	/**
	 * Fetch all row objects as an array
	 * @return stdClass[]
	 */
	public function fetchAllObject() {
		$objects = [];
		while($row = $this->fetchObject()) {
			$objects[] = $row;
		}
		return $objects;
	}

	/**
	 * @return int
	 */
	public function getRowCount() {
		return $this->pdoStatement->rowCount();
	}

	/**
	 * @return string
	 */
	public function getQuery() {
		return $this->query;
	}

	/**
	 * Get the error code/number.
	 * @return int
	 */
	public function getErrorNumber() {
		if($this->pdoStatement !== null) {
			return $this->pdoStatement->errorCode();
		}
		return 0;
	}

	/**
	 * Get the error message.
	 * @return string
	 */
	public function getErrorDesc() {
		if($this->pdoStatement !== null) {
			if(isset($this->pdoStatement->errorInfo()[2])) {
				return $this->pdoStatement->errorInfo()[2];
			}
		}
		return '';
	}
}
