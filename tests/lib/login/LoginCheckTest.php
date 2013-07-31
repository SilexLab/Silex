<?php
/**
 * @author    Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */
 
class LoginCheckTest extends PHPUnit_Framework_TestCase {
	public function testFindingLoginCheckers() {
		LoginCheck::reset();
		// Precondition
		$this->assertEmpty(LoginCheck::getLoginCheckers(), 'Precondition failed. There are LoginCheckers registered.');
		$this->assertNull(LoginCheck::getLoginCheckerInUse(), 'Precondition failed. There is a Checker in use registered.');

		// Init and test for registrations
		LoginCheck::init();
		$this->assertNotEmpty(LoginCheck::getLoginCheckers(), 'There were no LoginCheckers registered.');
		$this->assertNull(LoginCheck::getLoginCheckerInUse(), 'There was an checker registered as in use after init.');

		// Search for the SessionLoginChecker
		$fail = true;
		foreach(LoginCheck::getLoginCheckers() as $curLoginChecker) {
			if($curLoginChecker instanceof SessionLoginChecker) {
				$fail = false;
				break;
			}
		}
		if($fail)
			$this->fail('The obligatory SessionLoginChecker was not registered.');
	}

	public function testSessionLoginChecker() {
		// Setup LoginCheck
		LoginCheck::reset();
		LoginCheck::init();

		// Search for the SessionLoginChecker
		$fail = true;
		foreach(LoginCheck::getLoginCheckers() as $curLoginChecker) {
			if($curLoginChecker instanceof SessionLoginChecker) {
				$fail = false;
				break;
			}
		}
		if($fail)
			$this->fail('Precondition failed. The obligatory SessionLoginChecker was not registered.');

		// Precondition without login
		$this->assertFalse(LoginCheck::isLoggedIn(), 'Precondition failed. LoginCheck says user is logged in without login.');
		$this->assertInstanceOf('GuestUser', LoginCheck::getUser(), 'Precondition failed. LoginCheck doesn\'t return a GuestUser without login.');

		// Set the user as logged in
		$_SESSION['userID'] = 1;

		// Should now be logged in
		$this->assertTrue(LoginCheck::isLoggedIn(), 'LoginCheck says user is not logged in although he is.');

		// Precondition: LoginCheck must now have a Checker marked as "in use"
		$this->assertInstanceOf('SessionLoginChecker', LoginCheck::getLoginCheckerInUse(), 'LoginCheck does not have a Checker in use.');
		$user = LoginCheck::getUser();

		$this->assertNotInstanceOf('GuestUser', $user, 'LoginCheck returns GuestUser although user is logged in');
		$this->assertFalse($user->isGuest(), 'User object tells it is a guest, although not of GuestUser type.');
	}
}
