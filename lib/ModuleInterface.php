<?php
/**
 * @author SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @link https://silexlab.org/
 */

namespace silex;

interface ModuleInterface
{
	/**
	 * Run the module code
	 */
	public function run();

	/**
	 * Does this module need another module to be loaded first?
	 *
	 * @return array
	 */
	public function getParents();

	/**
	 * Just get the module priority (positive int)
	 * low number = high priority
	 * -1         = default priority
	 *
	 * @return int
	 */
	public function getPriority();

	/**
	 * Does the module belongs to a module group?
	 * This is needed for checking for modules (via status) which serve
	 * similar features and functions, like different text parsers
	 *
	 * @return string|null
	 */
	public function getModuleGroup();
}
