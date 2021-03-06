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
		foreach (scandir(Dir::LIB.'page/pages/') as $pageFile) {
			if (is_file(Dir::LIB.'page/pages/'.$pageFile) && preg_match('/^(([a-zA-Z0-9]+)Page).class.php$/', $pageFile, $pageMatch)) {
				$class = $pageMatch[1];
				$page = new $class();
				if ($page instanceof Page)
					self::$pages[$page->getName()] = $page;

				// Clear object
				unset($page);
			}
		}
	}

	public static function getPage() {
		// Try to get the page by url
		if (isset(self::$pages[URL::getRoute(0)]))
			return self::$pages[URL::getRoute(0)];
		// Try to get the default page
		if (URL::getRoute() == Config::get('url.base') && isset(self::$pages[self::getDefaultPage()]))
			return self::$pages[self::getDefaultPage()];
		// Try to get the error page (because requested site wasn't found)
		if (isset(self::$pages['error']))
			return self::$pages['error'];

		// Dude... something is wrong.
		throw new CoreException('Default and error page couldn\'t be loaded.', 0, 'The default page wasn\'t loaded.');
	}

	public static function getDefaultPage() {
		return Config::get('page.default');
	}
}