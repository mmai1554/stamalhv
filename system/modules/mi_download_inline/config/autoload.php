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
    'Contao\DownloadInline' => 'system/modules/mi_download_inline/elements/DownloadInline.php',
    'Contao\DownloadsInline' => 'system/modules/mi_download_inline/elements/DownloadsInline.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'ce_download_inline' => 'system/modules/mi_download_inline/templates',
	'ce_downloads_inline' => 'system/modules/mi_download_inline/templates',
));
