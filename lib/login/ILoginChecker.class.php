<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */
 
/**
 * Interface for login checkers
 */
interface ILoginChecker {
	/**
	 * Is somebody logged in?
	 * @return bool
	 */
	public function isLoggedIn();

	/**
	 * Get that guy!
	 * @return User
	 */
	public function getUser();
}
