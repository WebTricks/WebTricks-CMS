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
 * Container for a group of buttons.
 *
 * @package Cream_Web_UI_ExtControls
 * @author Danny Verkade
 */
class Cream_Web_UI_ExtControls_ButtonGroup extends Cream_Web_UI_ExtControls_Panel
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_ButtonGroup
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
		$this->setControl('Ext.ButtonGroup');
		$this->setXtype('buttongroup');
	}
	
	/**
	 * Defaults to 'x-btn-group'.
	 *
	 * @param string $baseCls
	 */
	public function setBaseCls($baseCls)
	{
		$this->setAttribute('baseCls', $baseCls);
	}

	/**
	 * The columns configuration property passed to the configured layout 
	 * manager.
	 *
	 * @param integer $columns
	 */
	public function setColumns($columns)
	{
		$this->setAttribute('columns', $columns);
	}

	/**
	 * Defaults to true. See Ext.Panel.frame.
	 *
	 * @param boolean $frame
	 */
	public function setFrame($frame)
	{
		$this->setAttribute('frame', $frame);
	}

	/**
	 * Defaults to 'table'. See Ext.Container.layout.
	 *
	 * @param string $layout
	 */
	public function setLayout($layout)
	{
		$this->setAttribute('layout', $layout);
	}
}