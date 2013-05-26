<?php
/**
 * @author    Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
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
		if(!Silex::isDebug()) {
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
		// Logfile
		$logFilePath = DIR_ROOT.'logs/'.date('d-m-Y', TIME).'.log';
		@touch($logFilePath);

		// Check file
		if(!file_exists($logFilePath) || !is_writable($logFilePath)) {
			// Hey server admin, you need to fix this
			return '1337';
		}

		// Do we have a repacked exception?
		$e = ($this->getPrevious() ?: $this);

		// Build the message
		$text = date('r', TIME).NL.
				'Message: '.$e->getMessage().NL.
				'Description: '.$this->description.NL.
				'File: '.$e->getFile().':'.$e->getLine().NL.
				'Request URI: '.(isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '').NL.
				'Referrer: '.(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '').NL.
				'Additional information: '.NL.$this->information.NL.NL.
				'Stacktrace: '.NL.implode(NL.' ', explode("\n", $e->getTraceAsString())).NL;

		$id = StringUtil::getHash($text);
		$message = '----- '.$id.' -----'.NL.$text.'----------'.NL.NL;

		return $id;
	}

}
