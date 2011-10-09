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
 * PEAR Packages Download Manager
 *
 * @package		WebTricks_Install
 * @author		WebTricks Core Team <core@webtricksframework.com>
 */
class WebTricks_Install_Installer_Pear extends WebTricks_Install_Installer_Abstract
{
    public function getPackages()
    {
        $packages = array(
            'pear/PEAR-stable',
            'appstore.webtricksframework.com/core/Lib_ZF',
            'appstore.webtricksframework.com/core/Lib_Cream',
            'appstore.webtricksframework.com/core/WebTricks_All',
            'appstore.webtricksframework.com/core/Interface_Frontend_Default',
            'appstore.webtricksframework.com/core/Interface_Adminhtml_Default',
            'appstore.webtricksframework.com/core/Interface_Install_Default',
        );
        return $packages;
    }

    public function checkDownloads()
    {
        $pear = Cream_Pear::instance();
        $pkg = new PEAR_PackageFile($pear->getConfig(), false);
        $result = true;
        foreach ($this->getPackages() as $package) {
            $obj = $pkg->fromAnyFile($package, PEAR_VALIDATE_NORMAL);
            if (PEAR::isError($obj)) {
                $uinfo = $obj->getUserInfo();
                if (is_array($uinfo)) {
                    foreach ($uinfo as $message) {
                        if (is_array($message)) {
                            $message = $message['message'];
                        }
                        WebTricks_Install_Session::singleton()->addError($message, $message);
                    }
                } else {
                    print_r($obj->getUserInfo());
                }
                $result = false;
            }
        }
        return $result;
    }
}
