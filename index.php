<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

// Excuse me, what time is it?
define('MICROTIME', microtime(true));
define('TIME', time());

// Where are we?
define('DROOT', dirname(__FILE__).'/');

// Load common stuff
require_once DROOT.'options.inc.php';
require_once DLIB.'corefunctions.inc.php';

// Register autoloader
require_once DLIB.'Autoloader.class.php';
Autoloader::register();

// Load third-party stuff
if(!is_file(DROOT.'lib/smarty/Smarty.class.php')) {
	header('Content-Type: text/plain; charset=UTF-8');
	die('Please run:
  git submodule foreach git pull');
}

// Set exception handler
set_exception_handler(['Silex', 'handleException']);
set_error_handler(['Silex', 'handleError'], E_ALL);

// Now lets start Silex
new Silex();

// PHP execution time / debugging mode
if(DEBUG) {
	echo '<p style="text-align: center; color: #aaa; font-size: 12px; padding-bottom: 20px;">
	DEBUGGING MODE ENABLED<br>
	Please note that Silex takes longer to execute in debugging mode than usual.<br>
	PHP execution: '.round((microtime(true) - MICROTIME) * 1000, 2).' ms'.'
</p>
';
} else if(Config::get('system.show_load')) {
	echo '<p style="text-align: center; color: #aaa; font-size: 12px; padding-bottom: 20px;">
	'.round((microtime(true) - MICROTIME) * 1000, 2).' ms'.'
</p>
';
}
echo '</body>
</html>
';
