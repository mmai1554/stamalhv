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
 * @copyright  Thyon Design 2010-2012
 * @author     John Brand <http://www.thyon.com>
 */

$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'wrapType';

$GLOBALS['TL_DCA']['tl_content']['palettes']['wrap'] = '{type_legend},type,wrapType';
$GLOBALS['TL_DCA']['tl_content']['palettes']['wrapwstart'] = '{type_legend},type,wrapType;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['wrapwstop'] = '{type_legend},type,wrapType;{protected_legend:hide},protected;{expert_legend:hide},guests;{invisible_legend:hide},invisible,start,stop';


// Fields
$GLOBALS['TL_DCA']['tl_content']['fields']['wrapType'] = array
(
	'label'					=> &$GLOBALS['TL_LANG']['tl_content']['wrapType'],
	'default'				=> 'wstart',
	'exclude'				=> true,
	'inputType'			=> 'radio',
	'options'				=> array('wstart', 'wstop'),
	'reference'			=> &$GLOBALS['TL_LANG']['tl_content']['wrapTypes'],
	'eval'					=> array('helpwizard'=>true, 'submitOnChange'=>true),
  'sql'						=> "varchar(32) NOT NULL default ''"
);

?>