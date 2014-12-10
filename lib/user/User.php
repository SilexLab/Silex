<?php
/**
 * @author SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @link https://silexlab.org/
 */

namespace silex\user;

use silex\database\Database as DB;
use silex\exception\CoreException;

/**
* 
*/
class User
{
	/**
	 * @var int
	 */
	protected $id;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $password;

	/**
	 * @var string
	 */
	protected $mail;

	/**
	 * @var Group
	 */
	protected $group;

	/**
	 * @var UserPermission
	 */
	protected $permission;

	/**
	 * @param int $id
	 */
	public function __construct($id)
	{
		$this->id = (int)$id;
		$data = DB::query('SELECT * FROM `user` WHERE `id` = ' . $this->id)->fetchObject();

		$this->name = $data->name;
		$this->password = $data->password;
		$this->mail = $data->mail;
		$this->group = new Group($data->group_id);
		$this->permission = new UserPermission($this->id);
	}

	/**
	 * Saves this users data to the database
	 */
	public function save()
	{
		$stmt = DB::prepare('UPDATE `user` SET
			`name` = :name,
			`mail` = :mail,
			`group_id` = :group
			WHERE `id` = :id');
		$stmt->execute([
			':id' => $this->id,
			':name' => $this->name,
			':mail' => $this->mail,
			':group' => $this->group->getId()
		]);
	}

	/**
	 * Get the permission for the $permission node
	 *
	 * @param string $permission What permission is requested?
	 * @param mixed $default Return if the permission isn't set
	 * @return mixed Usually bool (true = has permission, false = has not)
	 */
	public function getPermission($permission, $default = false)
	{
		// TODO: get from $this->permission->get(...)
		return true;

		$result = $this->permission->get();

		// if there is no extra permission for this user then use permission for this group
		if ($result === null)
			$result = $this->group->getPermission($permission, $default);

		return $result === null ? $default : $result;
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getMail()
	{
		return $this->mail;
	}

	/**
	 * @return Group
	 */
	public function getGroup()
	{
		return $this->group;
	}

	/**
	 * @param string $mail
	 */
	public function setMail($mail) {
		$this->mail = $mail;
	}
	/**
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @param int $id
	 */
	public function setGroup($id) {
		$this->group = new Group($id);
	}
}
