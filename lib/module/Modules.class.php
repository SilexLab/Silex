<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class Modules {
	private $modules = [];
	private $registered = [];
	private $methods = [];

	/**
	 * Initialize modules
	 * @param string $modulesPath
	 */
	public function __construct($modulesPath) {
		// search for and call modules
		foreach(scandir($modulesPath) as $file) {
			if(is_file($modulesPath.$file) && file_ext($file) == 'php') {
				require_once $modulesPath.$file;
				$module = substr($file, 0, -4);
				$class = preg_replace('/\./', '_', $module);

				$obj = new $class;
				if($obj instanceof IModule)
					$this->modules[$module] = $obj;
				unset($obj);
			}
		}
	}

	/**
	 * Get a method registered by a module
	 * @param  string $method
	 * @param  array  $args
	 * @return mixed
	 */
	public function callMethod($method, $args) {
		return isset($this->methods[$method]) ? $this->modules[$this->methods[$method]]->callMethod($method, $args) : null;
	}

	public function get($module) {
		return isset($this->modules[$module]) ? $this->modules[$module] : null;
	}

	/**
	 * Register a modul
	 * @param string $module
	 * @param string $source
	 */
	public function register($module = '', $source = '') {
		if(empty($module)) {
			foreach($this->prioritySort($this->modules) as $module => $n) {
				$this->register($module, $module);
			}
		} else {
			$m = $this->modules[$module];

			// Register methods
			$methods = $m->getMethods();
			if($methods) {
				foreach($methods as $method) {
					if(isset($this->methods[$method]))
						continue;
					$this->methods[$method] = $module;
				}
			}

			// Get parents
			if($m->getParents()) {
				foreach($m->getParents() as $parent => $importance) {
					if(!in_array($parent, $this->registered)) {
						if(array_key_exists($parent, $this->modules) && $parent != $source)
							$this->register($parent, $source);
						else if(!array_key_exists($parent, $this->modules) && $importance == 'required')
							return;
					}
				}
			}

			if(!in_array($module, $this->registered)) {
				$m->register();
				$this->registered[] = $module;
			}
		}
	}

	/**
	 * Sort by priority
	 * (the output array contains no more the objects)
	 * @param  array $modules
	 * @return array
	 */
	private function prioritySort(array $modules) {
		$hold = [];
		$holdDefault = [];

		// Get priority
		foreach($modules as $name => $object) {
			$priority = $object->getPriority();
			if($priority === -1)
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
