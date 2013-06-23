<?php
/**
 * @author    Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class SessionLoginChecker implements ILoginChecker {
	/**
	 * Is somebody logged in?
	 * @return bool
	 */
	public function isLoggedIn() {
		return (Session::getUser() instanceof User && !Session::getUser()->isGuest());
	}

	/**
	 * Get that guy!
	 * @return User
	 */
	public function getUser() {
		return Session::getUser();
	}
}
