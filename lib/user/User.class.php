<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class User {
	protected $id = 0;
	protected $name = '';
	protected $mail = '';
	protected $group = null;
	protected $permission = null;
	/*
	 * Here is no password, because the authentication for users will be
	 * implemented modular to support multiple authentication methods
	 * without need to hack the core code.
	 */

	public function __construct(array $dbData) {
		$this->id = $dbData['id'];
		$this->name = $dbData['name'];
		$this->mail = $dbData['mail'];
		$this->group = GroupFactory::get((int)$dbData['group']);
	}

	/**
	 * Saves this users data to the DB
	 */
	public function save() {
		$query = Silex::getDB()->prepare('UPDATE `user` SET
				`name` = :name,
				`mail` = :mail,
				`group` = :group
				WHERE `id` = :id');
		$query->execute([
			':id' => $this->id,
			':name' => $this->name,
			':mail' => $this->mail,
			':group' => $this->group->getID();
		]);
	}

	/* Setters */
	public function setMail($mail) {
		$this->mail = $mail;
	}

	public function setName($name) {
		$this->name = $name;
	}

	/* Getters */
	public function getID() {
		return $this->id;
	}

	public function getMail() {
		return $this->mail;
	}

	public function getName() {
		return $this->name;
	}

	public function isGuest() {
		return false;
	}

	public function getPermission() {
		// TODO: inhire permission from group
		return true;
	}
}
