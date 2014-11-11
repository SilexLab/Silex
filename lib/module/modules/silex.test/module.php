<?php
class silex_test implements IModule {
	public function __construct() {
	}

	public function load() {
		Event::listen('silex.construct.end', [$this, 'testest']);
	}

	public function getParents() {
		return [
			'silex.core' => 'required',
			'silex.test2' => 'optional'
		];
	}

	public function getPriority() {
		return -1;
	}

	public function getModuleGroup() {
		return null;
	}

	public function testest($v = null) {
		// we are testing stuff
	}

	public function getMethods() {}

	public function callMethod($name, $args) {}
}
