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
	 * this executes $callback if no $cacheFile is available or it neets to be refreshed
	 * @param  callable $callback         a callable wich will be executed
	 * @param  string   $cacheFile        the name of the file to cache
	 * @param  mixed    $data      null   some data the callable should get
	 * @param  num      $probably  90     the probability to NOT refresh the cache
	 * @param  bool     $doHash    false  should the $cacheFile name be hashed
	 */
	public static function _(callable $callback, $cacheFile, $data = null, $probably = 90, $doHash = false) {
		if (DEBUG) return $callback($data);

		if ($doHash)
			$cacheFile = hash_hmac('md5', $cacheFile, self::$salt);
		$cacheFile = Dir::CACHE.$cacheFile;

		if (is_file($cacheFile) && probably($probably))
			return unserialize(file_get_contents($cacheFile));

		$result = $callback($data);
		file_put_contents($cacheFile, serialize($result));
		return $result;
	}

	/**
	 * Remove the whole or a specific cache file(s)
	 * @param mixed $cacheFiles null
	 */
	public static function flush($cacheFiles = null) {
		if ($cacheFiles) {
			if (is_array($cacheFiles)) {
				foreach ($cacheFiles as $file) {
					self::flush($file);
				}
			} else {
				if (in_array($cacheFiles, ['.', '..']))
					return;
				$file = Dir::CACHE.$cacheFiles;
				if (is_dir($file))
					self::rmdir($file);
				else if (is_file($file))
					unlink($file);
			}
		} else {
			self::flush(scandir(Dir::CACHE));
		}
	}

	protected static function rmdir($dir) {
		$files = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
			RecursiveIteratorIterator::CHILD_FIRST);
		foreach ($files as $file) {
			if (in_array($file->getFilename(), ['.', '..']))
				continue;

			if ($file->isDir())
				self::rmdir($file->getRealPath());
			else
				unlink($file->getRealPath());
		}
		rmdir($dir);
	}
}
