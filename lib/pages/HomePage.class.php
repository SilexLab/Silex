<?php
/**
 * @author    Janek Ostendorf (ozzy) <ozzy@ozzyfant.de>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class HomePage extends Page {

	/**
	 * Get the pages short name. Has to be unique
	 * @return string
	 */
	public function getName() {
		return 'home';
	}

	/**
	 * Get the full page title
	 * @return string
	 */
	public function getTitle() {
		return 'Home';
	}

	/**
	 * Get the file name of the page's template
	 * @return string
	 */
	public function getTemplateName() {
		return 'pages/home.tpl';
	}

	/**
	 * Prepare the page for display
	 * @return void
	 */
	public function prepare() {

	}
}
