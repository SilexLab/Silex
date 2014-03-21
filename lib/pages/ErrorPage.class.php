<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class ErrorPage extends Page {
	protected $errorCode;

	/**
	 * Get the pages short name. Has to be unique
	 * @return string
	 */
	public function getName() {
		return 'error';
	}

	/**
	 * Get the full page title
	 * @return string
	 */
	public function getTitle() {
		return 'Error '.$this->errorCode;
	}

	/**
	 * Get the file name of the page's template
	 * @return string
	 */
	public function getTemplateName() {
		return 'pages/error.tpl';
	}

	/**
	 * Prepare the page for display
	 * @return void
	 */
	public function prepare() {
		$this->errorCode = 404;

		Silex::getTemplate()->assign(['error' => [
			'code' => $this->errorCode
		]]);
	}
}
