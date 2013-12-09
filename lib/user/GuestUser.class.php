<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */
 
/**
 * Our Guest
 */
class GuestUser extends User {
	public function __construct() {
		return; // Leave default values on properties
	}

	public function save() {
		return;
	}

	public function getID() {
		return 0;
	}

	public function getMail() {
		return null;
	}

	public function getName() {
		return 'Guest';
	}

	public function isGuest() {
		return true;
	}
}
