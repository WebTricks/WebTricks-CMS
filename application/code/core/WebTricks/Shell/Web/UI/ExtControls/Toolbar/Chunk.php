<?php
/**
 * WebTricks
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
 * ExtJS toolbar chunk.
 * 
 * @package		WebTricks_Shell
 * @author		Danny Verkade
 */
class WebTricks_Shell_Web_UI_ExtControls_Toolbar_Chunk extends Cream_Web_UI_ExtControls_ButtonGroup
{
	/**
	 * Create a new instance of this class
	 * 
	 * @return WebTricks_Shell_Web_UI_ExtControls_Toolbar_Chunk
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
		
	}	
	
	/**
	 * Click event when clicked on the title of the chunk.
	 * 
	 * @param string $onTitleClick
	 */
	public function setOnTitleClick($onTitleClick)
	{
		$this->setAttribute('onTitleClick', $onTitleClick);
	}                        
}