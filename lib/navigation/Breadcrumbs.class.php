<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class Breadcrumbs {
	protected $crumbs = [];

	public function __construct() {}

	/**
	 * Add a crumb to the breadcrumbs
	 * @param  mixed  $title
	 * @param  string $link
	 * @return bool   success
	 */
	public function add($title, $link = '') {
		// add multiple breadcrumbs
		if(is_array($title)) {
			$success = true;
			foreach($title as $crumb)
				$success = $this->add($crumb['title'], $crumb['link']);
			return $success;
		}
		// add a single breadcrumb
		if($link && $this->crumbs[] = ['title' => Silex::getLanguage()->get($title), 'link' => $link])
			return true;
		return false;
	}

	/**
	 * remove a crumb from breadcrumbs
	 * @param  mixed $id     title or id
	 * @return bool  success
	 */
	public function remove($id) {
		// remove by id
		if(is_int($id)) {
			if(isset($this->crumbs[$id])) {
				// remove this entry
				unset($this->crumbs[$id]);
				// re-index array
				$this->crumbs = array_values($this->crumbs);
				return true;
			}
			return false;
		}

		// remove by title
		return $this->remove($this->getID($id));
	}

	/**
	 * get the whole breadcrumbs-list
	 * @param  mixed $id title or id
	 * @return array
	 */
	public function get($id = -1) {
		if(is_int($id)) {
			if($id == -1)
				return $this->crumbs;
			if(isset($this->crumbs[$id]))
				return $this->crumbs[$id];
		} else if(is_string($id)) {
			$id = $this->getID($id);
			if($id !== false)
				return $this->crumbs[$id];
		}
		return false;
	}

	/**
	 * get id by title
	 * @param  string $title
	 * @return mixed  int if success false if not
	 */
	public function getID($title) {
		for($i = 0; $i < sizeof($this->crumbs); $i++) { 
			if($this->crumbs[$i]['title'] == $title)
				return $i;
		}
		return false;
	}
}
