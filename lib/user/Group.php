<?php
/**
 * @author SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @link https://silexlab.org/
 */

namespace silex\user;

class Group
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
	 * @var GroupPermission
	 */
	protected $permission;

	public function __construct($id)
	{
		$this->id = (int)$id;
		$data = DB::query('SELECT * FROM `group` WHERE `id` = ' . $this->id)->fetchObject();

		$this->name = $data->name;
		$this->permission = new GroupPermission($this->id);
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

		$result = $this->permission->get($permission);
		return $result === null ? $default : $result;
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}
}
