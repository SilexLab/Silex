<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

/**
 * PDO wrapper for PDO statements
 */
class DatabaseStatement {
	protected $database = null;
	protected $statement = null;
	protected $query = '';
	protected $parameters = '';

	public function __construct(Database $database, PDOStatement $statement, $query = '') {
		$this->database = $database;
		$this->statement = $statement;
		$this->query = $query;
	}

	public function __get($name) {
		return $this->statement->{$name};
	}

	public function __call($name, $arguments) {
		return call_user_func([$this->statement, $name], empty($arguments) ? null : $arguments);
	}

	public function execute($parameters = []) {
		$this->parameters = $parameters;
		$this->database->incrementQueryCount();

		try {
			if(empty($parameters))
				$this->statement->execute();
			else
				$this->statement->execute($parameters);
		} catch(PDOException $e) {
			throw new DatabaseException('Could not execute prepared statement: '.$e->getMessage(), $this->database, $this);
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
	public function fetchArray() {
		return $this->statement->fetch(PDO::FETCH_ASSOC);
	}

	/**
	 * Fetch all rows
	 * @param int $type
	 * @return array
	 */
	public function fetchAllArray($type = null) {
		$return = [];
		while($row = $this->fetchArray($type)) {
			$return[] = $row;
		}
		return $return;
	}

	/**
	 * Fetch all row objects as an array
	 * @return stdClass[]
	 */
	public function fetchAllObject() {
		$objects = [];
		while($row = $this->statement->fetchObject())
			$objects[] = $row;
		return $objects;
	}

	public function getResult() {
		return $this->result;
	}

	/**
	 * @return string
	 */
	public function getQuery() {
		return $this->query;
	}

	/**
	 * Get the error message.
	 * @return string
	 */
	public function getErrorDesc() {
		if($this->statement !== null) {
			if(isset($this->statement->errorInfo()[2])) {
				return $this->statement->errorInfo()[2];
			}
		}
		return '';
	}
}
