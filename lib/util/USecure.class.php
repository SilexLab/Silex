<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class USecure {
	/**
	 * Encrypt a password
	 * @param   string  $password
	 * @param   string  $email
	 * @param   string  $rounds
	 * @return  string
	 */
	public static function encryptPassword($password, $email, $rounds = '08') {
		$hash = hash_hmac('whirlpool', str_pad($password, strlen($password) * 4, sha1($email), STR_PAD_BOTH), Config::get('password.salt'), true);
		$salt = UString::getRandomString(32, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ./');
		return crypt($hash, '$2a$'.$rounds.'$'.$salt.'$');
	}

	/**
	 * Compare the e-mail and entered password with the encrypted from the database
	 * @param   string  $password   The users entered password
	 * @param   string  $email
	 * @param   string  $stored     The encrypted password from database
	 * @return  bool
	 */
	public static function checkPassword($password, $email, $stored) {
		$hash = hash_hmac('whirlpool', str_pad($password, strlen($password) * 4, sha1($email), STR_PAD_BOTH), Config::get('password.salt'), true);
		return crypt($hash, $stored) == $stored;
	}
}
