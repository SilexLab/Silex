<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class GroupFactory {
	protected static $groups = [];

	public static function get($id) {
		if (isset(self::$groups[$id]))
			return self::$groups[$id];

		if (!is_int($id))
			return false;

		if (Silex::getDB()->exists('group', '`id` = '.$id))
			self::$groups[$id] = new Group($id);
	}
}
