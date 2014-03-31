<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class Group {
	// 0 = guests
	protected $id = 0;
	protected $name = 'group.guest';
	protected $permission = null;

	/**
	 * @param int $id
	 */
	public function __construct($id) {
		// get datanbase info
		$info = Silex::getDB()->query('SELECT * FROM `group` WHERE `id` = '.(int)$id.' LIMIT 1')->fetchObject();
		$this->name = $info->name;
	}

	/**
	 * get the permission of this group
	 * @return mixed
	 */
	public function getPermission($node) {
		return true;
	}

	public function getID() {
		return $this->id;
	}

	public function getName() {
		return $this->name;
	}
}
