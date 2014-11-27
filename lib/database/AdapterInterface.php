<?php
/**
 * @author SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @link https://silexlab.org/
 */

namespace silex\database;

interface AdapterInterface
{
	/**
	 * Connects to the database via PDO
	 *
	 * @var string $host If empty use localhost
	 * @var string $username
	 * @var string $password
	 * @var string $database
	 * @var int $port If 0 use default port
	 * @throws DatabaseException
	 */
	public function __construct($host, $username, $password, $database, $port);

	/**
	 * Returns the Adapter name
	 *
	 * @return string
	 */
	public function getAdapterName();

	/* PDO methods */
	public function beginTransaction();
	public function commit();
	public function errorCode();
	public function errorInfo();
	public function exec($statement);
	public function getAttribute($attribute);
	public function inTransaction();
	public function lastInsertId($name = null);
	public function prepare($statement, array $driverOptions = []);
	public function query($statement);
	public function quote($string, $parameterType = \PDO::PARAM_STR);
	public function rollBack();
	public function setAttribute($attribute, $value);
}
