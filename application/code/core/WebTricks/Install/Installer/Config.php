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
 * Config installer
 * 
 * @package		WebTricks_Install
 * @author		WebTricks Core Team <core@webtricksframework.com>
 */
class WebTricks_Install_Installer_Config extends WebTricks_Install_Installer_Abstract
{
    const TMP_INSTALL_DATE_VALUE= 'd-d-d-d-d';
    const TMP_ENCRYPT_KEY_VALUE = 'k-k-k-k-k';

    /**
     * Path to local configuration file
     *
     * @var string
     */
    protected $_localConfigFile;

    protected $_configData = array();
    
    public static function singleton()
    {
    	return Cream::singleton(__CLASS__);
    }

    public function __construct()
    {
        $this->_localConfigFile = $this->_getApplication()->getOptions()->getConfigDir() . DS .'local.xml';
    }

    public function setConfigData($data)
    {
        if (is_array($data)) {
            $this->_configData = $data;
        }
        return $this;
    }

    public function getConfigData()
    {
        return $this->_configData;
    }

    public function install()
    {
        $data = $this->getConfigData();
        //foreach ($this->_getApplication()->getConfig()->getDistroServerVars() as $index => $value) {
        //    if (!isset($data[$index])) {
        //        $data[$index] = $value;
        //    }
        //}

        if (isset($data['unsecure_base_url'])) {
            $data['unsecure_base_url'] .= substr($data['unsecure_base_url'],-1) != '/' ? '/' : '';
            if (!$this->_getInstaller()->getDataModel()->getSkipBaseUrlValidation()) {
                $this->_checkUrl($data['unsecure_base_url']);
            }
        }
        if (isset($data['secure_base_url'])) {
            $data['secure_base_url'] .= substr($data['secure_base_url'],-1) != '/' ? '/' : '';

            if (!empty($data['use_secure'])
                && !$this->_getInstaller()->getDataModel()->getSkipUrlValidation()) {
                $this->_checkUrl($data['secure_base_url']);
            }
        }

        $data['date']   = self::TMP_INSTALL_DATE_VALUE;
        $data['key']    = self::TMP_ENCRYPT_KEY_VALUE;
        $data['var_dir'] = $data['root_dir'] . '/var';

        $data['use_script_name'] = isset($data['use_script_name']) ? 'true' : 'false';

        $this->_getInstaller()->getDataModel()->setConfigData($data);

        $template = file_get_contents($this->_getApplication()->getOptions()->getConfigDir() .DS .'local.xml.template');
        foreach ($data as $index=>$value) {
            $template = str_replace('{{'.$index.'}}', '<![CDATA['.$value.']]>', $template);
        }
        file_put_contents($this->_localConfigFile, $template);
        chmod($this->_localConfigFile, 0777);
    }

    public function getFormData()
    {
        $uri = Zend_Uri::factory(Mage::getBaseUrl('web'));

        $baseUrl = $uri->getUri();
        if ($uri->getScheme()!=='https') {
            $uri->setPort(null);
            $baseSecureUrl = str_replace('http://', 'https://', $uri->getUri());
        } else {
            $baseSecureUrl = $uri->getUri();
        }

        $data = Cream_Object::instance();
        $data->setDbHost('localhost');
        $data->setDbName('webtricks');
        $data->setDbUser('root');
        $data->setDbPass('');
        $data->setSecureBaseUrl($baseSecureUrl);
        $data->setUnsecureBaseUrl($baseUrl);
        $data->setAdminFrontname('admin');
        
        return $data;
    }

    protected function _checkHostsInfo($data)
    {
        $url = $data['protocol'] . '://' . $data['host'] . ':' . $data['port'] . $data['base_path'];
        $surl= $data['secure_protocol'] . '://' . $data['secure_host'] . ':' . $data['secure_port'] . $data['secure_base_path'];

        $this->_checkUrl($url);
        $this->_checkUrl($surl, true);

        return $this;
    }

    protected function _checkUrl($url, $secure=false)
    {
        $prefix = $secure ? 'install/wizard/checkSecureHost/' : 'install/wizard/checkHost/';
        $client = new Cream_Http_Client($url.'index.php/'.$prefix);
        try {
            $response = $client->request('GET');
            $body = $response->getBody();
        }
        catch (Exception $e){
            $this->_getInstaller()->getDataModel()->addError('The URL "%s" is not accessible.', $url);
            throw $e;
        }

        if ($body != WebTricks_Install_Installer::INSTALLER_HOST_RESPONSE) {
            $this->_getInstaller()->getDataModel()->addError('The URL "%s" is invalid.', $url);
            throw new Cream_Exceptions_Exception('This URL is invalid.');
        }
        return $this;
    }

    public function replaceTmpInstallDate($date = null)
    {
        $stamp    = strtotime((string) $date);
        $localXml = file_get_contents($this->_localConfigFile);
        $localXml = str_replace(self::TMP_INSTALL_DATE_VALUE, date('r', $stamp ? $stamp : time()), $localXml);
        file_put_contents($this->_localConfigFile, $localXml);

        return $this;
    }

    public function replaceTmpEncryptKey($key = null)
    {
        if (!$key) {
            $key = md5(time());
        }
        $localXml = file_get_contents($this->_localConfigFile);
        $localXml = str_replace(self::TMP_ENCRYPT_KEY_VALUE, $key, $localXml);
        file_put_contents($this->_localConfigFile, $localXml);

        return $this;
    }
}
