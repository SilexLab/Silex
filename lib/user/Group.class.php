<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

// TODO: GroupFactory: Speichert alle Gruppenobjekte in einem Pool (erstell Objekt bei Bedarf und verwendet dieses wieder).
//       Ein Gruppenobjekt wird über die ID der Gruppe zurückgegeben (GroupFactory::getGroup($id) { return Group; }),
//       dies verhindert, dass bei mehreren Nutzer die zu einer Gruppe gehören jedes mal ein neues Gruppenobjekt angelegt wird.

class Group {
	protected $id = 0;
	/**
	 * @param int $id
	 */
	public function __construct($id) {
		//
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
}
