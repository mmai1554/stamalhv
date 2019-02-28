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
 * Class ModuleArticleInclude
 *
 * Provide methods to include Article in Module.
 * @copyright  Thyon Design 2010
 * @author     John Brand <http://www.thyon.com>
 * @package    Controller
 */
class ModuleArticleInclude extends \Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_articleinclude';


	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### ARTICLE ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		// Return no alias has been set
		if ($this->articleAlias < 0)
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
		// get article
		$article = $this->replaceInsertTags($this->getArticle($this->articleAlias, false, true));
		
		// remove sub-indexers from included modules
		$article = str_replace(array('<!-- indexer::continue -->', '<!-- indexer::stop -->'), array('', ''), $article);
		
		$this->Template->article =  $article;

	}

}

?>