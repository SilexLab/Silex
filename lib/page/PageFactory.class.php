<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class PageFactory {

	protected static $pages = [];

	public static function init() {
		// Find available wrappers
		foreach(scandir(DIR_LIB.'pages/') as $pageFile) {
			if(is_file(DIR_LIB.'pages/'.$pageFile) && preg_match('/^([a-zA-Z0-9]+)Page.class.php$/', $pageFile)) {
				$class = substr($pageFile, 0, -strlen('.class.php'));

				$page = new $class();
				if($page instanceof Page)
					self::$pages[$page->getName()] = $page;

				// Clear object
				unset($page);
			}
		}
	}

	public static function getDefaultPage() {
		if(isset(self::$pages[Silex::getConfig()->get('page.default_page')]))
			return self::$pages[Silex::getConfig()->get('page.default_page')];
		else
			throw new CoreException('Default page couldn\'t be loaded.', 0, 'The default page wasn\'t loaded.');
	}

}