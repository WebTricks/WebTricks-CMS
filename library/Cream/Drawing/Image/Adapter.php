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
 * Factory class for retrieving the correct image adapter. Currently
 * only the GD2 adapter is implemented.
 *
 * @package		System_Drawing_Image
 * @author		Danny Verkade
 */
class System_Drawing_Image_Adapter
{
	/**
	 * Adapter constants
	 */
    const ADAPTER_GD				    = 'GD';
    const ADAPTER_GD2				    = 'GD2';
    const ADAPTER_IMAGEMAGIC		    = 'IMAGEMAGIC';

    /**
     * Get the correct image adapter
     *
     * @param string $adapter
     * @return System_Drawing_Image_Adapter_Abstract
     */
    public static function factory($adapter)
    {
        switch($adapter) {
            case self::ADAPTER_GD:
                throw System_Drawing_Image_Adapter_Gd::instance();
            break;
            case self::ADAPTER_GD2:
                return System_Drawing_Image_Adapter_Gd2::instance();
                break;
			case self::ADAPTER_IMAGEMAGIC:
                throw System_Drawing_Image_Adapter_ImageMagic::instance();
            break;
            default:
                throw new System_Drawing_Image_Exception('Invalid adapter selected.');
            break;
        }
    }
}