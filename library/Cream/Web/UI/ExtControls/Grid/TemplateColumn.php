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
 * A Column definition class which renders a value by processing a Record's 
 * data using a configured XTemplate. See the xtype config option of 
 * Ext.grid.Column for more details.
 *
 * @package 	Cream_Web_UI_ExtControls_Grid
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Grid_TemplateColumn extends Cream_Web_UI_ExtControls_Grid_Column
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Grid_NumberColumn
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
		$this->setControl('Ext.grid.TemplateColumn');
		$this->setXtype('templatecolumn');
	}
	
	/**
	 * A formatting string as used by Ext.util.Format.number to format a 
	 * numeric value for this Column (defaults to '0,000.00').
	 * 
	 * @param string|Cream_Web_UI_ExtControls_XTemplate $tpl
	 */
	public function setTpl($tpl)
	{
		$this->setAttribute('tpl', $tpl);		
	}
}