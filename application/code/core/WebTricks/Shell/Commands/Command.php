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

abstract class WebTricks_Shell_Commands_Command extends Cream_ApplicationComponent
{
	protected $_click;
	
	protected $_header;
	
	protected $_icon;
	
	abstract public function execute(WebTricks_Shell_Commands_CommandContext $context);
	
	public function queryState(WebTricks_Shell_Commands_CommandContext $context)
	{
		return WebTricks_Shell_Commands_CommandState::ENABLED;
	}
	
	public function getClick($click)
	{
		if ($this->_click) {
			return $this->_click;
		} else {
			return $click;
		}
	}
	
	public function getHeader(WebTricks_Shell_Commands_CommandContext $context, $header)
	{
		if ($this->_header) {
			return $this->_header;
		} else {
			return $header;
		}
	}
	
	public function getIcon($icon)
	{
		if ($this->_icon) {
			return $this->_icon;
		} else {
			return $icon;
		} 
	}
	
	public function getSubmenuItems(WebTricks_Shell_Commands_CommandContext $context)
	{
		return null;
	}
}