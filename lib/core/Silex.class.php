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
	public final function __construct() {
		// Initialize everything
	}
	
	/**
	 * @return bool
	 */
	public final static function isDebug() {
		return true; // TODO: Read from config or elsewhere
	}

	/**
	 * Handle our Exceptions
	 * @param \Exception $e
	 */
	public static final function handleException(\Exception $e) {
		if($e instanceof CoreException) {
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
