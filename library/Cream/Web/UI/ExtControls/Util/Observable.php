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
 * Base class that provides a common interface for publishing events. 
 * Subclasses are expected to to have a property "events" with all the events
 * defined, and, optionally, a property "listeners" with configured listeners 
 * defined.
 * 
 * Note: This class should not be created directly.
 * 
 * @package 	Cream_Web_UI_ExtControls_Util
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Util_Observable extends Cream_Web_UI_ExtControl
{
	/**
	 * A config object containing one or more event handlers to be added to 
	 * this object during initialization. This should be a valid listeners 
	 * config object as specified in the addListener example for attaching 
	 * multiple handlers at once.
	 
	 * @param array $listeners
	 * @return void
	 */
	public function setListeners($listeners)
	{
		$this->setAttribute('listeners', $listeners);		
	}
}