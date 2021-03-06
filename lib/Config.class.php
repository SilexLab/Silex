<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

/**
 * Class for configuration stuff
 */
class Config {
	/**
	 * @var array $config
	 */
	private static $config = [];

	/**
	 * Get the config
	 * @param array $config optional
	 */
	public static function init() {
		self::$config = Cache::_(function() {
			$res = Silex::getDB()->query('SELECT * FROM `config`');
			while ($row = $res->fetchObject()) {
				$value = $row->value;
				$type = $row->type;
				self::formatValue($row->option, $value, $type);

				self::$config[$row->option] = $value;
			}
			return self::$config;
		}, 'config');
	}

	/**
	 * Get the value of a config option
	 * @param  string $node
	 * @return mixed
	 */
	public static function get($node) {
		return array_key_exists($node, self::$config) ? self::$config[$node] : null;
	}

	/**
	 * Set the value of a config option
	 * @param  string $node
	 * @param  mixed  $value
	 * @return null
	 */
	public static function set($node, $value) {
		if (defined('ACP')) {
			// TODO: Set the value
		}
		return null;
	}

	public static function remove($node) {
		if (is_array($node))
			UArray::removeElements(self::$config, $node);
		else if (isset(self::$config[$node]))
			unset(self::$config[$node]);
		else
			return false;
		return true;
	}

	public static function asXML() {
		$xml = new XML('<config> </config>', true);
		foreach (self::$config as $node => $value) {
			$splitted = explode('.', $node);
			$curXML = $xml;
			for ($i = 0; $i < count($splitted); $i++) {
				if (!$curXML->{$splitted[$i]}) {
					if ($i == count($splitted) - 1) {
						// check and format value
						if (is_bool($value) || is_null($value))
							$value = (int)$value;

						// replace & and not &amp;
						$value = preg_replace('/&(?!amp;)/', '&amp;', $value);

						if (is_string($value) && !empty($value) && !preg_match('/[a-z0-9 ]+/i', $value))
							$curXML->addChild($splitted[$i])->addCData($value);
						else
							$curXML->addChild($splitted[$i], $value);
						$curXML->{$splitted[$i]}->addAttribute('type', gettype($value));
					} else
						$curXML->addChild($splitted[$i]);
				}
				if ($i < count($splitted) - 1)
					$curXML = $curXML->{$splitted[$i]};
			}
		}
		// TODO: format XML
		return $xml->asXML();
	}

	/**
	 * Formates the value and returns the right type
	 * @param string    $node
	 * @param mixed     $value
	 * @param           $type
	 * @throws CoreException
	 */
	private static function formatValue($node, &$value, &$type) {
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
				if (in_array($value, ['true', '1']))
					$value = true;
				else if (in_array($value, ['false', '0']))
					$value = false;
				else
					throw new CoreException('The config node "'.$node.'" is in the wrong format. Bool expected, the value is: "'.$value.'"');
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
	private static function parseType(&$type, $onlyLength = false) {
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
