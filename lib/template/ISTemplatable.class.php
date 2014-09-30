<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

interface ISTemplatable {
	/**
	 * Return an array suitable for assignment in an template variable
	 * @return array
	 */
	public static function assignTemplate();
}
