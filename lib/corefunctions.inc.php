<?php
/**
 * @author    Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

/**
 * Recursive scandir
 * @author Patrick Kleinschmidt (NoxNebula) <noxifoxi@gmail.com>
 * @param  string $directory
 * @param  int    $sorting_order
 * @return array
 */
function scandirr($directory, $sorting_order = 0) {
	$files = scandir($directory, $sorting_order);
	if(strpos($directory, '/', strlen($directory) - 1) === false)
		$directory .= '/';

	$rfiles = [];
	foreach($files as $f) {
		if(($f === '.' || $f === '..') && is_dir($directory.$f))
			continue;
		if(is_dir($directory.$f)) {
			$rf = scandirr($directory.$f, $sorting_order);
			for($i = 0; $i < sizeof($rf); $i++)
				$rfiles[] = $f.'/'.$rf[$i];
		}
		else
			$rfiles[] = $f;
	}
	return $rfiles;
}
