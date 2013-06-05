<?php
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
		} else
			$rfiles[] = $f;
	}
	return $rfiles;
}

/**
 * Get the file extension
 * @author Patrick Kleinschmidt (NoxNebula) <noxifoxi@gmail.com>
 * @param  string $file
 * @return string
 */
function file_ext($file) {
	return pathinfo($file, PATHINFO_EXTENSION);
}

/* ARRAYS */

/**
 * Searches the array for a given value and returns the corresponding key(s) if successful
 * @author Patrick Kleinschmidt (NoxNebula) <noxifoxi@gmail.com>
 * @param  mixed $needle
 * @param  array $haystack
 * @param  bool  $strict = false
 * @return mixed
 */
function array_search_all($needle, array $haystack, $strict = false) {
	$founds = [];
	foreach($haystack as $key => $value) {
		if(!$strict && $value == $needle)
			$founds[] = $key;
		else if($strict && $value === $needle)
			$founds[] = $key;
	}
	return empty($founds) ? false : $founds;
}

/* MATH */

/**
 * clamp the value
 * @author Patrick Kleinschmidt (NoxNebula) <noxifoxi@gmail.com>
 * @param mixed $value
 * @param int   $min
 * @param int   $max
 * @return mixed
 */
function clamp($value, $min, $max) {
	return max(min($value, $max), $min);
}

/* STRINGS */

/**
 * Can we find the needle in the haystack?
 * @author Patrick Kleinschmidt (NoxNebula) <noxifoxi@gmail.com>
 * @param string $haystack
 * @param string $needle
 * @return bool
 */
function strfind($haystack, $needle) {
	return strpos($haystack, $needle) !== false;
}

/**
 * urlencode without touching the slashes
 * @author Patrick Kleinschmidt (NoxNebula) <noxifoxi@gmail.com>
 * @param string $url
 * @return string
 */
function urlencode_slashes($url) {
	if(preg_match('/^(?<scheme>[a-z][a-z0-9+\-.]*:\/\/)/ix', $url, $m)) {
		$newURL = $m['scheme'];
		$url = explode('/', substr($url, strlen($newURL)));
		for($i = 0; $i < sizeof($url); $i++)
			$newURL .= urlencode($url[$i]).(($i < sizeof($url) - 1) ? '/' : '');
		return $newURL;
	}
	return urlencode($url);
}

/**
 * rawurlencode without touching the slashes
 * @author Patrick Kleinschmidt (NoxNebula) <noxifoxi@gmail.com>
 * @param  string $url
 * @return string
 */
function rawurlencode_slashes($url) {
	if(preg_match('/^(?<scheme>[a-z][a-z0-9+\-.]*:\/\/)/ix', $url, $m)) {
		$newURL = $m['scheme'];
		$url = explode('/', substr($url, strlen($newURL)));
		for($i = 0; $i < sizeof($url); $i++)
			$newURL .= rawurlencode($url[$i]).(($i < sizeof($url) - 1) ? '/' : '');
		return $newURL;
	}
	return rawurlencode($url);
}
