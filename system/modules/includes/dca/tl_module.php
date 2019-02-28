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
 * Table tl_module
 *
 * @copyright  Thyon Design 2010-2012
 * @author     John Brand <http://www.thyon.com>
 */


$GLOBALS['TL_DCA']['tl_module']['palettes']['content'] = '{title_legend},name,headline,type;{config_legend},cteAlias;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['article'] = '{title_legend},name,headline,type;{config_legend},articleAlias;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';


$GLOBALS['TL_DCA']['tl_module']['fields']['cteAlias'] = array 
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['cteAlias'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('tl_module_includes', 'getAlias'),
	'eval'                    => array('mandatory'=>true, 'submitOnChange'=>true),
	'wizard' => array
	(
		array('tl_module_includes', 'editAlias')
	),
	'sql'											=> "int(10) unsigned NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['articleAlias'] = array 
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['articleAlias'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('tl_module_includes', 'getArticleAlias'),
	'eval'                    => array('mandatory'=>true, 'submitOnChange'=>true),
	'wizard' => array
	(
		array('tl_module_includes', 'editArticleAlias')
	),
  'sql'											=> "int(10) unsigned NOT NULL default '0'"
);


/**
 * Class tl_module
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Leo Feyer 2005-2010
 * @author     Leo Feyer <http://www.contao.org>
 * @package    Controller
 */
class tl_module_includes extends tl_module
{

	/**
	 * Import the back end user object
	 */
/*
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}
*/

	/**
	 * Return the edit alias wizard
	 * @param object
	 * @return string
	 */
	public function editAlias(DataContainer $dc)
	{
		return ($dc->value < 1) ? '' : ' <a href="contao/main.php?do=article&table=tl_content&act=edit&id='. $dc->value.'" title="'.sprintf(specialchars($GLOBALS['TL_LANG']['tl_module']['editalias'][1]), $dc->value).'" style="padding-left:3px;">' . $this->generateImage('alias.gif', $GLOBALS['TL_LANG']['tl_module']['editalias'][0], 'style="vertical-align:top;"') . '</a>';
	}

	/**
	 * Get all content elements and return them as array (content element alias)
	 * @return array
	 */
	public function getAlias()
	{
		$arrPids = array();
		$arrAlias = array();

		if (!$this->User->isAdmin)
		{
			foreach ($this->User->pagemounts as $id)
			{
				$arrPids[] = $id;
				$arrPids = array_merge($arrPids, $this->getChildRecords($id, 'tl_page'));
			}

			if (empty($arrPids))
			{
				return $arrAlias;
			}

			$objAlias = $this->Database->prepare("SELECT c.id, c.pid, c.type, (CASE c.type WHEN 'module' THEN m.name WHEN 'form' THEN f.title WHEN 'table' THEN c.summary ELSE c.headline END) AS headline, c.text, a.title FROM tl_content c LEFT JOIN tl_article a ON a.id=c.pid LEFT JOIN tl_module m ON m.id=c.module LEFT JOIN tl_form f on f.id=c.form WHERE a.pid IN(". implode(',', array_map('intval', array_unique($arrPids))) .") AND c.id!=? ORDER BY a.title, c.sorting")
									   ->execute(Input::get('id'));
		}
		else
		{
			$objAlias = $this->Database->prepare("SELECT c.id, c.pid, c.type, (CASE c.type WHEN 'module' THEN m.name WHEN 'form' THEN f.title WHEN 'table' THEN c.summary ELSE c.headline END) AS headline, c.text, a.title FROM tl_content c LEFT JOIN tl_article a ON a.id=c.pid LEFT JOIN tl_module m ON m.id=c.module LEFT JOIN tl_form f on f.id=c.form WHERE c.id!=? ORDER BY a.title, c.sorting")
									   ->execute(Input::get('id'));
		}

		while ($objAlias->next())
		{
			$arrHeadline = deserialize($objAlias->headline, true);

			if (isset($arrHeadline['value']))
			{
				$headline = String::substr($arrHeadline['value'], 32);
			}
			else
			{
				$headline = String::substr(preg_replace('/[\n\r\t]+/', ' ', $arrHeadline[0]), 32);
			}

			$text = String::substr(strip_tags(preg_replace('/[\n\r\t]+/', ' ', $objAlias->text)), 32);
			$strText = $GLOBALS['TL_LANG']['CTE'][$objAlias->type][0] . ' (';

			if ($headline != '')
			{
				$strText .= $headline . ', ';
			}
			elseif ($text != '')
			{
				$strText .= $text . ', ';
			}

			$key = $objAlias->title . ' (ID ' . $objAlias->pid . ')';
			$arrAlias[$key][$objAlias->id] = $strText . 'ID ' . $objAlias->id . ')';
		}

		return $arrAlias;
	}

	/**
	 * Return the edit article alias wizard
	 * @param object
	 * @return string
	 */
	public function editArticleAlias(DataContainer $dc)
	{
		return ($dc->value < 1) ? '' : ' <a href="contao/main.php?do=article&table=tl_article&act=edit&id=' . $dc->value . '" title="'.sprintf(specialchars($GLOBALS['TL_LANG']['tl_module']['editalias'][1]), $dc->value).'" style="padding-left:3px;">' . $this->generateImage('alias.gif', $GLOBALS['TL_LANG']['tl_module']['editalias'][0], 'style="vertical-align:top;"') . '</a>';
	}

	/**
	 * Get all articles and return them as array (article alias)
	 * @param object
	 * @return array
	 */
	public function getArticleAlias(DataContainer $dc)
	{
		$arrPids = array();
		$arrAlias = array();

		if (!$this->User->isAdmin)
		{
			foreach ($this->User->pagemounts as $id)
			{
				$arrPids[] = $id;
				$arrPids = array_merge($arrPids, $this->Database->getChildRecords($id, 'tl_page'));
			}

			if (empty($arrPids))
			{
				return $arrAlias;
			}

			$objAlias = $this->Database->prepare("SELECT a.id, a.pid, a.title, a.inColumn, p.title AS parent FROM tl_article a LEFT JOIN tl_page p ON p.id=a.pid WHERE a.pid IN(". implode(',', array_map('intval', array_unique($arrPids))) .") ORDER BY parent, a.sorting")
									   ->execute();
		}
		else
		{
			$objAlias = $this->Database->prepare("SELECT a.id, a.pid, a.title, a.inColumn, p.title AS parent FROM tl_article a LEFT JOIN tl_page p ON p.id=a.pid ORDER BY parent, a.sorting")
									   ->execute();
		}

		if ($objAlias->numRows)
		{
			$this->loadLanguageFile('tl_article');

			while ($objAlias->next())
			{
				$key = $objAlias->parent . ' (ID ' . $objAlias->pid . ')';
				$arrAlias[$key][$objAlias->id] = $objAlias->title . ' (' . ($GLOBALS['TL_LANG']['tl_article'][$objAlias->inColumn] ?: $objAlias->inColumn) . ', ID ' . $objAlias->id . ')';
			}
		}

		return $arrAlias;
	}


}

?>