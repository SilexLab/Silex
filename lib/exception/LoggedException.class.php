<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

/**
 * Exceptions being logged
 */
class LoggedException extends Exception {
	/**
	 * @var string
	 */
	protected $description = '';

	/**
	 * Additional information
	 * @var string
	 */
	protected $information = '';

	/**
	 * Hide the real message when we're not in debug mode.
	 * @see Exception::getMessage()
	 * @return string
	 */
	public function _getMessage() {

		// You're not supposed to see this, when not debugging
		if (!Silex::isDebug()) {
			return 'This is an error. Is it not supposed to be here, neither are you. Send the displayed ID to the site admin.';
		}

		// Exception to use
		$e = ($this->getPrevious() ? : $this);
		return $e->getMessage();
	}

	/**
	 * Log this exception
	 * @return string
	 */
	protected function logError() {
		// You don't need no logfile
		if (Silex::isDebug())
			return '<b>Error logging disabled</b>';

		// Logfile
		$logDir = DROOT.'logs/';
		$logFilePath = $logDir.date('Y-m-d', TIME).'.log';

		// Check if logs directory exists, if not create
		if (!is_dir($logDir))
			mkdir($logDir, 0755, true);

		@touch($logFilePath);

		// Check file
		if (!is_file($logFilePath) || !is_writable($logFilePath)) {
			// Hey server admin, you need to fix this
			return 'unable to write to logs directory';
		}

		// Do we have a repacked exception?
		$e = ($this->getPrevious() ? : $this);

		// Build the message
		$text = date('r', TIME).NL.
				'Message: '.$e->getMessage().NL.
				'Description: '.$this->description.NL.
				'File: '.$e->getFile().':'.$e->getLine().NL.
				'Request URI: '.(isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '').NL.
				'Referrer: '.(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '').NL.
				'Additional information: '.NL.$this->information.NL.NL.
				'Stacktrace: '.NL.implode(NL.' ', explode("\n", $e->getTraceAsString())).NL;

		$id = UString::getHash($text);
		$message = '----- '.$id.' -----'.NL.$text.'----------'.NL.NL;

		// actually write something to the log file
		file_put_contents($logFilePath, $message, FILE_APPEND);

		return $id;
	}
}
