<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package Ce_wrap
 * @link    http://www.contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Elements
	'Contao\ContentWrap' => 'system/modules/ce_wrap/elements/ContentWrap.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'ce_wrap_start' => 'system/modules/ce_wrap/templates',
	'ce_wrap_stop'  => 'system/modules/ce_wrap/templates',
));
