<?php
/**
 * @author SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @link https://silexlab.org/
 */

namespace silex\message;

use silex\message\language\Language;
use silex\Config;

class Message
{
	/**
	 * @var Language
	 */
	protected static $language;

	protected static $defaultLanguage;

	public static function init()
	{
		// TODO: use user config
		self::$language = new Language(Config::get('language.default'));
		self::$language->getStrings();

		if (self::$language->id != Language::DEFAULT_LANG) {
			self::$defaultLanguage = new Language(Language::DEFAULT_LANG);
			self::$defaultLanguage->getStrings();
		}
	}

	/**
	 * Get a string from the corresponding node
	 *
	 * @param string $node
	 * @return string
	 */
	public static function get($node)
	{
		return self::$language->get($node) ? self::$language->get($node) : (
			self::$language->id != Language::DEFAULT_LANG && self::$defaultLanguage->get($node) ? self::$defaultLanguage->get($node) : $node
		);
	}
}
