<?php
/**
 * WebTricks - PHP Framework
 *
 * LICENSE
 *
 * For the full copyright and license information, please view the 
 * following URL: http://www.webtricksframework.com/license 
 * 
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade to newer versions in
 * the future. If you wish to customize WebTricks for your needs please go to 
 * http://www.webtricksframework.com for more information.
 *
 * @copyright Copyright (c) 2007-2010 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * A specialized toolbar that is bound to a Cream.Web.UI.Ext.Data.Store and 
 * provides automatic paging controls. 
 *
 * @package		Cream_Web_UI_ExtControls
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_PagingToolbar extends Cream_Web_UI_ExtControls_Toolbar 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_PagingToolbar
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Initialize function
	 *
	 */
	public function __init()
	{
		$this->setControl('Ext.PagingToolbar');
		$this->setAttribute('xtype', 'paging');
	}

	/**	
	 * Customizable piece of the default paging text (defaults to 'of {0}'). 
	 * Note that this string is formatted using {0} as a token that is replaced 
	 * by the number of total pages. This token should be preserved when 
	 * overriding this string if showing the total page count is desired.
	 *
	 * @param string $afterPageText
	 */
	public function setAfterPageText($afterPageText) 
	{
		$this->setAttribute('afterPageText', $afterPageText);
	}

	/**
	 * The text displayed before the input item (defaults to 'Page').
	 *
	 * @param string $beforePageText
	 */
	public function setBeforePageText($beforePageText) 
	{
		$this->setAttribute('beforePageText', $beforePageText);
	}	
	
	/**
	 * The Ext.data.Store the paging toolbar should use as its data source 
	 * (required).
	 *
	 * @param ext.data.store $store
	 */
	public function setStore($store) 
	{
		$this->setAttribute('store', $store);
	}

	/**
	 * True to display the displayMsg (defaults to false)
	 *
	 * @param boolean $displayInfo
	 */
	public function setDisplayInfo($displayInfo) 
	{
		$this->setAttribute('displayInfo', $displayInfo);
	}

	/**
	 * The number of records to display per page (defaults to 20)
	 *
	 * @param number $pageSize
	 */
	public function setPageSize($pageSize) 
	{
		$this->setAttribute('pageSize', $pageSize);
	}

	/**
	 * The paging status message to display (defaults to 'Displaying {0} - {1} 
	 * of {2}'). Note that this string is formatted using the braced numbers 
	 * {0}-{2} as tokens that are replaced by the values for start, end and 
	 * total respectively. These tokens should be preserved when overriding 
	 * this string if showing those values is desired.
	 *
	 * @param string $displayMsg
	 */
	public function setDisplayMsg($displayMsg) 
	{
		$this->setAttribute('displayMsg', $displayMsg);
	}

	/**
	 * The message to display when no records are found (defaults to 'No data 
	 * to display')
	 *
	 * @param string $emptyMsg
	 */
	public function setEmptyMsg($emptyMsg) 
	{
		$this->setAttribute('emptyMsg', $emptyMsg);
	}
	
	/**
	 * The quicktip text displayed for the first page button (defaults to 
	 * 'First Page'). Note: quick tips must be initialized for the quicktip to 
	 * show.
	 *
	 * @param string $firstText
	 */
	public function setFirstText($firstText) 
	{
		$this->setAttribute('firstText', $firstText);
	}	
	
	/**
	 * The quicktip text displayed for the last page button (defaults to 'Last 
	 * Page'). Note: quick tips must be initialized for the quicktip to show.
	 *
	 * @param string $lastText
	 */
	public function setLastText($lastText) 
	{
		$this->setAttribute('lastText', $lastText);
	}		
	
	/**
	 * The quicktip text displayed for the next page button (defaults to 'Next 
	 * Page'). Note: quick tips must be initialized for the quicktip to show.
	 *
	 * @param string $nextText
	 */
	public function setNextText($nextText) 
	{
		$this->setAttribute('nextText', $nextText);
	}		
	
	/**
	 * True to insert any configured items before the paging buttons. Defaults 
	 * to false.
	 *
	 * @param boolean $prependButtons
	 */
	public function setPrependButtons($prependButtons) 
	{
		$this->setAttribute('prependButtons', $prependButtons);
	}	

	/**
	 * The quicktip text displayed for the previous page button (defaults to 
	 * 'Previous Page'). Note: quick tips must be initialized for the quicktip
	 * to show.
	 *
	 * @param string $prevText
	 */
	public function setPrevText($prevText) 
	{
		$this->setAttribute('prevText', $prevText);
	}		
	
	/**
	 * The quicktip text displayed for the previous page button (defaults to 
	 * 'Previous Page'). Note: quick tips must be initialized for the quicktip
	 * to show.
	 *
	 * @param string $refreshText
	 */
	public function setRefreshText($refreshText) 
	{
		$this->setAttribute('refreshText', $refreshText);
	}		
}