<?php
/**
 * @author    Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class LanguageFactory {
	/**
	 * Buffer for Language obj
	 * @var Language[]
	 */
	static public $languageObjects = [];

	/**
	 * Current default language
	 * @var Language
	 */
	static protected $defaultLanguage = null;

}