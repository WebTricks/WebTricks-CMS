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
 * Install config control
 * 
 * @package		WebTricks_Install
 * @author		Danny Verkade
 */
class WebTricks_Install_WebControls_ConfigControl extends Cream_Web_UI_WebControls_TemplateControl
{
	/**
	 * Initialize function.
	 * 
	 * @see library/Cream/Web/UI/WebControls/Cream_Web_UI_WebControls_TemplateControl::__init()
	 */
    public function __init($data = null)
    {
        parent::__init($data);
        $this->setTemplate('install/config.phtml');
    }
    
    /**
     * Retrieve configuration form data object
     *
     * @return Cream_Object
     */
    public function getFormData()
    {
        $data = $this->getData('form_data');
        if (is_null($data)) {
            $sessionData = WebTricks_Install_Session::singleton()->getConfigData(true);
            
            if ($sessionData) {
            	$data = new Cream_Object();
            	$data->addData($sessionData);
            } else {
            	$data = new Cream_Object();
            }
            $this->setFormData($data);
        }
        return $data;
    }    
    
    public function getSessionSaveOptions()
    {
        return array(
            'files' => $this->__('File System'),
            'db'    => $this->__('Database'),
        );
    }

    public function getSessionSaveSelect()
    {
		$select = $this->getLayout()->createBlock('htmlcontrol/select');
		$select->setName('config[session_save]');
		$select->setId('session_save');
		$select->setTitle($this->__('Save Session Files In'));
		$select->setClass('required-entry');
		$select->setOptions($this->getSessionSaveOptions());
		return $select->getHtml();
    }    
    
    /**
     * Retrieve installer
     *
     * @return WebTricks_Install_Installer
     */
    public function getInstaller()
    {
        return WebTricks_Install_Installer::singleton();
    }    
}
