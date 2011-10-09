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
 * Basic Toolbar class. Toolbar elements can be created explicitly 
 * via their constructors, or implicitly via their xtypes. Some items
 * also have shortcut strings for creation. 
 *
 * @package		Cream_Web_UI_ExtControls
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Toolbar extends Cream_Web_UI_ExtControls_Container
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Toolbar
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
		$this->setControl('Ext.Toolbar');
		$this->setAttribute('xtype', 'toolbar');		
	}
	
	/**
	 * The default position at which to align child items. Defaults to "left"
	 * May be specified as "center" to cause items added before a Fill 
	 * (A "->") item to be centered in the Toolbar. Items added after a Fill 
	 * are still right-aligned.
	 * 
	 * Specify as "right" to right align all child items.
	 * 
	 * @param string $buttonAlign
	 */
	public function setButtonAlign($buttonAlign)
	{
		$this->setAttribute('buttonAlign', $buttonAlign);
	}	
	
	/**
	 * Defaults to false. Configure true to make the toolbar provide a button 
	 * which activates a dropdown Menu to show items which overflow the 
	 * Toolbar's width.
	 * 
	 * @param enableOverflow $enableOverflow
	 */
	public function setEnableOverflow($enableOverflow)
	{
		$this->setAttribute('enableOverflow', $enableOverflow);
	}	

	/**
	 * This class assigns a default layout (layout:'toolbar'). Developers may 
	 * override this configuration option if another layout is required (the 
	 * constructor must be passed a configuration object in this case instead 
	 * of an array). See Ext.Container.layout for additional information.
	 * 
	 * @param string $layout
	 */
	public function setLayout($layout)
	{
		parent::setLayout($layout);
	}		
}