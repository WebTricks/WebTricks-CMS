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
 * Encapsulates a DOM element, adding simple DOM manipulation facilities, 
 * normalizing for browser differences.
 * 
 * @package		Cream_Web_UI_ExtControls
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Element extends Cream_Web_UI_ExtControls_Component
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Element
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
		$this->setControl('Ext.Element');
	}	
	
	/**
	 * True to automatically adjust width and height settings for box-model 
	 * issues (default to true)
	 *
	 * @param object $autoBoxAdjust
	 */
	public function setAutoBoxAdjust($autoBoxAdjust) 
	{
		$this->setAttribute('autoBoxAdjust', $autoBoxAdjust);
	}
	
	/**
	 * The default unit to append to CSS values where a unit isn't provided 
	 * (defaults to px).
	 *
	 * @param string $defaultUnit
	 */
	public function setDefaultUnit($defaultUnit) 
	{
		$this->setAttribute('defaultUnit', $defaultUnit);
	}	
	
	/**
	 * The DOM element
	 *
	 * @param HTMLElement $dom
	 */
	public function setDom($dom) 
	{
		$this->setAttribute('dom', $dom);
	}	

	/**
	 * The DOM element ID
	 *
	 * @param string $id
	 */
	public function setId($id) 
	{
		$this->setAttribute('id', $id);
	}	

	/**
	 * The element's default display mode (defaults to "")
	 *
	 * @param string $originalDisplay
	 */
	public function setOriginalDisplay($originalDisplay) 
	{
		$this->setAttribute('originalDisplay', $originalDisplay);
	}		
}