<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
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
