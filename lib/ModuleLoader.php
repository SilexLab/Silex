<?php
/**
 * @author SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @link https://silexlab.org/
 */

namespace silex;

use silex\database\Database as DB;
use silex\exception\CoreException;

class ModuleLoader
{
	/**
	 * @var string The top directory there the modules are located
	 */
	protected $path;

	/**
	 * @var array All modules from the database
	 */
	protected $modules = [];

	/**
	 * @param string $path The top directory there the modules are located
	 */
	public function __construct($path)
	{
		$this->setPath($path);
	}

	/**
	 * Load modules
	 *
	 * @param array $modules optional
	 * @return bool Successful loaded
	 * @throws CoreException
	 */
	public function load(array $modules = [])
	{
		if (!empty($this->modules))
			return false;

		if ($modules)
			$this->modules = $modules;
		else {
			$statement = DB::query('SELECT * FROM `modules`');
			while ($row = $statement->fetchObject()) {
				if (is_file($this->path . $row->id . '/module.php')) {
					$this->modules[$row->id] = [
						'enabled' => (int)$row->enabled
					];
				} else {
					throw new CoreException('Module "' . $row->id . '" which is defined in the database does not exists', 1);
				}
			}
		}

		return true;
	}

	/**
	 * Get the status of a module
	 *  1 = enabled
	 *  0 = disabled
	 * -1 = not installed
	 *
	 * @param string $module Module name
	 * @return int Status
	 */
	public function getStatus($module)
	{
		if (array_key_exists($module, $this->modules))
			return $this->modules[$module]->enabled;

		return -1;
	}

	/**
	 * Set the modules path
	 *
	 * @param string $path The top directory there the modules are located
	 */
	public function setPath($path)
	{
		// if last character isn't "/" then add it 
		$this->path = preg_replace('/([^\/])$/', '$1/', $path);
	}

	/**
	 * Get the modules path
	 *
	 * @return string
	 */
	public function getPath()
	{
		return $this->path;
	}
}
