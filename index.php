<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

// Excuse me, what time is it?
define('TIME', time());
define('MICROTIME', microtime(true));

// Where are we?
define('DIR_ROOT', dirname(__FILE__).'/');

// Load common stuff
require_once DIR_ROOT.'options.inc.php';
require_once DIR_LIB.'corefunctions.inc.php';

// Register autoloader
require_once DIR_LIB.'Autoloader.class.php';
Autoloader::register();
// Load third-party stuff
if(is_file(DIR_ROOT.'vendor/autoload.php'))
	require_once DIR_ROOT.'vendor/autoload.php';
else
	die('Please run "composer install".');

// Set default timezone
// TODO: read from config and prefer user settings
date_default_timezone_set('Europe/Berlin');

// Set exception handler
set_exception_handler(['Silex', 'handleException']);
set_error_handler(['Silex', 'handleError'], E_ALL);

new Silex();
