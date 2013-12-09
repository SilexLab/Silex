<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

/**
 * Exceptions which can be displayed
 */
interface IPrintableException {
	/**
	 * Print this exception
	 * @return void
	 */
	public function show();
}
