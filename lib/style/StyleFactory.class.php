<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class StyleFactory {
	protected static $styleObjects = [];

	public static function init() {
		// Read all dem data
		foreach(scandir(DIR_STYLE) as $file) {
			if(is_dir(DIR_STYLE.$file) && preg_match('/^[a-zA-Z0-9_]+$/', $file)) {
				try {
					@include_once(DIR_STYLE.$file.'/'.$file.'.php');
					$class = preg_replace('/\./', '_', $file);
					self::$styleObjects[$file] = new $class;
				} catch(Exception $e) {
					unset(self::$styleObjects[$file]);
				}
			}
		}
	}

} 