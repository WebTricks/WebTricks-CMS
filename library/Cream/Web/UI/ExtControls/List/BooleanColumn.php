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
 * A Column definition class which renders boolean data fields. See the xtype
 * config option of Ext.list.Column for more details.
 *
 * @package 	Cream_Web_UI_ExtControls_List
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_List_BooleanColumn extends Cream_Web_UI_ExtControls_List_Column
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_List_BooleanColumn
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
		$this->setControl('Ext.list.BooleanColumn');
	}
	
	/**
	 * The string returned by the renderer when the column value is falsey (but
	 * not undefined) (defaults to 'false').
	 * 
	 * @param string $falseText
	 */
	public function setFalseText($falseText)
	{
		$this->setAttribute('falseText', $falseText);		
	}
	
	/**
	 * The string returned by the renderer when the column value is not falsey
	 * (defaults to 'true').
	 * 
	 * @param string $trueText
	 */
	public function setTrueText($trueText)
	{
		$this->setAttribute('trueText', $trueText);				
	}
	
	/**
	 * The string returned by the renderer when the column value is undefined
	 * (defaults to ' ').
	 * 
	 * @param string $undefinedText
	 */
	public function setUndefinedText($undefinedText)
	{
		$this->setAttribute('undefinedText', $undefinedText);				
	}
}