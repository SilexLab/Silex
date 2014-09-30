<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class Language implements ISTemplatable {
	private static $init = false;
	private static $lang = null;

	public static function init() {
		if (!self::$init) {
			LanguageFactory::init();
			self::$lang = LanguageFactory::getDefaultLanguage();
			self::$init = true;
		}
	}

	public static function get($node) {
		return self::$lang->get($node);
	}

	public static function getVar($node) {
		return self::$lang->getVar($node);
	}

	public static function assignTemplate() {
		self::$lang->assignTemplate();
	}
}
