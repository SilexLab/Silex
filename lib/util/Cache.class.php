<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class Cache {
	private $cacheDir;

	public function __construct($cacheDir) {
		$this->cacheDir = $cacheDir;
	}

	public function checkFile($checkFile) {
		$md5 = md5_file($checkFile);
		$cacheFileName = $md5.'.'.$checkFile.'.php';
		// foreach(scandir($this->cacheDir) as $f) {
		// 	if()
		// }
	}
}
