<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

/* PHP ini settings */
ini_set('default_charset', 'UTF-8');
ini_set('php.input_encoding', 'UTF-8');
ini_set('php.internal_encoding', 'UTF-8');
ini_set('php.output_encoding', 'UTF-8');

/* Constants */
define('DEBUG', true);

// Helper constant for Dir class
define('ROOT', dirname(__FILE__));
// Directory constants
class Dir {
	// root directory
	const ROOT  = ROOT.'/';

	// all constants are relative to ROOT
	const LIB   = 'lib/';
	const CACHE = 'cache/';
	const ASSET = 'asset/';
	const TPL   = self::ASSET.'template/';
	const LANG  = self::ASSET.'language/';
	const STYLE = self::ASSET.'style/';
}

// New line
define('NL', PHP_EOL);

/* Other settings */
