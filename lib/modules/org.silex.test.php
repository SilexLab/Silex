<?php
class org_silex_test implements IModule {
	public function __construct() {
		Event::register('silex.construct.end', [$this, 'testest']);
	}

	public function register() {
	}

	public function getParents() {
		return [
			'org.silex.core' => 'required',
			'org.silex.test2' => 'optional'
		];
	}


	public function testest($v = null) {
		// we are testing stuff
	}
}
