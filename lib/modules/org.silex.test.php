<?php
class org_silex_test implements IModule {
	public function __construct() {
		//
	}

	public function register() {
		if(Silex::isDebug())
			echo 'registered test'.NL;
	}

	public function getParents() {
		return [
			'org.silex.core' => 'required',
			'org.silex.test2' => 'optional'
		];
	}
}
