<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */
 
/**
 * Our Guest
 */
class GuestUser extends User {
	public function __construct() {
		$this->name = 'group.guest';
		return; // Leave default values on properties
	}

	public function save() {
		return;
	}

	public function getName() {
		return Silex::getLanguage()->get($this->name);
	}

	public function getMail() {
		return null;
	}

	public function isGuest() {
		return true;
	}
}
