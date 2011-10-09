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
 * ImageMagic Adapter
 *
 * @package		System_Drawing_Image_Adapter
 * @author		Danny Verkade
 */
class System_Drawing_Image_Adapter_ImageMagic
{
	/**
	 * Create a new instance of this class
	 * 
	 * @return System_Drawing_Image_Adapter_ImageMagic
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Constructor function
	 * 
	 * @return void
	 */
	public function __construct()
	{
		throw new Cream_Exceptions_TodoException();
	}
}