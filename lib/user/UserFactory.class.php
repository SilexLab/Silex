<?php
/**
 * @author    Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class UserFactory {
	/**
	 * Username -> ID
	 * @var array
	 */
	protected static $nameToID = [];

	/**
	 * Users by their ID
	 * @var User[]
	 */
	protected static $userBuffer = [];

	/**
	 * @param int $userID The user's ID
	 * @return User
	 * @throws UserNotFoundException
	 */
	public static function getUserByID($userID) {
		// Is he already buffered?
		if(isset(self::$userBuffer[$userID]) && self::$userBuffer[$userID] instanceof User) {
			return self::$userBuffer[$userID];
		}

		// Create new
		$query = Silex::getDB()->prepare('SELECT * FROM `user` WHERE `id` = :id')->execute([':id' => $userID]);
		if($query->getRowCount() == 1) {
			$user = new User($query->fetchArray(PDO::FETCH_ASSOC));
			if($user instanceof User) {
				self::$userBuffer[(int)$user->getID()] = $user;
				self::$nameToID[$user->getName()] = (int)$user->getID();
				return $user;
			}
		}

		// Not buffered and failed to create: User not found
		throw new UserNotFoundException();
	}

	/**
	 * @param string $userName The user's name
	 * @return User
	 * @throws UserNotFoundException
	 */
	public static function getUserByName($userName) {
		// Is he already buffered?
		if(isset(self::$nameToID[$userName]) && self::$userBuffer[self::$nameToID[$userName]] instanceof User) {
			return self::$userBuffer[self::$nameToID[$userName]];
		}

		// Create new
		$query = Silex::getDB()->prepare('SELECT * FROM `user` WHERE `name` = :name')->execute([':name' => $userName]);
		if($query->getRowCount() == 1) {
			$user = new User($query->fetchArray(PDO::FETCH_ASSOC));
			if($user instanceof User) {
				self::$userBuffer[(int)$user->getID()] = $user;
				self::$nameToID[$user->getName()] = (int)$user->getID();
				return $user;
			}
		}

		// Not buffered and failed to create: User not found
		throw new UserNotFoundException();
	}

	/**
	 * Get a fresh new guest
	 * @return GuestUser
	 */
	public static function getGuest() {
		return new GuestUser();
	}
}
