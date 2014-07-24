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

	public function __construct($styleDir, $compiledLocation = '') {
		$this->compiledLocation = $compiledLocation ? $compiledLocation : $styleDir;
		$this->styleDir = $styleDir;
		$this->scss = new scssc();
	}

	public function compile($in) {
		$e = explode('/', $in);
		$file = array_pop($e);
		$path = implode('/', $e);

		if(preg_match('/^([a-zA-Z0-9_\-]+)\.scss$/', $file, $match)) {
			// file with out extension
			$fWOExt = $match[1];

			$md5Name = md5($file);
			$md5Hash = md5_file($this->styleDir.'/'.$in);

			$out = $md5Name.'.css';
			$meta = ($path ? $path.'/' : '').$match[1].'.meta';

			// check if file need to be updated
			if(is_file($this->compiledLocation.'/'.$out) && is_file($this->styleDir.'/'.$meta) && file_get_contents($this->styleDir.'/'.$meta) == $md5Hash)
				return $out;

			file_put_contents($this->compiledLocation.'/'.$out, $this->scss->compile(file_get_contents($this->styleDir.'/'.$in), $in));
			file_put_contents($this->styleDir.'/'.$meta, $md5Hash);
			return $out;
		}
		return $in;
	}

	public function getObj() {
		return $scss;
	}
}
