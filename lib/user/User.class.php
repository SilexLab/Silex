<?php
/**
 * @author    Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class User {
	protected $id = 0;
	protected $name = '';
	protected $mail = '';
	/*
	 * Here is no password, because the authentication for users will be
	 * implemented modular to support multiple authentication methods
	 * without need to hack the core code.
	 */

	public function __construct(array $dbData) {
		$this->id = $dbData['id'];
		$this->name = $dbData['name'];
		$this->mail = $dbData['mail'];
	}

	/**
	 * Saves this users data to the DB
	 */
	public function save() {
		$query = Silex::getDB()->prepare('UPDATE `user` SET
				`name` = :name,
				`mail` = :mail
				WHERE `id` = :id');
		$query->execute([
			':id' => $this->id,
			':name' => $this->name,
			':mail' => $this->mail,
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
}
