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
 * Main library of Silex
 */
class Silex
{
	const VERSION = '0.1.0-dev';

	/**
	 * Deprechated
	 */
	public static function init()
	{
		//
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
	 * Catches php errors and throws instead a system exception
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
