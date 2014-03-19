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
		$hash = hash_hmac('whirlpool', str_pad($password, strlen($password) * 4, sha1($email), STR_PAD_BOTH), Silex::getConfig()->get('password.salt'), true);
		$salt = substr(str_shuffle('./0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 22); // TODO: replace str_shuffle with something more random
		return crypt($hash, '$2a$'.$rounds.'$'.$salt);
	}

	/**
	 * Compare the password and e-mail with the encrypted
	 * @param   string  $password
	 * @param   string  $email
	 * @param   string  $Stored     The encrypted password
	 * @return  bool
	 */
	public static function checkPassword($password, $email, $Stored) {
		$hash = hash_hmac('whirlpool', str_pad($password, strlen($password) * 4, sha1($email), STR_PAD_BOTH), Silex::getConfig()->get('password.salt'), true);
		return crypt($hash, substr($Stored, 0, 30)) == $Stored;
	}
}
