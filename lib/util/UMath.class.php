<?php
/**
 * @author    Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class UMath {
	/**
	 * clamp the value
	 * @author Patrick Kleinschmidt (NoxNebula) <noxifoxi@gmail.com>
	 * @param mixed $value
	 * @param int $min
	 * @param int $max
	 * @return mixed
	 */
	public static function clamp($value, $min, $max) {
		return max(min($value, $max), $min);
	}
}
