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
 * @copyright Copyright (c) 2007-2011 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * Base class for validators
 *
 * @package		Cream_Content
 * @author		Danny Verkade
 */
abstract class Cream_Content_Validators_Abstract
{
	/**
	 * Do the actual validation.
	 * 
	 * @return integer
	 */
	abstract protected function _evaluate();
	
	/**
	 * Validate
	 * 
	 * @return integer
	 */
	public function validate()
	{
		
	}
}