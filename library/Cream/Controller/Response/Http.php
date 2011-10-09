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
 * Custom Http Response object.
 *
 * @package		Cream_Content
 * @author		Danny Verkade
 */
class Cream_Controller_Response_Http extends Zend_Controller_Response_Http
{
    /**
     * Create a new instance of this class
     * 
     * @return Cream_Controller_Response_Http
     */
    public static function instance()
    {
    	return Cream::instance(__CLASS__);
    }	
    
    public function clear()
    {
    	$this->clearAllHeaders();
    	$this->clearBody();
    }
	
    /**
     * Fixes CGI only one Status header allowed bug
     *
     * @link  http://bugs.php.net/bug.php?id=36705
     *
     */
    public function sendHeaders()
    {
        if (!$this->canSendHeaders()) {
            //Cream::getApplication()->log('HEADERS ALREADY SENT: '. debug_backtrace());
        }

        if (substr(php_sapi_name(), 0, 3) == 'cgi') {
            $statusSent = false;
            foreach ($this->_headersRaw as $i=>$header) {
                if (stripos($header, 'status:')===0) {
                    if ($statusSent) {
                        unset($this->_headersRaw[$i]);
                    } else {
                        $statusSent = true;
                    }
                }
            }
            foreach ($this->_headers as $i=>$header) {
                if (strcasecmp($header['name'], 'status')===0) {
                    if ($statusSent) {
                        unset($this->_headers[$i]);
                    } else {
                        $statusSent = true;
                    }
                }
            }
        }
        
        parent::sendHeaders();
    }

    /**
     * Send the response to the browser.
     *  
     */
    public function sendResponse()
    {
        return parent::sendResponse();
    }
}