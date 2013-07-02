<?php
require_once dirname(__FILE__).'/../vendor/autoload.php';

// Load our autoloader
define('TIME', time());

// Where are we?
define('DIR_ROOT', dirname(dirname(__FILE__).'/../index.php').'/');
define('DIR_TESTS', dirname(__FILE__).'/');

// Load common stuff
require_once DIR_ROOT.'options.inc.php';
require_once DIR_LIB.'corefunctions.inc.php';

// Register autoloader
require_once DIR_LIB.'Autoloader.class.php';
Autoloader::register();

// Load common interfaces and classes
require_once DIR_TESTS.'SilexDatabaseTestCase.php';

new Silex(true);
