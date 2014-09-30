<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class LanguageO implements ITemplatable {
	/**
	 * Language ID according to ISO 639-1 and ISO 3166
	 * @var string
	 */
	protected $id = '';
	protected $idShort = '';

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
		if (empty($customPath))
			$customPath = DLANG;

		// Wrong naming
		if (!preg_match('/^[a-z]{2}-[A-Z]{2}$/', $languageID)) {
			throw new LanguageNotFoundException();
		}

		// Try to open the info file
		if (file_exists($customPath.$languageID) &&
			file_exists($customPath.$languageID.'/info.xml') &&
			file_exists($customPath.$languageID.'/core.xml')) {
			/* Read info */
			$info = new XML($customPath.$languageID.'/info.xml');

			$this->id            = (string)$info->id;
			$this->idShort       = (string)$info->{'id-short'};
			$this->name          = (string)$info->name;
			$this->description   = (string)$info->description;
			$this->nameEn        = (string)$info->{'name-en'};
			$this->descriptionEn = (string)$info->{'description-en'};

			/* Read language and generate heap */ // TODO: Only read on demand, e.g. only when somebody really gets lang vars
			$this->heap = Cache::_(function($var) {
				return UArray::toNode((new XML($var))->asArray());
			}, 'lang-'.$this->id, $customPath.$languageID.'/core.xml');

		} else {
			throw new LanguageNotFoundException();
		}
	}

	/**
	 * Get language variable directory from this language
	 * @param string $noed Language variable
	 * @return string
	 */
	public function getVar($node) {
		return array_key_exists($node, $this->heap) ? $this->heap[$node] : $node;
	}

	/**
	 * Get language variable
	 * Fallback uses default language
	 * @param string $node Language variable
	 * @return string
	 */
	public function get($node) {
		// won't search for the value at all if it's not a node
		if (!UString::find($node, '.') || UString::find($node, ' '))
			return $node;

		$result = $this->getVar($node);

		// If not existent, use the default language. Will return the value of $node here when not existent at all
		if ($result == $node && $this !== LanguageFactory::getDefaultLanguage())
			$result = LanguageFactory::getDefaultLanguage()->getVar($node);

		return $result;
	}

	public function assignTemplate() {
		Template::assign(['lang' =>
			[
				'id' => $this->id,
				'id-short' => $this->idShort,
				'name' => $this->name,
				'description' => $this->description,
				'name-en' => $this->nameEn,
				'description-en' => $this->descriptionEn
			]
		]);
	}
}
