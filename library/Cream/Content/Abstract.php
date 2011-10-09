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
 * Base class for the content item
 *
 * @package		Cream_Content
 * @author		Danny Verkade
 */
abstract class Cream_Content_Abstract extends Cream_ApplicationComponent
{
	/**
	 * Collection of content item fields
	 * 
	 * @var Cream_Content_Data_FieldCollection
	 */
	protected $fields;
	
	/**
	 * Returns a collection of fields objects
	 * 
	 * @return Cream_Content_Data_FieldCollection
	 */
	protected function getFields()
	{
		if (!$this->fields) {
			$this->setFields();
		}
		
		return $this->fields;
	}
}