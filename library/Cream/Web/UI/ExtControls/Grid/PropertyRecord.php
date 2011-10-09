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
 * A specific Ext.data.Record type that represents a name/value pair and is 
 * made to work with the Ext.grid.PropertyGrid. Typically, PropertyRecords do
 * not need to be created directly as they can be created implicitly by simply
 * using the appropriate data configs either via the 
 * Ext.grid.PropertyGrid.source config property or by calling 
 * Ext.grid.PropertyGrid.setSource. However, if the need arises, these records 
 * can also be created explicitly as shwon below. 
 * 
 * @package 	Cream_Web_UI_ExtControls_Grid
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Grid_PropertyRecord extends Cream_Web_UI_ExtControl 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Grid_PropertyRecord
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
		$this->setControl('Ext.grid.PropertyStore');
	}
	
	/**
	 * Name of the record
	 *
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->setAttribute('name', $name);
	}

	/**
	 * Value of the record
	 *
	 * @param mixed $value
	 */
	public function setValue($value)
	{
		$this->setAttribute('value', $value);
	}
}