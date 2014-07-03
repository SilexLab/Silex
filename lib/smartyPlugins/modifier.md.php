<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

function smarty_modifier_md($text) {
	if(Silex::getModule()->status('silex.markdown') == 1)
		return Silex::getParser()->parse($text);
	return $text;
}
