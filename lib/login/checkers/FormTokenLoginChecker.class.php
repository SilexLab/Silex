<?php
/**
 * @author    Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */
 
/**
 * Checks for tokens sent with forms to keep the user logged in
 */
class FormTokenLoginChecker implements ILoginChecker {
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

		// Check for POST token
		if(HTTPPost::get('silex_form_token') !== false) {
			if(preg_match('/^[0-9a-f]{40}$/i', HTTPPost::get('silex_form_token')) == 1) {
				// Keys valid, check the DB
				$query = Silex::getDB()->prepare('SELECT * FROM `user` WHERE `form_token` = :formToken');
				$query->execute([':formToken' => HTTPPost::get('silex_form_token')]);

				if($query->getRowCount() == 1) {
					$user = new User($query->fetchArray(PDO::FETCH_ASSOC));
				}
			}
		}
		return $user;
	}
}
