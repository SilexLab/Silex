<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */
 
class SilexTest extends PHPUnit_Framework_TestCase {

	public function testUserIsGuestByDefault() {
		$this->assertInstanceOf('GuestUser', Silex::getUser(), 'User is no Guest by default');
	}

}
