<?php
/**
 * @author SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @link https://silexlab.org/
 */

// Excuse me, what time is it?
define('MICROTIME', microtime(true));
define('TIME', time());

// Check PHP version
if (!version_compare(PHP_VERSION, '5.6.0', '>=')) {
	trigger_error('Current PHP version: ' . PHP_VERSION . '. '
		. 'You need at least PHP 5.6.0 to execute Silex. Please upgrade your PHP environment in order to run Silex.'
	, E_USER_ERROR);
}

// Check required extensions
if (!extension_loaded('Zend Opcache')) {
	trigger_error('Please enable Zend Opcache extension in your php.ini with "zend_extension='
		. (PHP_SHLIB_SUFFIX == 'dll' ? 'php_' : '') . 'opcache.' . PHP_SHLIB_SUFFIX . '".'
	, E_USER_NOTICE);
}

// setting options
require_once 'options.php';

// bootstrap
require_once 'lib/bootstrap.php';

// PHP execution time / debugging mode message
if (DEBUG) {
	echo '<p style="text-align: center; color: #aaa; font-size: 12px; padding-bottom: 20px;">
		DEBUGGING MODE ENABLED<br>
		Please note that Silex takes longer to execute in debugging mode than usual.<br>
		PHP execution: '.round((microtime(true) - MICROTIME) * 1000, 2).' ms'.'
	</p>';
} else if (Config::get('system.show_load')) {
	echo '<p style="text-align: center; color: #aaa; font-size: 12px; padding-bottom: 20px;">
		'.round((microtime(true) - MICROTIME) * 1000, 2).' ms'.'
	</p>';
}
