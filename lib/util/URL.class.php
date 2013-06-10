<?php
/**
 * @author    Patrick Kleinschmidt (NoxNebula) <noxifoxi@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class URL {
	private static $format = '';
	private static $base = '';

	/**
	 * make an url to that route
	 * @param  string $route
	 * @param  array  $params
	 * @return string
	 */
	public static function to($route, array $params = []) {
		// get url config
		if(!self::$format)
			self::$format = Silex::getConfig()->get('url.format');
		if(!self::$base)
			self::$base = Silex::getConfig()->get('url.base');

		// check if route is valid
		if(!is_string($route))
			return false;
		if(!preg_match('/^[a-zA-Z0-9\/\-_]+$/', $route))
			return false;

		// make everything ok
		$route = preg_replace('/(^[\/]+)|([\/]+$)/', '', $route);

		// url route
		$url = '';
		if(!self::$format)
			$url = '?q=';
		$url .= $route;

		// attach parameters
		if(!empty($params)) {
			if(!self::$format)
				$url .= '&amp;';
			else
				$url .= '?';

			$i = 0;
			foreach($params as $key => $value) {
				$url .= $key.'='.$value;
				if(++$i < sizeof($params))
					$url .= '&amp;';
			}
		}

		return self::$base.$url;
	}
}