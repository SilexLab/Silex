<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class Modules {
	private $modules = [];
	private $registered = [];

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
			}
		}

		// register modules
		$this->register();
	}

	/**
	 * Register a modul
	 * @param string $module
	 * @param string $source
	 */
	private function register($module = '', $source = '') {
		if(empty($module)) {
			foreach($this->modules as $m => $n) {
				$this->register($m, $m);
			}
		} else {
			$m = $this->modules[$module];
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
}
