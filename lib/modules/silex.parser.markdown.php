<?php
class silex_parser_markdown implements IModule {
	protected $markdown = null;

	public function __construct() {}

	public function register() {}

	public function getParents() {
		return null;
	}

	public function getPriority() {
		return 0;
	}

	public function getModuleGroup() {
		return 'silex.parser';
	}

	public function getMethods() {
		return ['getParser'];
	}

	public function callMethod($name, $args) {
		if($name == 'getParser') {
			if($this->markdown === null)
				$this->markdown = new Markdown();
			return $this->markdown;
		}
	}
}
