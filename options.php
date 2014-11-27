<?php
/**
 * @author SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @link https://silexlab.org/
 */

/* PHP runtime settings */

// For debugging
error_reporting(E_ALL);

// UTF-8 everything
ini_set('default_charset', 'UTF-8');
ini_set('php.input_encoding', 'UTF-8');
ini_set('php.internal_encoding', 'UTF-8');
ini_set('php.output_encoding', 'UTF-8');

mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

// set include path
ini_set('include_path', '.');


/* Defining constants */

// Debugging mode enabled?
define('DEBUG', true);

define('ROOT', dirname(__FILE__) . '/');
define('NL', "\n");
