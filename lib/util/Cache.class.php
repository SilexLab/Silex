<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class Cache {
	private static $salt = 'TODO: salt';

	/**
	 * Cache some data
	 * this executes $data if no $cacheFile is available or it neets to be refreshed
	 * @param  callable $data             a callable wich will be executed
	 * @param  string   $cacheFile        the name of the file to cache
	 * @param  mixed    $vars      null   some data the callable should get
	 * @param  num      $probably  90     the probability to NOT refresh the cache
	 * @param  bool     $doHash    false  should the $cacheFile name be hashed
	 */
	public static function _(callable $data, $cacheFile, $vars = null, $probably = 90, $doHash = false) {
		if (DEBUG && false) return $data($vars);

		if ($doHash)
			$cacheFile = hash_hmac('md5', $cacheFile, self::$salt);
		$cacheFile = DCACHE.$cacheFile;

		if (is_file($cacheFile) && probably($probably)) {
			return unserialize(file_get_contents($cacheFile));
		} else {
			$data = $data($vars);
			file_put_contents($cacheFile, serialize($data));
			return $data;
		}
	}

	/**
	 * Remove the whole cache
	 */
	public static function flush() {
		// I am a comment
	}
}
