<?php
class silex_markdown implements IModule {
	protected $markdown = null;

	public function __construct() {}

	public function register() {}

	public function getParents() {
		return null;
	}

	public function getPriority() {
		return 0;
	}

	public function getMethods() {
		return ['getMarkdown'];
	}

	public function callMethod($name, $args) {
		if($name == 'getMarkdown') {
			if($this->markdown === null)
				$this->markdown = new Markdown();
			return $this->markdown;
		}
	}
}
