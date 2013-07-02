<?php
/**
 * @author    Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class UArray {
	/**
	 * Searches the array for a given value and returns the corresponding key(s) if successful
	 * @author Patrick Kleinschmidt (NoxNebula) <noxifoxi@gmail.com>
	 * @param  mixed $needle
	 * @param  array $haystack
	 * @param  bool  $strict = false
	 * @return mixed
	 */
	public static function searchAll($needle, array $haystack, $strict = false) {
		$founds = [];
		foreach($haystack as $key => $value) {
			if(!$strict && $value == $needle)
				$founds[] = $key;
			else if($strict && $value === $needle)
				$founds[] = $key;
		}
		return empty($founds) ? false : $founds;
	}
}
