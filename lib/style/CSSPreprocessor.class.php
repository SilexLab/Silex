<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

require_once 'scss/scss.inc.php';

/**
 * Simple SCSS wrapper
 */
class CSSPreprocessor {
	private $scss = null;
	private $compiledLocation = '';
	private $styleDir = '';
	public $cssSubDir = 'css/';

	public function __construct($styleDir, $compiledLocation = '') {
		$this->compiledLocation = $compiledLocation ? $compiledLocation : $styleDir;
		$this->styleDir = $styleDir.'/';
		$this->scss = new scssc();
		$this->scss->setFormatter('scss_formatter_nested_ex');
	}

	public function compile($in) {
		$pi = pathinfo($in);
		if(preg_match('/^([a-zA-Z0-9_\-]+)\.scss$/', $pi['basename'])) {
			$out = $this->cssSubDir.$pi['filename'].'.css';

			if($this->scss->checkedCompile($this->styleDir.$in, $this->styleDir.$out))
				$this->scss->compileFile($this->styleDir.$in, $this->styleDir.$out);
			return $out;
		}
		return $in;
	}

	public function getObj() {
		return $scss;
	}
}
