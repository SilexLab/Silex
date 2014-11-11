<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

interface IModule {
	/**
	 * load the module
	 * @return void
	 */
	public function load();

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

	/**
	 * does the module belongs to an module group?
	 * this is needed for checking for modules (via status) wich deserve similar features and functions, like different text parsers
	 * @return string|null
	 */
	public function getModuleGroup();

	/**
	 * Get the methods wich are called in Silex provided by this module
	 * called by __callStatic() in Silex (Silex::MethodName()->[...])
	 * @return array or nothing when no methods are provided
	 */
	public function getMethods();

	/**
	 * This handle and call requested methods
	 * @param  string $name
	 * @param  array  $args
	 * @return mixed or nothing when no methods are provided
	 */
	public function callMethod($name, $args);
}
