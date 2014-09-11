<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class NavigationFactory {
	protected $main;
	protected $breadcrumbs;

	public function __construct() {
		$this->main = new Navigation();
		$this->breadcrumbs = new Navigation();
	}

	public function prepare() {
		$mainNav = Silex::getDB()->query('SELECT * FROM `navigation` ORDER BY `position`')->fetchAllObject();
		$main = [];
		foreach ($mainNav as $entry) {
			$main[] = [
				'title' => $entry->title, // title
				'link' => URL::to($entry->target) ? URL::to($entry->target) : $entry->target, // link
				'active' => $entry->target == Silex::getPage()->getName(), // is active?
				'enabled' => (bool)$entry->enabled
			];
		}

		$this->main->prepend($main);
	}

	public function getTemplateArray() {
		return [
			'main'   => $this->main->get(),
			'crumbs' => $this->breadcrumbs->get()
		];
	}

	public function getMain() {
		return $this->main;
	}

	public function getCrumbs() {
		return $this->breadcrumbs;
	}
}
