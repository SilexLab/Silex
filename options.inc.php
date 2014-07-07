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
define('REL_LIB', 'lib/');
define('REL_CACHE', 'cache/');
define('REL_ASSET', 'asset/');
define('REL_TPL', REL_ASSET.'template/');
define('REL_LANGUAGE', REL_ASSET.'language/');
define('REL_STYLE', REL_ASSET.'style/');

// Directories
define('DIR_LIB', DIR_ROOT.REL_LIB);
define('DIR_CACHE', DIR_ROOT.REL_CACHE);
define('DIR_ASSET', DIR_ROOT.REL_ASSET);
define('DIR_TPL', DIR_ROOT.REL_TPL);
define('DIR_LANGUAGE', DIR_ROOT.REL_LANGUAGE);
define('DIR_STYLE', DIR_ROOT.REL_STYLE);
