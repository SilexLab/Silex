<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class StyleFactory {
	protected $styleObjects = [];

	public function __construct() {
		// Read all dem data
		foreach (scandir(DSTYLE) as $file) {
			if (!in_array($file, ['.', '..']) && is_dir(DSTYLE.$file) && preg_match('/^[a-zA-Z0-9_\-\.]+$/', $file)) {
				try {
					include_once(DSTYLE.$file.'/style.php');
					$class = preg_replace('/\./', '_', $file);
					$this->styleObjects[$file] = new $class;
					if (!($this->styleObjects[$file] instanceof Style))
						throw new StyleNotFoundException('Invalid Style');
				} catch(Exception $e) {
					echo 'StyleFactory: '.$e->getMessage();
					unset($this->styleObjects[$file]);
				}
			}
		}
	}

	public function getStyle() {
		// get default style
		$style = Config::get('style.default');

		// TODO: get user style
		// if user has custom style then $style = user's style

		if (isset($this->styleObjects[$style]))
			return $this->styleObjects[$style];
		
		// Do you really want to torture your visitors with an ugly page without a style? Nice try, not with Silex. Silex protects visitors against ugly webpages. Use Silex now. Only today 20% off. 100% free and open source. Grab it now.
		throw new StyleNotFoundException('The default style \''.$style.'\' could not be found.');
	}
}
