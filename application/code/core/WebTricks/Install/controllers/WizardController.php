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
 * Default controller for the WebTricks Install module.
 * 
 * @package		WebTricks_Install
 * @author		Danny Verkade
 */
class WebTricks_Install_WizardController extends WebTricks_Install_Controller_Action
{
	/**
	 * Wizard instance
	 *  
	 * @var WebTricks_Install_Wizard
	 */
	protected $_wizard;
	
    /**
     * Checking installation status. Returns false when the application
     * is not installed. Redirect to the root folder when the application
     * is already installed. 
     *
     * @return boolean
     */
    protected function _checkIsInstalled()
    {
        if ($this->getApplication()->isInstalled()) {
            //$this->getResponse()->setRedirect('/')->sendResponse();
            //exit;
        }
        
        return false;
    }	
    
    /**
     * Returns the installer object.
     *
     * @return WebTricks_Install_Installer
     */
    protected function _getInstaller()
    {
    	return WebTricks_Install_Installer::singleton();
    }
	
    /**
     * Prepare layout
     *
     * @return unknown
     */
    protected function _prepareLayout()
    {
        $this->loadLayout('install_wizard');
        
        $step = $this->_getWizard()->getStepByRequest($this->getRequest());
        if ($step) {
            $step->setActive(true);
        }

        $leftBlock = $this->getLayout()->createBlock('install/state', 'install.state', array('steps' => $this->_getWizard()->getSteps()));
        $this->getLayout()->getBlock('left')->append($leftBlock);
    }	

    /**
     * Get wizard
     * 
     * @return WebTricks_Install_Wizard
     */
    public function _getWizard()
    {
    	if (!$this->_wizard) {
    		$this->_wizard = WebTricks_Install_Wizard::instance();
    	}
    	
    	return $this->_wizard;
    }
	
    /**
     * Redirect to first step in the wizard.
     * 
     */
    public function indexAction()
    {
        $this->_forward('begin', 'wizard', 'install');
    }

    /**
     * First step in the installation wizard.
     * 
     */
    public function beginAction()
    {
    	if ($this->getRequest()->isPost()) {
        	$this->_checkIsInstalled();

        	$agree = $this->getRequest()->getPost('agree');
        	$step = $this->_getWizard()->getStepByName('begin');
        	if ($agree && $step) {
	            $this->getResponse()->setRedirect($step->getNextUrl());
        	} 
    	}
    	
    	$this->_prepareLayout();
    	
    	$begin = $this->getLayout()->createBlock('install/license');
    	$begin->setTemplate('install/begin.phtml');
    	
        $this->getLayout()->getBlock('content')->append($begin);
        $this->renderLayout();
    }
    
    /**
     * Installation wizard step to set the locale information.
     * 
     */
    public function localeAction()
    {
        $this->_checkIsInstalled();
        
        if ($this->getRequest()->isPost()) {
        	
        	$step = $this->_getWizard()->getStepByName('locale');
            $data = $this->getRequest()->getPost('config');
            
        	if ($step && $data) {
        		WebTricks_Install_Session::singleton()->setLocaleData($data);
	            $this->getResponse()->setRedirect($step->getNextUrl());
        	}    		
    	}        

        $this->_prepareLayout();
        $this->getLayout()->getBlock('content')->append(
            $this->getLayout()->createBlock('install/locale', 'install.locale')
        );

        $this->renderLayout();
    }
    
    /**
     * Change current locale.
     * 
     */
    public function localeChangeAction()
    {
        $this->_checkIsInstalled();

        $locale = $this->getRequest()->getParam('locale');
        $timezone = $this->getRequest()->getParam('timezone');
        $currency = $this->getRequest()->getParam('currency');
        if ($locale) {
            WebTricks_Install_Session::singleton()->setLocale($locale);
            WebTricks_Install_Session::singleton()->setTimezone($timezone);
            WebTricks_Install_Session::singleton()->setCurrency($currency);
        }

        $this->_redirect('*/*/locale');
    }    
    
    /**
     * Installation wizard step to set the config information.
     * 
     */
    public function configAction()
    {
        $this->_checkIsInstalled();
        
        if ($this->getRequest()->isPost()) {
        	$step = $this->_getWizard()->getStepByName('config');
            $data = $this->getRequest()->getPost('config');
                    	
        	if ($step && $data) {
        		WebTricks_Install_Session::singleton()->setConfigData($data);
        		WebTricks_Install_Session::singleton()->setSkipUrlValidation($this->getRequest()->getPost('skip_url_validation'));        		
        		WebTricks_Install_Session::singleton()->setSkipBaseUrlValidation($this->getRequest()->getPost('skip_base_url_validation'));
        		
        		$this->_getInstaller()->installConfig($data);
        		$this->_getInstaller()->installDb();
        		
	            $this->getResponse()->setRedirect($step->getNextUrl());
        	}    		
    	}

        $this->_prepareLayout();
        $this->getLayout()->getBlock('content')->append(
            $this->getLayout()->createBlock('install/config', 'install.config')
        );

        $this->renderLayout();    	
    }
    
    /**
     * Install admininstrator account
     * 
     */
    public function administratorAction()
    {
        $this->_checkIsInstalled();
        
        if ($this->getRequest()->isPost()) {
        	$step = $this->_getWizard()->getStepByName('administrator');
        	$data = $this->getRequest()->getPost('admin');
        	
        	if ($step) {
        		WebTricks_Install_Session::singleton()->setAdminData($data);
        		
        		$this->_getInstaller()->createAdministrator($data);
        		
	            $this->getResponse()->setRedirect($step->getNextUrl());
        	}    		
    	}            

        $this->_prepareLayout();
        $this->getLayout()->getBlock('content')->append(
            $this->getLayout()->createBlock('install/admin', 'install.administrator')
        );
        $this->renderLayout();
    }

    /**
     * End installation
     * 
     */
    public function endAction()
    {
        $this->_checkIsInstalled();

        $date = (string) $this->getApplication()->getConfig()->getNode('global/install/date');
        if ($date !== WebTricks_Install_Installer_Config::TMP_INSTALL_DATE_VALUE) {
            $this->_redirect('*/*');
            return;
        }

        $this->_getInstaller()->finish();
        $this->_prepareLayout();
        $this->getLayout()->getBlock('content')->append(
            $this->getLayout()->createBlock('install/end', 'install.end')
        );
        $this->renderLayout();
        
        WebTricks_Install_Session::singleton()->clear();
    }    
    
    /**
     * Host validation response
     * 
     */
    public function checkHostAction()
    {
        $this->getResponse()->setHeader('Transfer-encoding', '', true);
        $this->getResponse()->setBody(WebTricks_Install_Installer::INSTALLER_HOST_RESPONSE);
    }

    /**
     * Host validation response
     * 
     */
    public function checkSecureHostAction()
    {
        $this->getResponse()->setHeader('Transfer-encoding', '', true);
        $this->getResponse()->setBody(WebTricks_Install_Installer::INSTALLER_HOST_RESPONSE);
    }
}