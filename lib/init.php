<?php
/**
 * @author    Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

// Libraries directory
define('DIR_LIB', dirname(__FILE__).'/');

// Load common stuff
require_once DIR_LIB.'options.inc.php';
require_once DIR_LIB.'corefunctions.inc.php';

// Register autoloader
require_once DIR_LIB.'Autoloader.class.php';
Autoloader::register();

new Silex();
