<?php
/**
 * @author SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @link https://silexlab.org/
 */

namespace silex\util;

use \silex\exception\CoreException;

/**
 * Provides common array and object (which are containing data) functions
 */
class Data
{
	/**
	 * Generator to flatten a multi-dimensional associative array or object with a delimiter.
	 *
	 * @author Patrick Kleinschmidt (NoxNebula) <noxifoxi@gmail.com>
	 * @param array|object $input
	 * @param string $delimiter optional
	 * @throws CoreException
	 */
	public static function flatten($input, $delimiter = '.')
	{
		if (!is_array($input) && !is_object($input))
			throw new CoreException('The input isn\'t an array neither an object, there is nothing to flatten');
			
		foreach ($input as $key => $value) {
			if (is_array($value) || is_object($value)) {
				foreach(self::flatten($value, $delimiter) as $resultKey => $resultValue) {
					/*
					TODO: Check if there is a better way to do this, like:
					    $result = self::flatten($value, $delimiter)
					    yield $key . $delimiter . $result->key() => $result->current();
					but this obvious doesn't work w/o foreach and just returns the first key/value pair
					*/
					yield $key . $delimiter . $resultKey => $resultValue;
				}
			} else {
				yield $key => $value;
			}
		}
	}
}
