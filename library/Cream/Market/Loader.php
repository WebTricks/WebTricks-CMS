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
 * @copyright Copyright (c) 2007-2012 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * Class for loader which using in the Rest
 *
 * @category    Cream
 * @package     Cream_Market
 * @author      WebTricks Core Team <core@webtricksframework.com>
 */
class Cream_Market_Loader
{
    /**
     * Factory for HTTP client
	 * 
     * @param string/false $protocol  'curl'/'socket' or false for auto-detect
     * @return Cream_IO_Http_Client/Cream_Market_Loader_Ftp
     */
    public static function factory($protocol = '')
    {
        if ($protocol  == 'ftp') {
            return Cream_Market_Loader_Ftp::instance();;
        } else {
            return Cream_IO_Http_Client::instance();
        }
    }

}