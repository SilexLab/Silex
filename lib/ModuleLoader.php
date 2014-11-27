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
	 * @var array Containing all executed (run()) modules
	 */
	protected $executed = [];

	/**
	 * @param string $path The top directory there the modules are located
	 */
	public function __construct($path)
	{
		$this->setPath($path);

		// convert namespace "_" to "." for include path
		Autoloader::addRule('silex\\modules', function($subject) {
			return str_replace('_', '.', $subject);
		});
	}

	/**
	 * Load modules
	 *
	 * @return bool Successful loaded
	 * @throws CoreException
	 */
	public function load()
	{
		if (!empty($this->modules))
			return false;

		// Get available modules from database and pack into $this->modules
		$statement = DB::query('SELECT * FROM `modules`');
		while ($row = $statement->fetchObject()) {
			if (is_file($this->path . $row->id . '/Module.php')) {
				$class = '\\silex\\modules\\' . str_replace('.', '_', $row->id) . '\\Module';
				$this->modules[$row->id] = [
					'module' => (bool)$row->enabled ? new $class() : null,
					'enabled' => (int)$row->enabled
				];
			} else {
				throw new CoreException('Module "' . $row->id . '" which is defined in the database does not exists', 1);
			}
		}

		return true;
	}

	/**
	 * Sort modules and execute the run() method
	 */
	public function run($module = '', $source = '')
	{
		if (empty($module)) {
			foreach ($this->prioritySort($this->modules) as $module => $n) {
				$this->run($module, $module);
			}
		} else {
			$m = $this->modules[$module]['module'];

			// Get parents
			if ($m->getParents()) {
				foreach ($m->getParents() as $parent => $importance) {
					if (!in_array($parent, $this->executed)) {
						if (array_key_exists($parent, $this->modules)
							&& $parent != $source
							&& $this->modules[$parent]['enabled'])
						{
							$this->run($parent, $source);
						} else if ((!array_key_exists($parent, $this->modules) || !$this->modules[$parent]['enabled'])
							&& $importance == 'required')
						{
							// Throw exception? 'Required module not found'
							return;
						}
					}
				}
			}

			if (!in_array($module, $this->executed)) {
				$m->run();
				$this->executed[] = $module;
			}
		}
	}

	/**
	 * Get the module instance
	 *
	 * @param string module name
	 * @return ModuleInterface|null
	 */
	public function get($module)
	{
		return isset($this->modules[$module]) ? $this->modules[$module]['module'] : null;
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
			return $this->modules[$module]['enabled'];

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

	/**
	 * Sort by priority
	 * (the output array does not contain objects)
	 *
	 * @param  array $modules
	 * @return array
	 */
	private function prioritySort(array $modules)
	{
		// TODO: convert to generator if possible
		$hold = [];
		$holdDefault = [];

		// Get priority
		foreach ($modules as $name => $m) {
			$priority = $m['module']->getPriority();
			if ($priority <= -1)
				$holdDefault[$name] = $priority;
			else
				$hold[$name] = $priority;
		}

		// Sort by priority
		asort($hold);

		// Add default priorities at the end
		return array_merge($hold, $holdDefault);
	}
}
