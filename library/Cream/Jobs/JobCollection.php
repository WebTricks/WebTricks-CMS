<?php
/**
 * WebTricks - PHP Framework
 *
 * LICENSE
 *
 * For the full copyright and license information, please view the 
 * following URL: http://www.webtricksframework.com/license 
 *
 * @copyright Copyright (c) 2007-2011 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

class Cream_Jobs_JobCollection extends Cream_Collection_Iterator
{
	/**
	 * Create a new instance of this class.
	 * 
	 * @return Cream_Jobs_JobCollection
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
}