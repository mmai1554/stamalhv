<?php 


/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package Includes
 * @link    http://www.thyon.com
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace Contao;


/**
 * Class ModuleContentInclude
 *
 * Provide methods to include Content in Module.
 * @copyright  Thyon Design 2010
 * @author     John Brand <http://www.thyon.com>
 * @package    Controller
 */
class ModuleContentInclude extends \Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_contentinclude';

	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### CONTENT ELEMENT ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&table=tl_module&act=edit&id=' . $this->id;

			return $objTemplate->parse();
		}

		// Return no alias has been set
		if ($this->cteAlias < 0)
		{
			return '';
		}
		
		return parent::generate();


	}


	/**
	 * Generate module
	 */
	protected function compile()
	{
		$objElement = $this->Database->prepare("SELECT * FROM tl_content WHERE id=?")
									 ->limit(1)
									 ->execute($this->cteAlias);

		if ($objElement->numRows < 1)
		{
			return '';
		}

		$strClass = $this->findContentElement($objElement->type);

		if (!$this->classFileExists($strClass))
		{
			return '';
		}

		$objElement->id = $this->id;
		$objElement->typePrefix = 'ce_';

		$objElement = new $strClass($objElement);

		// Overwrite spacing and CSS ID
		// $objElement->space = $this->space;
		// $objElement->cssID = $this->cssID;

		$this->Template->contentelement = $objElement->generate();
	}

}

?>