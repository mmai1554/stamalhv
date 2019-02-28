<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package Includes
 * @link    http://www.contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Modules
	'Contao\ModuleArticleInclude' => 'system/modules/includes/modules/ModuleArticleInclude.php',
	'Contao\ModuleContentInclude'        => 'system/modules/includes/modules/ModuleContentInclude.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_articleinclude' => 'system/modules/includes/templates',
	'mod_contentinclude' => 'system/modules/includes/templates',
));
