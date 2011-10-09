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
 * HTML head element control.
 *
 * @package		Cream_Web_UI_HtmlControls
 * @author		WebTricks Core Team <core@webtricksframework.com>
 */
class Cream_Web_UI_HtmlControls_HeadControl extends Cream_Web_UI_WebControls_TemplateControl
{
    /**
     * Initialize template
     *
     */
    public function __init($data = null)
    {
        parent::__init($data);
        $this->setTemplate('html/head.phtml');
    }

    public function addJs()
    {
    	
    }
    
    public function addCss()
    {
    	
    }
}