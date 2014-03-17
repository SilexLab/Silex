<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class Language {
	/**
	 * Language ID according to ISO 639-1 and ISO 3166
	 * @var string
	 */
	protected $id = '';

	// Title and description in the language pack's language
	protected $name = '';
	protected $description = '';

	// Title and description in English
	protected $nameEn = '';
	protected $descriptionEn = '';

	/**
	 * The array holding all language data
	 * @var array
	 */
	protected $heap = [];

	/**
	 * @param string $languageID Language ID
	 * @param string $customPath Custom path to search for lang files in
	 * @throws LanguageNotFoundException
	 */
	public function __construct($languageID, $customPath = '') {
		if(empty($customPath))
			$customPath = DIR_LANGUAGE;

		// Wrong naming
		if(!preg_match('/^[a-z]{2}-[A-Z]{2}$/', $languageID)) {
			throw new LanguageNotFoundException();
		}

		// Try to open the info file
		if(file_exists($customPath.$languageID) && file_exists($customPath.$languageID.'/info.xml') && file_exists($customPath.$languageID.'/core.xml')) {
			/* Read info */
			$info = new XML($customPath.$languageID.'/info.xml');

			$this->id =            $info->id;
			$this->name =          $info->name;
			$this->description =   $info->description;
			$this->nameEn =        $info->{'name-en'};
			$this->descriptionEn = $info->{'description-en'};

			/* Read language and generate heap */ // TODO: Only read on demand, e.g. only when somebody really gets lang vars
			$this->heap = UArray::toNode((new XML($customPath.$languageID.'/core.xml'))->asArray());

		} else {
			throw new LanguageNotFoundException();
		}
	}

	/**
	 * Get language variable directory from this language
	 * @param string $var Language variable
	 * @return string|null
	 */
	public function getVar($node) {
		return array_key_exists($node, $this->heap) ? $this->heap[$node] : null;
	}

	/**
	 * Get language variable
	 * Fallback uses default language
	 * @param string $var Language variable
	 * @return string|null
	 */
	public function get($var) {
		$result = $this->getVar($var);

		// If not existent, use the default language. Will return null here when not existent at all
		// Stop if this is default language
		if($result === null && $this !== LanguageFactory::getDefaultLanguage())
			$result = LanguageFactory::getDefaultLanguage()->getVar($var);

		return $result;
	}
}
