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
	protected static $db = null;
	protected static $config = null;
	protected static $modules = null;

	/**
	 * Start Silex up!
	 */
	public final function __construct() {
		// Read config file
		if(!is_file(DIR_LIB.'config.inc.php'))
			throw new CoreException('Y U NO HAVE A CONFIG FILE?!', 0, 'Your config file can\'t be found.');
		$config = require_once DIR_LIB.'config.inc.php';

		self::$db = DatabaseFactory::initDatabase(
			$config['database.wrapper'],
			$config['database.host'],
			$config['database.user'],
			$config['database.password'],
			$config['database.name'],
			$config['database.port']);
		self::$config = new Config($config);

		// Set default timezone
		date_default_timezone_set(self::$config->get('time.timezone')); // TODO: prefer user settings

		// Modules
		self::$modules = new Modules(DIR_LIB.'modules/');
		Event::fire('silex.construct.before_modules_register');
		self::$modules->register();
		Event::fire('silex.construct.after_modules_register');

		Event::fire('silex.construct.end');
	}

	/**
	 * Call module provided methods
	 * @return mixed
	 */
	public static final function __callStatic($name, $args) {
		return self::$modules->callMethod($name, $args);
	}

	/**
	 * Handle our Exceptions
	 * @param Exception $e
	 */
	public static final function handleException(Exception $e) {
		if($e instanceof IPrintableException) {
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

	/**
	 * Access to database instance
	 * @return Database
	 */
	public static final function getDB() {
		return self::$db;
	}

	/**
	 * Get the config instance
	 * @return Config
	 */
	public static final function getConfig() {
		//return self::$config->get($node);
		return self::$config;
	}

	/**
	 * @return Language
	 */
	public static final function getLanguage() {
		// TODO: Which language does he/she/it want?
		return LanguageFactory::getDefaultLanguage();
	}

	/**
	 * @return Modules
	 */
	public static final function getModule() {
		return self::$modules;
	}

	/**
	 * @return bool
	 */
	public static final function isDebug() {
		return DEBUG;
	}
}
