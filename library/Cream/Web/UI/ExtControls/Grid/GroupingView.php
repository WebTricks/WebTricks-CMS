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
 * Adds the ability for single level grouping to the grid. A GroupingStore must 
 * be used to enable grouping. 
 * 
 * @package		Cream_Web_UI_ExtControls_Grid
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Grid_GroupingView extends Cream_Web_UI_ExtControls_Grid_GridView 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Grid_GroupingView
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
		$this->setControl('Ext.grid.GroupingView');
	}	
	
	/**
	 * True to hide the column that is currently grouped
	 *
	 * @param boolean $hideGroupedColumn
	 */
	public function setHideGroupedColumn($hideGroupedColumn)
	{
		$this->setAttribute('hideGroupedColumn', $hideGroupedColumn);
	}

	/**
	 * True to display the name for each set of grouped rows (defaults to true)
	 *
	 * @param boolean $showGroupName
	 */
	public function setShowGroupName($showGroupName)
	{
		$this->setAttribute('showGroupName', $showGroupName);
	}

	/**
	 * True to start all groups collapsed
	 *
	 * @param boolean $startCollapsed
	 */
	public function setStartCollapsed($startCollapsed)
	{
		$this->setAttribute('startCollapsed', $startCollapsed);
	}

	/**
	 * False to disable grouping functionality (defaults to true)
	 *
	 * @param boolean $enableGrouping
	 */
	public function setEnableGrouping($enableGrouping)
	{
		$this->setAttribute('enableGrouping', $enableGrouping);
	}

	/**
	 * True to enable the grouping control in the column menu
	 *
	 * @param boolean $enableGroupingMenu
	 */
	public function setEnableGroupingMenu($enableGroupingMenu)
	{
		$this->setAttribute('enableGroupingMenu', $enableGroupingMenu);
	}

	/**
	 * True to allow the user to turn off grouping
	 *
	 * @param boolean $enableNoGroups
	 */
	public function setEnableNoGroups($enableNoGroups)
	{
		$this->setAttribute('enableNoGroups', $enableNoGroups);
	}

	/**
	 * The text to display when there is an empty group value (defaults to 
	 * '(None)'). May also be specified per column, see 
	 * Ext.grid.Column.emptyGroupText.
	 *
	 * @param string $emptyGroupText
	 */
	public function setEmptyGroupText($emptyGroupText)
	{
		$this->setAttribute('emptyGroupText', $emptyGroupText);
	}

	/**
	 * True to skip refreshing the view when new rows are added (defaults to false)
	 *
	 * @param boolean $ignoreAdd
	 */
	public function setIgnoreAdd($ignoreAdd)
	{
		$this->setAttribute('ignoreAdd', $ignoreAdd);
	}

	/**
	 * The template used to render the group header. This is used to
	 *
	 * @param string $groupTextTpl
	 */
	public function setGroupTextTpl($groupTextTpl)
	{
		$this->setAttribute('groupTextTpl', $groupTextTpl);
	}

	/**
	 * The function used to format the grouping field value for
	 *
	 * @param function $groupRenderer
	 */
	public function setGroupRenderer($groupRenderer)
	{
		$this->setAttribute('groupRenderer', $groupRenderer);
	}

	/**
	 * Text displayed in the grid header menu for grouping by a column.
	 *
	 * @param string $groupByText
	 */
	public function setGroupByText($groupByText)
	{
		$this->setAttribute('groupByText', $groupByText);
	}
	
	/**
	 * Indicates how to construct the group identifier. 'value' constructs the 
	 * id using raw value, 'display' constructs the id using the rendered 
	 * value. Defaults to 'value'.
	 *
	 * @param string $groupMode
	 */
	public function setGroupMode($groupMode)
	{
		$this->setAttribute('groupMode', $groupMode);
	}	

	/**
	 * Text displayed in the grid header for enabling/disabling grouping
	 *
	 * @param string $showGroupsText
	 */
	public function setShowGroupsText($showGroupsText)
	{
		$this->setAttribute('showGroupsText', $showGroupsText);
	}

 } 