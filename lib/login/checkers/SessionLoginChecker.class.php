<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class SessionLoginChecker implements ILoginChecker {
	/**
	 * Is somebody logged in?
	 * @return bool
	 */
	public function isLoggedIn() {
		return ($this->getUser() instanceof User && !$this->getUser()->isGuest());
	}

	/**
	 * Get that guy!
	 * @return User
	 */
	public function getUser() {
		$user = null;
		if(Session::get('userID', false)) {
			try {
				$user = UserFactory::getUserByID(Session::get('userID'));
			} catch(UserNotFoundException $e) {
				// Relog. Afterwards there is no login, so return null
				Session::destroy();
			}
		}
		return $user;
	}
}
