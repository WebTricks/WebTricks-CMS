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
 * A specialized grid implementation intended to mimic the traditional property
 * grid as typically seen in development IDEs. Each row in the grid represents 
 * a property of some object, and the data is stored as a set of name/value 
 * pairs in Ext.grid.PropertyRecords. 
 *
 * @package 	Cream_Web_UI_ExtControls_Grid
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Grid_PropertyGrid extends Cream_Web_UI_ExtControls_Grid_EditorGridPanel
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Grid_PropertyColumnModel
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}	
		
	/**
	 * Initialize function, set the Ext JS control
	 *
	 */
	public function __init()
	{
		$this->setControl('Ext.grid.PropertyGrid');
		$this->setXtype('propertygrid');
	}
	
	/**
	 * An object containing name/value pairs of custom editor type definitions
	 * that allow the grid to support additional types of editable fields. By 
	 * default, the grid supports strongly-typed editing of strings, dates, 
	 * numbers and booleans using built-in form editors, but any custom type 
	 * can be supported and associated with a custom input control by specifying 
	 * a custom editor. The name of the editor type should correspond with the 
	 * name of the property that will use the editor. 
	 * 
	 * @param array $customEditors
	 */
	public function setCustomEditors($customEditors)
	{
		$this->setAttribute('customEditors', $customEditors);
	}
	
	/**
	 * An object containing name/value pairs of custom renderer type definitions 
	 * that allow the grid to support custom rendering of fields. By default, 
	 * the grid supports strongly-typed rendering of strings, dates, numbers and
	 * booleans using built-in form editors, but any custom type can be 
	 * supported and associated with the type of the value. The name of the 
	 * renderer type should correspond with the name of the property that it 
	 * will render. 
	 * 
	 * @param array $customRenderers
	 */
	public function setCustomRenderers($customRenderers)
	{
		$this->setAttribute('customRenderers', $customRenderers);
	}	
	
	/**
	 * An object containing property name/display name pairs. If specified, the 
	 * display name will be shown in the name column instead of the property 
	 * name.
	 * 
	 * @param array $propertyNames
	 */
	public function setPropertyNames($propertyNames)
	{
		$this->setAttribute('propertyNames', $propertyNames);
	}	

	/**
	 * A data object to use as the data source of the grid.
	 * 
	 * @param object $source
	 */
	public function setSource($source)
	{
		$this->setAttribute('source', $source);
	}		
}