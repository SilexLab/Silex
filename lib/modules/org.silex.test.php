<?php
class org_silex_test implements IModule {
	public function __construct() {
		//
	}

	public function register() {
	}

	public function getParents() {
		return [
			'org.silex.core' => 'required',
			'org.silex.test2' => 'optional'
		];
	}
}
