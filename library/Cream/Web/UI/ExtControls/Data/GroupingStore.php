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
 * A specialized store implementation that provides for grouping records by one
 * of the available fields. This is usually used in conjunction with an 
 * Ext.grid.GroupingView to proved the data model for a grouped GridPanel.
 * 
 * @package 	Cream_Web_UI_ExtControls_Data
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Data_GroupingStore extends Cream_Web_UI_ExtControls_Data_Store 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Data_GroupingStore
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
		$this->setControl('Ext.data.GroupingStore');
	}
	
	/**
	 * The field name by which to sort the store's data (defaults to '').
	 *
	 * @param string $groupField
	 */
	public function setGroupField($groupField)
	{
		$this->setAttribute('groupField', $groupField);
	}

	/**
	 * True if the grouping should apply on the server side, false if it is 
	 * local only (defaults to false). If the grouping is local, it can be 
	 * applied immediately to the data. If it is remote, then it will simply 
	 * act as a helper, automatically sending the grouping field name as the 
	 * 'groupBy' param with each XHR call.
	 *
	 * @param boolean $remoteGroup
	 */
	public function setRemoteGroup($remoteGroup)
	{
		$this->setAttribute('remoteGroup', $remoteGroup);
	}

	/**
	 * True to sort the data on the grouping field when a grouping operation 
	 * occurs, false to sort based on the existing sort info (defaults to 
	 * false).
	 *
	 * @param boolean $groupOnSort
	 */
	public function setGroupOnSort($groupOnSort)
	{
		$this->setAttribute('groupOnSort', $groupOnSort);
	}
} 