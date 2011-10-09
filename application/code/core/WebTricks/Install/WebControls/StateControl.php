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

/**
 * Install state control
 * 
 * @package		WebTricks_Install
 * @author		Danny Verkade
 */
class WebTricks_Install_WebControls_StateControl extends Cream_Web_UI_WebControls_TemplateControl
{
	/**
	 * Initialize function
	 * 
	 * @see library/Cream/Web/UI/WebControls/Cream_Web_UI_WebControls_TemplateControl::__init()
	 */
    public function __init($data = null) 
    {
    	parent::__init($data);
    	
        $this->setTemplate('install/state.phtml');
		$this->assign('steps', $data['steps']);
    }
}