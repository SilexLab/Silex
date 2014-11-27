<?php
/**
 * @author SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @link https://silexlab.org/
 */

namespace silex\database\sqlite;

use silex\database\AdapterInterface;
use silex\database\PDOTrait;
use silex\exception\DatabaseException;

class Adapter implements AdapterInterface
{
	use PDOTrait;

	/**
	 * @var null|PDO holds the PDO instance
	 */
	protected $pdo = null;

	/**
	 * @see AdapterInterface
	 */
	public function __construct($host, $username, $password, $database, $port)
	{
		$this->checkSupport('sqlite');

		$options = [];

		try {
			$this->pdo = new \PDO('sqlite:' . $database . ';charset=utf8', $username, $password, $options);
		} catch (\PDOException $e) {
			throw new DatabaseException('Failed to connect to MySQL server "' . $host . '"', 1);
			
		}
	}

	/**
	 * @see AdapterInterface
	 */
	public function getAdapterName()
	{
		return 'sqlite';
	}
}
