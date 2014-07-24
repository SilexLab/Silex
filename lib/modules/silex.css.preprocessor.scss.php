<?php
class silex_css_preprocessor_scss implements IModule {
	protected $preprocessor = null;

	public function __construct() {}

	public function register() {}

	public function getParents() {
		return null;
	}

	public function getPriority() {
		return 0;
	}

	public function getModuleGroup() {
		return 'silex.css.preprocessor';
	}

	public function getMethods() {
		return ['getCSSPreprocessor'];
	}

	public function callMethod($name, $args) {
		if($name == 'getCSSPreprocessor') {
			if($this->preprocessor === null)
				$this->preprocessor = new CSSPreprocessor($args[0]);
			return $this->preprocessor;
		}
	}
}
