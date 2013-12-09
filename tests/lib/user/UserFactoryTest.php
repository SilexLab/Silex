<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */
 
class UserFactoryTest extends PHPUnit_Framework_TestCase {
	public function testProperUserFetching() {
		$userByID = $userByName = null;
		$guestUser = UserFactory::getGuest();
		try {
			$userByName = UserFactory::getUserByName('admin');
			$userByID = UserFactory::getUserByID(1);
		} catch(UserNotFoundException $e) {
			$this->fail('UserNotFoundException thrown while the user exists');
		}

		$this->assertInstanceOf('GuestUser', $guestUser, 'Guest is no instance of GuestUser.');
		$this->assertInstanceOf('User', $userByName, 'UserByName is no instance of User.');
		$this->assertInstanceOf('User', $userByID, 'UserByID is no instance of User.');

		$this->assertEquals($userByID, $userByName, 'Users are not equal, although they must.');
	}

	public function testFactoryThrowsExceptionIfNotExistsByName() {
		try {
			$userByName = UserFactory::getUserByName('IDoNotExist');
		} catch(UserNotFoundException $e) {
			return;
		}
		$this->fail('UserNotFoundException hasn\'t been thrown');
	}

	public function testFactoryThrowsExceptionIfNotExistsByID() {
		try {
			$userByID = UserFactory::getUserByID(-42);
		} catch(UserNotFoundException $e) {
			return;
		}
		$this->fail('UserNotFoundException hasn\'t been thrown');
	}
}
