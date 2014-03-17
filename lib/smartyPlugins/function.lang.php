<?php
/**
 * @author    SilexLab <labs@silexlab.org>
 * @copyright Copyright (c) 2014 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

function smarty_function_lang($params, Smarty_Internal_Template $template) {
	return Silex::getLanguage()->get($params['node']);
}
