<?php
/**
 * @author SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @link https://silexlab.org/
 */

namespace silex\message\language;

use silex\Modules;
use silex\util\Data;

class Language
{
	const DEFAULT_LANG = 'en-US';

	/**
	 * Language ID according to ISO 639-1 and ISO 3166
	 * @var string
	 */
	protected $id = '';

	/**
	 * Short (2 chars) form of the id
	 * @var string
	 */
	protected $idShort = '';

	/**
	 * Title in the language pack's language
	 * @var string
	 */
	protected $name = '';

	/**
	 * Description in the language pack's language
	 * @var string
	 */
	protected $description = '';

	/**
	 * Title in english
	 * @var string
	 */
	protected $nameEn = '';

	/**
	 * Description in english
	 * @var string
	 */
	protected $descriptionEn = '';

	/**
	 * @var string
	 */
	protected $path = '';

	/**
	 * Array containing all strings
	 * @var array
	 */
	protected $strings = [];

	/**
	 * @param string $language
	 */
	public function __construct($language)
	{
		if (is_file('lib/message/language/' . $language . '/info.json')) {
			$this->path = 'lib/message/language/' . $language . '/';
			$info = json_decode(file_get_contents($this->path . 'info.json'));

			$this->id = $info->id;
			$this->idShort = $info->{'id-short'};
			$this->name = $info->name;
			$this->description = $info->description;
			$this->nameEn = $info->{'name-en'};
			$this->descriptionEn = $info->{'description-en'};
		}
	}

	public function __get($name)
	{
		return $this->{$name};
	}

	/**
	 * Return the string to the corresponding node
	 *
	 * @param string $node
	 * @return string|bool
	 */
	public function get($node)
	{
		return isset($this->strings[$node]) ? $this->strings[$node] : false;
	}

	/**
	 * Get all available strings
	 */
	public function getStrings()
	{
		// TODO: check if already cached, if so, load from cache instead of the code below
		foreach (Modules::getAll() as $module) {
			if (is_file($this->path . $module . '.json')) {
				$data = json_decode(file_get_contents($this->path . $module . '.json'));
				foreach (Data::flatten($data, '.') as $key => $value) {
					if (isset($this->strings[$key]))
						trigger_error('String for node ' . $key . ' does already exists.');

					$this->strings[$key] = $value;
				}
			}
		}
		// TODO: cache $this->strings (as php file)
	}
}
