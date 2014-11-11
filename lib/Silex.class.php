<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

/**
 * One class to rule them all
 */
class Silex {
	const VERSION = '0.1.0-DEV';

	protected static $db = null;

	/**
	 * Start Silex up!
	 */
	public final function __construct() {
		if (!defined('CLASS_SILEX')) {
			define('CLASS_SILEX', 1);

			// Get config file
			if (!is_file(Dir::LIB.'config.inc.php'))
				throw new CoreException('Y U NO HAVE A CONFIG FILE?!', 0, 'Your config file can\'t be found.');
			$config = require_once Dir::LIB.'config.inc.php';

			// Connect to the database
			self::$db = DatabaseFactory::initDatabase(
				$config['database.wrapper'],
				$config['database.host'],
				$config['database.user'],
				$config['database.password'],
				$config['database.name'],
				$config['database.port']);
			// Unset $config for security reasons
			unset($config);

			// Load the config
			Config::init();

			// Set default timezone // TODO: prefer user settings
			date_default_timezone_set(Config::get('time.timezone'));

			// Registering modules
			Modules::init(Dir::LIB.'module/modules/');
			Modules::register();

			// That's it
			Event::fire('silex.construct.end');
		}
	}

	/**
	 * Call module provided methods
	 * @return mixed
	 */
	public static final function __callStatic($name, $args) {
		return Modules::callMethod($name, $args);
	}

	/**
	 * Handle our Exceptions
	 * @param Exception $e
	 */
	public static final function handleException(Exception $e) {
		if ($e instanceof IPrintableException) {
			$e->show();
			exit(1);
		}

		// Repack Exception
		self::handleException(new CoreException($e->getMessage(), $e->getCode(), '', $e));
	}

	/**
	 * Catches php errors and throws instead a system exceptions
	 * @param integer $errorNo
	 * @param string  $message
	 * @param string  $filename
	 * @param integer $lineNo
	 * @throws CoreException
	 */
	public static final function handleError($errorNo, $message, $filename, $lineNo) {
		if (error_reporting() != 0) {
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

	/**
	 * Access to database instance
	 * @return Database
	 */
	public static final function getDB() {
		return self::$db;
	}

	/**
	 * @return bool
	 */
	public static final function isDebug() {
		return DEBUG;
	}
}
