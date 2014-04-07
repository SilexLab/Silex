<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

/**
 * One class to rule them all
 */
class Silex {
	protected static $db = null;
	protected static $config = null;
	protected static $modules = null;
	protected static $template = null;
	protected static $user = null;
	protected static $page = null;
	protected static $style = null;
	protected static $navigation = null;

	/**
	 * Start Silex up!
	 */
	public final function __construct($withoutOutput = false) {
		// Read config file
		if(!is_file(DIR_LIB.'config.inc.php'))
			throw new CoreException('Y U NO HAVE A CONFIG FILE?!', 0, 'Your config file can\'t be found.');
		$config = require_once DIR_LIB.'config.inc.php';

		self::$db = DatabaseFactory::initDatabase(
			$config['database.wrapper'],
			$config['database.host'],
			$config['database.user'],
			$config['database.password'],
			$config['database.name'],
			$config['database.port']);
		// Just remove these entries
		UArray::removeElements($config, ['database.host', 'database.user', 'database.password', 'database.name', 'database.port', 'database.wrapper']);
		self::$config = new Config($config);

		// Set default timezone
		date_default_timezone_set(self::$config->get('time.timezone')); // TODO: prefer user settings

		// User and session stuff
		Session::start();
		LoginCheck::init();
		self::$user = LoginCheck::getUser();
		// Initiate language
		LanguageFactory::init();

		// Check URL
		URL::check();

		// Navigation
		self::$navigation = new NavigationFactory();

		// Initiate page
		PageFactory::init();
		self::$page = PageFactory::getPage();

		// Style
		StyleFactory::init();
		self::$style = StyleFactory::getStyle();

		// Modules
		Event::fire('silex.construct.before_modules');
		self::$modules = new Modules(DIR_LIB.'modules/');
		Event::fire('silex.construct.after_modules');

		// Initiate templates
		self::$template = new Template(DIR_TPL, !self::isDebug());
		self::$page->prepare();
		self::$navigation->prepare();
		// Assign some default template variables
		Event::fire('silex.construct.before_template_assign');
		self::$template->assign([
			'page'  => self::$page->getTemplateArray(),
			'style' => self::$style->getTemplateArray(),
			'nav'   => self::$navigation->getTemplateArray(),
			'url'   => ['base' => self::$config->get('url.base')],
			'user'  => self::$user->getTemplateArray(),
			'lang'  => self::getLanguage()->getTemplateArray()
		]);

		// Display template
		if(!$withoutOutput) {
			Event::fire('silex.construct.before_display');
			header('Content-Type: text/html; charset=utf-8');
			self::$template->display('index.tpl');
		}
		Event::fire('silex.construct.end');
	}

	/**
	 * Handle our Exceptions
	 * @param Exception $e
	 */
	public static final function handleException(Exception $e) {
		if($e instanceof IPrintableException) {
			$e->show();
			exit(1);
		}

		// Repack Exception
		self::handleException(new CoreException($e->getMessage(), $e->getCode(), '', $e));
	}

	/**
	 * Catches php errors and throws instead a system exceptions
	 * @param integer $errorNo
	 * @param string  $message
	 * @param string  $filename
	 * @param integer $lineNo
	 * @throws CoreException
	 */
	public static final function handleError($errorNo, $message, $filename, $lineNo) {
		if(error_reporting() != 0) {
			$type = 'errors';
			switch($errorNo) {
				case 2:
					$type = 'warning';
					break;
				case 8:
					$type = 'notice';
					break;
			}
			throw new CoreException('PHP '.$type.' in file '.$filename.' ('.$lineNo.'): '.$message, 0);
		}
	}

	/**
	 * Access to database instance
	 * @return Database
	 */
	public static final function getDB() {
		return self::$db;
	}

	/**
	 * Get the config instance
	 * @return Config
	 */
	public static final function getConfig() {
		//return self::$config->get($node);
		return self::$config;
	}

	/**
	 * Get template instance
	 * @return Template
	 */
	public static final function getTemplate() {
		return self::$template;
	}

	/**
	 * @return User
	 */
	public static final function getUser() {
		return self::$user;
	}

	/**
	 * @return Language
	 */
	public static final function getLanguage() {
		// TODO: Which language does he/she/it want?
		return LanguageFactory::getDefaultLanguage();
	}

	/**
	 * @return Page
	 */
	public static final function getPage() {
		return self::$page;
	}

	/**
	 * @return Breadcrumbs
	 */
	public static final function getNav() {
		return self::$navigation;
	}

	/**
	 * @return bool
	 */
	public static final function isDebug() {
		return DEBUG;
	}
}
