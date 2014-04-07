<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class DesignPage extends Page {
	public function __construct() {
		Silex::getNav()->getMain()->add($this->getTitle(), URL::to($this->getName()));
	}

	/**
	 * Get the pages short name. Has to be unique
	 * @return string
	 */
	public function getName() {
		return 'design';
	}

	/**
	 * Get the full page title
	 * @return string
	 */
	public function getTitle() {
		return 'Design';
	}

	/**
	 * Get the file name of the page's template
	 * @return string
	 */
	public function getTemplateName() {
		return 'pages/design.tpl';
	}

	/**
	 * Prepare the page for display
	 * @return void
	 */
	public function prepare() {
		Silex::getNav()->getMain()->toggleActive($this->getTitle(), 1);
		Silex::getNav()->getCrumbs()->add('page.design', URL::to('design'));
		Silex::getNav()->getCrumbs()->add('Test', URL::to('design/test'));
		Silex::getNav()->getCrumbs()->add('Some', URL::to('design/some'));
		Silex::getNav()->getCrumbs()->add('Breadcrumbs', URL::to('design/crumbs'));
	}
}
