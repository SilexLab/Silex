<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

require_once 'preprocessor/scss/scss.inc.php';
require_once 'preprocessor/scss/src/Formatter/NestedSilex.php';

/**
 * Simple SCSS wrapper
 */
class CSSPreprocessor {
	private $scss = null;
	private $server = null;
	private $compiledLocation = '';
	private $styleDir = '';
	public $cssSubDir = 'css/';

	public function __construct($styleDir, $compiledLocation = '') {
		$this->compiledLocation = $compiledLocation ? $compiledLocation : $styleDir;
		$this->styleDir = $styleDir.'/';
		$this->scss = new \Scss\Compiler();
		$this->scss->setFormatter('Scss\Formatter\NestedSilex');
		$this->server = new \Scss\Server($this->styleDir.'scss/', $this->styleDir.'css/', $this->scss);
	}

	public function compile($in) {
		$pi = pathinfo($in);
		if (preg_match('/^([a-zA-Z0-9_\-]+)\.scss$/', $pi['basename'])) {
			$out = $this->cssSubDir.$pi['filename'].'.css';

			if ($this->server->checkedCompile($this->styleDir.$in, $this->styleDir.$out))
				$this->server->compileFile($this->styleDir.$in, $this->styleDir.$out);
			return $out;
		}
		return $in;
	}

	public function getCompiler() {
		return $this->scss;
	}

	public function getServer() {
		return $this->server;
	}
}
