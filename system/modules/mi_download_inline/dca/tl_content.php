<?php 

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package Backend
 * @link    http://www.contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Table tl_content
 *
 * @copyright  nordwerker.net
 * @author     Michael Mai <http://www.nordwerker.net>
 */


$GLOBALS['TL_DCA']['tl_content']['palettes']['downloadinline'] = '{type_legend},type,headline;{source_legend},singleSRC;{dwnconfig_legend},linkTitle,titleText;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['downloadsinline'] = '{type_legend},type,headline;{source_legend},multiSRC,sortBy,useHomeDir;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
		
?>