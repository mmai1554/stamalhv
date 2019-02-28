<?php 

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package ContentBreak
 * @link    http://www.contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace Contao;


/**
 * Class ContentWrap
 *
 * Front end content element "DIV Wrapper".
 * @copyright  Thyon Design 2010-2012
 * @author     John Brand <http://www.thyon.com>
 * @package    ContentWrap
 */

class ContentWrap extends \ContentElement
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_wrap_start';

	/**
	 * Colors
	 * @var string
	 */
	private $colors = array('maroon','aqua','olive','forestgreen','mistyrose', 'mediumblue', 'violet');


	/**
	 * Generate BE visibility
	 */
	public function compile()
	{

		//static index counter
		static $wrapIndex = 0;
		static $wrapColors = array();

		// Accordion start
		if ($this->wrapType == 'wstart')
		{

			// increment index;
			$wrapIndex++;

			if (TL_MODE == 'FE')
			{
				$this->strTemplate = 'ce_wrap_start';
				$this->Template = new \FrontendTemplate($this->strTemplate);
				$this->Template->setData($this->arrData);
			}
			else
			{
				// get and store color
				$color = $this->colors[$this->id % count($this->colors)];
				$wrapColors[$wrapIndex] = $color;

				$cssID = (($this->cssID[0] != '') ?  $this->generateImage('system/modules/ce_wrap/public/icon-id.png', 'class', 'style="vertical-align:-2px;"') .' '. $this->cssID[0] . ' &nbsp;&nbsp; ' : '') . (($this->cssID[1] != '') ? ' '. $this->generateImage('system/modules/ce_wrap/public/icon-class.png', 'id', 'style="vertical-align:-2px;"') .' '. $this->cssID[1] : '');

				$this->strTemplate = 'be_wildcard';
				$this->Template = new \BackendTemplate($this->strTemplate);
				$this->Template->wildcard = '<div style="margin-left:'.(($wrapIndex-1)*10).'px;background: url(system/modules/ce_wrap/public/wrap-start.png) no-repeat 5px center;padding-left:20px;"><strong>DIV</strong> &nbsp;&nbsp; '.$cssID.'</div>';

			}

		}

		// Accordion end
		elseif ($this->wrapType == 'wstop')
		{
			if (TL_MODE == 'FE')
			{
				$this->strTemplate = 'ce_wrap_stop';
				$this->Template = new \FrontendTemplate($this->strTemplate);
				$this->Template->setData($this->arrData);
			}
			else
			{
				// get stored color
				$color = $wrapColors[$wrapIndex];

				$this->strTemplate = 'be_wildcard';
				$this->Template = new \BackendTemplate($this->strTemplate);
				$this->Template->title = '<div style="margin-left:'.(($wrapIndex-1)*10).'px;background: url(system/modules/ce_wrap/public/wrap-stop.png) no-repeat 5px center;padding-left:20px;">DIV</div>';
			}

			// decrement index;
			$wrapIndex--;
			if ($wrapIndex < 0)
			{
				$wrapIndex = 0;
			}
		}

	}


}

?>