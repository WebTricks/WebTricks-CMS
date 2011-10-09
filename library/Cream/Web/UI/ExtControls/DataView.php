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
 * A mechanism for displaying data using custom layout templates and formatting. 
 * DataView uses an Ext.XTemplate as its internal templating mechanism, and is 
 * bound to an Ext.data.Store so that as the data in the store changes the view 
 * is automatically updated to reflect the changes. The view also provides 
 * built-in behavior for many common events that can occur for its contained 
 * items including click, doubleclick, mouseover, mouseout, etc. as well as a 
 * built-in selection model. In order to use these features, an itemSelector 
 * config must be provided for the DataView to determine what nodes it will be 
 * working with. 
 * 
 * @package 	Cream_Web_UI_ExtControls
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_DataView extends Cream_Web_UI_ExtControls_BoxComponent 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_DataView
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
		$this->setControl('Ext.DataView');
	}	
	
	/**
	 * True to defer emptyText being applied until the store's first load.
	 *
	 * @param boolean $deferEmptyText
	 */
	public function setDeferEmptyText($deferEmptyText) 
	{
		$this->setAttribute('deferEmptyText', $deferEmptyText);
	}	
	
	/**
	 * The HTML fragment or an array of fragments that will make up the 
	 * template used by this DataView. This should be specified in the same 
	 * format expected by the constructor of Ext.XTemplate.
	 *
	 * @param string/array $tpl
	 */
	public function setTpl($tpl) 
	{
		$this->setAttribute('tpl', $tpl);
	}

	/**
	 * The Ext.data.Store to bind this DataView to.
	 *
	 * @param ext.data.store $store
	 */
	public function setStore($store) 
	{
		$this->setAttribute('store', $store);
	}

	/**
	 * This is a required setting. A simple CSS selector (e.g. div.some-class 
	 * or span:first-child) that will be used to determine what nodes this 
	 * DataView will be working with.
	 *
	 * @param string $itemSelector
	 */
	public function setItemSelector($itemSelector) 
	{
		$this->setAttribute('itemSelector', $itemSelector);
	}

	/**
	 * True to allow selection of more than one item at a time, false to allow 
	 * selection of only a single item at a time or no selection at all, 
	 * depending on the value of singleSelect (defaults to false).
	 *
	 * @param boolean $multiSelect
	 */
	public function setMultiSelect($multiSelect) 
	{
		$this->setAttribute('multiSelect', $multiSelect);
	}

	/**
	 * True to allow selection of exactly one item at a time, false to allow no 
	 * selection at all (defaults to false). Note that if multiSelect = true, 
	 * this value will be ignored.
	 *
	 * @param boolean $singleSelect
	 */
	public function setSingleSelect($singleSelect) 
	{
		$this->setAttribute('singleSelect', $singleSelect);
	}

	/**
	 * True to enable multiselection by clicking on multiple items without 
	 * requiring the user to hold Shift or Ctrl, false to force the user to 
	 * hold Ctrl or Shift to select more than on item (defaults to false).
	 *
	 * @param boolean $simpleSelect
	 */
	public function setSimpleSelect($simpleSelect) 
	{
		$this->setAttribute('simpleSelect', $simpleSelect);
	}

	/**
	 * A CSS class to apply to each item in the view on mouseover (defaults to 
	 * undefined).
	 *
	 * @param string $overClass
	 */
	public function setOverClass($overClass) 
	{
		$this->setAttribute('overClass', $overClass);
	}

	/**
	 * A string to display during data load operations (defaults to undefined). 
	 * If specified, this text will be displayed in a loading div and the 
	 * view's contents will be cleared while loading, otherwise the view's 
	 * contents will continue to display normally until the new data is loaded 
	 * and the contents are replaced.
	 *
	 * @param string $loadingText
	 */
	public function setLoadingText($loadingText) 
	{
		$this->setAttribute('loadingText', $loadingText);
	}

	/**
	 * A CSS class to apply to each selected item in the view (defaults to 
	 * 'x-view-selected').
	 *
	 * @param string $selectedClass
	 */
	public function setSelectedClass($selectedClass) 
	{
		$this->setAttribute('selectedClass', $selectedClass);
	}

	/**
	 * The text to display in the view when there is no data to display 
	 * (defaults to '').
	 *
	 * @param string $emptyText
	 */
	public function setEmptyText($emptyText) 
	{
		$this->setAttribute('emptyText', $emptyText);
	}
	
	/**
	 * True to enable mouseenter and mouseleave events.
	 *
	 * @param boolean $trackOver
	 */
	public function setTrackOver($trackOver) 
	{
		$this->setAttribute('trackOver', $trackOver);
	}	
}