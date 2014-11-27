<?php
/**
 * @author SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @link https://silexlab.org/
 */

namespace silex;

use silex\database\Database as DB;
use silex\exception\CoreException;

class Config
{
	/**
	 * @var array $config
	 */
	private static $config = [];

	/**
	 * Fetch the configuration from database
	 */
	public static function init()
	{
		// TODO: cache
		// self::$config = Cache::_(function() {
		// 	$res = DB::query('SELECT * FROM `config`');
		// 	while ($row = $res->fetchObject()) {
		// 		$value = $row->value;
		// 		$type = $row->type;
		// 		self::castValue($row->option, $value, $type);

		// 		self::$config[$row->option] = $value;
		// 	}
		// 	return self::$config;
		// }, 'config');

		$res = DB::query('SELECT * FROM `config`');
		while ($row = $res->fetchObject()) {
			$value = $row->value;
			$type = $row->type;

			// castValue isn't really nessasary and makes the load ~0.1 - 1 ms longer
			// remove this later maybe
			// self::castValue($row->option, $value, $type);

			self::$config[$row->option] = $value;
		}
	}

	/**
	 * Get the value of an option
	 *
	 * @param  string $node
	 * @return mixed
	 */
	public static function get($node)
	{
		return array_key_exists($node, self::$config) ? self::$config[$node] : null;
	}

	/**
	 * Set the value of an option
	 *
	 * @param  string $node
	 * @param  mixed  $value
	 * @return null
	 */
	public static function set($node, $value)
	{
		if (defined('ACP')) {
			// TODO: Set the value
		}
		return null;
	}

	// public static function remove($node) {
	// 	if (is_array($node))
	// 		UArray::removeElements(self::$config, $node);
	// 	else if (isset(self::$config[$node]))
	// 		unset(self::$config[$node]);
	// 	else
	// 		return false;
	// 	return true;
	// }

	/**
	 * Export the loaded configuration in the JSON format
	 *
	 * @return string
	 */
	public static function export()
	{
		// TODO: node am . auftrennen und in json umwandeln:
		/*
		"foo.bar.baz" => "asdf", "foo.bar.zab" => "zab", "foo.baz.bar" => "bar", "baz.foo.bar" => "foo"
		=>
		{
			"foo": {
				"bar": {
					"baz": "asdf"
				}
			}
		}
		*/
	}

	/**
	 * Formates the value and returns the right type
	 *
	 * @param string    $node
	 * @param mixed     $value
	 * @param           $type
	 * @throws CoreException
	 */
	private static function castValue($node, &$value, &$type)
	{
		preg_match('/^[a-zA-Z]+/', $type, $match);
		switch ($match[0]) {
			case 'string':
				$value = (string)$value;
				if (defined('ACP'))
					$type = self::parseType($type, true);
				break;
			case 'int':
				$value = (int)$value;
				if (defined('ACP'))
					$type = self::parseType($type);
				break;
			case 'float':
				$value = (float)$value;
				if (defined('ACP'))
					$type = self::parseType($type);
				break;
			case 'bool':
				$value = in_array($value, ['1', 'true']);
				break;
			default:
				throw new CoreException('The type ('.self::$config[$node]['Type'].') of the node "'.$node.'" is not a valid type.');
		}
	}

	/**
	 * Parse length or range
	 * @param           $type
	 * @param bool      $onlyLength optional
	 */
	private static function parseType(&$type, $onlyLength = false)
	{
		if (!$onlyLength && preg_match('/(\-{0,1}[0-9]+(\.[0-9]+){0,1}){0,1}\|(\-{0,1}[0-9]+(\.[0-9]+){0,1}){0,1}/', $type, $range)) {
			// Range
			$range = $range[0];
			$aR = explode('|', $range);
			if (isset($aR[0]) && !empty($aR[0]) && isset($aR[1]) && !empty($aR[1])) {
				// Range
				if ($aR[0] < $aR[1]) {
					$type = ['range' => ['min' => (int)$aR[0], 'max' => (int)$aR[1]]];
				}
			} else if (isset($aR[0]) && !empty($aR[0])){ // Min
				$type = ['range' => ['min' => (int)$aR[0]]];
			} else { // Max
				$type = ['range' => ['max' => (int)$aR[1]]];
			}
		} else if (preg_match('/[0-9]+/', $type, $length)) {
			// Length
			$type = ['length' => $length];
		}
	}
}
