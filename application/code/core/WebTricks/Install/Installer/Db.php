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
 * DB Installer
 *
 * @package		WebTricks_Install
 * @author		WebTricks Core Team <core@webtricksframework.com>
 */
class WebTricks_Install_Installer_Db extends WebTricks_Install_Installer_Abstract
{
    public static function singleton()
    {
    	return Cream::singleton(__CLASS__);
    }
    
    /**
     * Retrieve Connection Type
     *
     * @return string
     */
    protected function _getConnenctionType()
    {
        return (string) $this->_getApplication()->getConfig()->getNode('global/data/connection/default_setup/type');
    }    
	
    /**
     * Check database connection
     *
     * $data = array(
     *      [db_host]
     *      [db_name]
     *      [db_user]
     *      [db_pass]
     * )
     *
     * @param array $data
     */
    public function checkDatabase($data)
    {
        $config = array(
            'server'    => $data['db_host'],
            'username'  => $data['db_user'],
            'password'  => $data['db_pass'],
            'database'  => $data['db_name'],
        	'type'		=> $this->_getConnenctionType()
        );

        try {
            $connection = Cream_Data_Connection::instance($config);
            $variables  = $connection->fetchPairs("SHOW VARIABLES");

            $version = isset($variables['version']) ? $variables['version'] : 'undefined';
            $match = array();
            if (preg_match("#^([0-9\.]+)#", $version, $match)) {
                $version = $match[0];
            }
            $requiredVersion = (string) WebTricks_Install_Config::singleton()->getNode('check/mysql/version');

            // check MySQL Server version
            if (version_compare($version, $requiredVersion) == -1) {
                throw new Cream_Exceptions_Exception(sprintf('The database server version does not match system requirements (required: %s, actual: %s).', $requiredVersion, $version));
            }

            // check InnoDB support
            if (!isset($variables['have_innodb']) || $variables['have_innodb'] != 'YES') {
                throw new Cream_Exceptions_Exception('Database server does not support the InnoDB storage engine.');
            }
        }
        catch (Exception $e){
            $this->_getInstaller()->getDataModel()->addError($e->getMessage());
            throw new Cream_Exceptions_Exception('Database connection error.');
        }
    }
}