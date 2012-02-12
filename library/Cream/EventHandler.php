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
 * Event handler class.
 *
 * @package		Cream
 * @author		Danny Verkade
 */
class Cream_EventHandler extends Cream_ApplicationComponent
{
	/**
	 * Holds the object for the event handler. 
	 * 
	 * @var Cream_Object
	 */
	protected $_object;
	
	/**
	 * Create a new instance of this class.
	 *  
	 * @param Cream_Component $object
	 * @return Cream_EventHandler
	 */
	public static function instance(Cream_Component $object)
	{
		return Cream::instance(__CLASS__, $object);
	}
	
	/**
	 * Initialize function
	 * 
	 * @param Cream_Component $object
	 */
	public function __init(Cream_Component $object)
	{
		$this->_object = $object;
	}
	
	public function dispatch($eventName, $args)
	{
		$path = "global/events/". $eventName ."/observers";
		$observers = $this->_getApplication()->getConfig()->getNode($path);
		
		//foreach($observers as $observer) {
			
		//}
	}
}