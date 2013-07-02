<?php
require_once dirname(__FILE__).'/../vendor/autoload.php';

// Load our autoloader
define('TIME', time());

// Where are we?
define('DIR_ROOT', dirname(dirname(__FILE__).'/../index.php').'/');

// Load common stuff
require_once DIR_ROOT.'options.inc.php';
require_once DIR_LIB.'corefunctions.inc.php';

// Register autoloader
require_once DIR_LIB.'Autoloader.class.php';
Autoloader::register();
