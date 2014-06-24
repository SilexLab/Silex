<?php
class org_silex_core implements IModule {
	public function __construct() {
		//
	}

	public function register() {
		// Database
		// 
	}

	public function getParents() {
		return null;
	}

	public function getPriority() {
		return 0;
	}

	public function getObjects() {
		// get the module objects
		// ['ModuleName' => $object]
		// called by __call() in Silex (Silex::getModuleName()->[...])
	}
}
