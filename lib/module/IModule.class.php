<?php
/**
 * @author    Patrick Kleinschmidt (NoxNebula) <noxifoxi@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
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
}
