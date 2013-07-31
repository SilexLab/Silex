<?php
/**
 * @author    Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */
 
class URLTest extends PHPUnit_Framework_TestCase {
	/**
	 * Format, base, $_SERVER['REQUEST_URI'], $_GET, expected URL
	 * @return array
	 */
	public function properRedirectionDataProvider() {
		return [
			[
				1,                              // Format
				'/',                            // Base
				'/ttest/bla/bla/?foo=test',     // REQUEST_URI
				[                               // $_GET
					'q' => '/test/bla/bla//',
					'test' => 'foo',
				],                              // $_GET end
				'/ttest/bla/bla/?foo=test'      // Expected URL
			],
		];
	}

	protected function clearHeaders() {
		@ob_clean();
		header_remove();
		ob_start();
	}

	/**
	 * @param $format
	 * @param $base
	 * @param $requestUri
	 * @param $getArray
	 * @param $expectedURL
	 * @dataProvider properRedirectionDataProvider
	 * later: runInSeparateProcess
	 */
	public function testProperRedirection($format, $base, $requestUri, $getArray, $expectedURL) {
		$this->markTestSkipped('Not yet fully implemented.');
		$this->setPreserveGlobalState(false);
		$this->clearHeaders();
		// Setup emulated environment
		$GLOBALS['_GET'] = $_GET = $getArray;
		$GLOBALS['_SERVER']['REQUEST_URI'] = $_SERVER['REQUEST_URI'] = $requestUri;

		// Precondition
		$headerList = headers_list();
		$this->assertEmpty($headerList, 'Precondition failed, headers list not empty.');

		// Start check for redirection
		URL::check($format, $base);

		// Test
		$headerList = headers_list();
		$this->assertContains('Location: '.$expectedURL, $headerList, 'Redirect header wasn\'t sent.');
	}
}
