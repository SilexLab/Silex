<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class URL {
	const ROUTE_PARAM = 'q';

	private static $format = '';
	private static $base = '';
	private static $route = '/';

	/**
	 * just check some url stuff
	 */
	public static function check($format = null, $base = null) {
		self::$format = $format;
		self::$base = $base;
		// get url config
		if(!self::$format)
			self::$format = Silex::getConfig()->get('url.format');
		if(!self::$base)
			self::$base = Silex::getConfig()->get('url.base');

		// get route
		if(isset($_GET[self::ROUTE_PARAM])) {
			self::$route = $_GET[self::ROUTE_PARAM];

			// redirect to fix the url format if it's wrong
			$url = self::$route.self::getParams(true, false);
			if(preg_match('/[\/]+$/', self::$route) || (self::$format && $url != self::getURL())) {
				self::$route = preg_replace('/[\/]+$/', '', self::$route);
				$url = self::$route.self::getParams(true, false);
				header('Location: '.$url);
			}
		}
	}

	/**
	 * make an url to that route
	 * @param  string $route
	 * @param  array  $params
	 * @return string
	 */
	public static function to($route, array $params = []) {
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
			$url = '?'.self::ROUTE_PARAM.'=';
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

	/**
	 * get the route
	 * @return string
	 */
	public static function getRoute() {
		return self::$route;
	}

	/**
	 * get the parameters
	 * @param  bool $asString optional
	 * @return mixed
	 */
	public static function getParams($asString = true, $asHTML = true) {
		$aURL = [];
		$sURL = '?';
		foreach($_GET as $key => $value) {
			if($key == self::ROUTE_PARAM)
				continue;
			$aURL[$key] = $value;
			$sURL .= $key.'='.$value.($asHTML ? '&amp;' : '&');
		}

		if($asString)
			return substr($sURL, 0, ($asHTML ? -5 : -1));
		return $aURL;
	}

	/**
	 * get the whole request url
	 * @return string
	 */
	public static function getURL() {
		return $_SERVER['REQUEST_URI'];
	}

	/**
	 * get the value of a parameter
	 * @param  string $param
	 * @return mixed         string if key exists, null if not
	 */
	public static function get($param) {
		return isset($_GET[$param]) ? $_GET[$param] : null;
	}
}
