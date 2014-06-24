<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

interface IModule {
	/**
	 * register the module
	 * @return void
	 */
	public function register();

	/**
	 * does this module need another module to be loaded first?
	 * @return array
	 */
	public function getParents();

	/**
	 * just get the module priority (positive int)
	 * low number = high priority
	 * -1         = default priority
	 * @return int
	 */
	public function getPriority();
}
