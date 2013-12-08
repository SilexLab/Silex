<?php
/**
 * @author    Janek Ostendorf (ozzy) <ozzy@ozzyfant.de>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

interface ITemplatable {
	/**
	 * Return an array suitable for assignment in an template variable
	 * @return array
	 */
	public function getTemplateArray();
} 