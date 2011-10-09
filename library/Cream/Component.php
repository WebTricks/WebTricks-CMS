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
 * The Component class is the base class for all components, it gives
 * access to the event handler, this makes it possible to attach an raise
 * events on an component.
 *
 * @package 	Cream
 * @author 		Danny Verkade 
 */
class Cream_Component extends Cream_Object
{
	/**
	 * Event handler object
	 * 
	 * @var Cream_EventHandler
	 */
	private $_eventHandler;
	
	/**
	 * Returns the event handler instance
	 *
	 * @return Cream_EventHandler
	 */
	protected function _getEventHandler()
	{
		if (!$this->_eventHandler) {
			$this->_eventHandler = Cream_EventHandler::instance($this);
		}
		
		return $this->_eventHandler;
	}
}