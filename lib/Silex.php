<?php
/**
 * @author SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @link https://silexlab.org/
 */

namespace silex;

use silex\exception\CoreException;

/**
 * Main class of Silex application
 */
class Silex
{
	const VERSION = '0.1.0-dev';

	/**
	 * Application
	 *
	 * @var Silex
	 */
	private static $app = null;

	/**
	 * ModuleLoader Object
	 *
	 * @var ModuleLoader
	 */
	private $moduleLoader = null;

	public function __construct($config)
	{
		// Initiate database
		database\Factory::init($config);

		// Initiate configuration
		Config::init();

		// Enable sessions
		session\Session::start();
	}

	public function boot()
	{
		// Load modules
		$this->moduleLoader = new ModuleLoader('lib/modules/');
		if (!$this->moduleLoader->load())
			throw new CoreException('Modules could not loaded', 1);

		// Run loaded modules
		$this->moduleLoader->run();
	}

	/**
	 * Get the ModuleLoader instance
	 *
	 * @return ModuleLoader
	 */
	public function getModules()
	{
		return $this->moduleLoader;
	}

	/**
	 * Set this app as main app, so it can be called via Silex::getApp()
	 */
	public function setAsMainApp()
	{
		self::$app = $this;
	}

	/**
	 * Get the main application
	 *
	 * @return Silex
	 */
	public static function getApp()
	{
		return self::$app;
	}

	/**
	 * A handler to catch thrown exceptions
	 *
	 * @param Exception $e
	 */
	public static function exceptionHandler(\Exception $e)
	{
		echo $e->getMessage();
		// if ($e instanceof IPrintableException) {
		// 	$e->show();
		// 	exit(1);
		// }

		// // Repack to a printable exception
		// self::exceptionHandler(new CoreException($e->getMessage(), $e->getCode(), '', $e));
	}

	/**
	 * Catches php errors and throws a system exception instead
	 *
	 * @param int $errorNo
	 * @param string $message
	 * @param string $filename
	 * @param int $lineNo
	 * @throws CoreException
	 * @return bool
	 */
	public static function errorHandler($errorNo, $message, $filename, $lineNo)
	{
		if (error_reporting() != 0) {
			$type = 'unknown error';
			switch($errorNo) {
				case E_ERROR:
				case E_USER_ERROR:
					$type = 'error';
					break;
				case E_WARNING:
				case E_USER_WARNING:
					$type = 'warning';
					break;
				case E_NOTICE:
				case E_USER_NOTICE:
					$type = 'notice';
					break;
			}
			throw new CoreException('PHP ' . $type . ' in file ' . $filename . ' (' . $lineNo . '): ' . $message, 0);

			// TODO: Implement return?
			// Don't execute PHP internal error handler
			return true;
		}
	}
}
