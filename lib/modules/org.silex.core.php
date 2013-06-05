<?php
class org_silex_core implements IModule {
	public function __construct() {
		//
	}

	public function register() {
		if(Silex::isDebug())
			echo 'registered core'.NL;
	}

	public function getParents() {
		return null;
	}
}
