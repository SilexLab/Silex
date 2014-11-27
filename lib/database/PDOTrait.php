<?php
/**
 * @author SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @link https://silexlab.org/
 */

namespace silex\database;

/**
 * standard PDO methods for AdapterInterface implementing classes
 * @see http://php.net/manual/en/class.pdo.php
 */
trait PDOTrait
{
	/**
	 * Checking the PDO support of the given adapter
	 *
	 * @throws DatabaseException
	 */
	private function checkSupport($adapter) {
		if (!extension_loaded('PDO'))
			throw new DatabaseException('The PDO extension isn\'t loaded', 1);
			
		if (!extension_loaded('pdo_' . $adapter))
			throw new DatabaseException('The PDO driver "pdo_' . $adapter . '" is not installed or enabled', 1);
	}

	/* PDO methods */

	/**
	 * @return bool
	 */
	public function beginTransaction()
	{
		return $this->pdo->beginTransaction();
	}

	/**
	 * @return bool
	 */
	public function commit()
	{
		return $this->pdo->commit();
	}

	/**
	 * @return mixed
	 */
	public function errorCode()
	{
		return $this->pdo->errorCode();
	}

	/**
	 * @return array
	 */
	public function errorInfo()
	{
		return $this->pdo->errorInfo();
	}

	/**
	 * @param string $statement
	 * @return int
	 */
	public function exec($statement)
	{
		return $this->pdo->exec($statement);
	}

	/**
	 * @param int $attribute
	 * @return mixed
	 */
	public function getAttribute($attribute)
	{
		return $this->pdo->getAttribute($attribute);
	}

	/**
	 * @return bool
	 */
	public function inTransaction()
	{
		return $this->pdo->inTransaction();
	}

	/**
	 * @param string $name optional
	 * @return string
	 */
	public function lastInsertId($name = null)
	{
		return $this->pdo->lastInsertId($name);
	}

	/**
	 * @param string $statement
	 * @param array $driverOptions optional
	 * @return PDOStatement
	 */
	public function prepare($statement, array $driverOptions = [])
	{
		return $this->pdo->prepare($statement, $driverOptions);
	}

	/**
	 * @param string $statement
	 * @return PDOStatement
	 */
	public function query($statement)
	{
		return $this->pdo->query($statement);
	}

	/**
	 * @param string $string
	 * @param int $parameterType
	 * @return string
	 */
	public function quote($string, $parameterType = \PDO::PARAM_STR)
	{
		return $this->pdo->quote($string, $parameterType);
	}

	/**
	 * @return bool
	 */
	public function rollBack()
	{
		return $this->pdo->rollBack();
	}

	/**
	 * @param int $attribute
	 * @param mixed $value
	 * @return bool
	 */
	public function setAttribute($attribute, $value)
	{
		return $this->pdo->setAttribute($attribute, $value);
	}
}
