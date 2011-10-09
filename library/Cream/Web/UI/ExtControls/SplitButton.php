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
 * A split button that provides a built-in dropdown arrow that can fire an 
 * event separately from the default click event of the button. Typically this 
 * would be used to display a dropdown menu that provides additional options to 
 * the primary button action, but any custom handler can provide the arrowclick 
 * implementation.
 * 
 * @package 	Cream_Web_UI_ExtControls
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_SplitButton extends Cream_Web_UI_ExtControls_Button 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_SplitButton
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
		$this->setControl('Ext.SplitButton');
		$this->setAttribute('xtype', 'splitbutton');
	}
		
	/**
	 * A function called when the arrow button is clicked (can be used instead 
	 * of click event)
	 *
	 * @param function $arrowHandler
	 */
	public function setArrowHandler($arrowHandler) 
	{
		$this->setAttribute('arrowHandler', $arrowHandler);
	}

	/**
	 * The title attribute of the arrow
	 *
	 * @param string $arrowTooltip
	 */
	public function setArrowTooltip($arrowTooltip) 
	{
		$this->setAttribute('arrowTooltip', $arrowTooltip);
	}
}