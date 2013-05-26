<?php
/**
 * @author    Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */
 

/**
 * Utility methods for strings
 */
class StringUtil {

	/**
	 * We use SHA1
	 * @param string $string
	 * @return string Hash
	 */
	public static function getHash($string) {
		return sha1($string);
	}

	/**
	 * Convert special HTML chars
	 * @param string $string
	 * @return string
	 */
	public static function encodeHtml($string) {
		return @htmlspecialchars($string, ENT_COMPAT, 'UTF-8');
	}

}
