<?php
/**
 * @author    Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class LanguageTest extends PHPUnit_Framework_TestCase {

	private $langPath = '';

	protected function setUp() {
		$this->langPath = DIR_TESTS.'asset/language/';
		parent::setUp();
	}

	public function testProperLanguageSetup() {
		// Correct pack
		// should succeed
		try {
			$testLanguage = new Language('te-ST', $this->langPath);
		} catch(LanguageNotFoundException $e) {
			// You've failed, gtfo
			$this->fail('Correct language pack failed to setup.');
		}
	}

	public function testMissingInfoXMLLanguageSetup() {
		// Incorrect pack, missing info.xml
		// should fail
		$this->setExpectedException('LanguageNotFoundException');
		$testLanguage = new Language('wo-IN', $this->langPath);
	}

	public function testWrongNamingLanguageSetup() {
		// Incorreft pack, wrong naming
		// should fail
		$this->setExpectedException('LanguageNotFoundException');
		$testLanguage = new Language('WR-ng', $this->langPath);
	}

}
