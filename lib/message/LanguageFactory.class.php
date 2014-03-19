<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class LanguageFactory {
	/**
	 * Buffer for Language obj
	 * @var Language[]
	 */
	protected static $languageObjects = [];

	/**
	 * Current default language
	 * @var Language
	 */
	protected static $defaultLanguage = null;

	public static function init() {
		// Read all dem data
		foreach(scandir(DIR_LANGUAGE) as $file) {
			if(is_dir(DIR_LANGUAGE.$file) && preg_match('/^([a-z]{2}\-[A-Z]{2})$/', $file, $matches)) {
				try {
					self::$languageObjects[$matches[1]] = new Language($matches[1]);
				} catch(LanguageNotFoundException $e) {
					unset(self::$languageObjects[$matches[1]]);
				}
			}
		}

		// Try to find the default language
		// By now this is done only via the global config. User or location specific stuff is to come
		$defaultLangID = Silex::getConfig()->get('language.default');

		if(isset(self::$languageObjects[$defaultLangID])) {
			self::$defaultLanguage = self::$languageObjects[$defaultLangID];
		}
		// Use the first language loaded instead
		elseif(!empty(self::$languageObjects)) {
			self::$defaultLanguage = self::$languageObjects[current(array_keys(self::$languageObjects))];
		} else {
			throw new CoreException('Couldn\'t load any default language', 0 , 'No language could be loaded. Check your directory naming.');
		}
	}

	/**
	 * @return Language
	 */
	public static function getDefaultLanguage() {
		return self::$defaultLanguage;
	}

	/**
	 * @return Language[]
	 */
	public static function getLanguageObjects() {
		return self::$languageObjects;
	}

}
