<?php
/**
 * @author    Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

error_reporting(E_ALL);

// Where are we?
define('DIR_TEST', dirname(__FILE__).'/');
define('DIR_LIB', DIR_TEST.'../lib/');


// Register autoloader
require_once DIR_LIB.'corefunctions.inc.php';
require_once DIR_LIB.'Autoloader.class.php';
Autoloader::register();
