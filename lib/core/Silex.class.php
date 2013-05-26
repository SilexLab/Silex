<?php
/**
 * @author    Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

/**
 * One class to rule them all
 */
class Silex {

	/**
	 * @var Database
	 */
	protected static $db = null;

	/**
	 * Start Silex up!
	 */
	public final function __construct() {
		$this->initDb();
	}

	private final function initDb() {
		// Read config file
		if(!file_exists(DIR_LIB.'config.inc.php'))
			throw new CoreException('Y U HAVE NO CONFIG FILE?!', 0, 'Your config file can\'t be found. ');

		// Default values
		$dbHost = $dbUser = $dbPassword = $dbClass = $dbName = '';
		$dbPort = 0;
		require_once DIR_LIB.'config.inc.php';

		self::$db = new $dbClass($dbHost, $dbUser, $dbPassword, $dbName, $dbPort);

		if(!(self::$db instanceof Database) || !self::$db->isSupported()) {
			throw new CoreException('Failed to create a database object.', 0, 'Failed to create the database object. Either there was a connection error or the DB type isn\'t supported.');
		}

	}
	
	/**
	 * @return bool
	 */
	public final static function isDebug() {
		return DEBUG;
	}

	/**
	 * Handle our Exceptions
	 * @param Exception $e
	 */
	public static final function handleException(Exception $e) {
		if($e instanceof IPrintableException) {
			$e->show();
			exit;
		}

		// Repack Exception
		self::handleException(new CoreException($e->getMessage(), $e->getCode(), '', $e));
	}

	/**
	 * Catches php errors and throws instead a system exceptions
	 * @param integer $errorNo
	 * @param string $message
	 * @param string $filename
	 * @param integer $lineNo
	 * @throws CoreException
	 */
	public static final function handleError($errorNo, $message, $filename, $lineNo) {
		if(error_reporting() != 0) {
			$type = 'errors';
			switch($errorNo) {
				case 2:
					$type = 'warning';
					break;
				case 8:
					$type = 'notice';
					break;
			}
			throw new CoreException('PHP '.$type.' in file '.$filename.' ('.$lineNo.'): '.$message, 0);
		}
	}
}
