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
 * Represents a multilist field
 *
 * @package		Cream_Content_Fields
 * @author		Danny Verkade
 */
class Cream_Content_Fields_MultilistField extends Cream_Content_Fields_CustomField
{
	/**
	 * Create a new instance of this class.
	 * 
	 * @param Cream_Guid $fieldId
	 * @param Cream_Content_Item $item
	 * @return Cream_Content_Fields_MultilistField
	 */
	public static function instance(Cream_Guid $fieldId, $item)
	{
		return Cream::instance(__CLASS__, $fieldId, $item);
	}	
	
	public function getItems()
	{
		
	}
	
	/**
	 * Returns the repository
	 * 
	 * @return Cream_Content_Repository
	 */
	protected function getRepository()
	{

	}
}