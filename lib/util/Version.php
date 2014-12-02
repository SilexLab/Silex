<?php
/**
 * @author SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @link https://silexlab.org/
 */

namespace silex\util;

/**
 * Simple class to provide version comparing
 */
class Version
{
	/**
	 * RegeX Replace A-Z
	 */
	const RX_R_AZ = '/\.?([a-z]+)\.?/i';

	/**
	 * String Replace To Period
	 */
	const S_R_TP = ['_', '-', '+'];

	/**
	 * Compares two version with each other
	 *
	 * Return values:
	 * -1 - $version1 < $version2
	 *  0 - $version1 = $version2
	 *  1 - $version1 > $version2
	 *
	 * @param string $version1
	 * @param string $version2
	 * @param string $operator
	 * @return int|bool
	 */
	public static function compare($version1, $version2, $operator = '')
	{
		// If operator is given, handle it
		if ($operator)
			return self::handleOperator($version1, $version2, $operator);

		// Explode version1 on .
		$v1 = explode(
			'.',
			// Pre- and append . to not numeric stuff
			preg_replace(
				self::RX_R_AZ,
				'.$1.',
				// Replace strings in S_R_TP with .
				str_replace(self::S_R_TP, '.', $version1)
			)
		);

		// Same as above for version2
		$v2 = explode(
			'.',
			preg_replace(
				self::RX_R_AZ,
				'.$1.',
				str_replace(self::S_R_TP, '.', $version2)
			)
		);

		// Check
		for ($i = 0; $i < max(count($v1), count($v2)); $i++) {
			// If the provided version string is shorter than the other fill missing entries with zeros
			if (!isset($v1[$i]))
				$v1[$i] = 0;
			if (!isset($v2[$i]))
				$v2[$i] = 0;

			// Continue if this part is equal
			if (self::convert($v1[$i]) == self::convert($v2[$i]))
				continue;

			// Version is different
			return (self::convert($v1[$i]) > self::convert($v2[$i])) ? 1 : -1;
		}

		// Version is equal
		return 0;
	}

	/**
	 * Gets the height of the version part
	 *
	 * @param string $v
	 * @return int
	 */
	protected static function convert($v)
	{
		if (is_numeric($v))
			return $v;

		switch ($v) {
			case 'dev':
				return -4;
			case 'a':
			case 'alpha':
				return -3;
			case 'b':
			case 'beta':
				return -2;
			case 'pre':
			case 'rc':
				return -1;
			default:
				return 0;
		}
	}

	/**
	 * Compares two version with each other via operator
	 *
	 * Return values:
	 * true - operator match
	 * false - operator dismatch
	 *
	 * @param string $version1
	 * @param string $version2
	 * @param string $operator
	 * @return bool
	 */
	protected static function handleOperator($version1, $version2, $operator)
	{
		$result = self::compare($version1, $version2);

		switch ($operator) {
			case '=':
			case '==':
			case 'eq':
				return $result == 0;
			case '<':
			case 'lt':
				return $result === -1;
			case '>':
			case 'gt':
				return $result === 1;
			case '<=':
			case 'le':
				return $result == -1 || $result === 0;
			case '>=':
			case 'ge':
				return $result === 1 || $result === 0;
			case '!=':
			case '<>':
			case 'ne':
				return $result != 0;
			
			default:
				return null;
		}
	}
}
