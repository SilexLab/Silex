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
	 * Compares two version with each other
	 *
	 * Return values:
	 *  0 - $version1 < $version2
	 *  1 - $version1 > $version2
	 * -1 - $version1 == $version2
	 *
	 * @param string $version1
	 * @param string $version2
	 * @param string $operator
	 * @return int|bool
	 */
	public static function compare($version1, $version2, $operator = '')
	{
		if ($operator)
			return self::handleOperator($version1, $version2, $operator);

		$state1 = preg_replace('/^[0-9]+(\.[0-9]+)+-(.*)/', '$2', $version1);
		$state2 = preg_replace('/^[0-9]+(\.[0-9]+)+-(.*)/', '$2', $version2);

		$v1 = explode('.', preg_replace('/^([0-9]+(\.[0-9]+)+)/', '$1', $version1));
		$v2 = explode('.', preg_replace('/^([0-9]+(\.[0-9]+)+)/', '$1', $version2));

		for ($i = 0; $i < count($v1); $i++) {
			if (!isset($v2[$i]))
				$v2[$i] = 0;

			if ($v1[$i] == $v2[$i])
				continue;

			return (int)($v1[$i] > $v2[$i]);
		}

		if ($state1 != $version1 && $state2 != $version2 && $state1 != $state2) {
			$p1 = self::getHeight($state1);
			$p2 = self::getHeight($state2);

			if ($p1 > $p2)
				return (int)($p1 > $p2);

			if ($state1 > $state2)
				return (int)($state1 > $state2);
		}

		return -1;
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
	private static function handleOperator($version1, $version2, $operator)
	{
		$result = self::compare($version1, $version2);

		switch ($operator) {
			case '==':
				return $result == -1;
			case '<':
				return $result === 0;
			case '>':
				return $result === 1;
			case '<=':
				return $result == -1 || $result === 0;
			case '>=':
				return $result == -1 || $result === 1;
			case '!=':
				return $result != -1;
			
			default:
				return null;
		}
	}

	/**
	 * Gets the height of the release state
	 *
	 * @param string &$state
	 * @return int
	 */
	private static function getHeight(&$state)
	{
		preg_match('/([a-z]+)([0-9]*)/', strtolower($state), $match);
		$state = (int)$match[1];

		switch ($match[0]) {
			case 'dev':
				return -4;
			case 'a':
			case 'alpha':
				return -3;
			case 'b':
			case 'beta':
				return -2;
			case 'pre':
				return -1;
			default:
				return 0;
		}
	}
}
