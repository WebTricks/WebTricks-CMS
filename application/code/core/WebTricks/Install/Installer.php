<?php

class WebTricks_Install_Installer extends Cream_ApplicationComponent
{

    /**
     * Installer host response used to check urls
     *
     */
    const INSTALLER_HOST_RESPONSE   = 'WEBTRICKS';

    /**
     * Installer data model used to store data between installation steps
     *
     * @var Cream_Object
     */
    protected $_dataModel;

    
    public static function singleton()
    {
    	return Cream::singleton(__CLASS__);
    }    
    
    /**
     * Checking install status of application
     *
     * @return bool
     */
    public function isApplicationInstalled()
    {
        return $this->getApplication()->isInstalled();
    }

    /**
     * Get data model
     *
     * @return Cream_Object
     */
    public function getDataModel()
    {
        if (is_null($this->_dataModel)) {
            $this->setDataModel(new Cream_Object());
        }
        return $this->_dataModel;
    }

    /**
     * Set data model to store data between installation steps
     *
     * @param Cream_Object $model
     * @return void
     */
    public function setDataModel(Cream_Object $model)
    {
        $this->_dataModel = $model;
    }

    /**
     * Check packages (pear) downloads
     *
     * @return boolean
     */
    public function checkDownloads()
    {
        try {
            $result = WebTricks_Install_Installer_Pear::singleton()->checkDownloads();
            $result = true;
        } catch (Exception $e) {
            $result = false;
        }
        $this->setDownloadCheckStatus($result);
        return $result;
    }

    /**
     * Check server settings
     *
     * @return bool
     */
    public function checkServer()
    {
        try {
            WebTricks_Install_Installer_Filesystem::singleton()->install();
            WebTricks_Install_Installer_Environment::singleton()->install();
            $result = true;
        } catch (Exception $e) {
            $result = false;
        }
        $this->setData('server_check_status', $result);
        return $result;
    }

    /**
     * Retrieve server checking result status
     *
     * @return unknown
     */
    public function getServerCheckStatus()
    {
        $status = $this->getData('server_check_status');
        if (is_null($status)) {
            $status = $this->checkServer();
        }
        return $status;
    }

    /**
     * Installation config data
     *
     * @param   array $data
     * @return  void
     */
    public function installConfig($data)
    {
        $data['db_active'] = true;
        WebTricks_Install_Installer_Db::singleton()->checkDatabase($data);
        WebTricks_Install_Installer_Config::singleton()->setConfigData($data);
        WebTricks_Install_Installer_Config::singleton()->install();
    }

    /**
     * Database installation
     *
     * @return void
     */
    public function installDb()
    {
        WebTricks_Core_Setup::applyAllUpdates();
        $data = $this->getDataModel()->getConfigData();

        /**
         * Saving host information into DB
         */
        $setupModel = new Mage_Core_Model_Resource_Setup('core_setup');

        if (!empty($data['use_rewrites'])) {
            $setupModel->setConfigData(Mage_Core_Model_Store::XML_PATH_USE_REWRITES, 1);
        }

        $unsecureBaseUrl = Mage::getBaseUrl('web');
        if (!empty($data['unsecure_base_url'])) {
            $unsecureBaseUrl = $data['unsecure_base_url'];
            $setupModel->setConfigData(Mage_Core_Model_Store::XML_PATH_UNSECURE_BASE_URL, $unsecureBaseUrl);
        }

        if (!empty($data['use_secure'])) {
            $setupModel->setConfigData(Mage_Core_Model_Store::XML_PATH_SECURE_IN_FRONTEND, 1);
            $setupModel->setConfigData(Mage_Core_Model_Store::XML_PATH_SECURE_BASE_URL, $data['secure_base_url']);
            if (!empty($data['use_secure_admin'])) {
                $setupModel->setConfigData(Mage_Core_Model_Store::XML_PATH_SECURE_IN_ADMINHTML, 1);
            }
        }
        elseif (!empty($data['unsecure_base_url'])) {
            $setupModel->setConfigData(Mage_Core_Model_Store::XML_PATH_SECURE_BASE_URL, $unsecureBaseUrl);
        }

        /**
         * Saving locale information into DB
         */
        $locale = $this->getDataModel()->getLocaleData();
        if (!empty($locale['locale'])) {
            $setupModel->setConfigData(Mage_Core_Model_Locale::XML_PATH_DEFAULT_LOCALE, $locale['locale']);
        }
        if (!empty($locale['timezone'])) {
            $setupModel->setConfigData(Mage_Core_Model_Locale::XML_PATH_DEFAULT_TIMEZONE, $locale['timezone']);
        }
        if (!empty($locale['currency'])) {
            $setupModel->setConfigData(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE, $locale['currency']);
            $setupModel->setConfigData(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_DEFAULT, $locale['currency']);
            $setupModel->setConfigData(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_ALLOW, $locale['currency']);
        }
    }

    /**
     * Prepare admin user data in model and validate it.
     * Returns TRUE or array of error messages.
     *
     * @param array $data
     * @return mixed
     */
    public function validateAndPrepareAdministrator($data)
    {
        $user = Mage::getModel('admin/user')
            ->load($data['username'], 'username');
        $user->addData($data);

        $result = $user->validate();
        if (is_array($result)) {
            foreach ($result as $error) {
                $this->getDataModel()->addError($error);
            }
            return $result;
        }
        return $user;
    }

    /**
     * Create admin user.
     * Paramater can be prepared user model or array of data.
     * Returns TRUE or throws exception.
     *
     * @param mixed $data
     * @return bool
     */
    public function createAdministrator($data)
    {
        $user = Mage::getModel('admin/user')
            ->load('admin', 'username');
        if ($user && $user->getPassword()=='4297f44b13955235245b2497399d7a93') {
            $user->delete();
        }

        //to support old logic checking if real data was passed
        if (is_array($data)) {
            $data = $this->validateAndPrepareAdministrator($data);
            if (is_array(data)) {
                throw new Exception('Please correct the user data and try again.');
            }
        }

        //run time flag to force saving entered password
        $data->setForceNewPassword(true);

        $data->save();
        $data->setRoleIds(array(1))->saveRelations();

        /*Mage::getModel("permissions/user")->setRoleId(1)
            ->setUserId($user->getId())
            ->setFirstname($user->getFirstname())
            ->add();*/

        return true;
    }

    /**
     * Validating encryption key.
     * Returns TRUE or array of error messages.
     *
     * @param $key
     * @return unknown_type
     */
    public function validateEncryptionKey($key)
    {
        $errors = array();

        try {
            if ($key) {
                Mage::helper('core')->validateKey($key);
            }
        } catch (Exception $e) {
            $errors[] = $e->getMessage();
            $this->getDataModel()->addError($e->getMessage());
        }

        if (!empty($errors)) {
            return $errors;
        }

        return true;
    }

    /**
     * Set encryption key
     *
     * @param string $key
     * @return void
     */
    public function installEnryptionKey($key)
    {
        if ($key) {
            Mage::helper('core')->validateKey($key);
        }
        WebTricks_Install_Installer_Config::singleton()->replaceTmpEncryptKey($key);
    }

    public function finish()
    {
        WebTricks_Install_Installer_Config::singleton()->replaceTmpInstallDate();
        $this->getApplication()->getCache()->clean();

        $cacheData = array();
        foreach (Mage::helper('core')->getCacheTypes() as $type=>$label) {
            $cacheData[$type] = 1;
        }
        
        Mage::app()->saveUseCache($cacheData);
    }
}