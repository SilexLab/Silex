<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

abstract class Page implements ITemplatable {
	/**
	 * Get the pages short name. Has to be unique
	 * @return string
	 */
	abstract public function getName();

	/**
	 * Get the full page title
	 * @return string
	 */
	abstract public function getTitle();

	/**
	 * Get the file name of the page's template
	 * @return string
	 */
	abstract public function getTemplateName();

	/**
	 * Prepare the page for display
	 * @return void
	 */
	abstract public function prepare();

	/**
	 * Is this page currently displayed?
	 * @return bool
	 */
	public function isActive() {
		return Silex::getPage() === $this;
	}

	/**
	 * Return an array suitable for assignment in an template variable
	 * @return array
	 */
	public function getTemplateArray() {
		return [
			'name' => $this->getName(),
			'title' => $this->getTitle(),
			'template' => $this->getTemplateName(),
			'isActive' => $this->isActive(),
			'object' => $this
		];
	}
} 