<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */
 
/**
 * $_POST stuff
 */
class HTTPPost {
	public static function get($key) {
		return isset($_POST[$key]) ? $_POST[$key] : false;
	}

	public static function delete($key) {
		$_POST[$key] = null;
		unset($_POST[$key]);
	}
}
