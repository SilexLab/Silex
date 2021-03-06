<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class URL {
	const ROUTE_PARAM = 'q';

	private static $format = '';
	private static $base = '';
	private static $route = '/';
	private static $aRoute = [];

	/**
	 * just check some url stuff
	 */
	public static function check($format = null, $base = null) {
		self::$format = $format;
		self::$base = $base;
		// get url config
		if (!self::$format)
			self::$format = Config::get('url.format');
		if (!self::$base)
			self::$base = Config::get('url.base');

		// get route
		if (isset($_GET[self::ROUTE_PARAM])) {
			self::$route = UString::urlEncodeSlashes($_GET[self::ROUTE_PARAM]);
			self::$aRoute = explode('/', trim(self::$route, '/'));

			// redirect to fix the url format if it's wrong
			$url = self::$route.self::getParams(true, false);
			if (preg_match('/[\/]+$/', self::$route) || (self::$format && $url != self::getURL())) {
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
	public static function to($route, array $params = [], $asHTML = true) {
		// check if route is valid
		if (!is_string($route))
			return false;
		if (!preg_match('/^[a-zA-Z0-9\/\-_]+$/', $route))
			return false;

		// make everything ok
		$route = preg_replace('/(^[\/]+)|([\/]+$)/', '', $route);

		// is it the default page? if yes, remove route
		if ($route == PageFactory::getDefaultPage())
			$route = '';

		// url route
		$url = '';
		if (!self::$format)
			$url = '?'.self::ROUTE_PARAM.'=';
		$url .= $route;

		// attach parameters
		if (!empty($params)) {
			if (!self::$format)
				$url .= ($asHTML ? '&amp;' : '&');
			else
				$url .= '?';

			$i = 0;
			foreach ($params as $key => $value) {
				$url .= $key.'='.$value;
				if (++$i < sizeof($params))
					$url .= ($asHTML ? '&amp;' : '&');
			}
		}

		return self::$base.$url;
	}

	/**
	 * get the route
	 * @return mixed
	 */
	public static function getRoute($position = -1) {
		return ($position <= -1) ? self::$route : (isset(self::$aRoute[$position]) ? self::$aRoute[$position] : false);
	}

	/**
	 * get the parameters
	 * @param  bool $asString optional
	 * @return mixed
	 */
	public static function getParams($asString = true, $asHTML = true) {
		$aURL = [];
		$sURL = '?';
		foreach ($_GET as $key => $value) {
			if ($key == self::ROUTE_PARAM)
				continue;
			$aURL[$key] = $value;
			$sURL .= $key.'='.$value.($asHTML ? '&amp;' : '&');
		}

		if ($asString)
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

	/**
	 * Compare route on position
	 * @param  int    $routePosition
	 * @param  string $expected
	 * @param  bool   $redirect   optional
	 * @param  string $redirectTo optional
	 * @return mixed
	 */
	public static function comparePos($routePosition, $expected, $redirect = false, $redirectTo = '') {
		if (isset(self::$aRoute[$routePosition])) {
			if (self::$aRoute[$routePosition] == $expected)
				return true;
			if ($redirect)
				header('Location: '.($redirectTo ? $redirectTo : $expected));
			return false;
		}
		return null;
	}

	public static function modify() {
		//return new URLModify(); // modify current url
		// -> add(key, value), remove(key), changeValue(key, newValue)
		// URL::modify()->remove('test');
	}
}
