<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

ini_set('default_charset', 'UTF-8');
ini_set('php.input_encoding', 'UTF-8');
ini_set('php.internal_encoding', 'UTF-8');
ini_set('php.output_encoding', 'UTF-8');

define('SILEX_VERSION', '0.1.0-DEV');
define('DEBUG', true);

// New line
define('NL', PHP_EOL);

// Relative directories
define('RLIB', 'lib/');
define('RCACHE', 'cache/');
define('RASSET', 'asset/');
define('RTPL', RASSET.'template/');
define('RLANG', RASSET.'language/');
define('RSTYLE', RASSET.'style/');

// Directories
define('DLIB', DROOT.RLIB);
define('DCACHE', DROOT.RCACHE);
define('DASSET', DROOT.RASSET);
define('DTPL', DROOT.RTPL);
define('DLANG', DROOT.RLANG);
define('DSTYLE', DROOT.RSTYLE);
