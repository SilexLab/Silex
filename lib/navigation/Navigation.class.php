<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class Navigation {
	protected $entries = [];

	public function __construct() {
		//
	}

	// TODO: merge add and prepend (similarities)

	/**
	 * Append an entry to the entries
	 * @param  string|array $title
	 * @param  string       $link
	 * @param  bool         $active
	 * @return bool         success
	 */
	public function add($title, $link = '', $active = false) {
		// add multiple entries
		if(is_array($title)) {
			$success = true;
			foreach($title as $entry)
				$success = $this->add($entry['title'], $entry['link'], isset($entry['active']) ? $entry['active'] : false);
			return $success;
		}
		// add a single entry
		if($link && $this->entries[] = ['title' => Silex::getLanguage()->get($title), 'link' => $link, 'active' => $active])
			return true;
		return false;
	}

	/**
	 * Prepend an entry to the entries
	 * @param  string|array $title
	 * @param  string       $link
	 * @param  bool         $active
	 * @return bool         success
	 */
	public function prepend($title, $link = '', $active = false) {
		$entries = [];

		if(is_array($title)) {
			$success = true;
			foreach($title as $entry) {
				$entries[] = ['title' => Silex::getLanguage()->get($entry['title']),
					'link' => $entry['link'],
					'active' => isset($entry['active']) ? $entry['active'] : false,
					'enabled' => $entry['enabled']];
			}
			$this->entries = array_merge($entries, $this->entries);
			return true;
		} else if($link && $entries[] = ['title' => Silex::getLanguage()->get($title), 'link' => $link, 'active' => $active]) {
			$this->entries = array_merge($entries, $this->entries);
			return true;
		}
		return false;
	}

	/**
	 * remove a entry from entries
	 * @param  mixed $id     title or id
	 * @return bool  success
	 */
	public function remove($id) {
		// remove by id
		if(is_int($id)) {
			if(isset($this->entries[$id])) {
				// remove this entry
				unset($this->entries[$id]);
				// re-index array
				$this->entries = array_values($this->entries);
				return true;
			}
			return false;
		}

		// remove by title
		return $this->remove($this->getID($id));
	}

	/**
	 * get the whole entries
	 * @param  mixed $id title or id
	 * @return array
	 */
	public function get($id = -1) {
		if(is_int($id)) {
			if($id == -1)
				return $this->entries;
			if(isset($this->entries[$id]))
				return $this->entries[$id];
		} else if(is_string($id)) {
			$id = $this->getID($id);
			if($id !== false)
				return $this->entries[$id];
		}
		return false;
	}

	/**
	 * get id by title
	 * @param  string $title
	 * @return mixed  int if success false if not
	 */
	public function getID($title) {
		for($i = 0; $i < sizeof($this->entries); $i++) { 
			if($this->entries[$i]['title'] == $title)
				return $i;
		}
		return false;
	}

	/**
	 * toggle the active status of an entry
	 * @param string|int $title  title or id of an entry
	 * @param int        $active optional (-1 = toggle, 0 = not active, 1 = active)
	 */
	public function toggleActive($title, $active = -1) {
		$id = false;

		// get id
		if(is_int($title) && isset($this->entries[$title]))
			$id = $title;
		else
			$id = $this->getID($title);

		// no id?
		if($id === false)
			return false;

		// toggle active
		if($active >= 0)
			$this->entries[$id]['active'] = (bool)$active;
		else
			$this->entries[$id]['active'] ^= true;

		return true;
	}
}
