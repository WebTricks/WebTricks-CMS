<?php

class WebTricks_Install_Installer_Environment extends WebTricks_Install_Installer_Abstract
{
    public static function singleton()
    {
    	return Cream::singleton(__CLASS__);
    }
    	
    public function install()
    {
        if (!$this->_checkPhpExtensions()) {
            throw new Exception();
        }
        return $this;
    }

    protected function _checkPhpExtensions()
    {
        $res = true;
        $config = WebTricks_Install_Config::singleton()->getExtensionsForCheck();
        foreach ($config as $extension => $info) {
            if (!empty($info) && is_array($info)) {
                $res = $this->_checkExtension($info) && $res;
            }
            else {
                $res = $this->_checkExtension($extension) && $res;
            }
        }
        return $res;
    }

    protected function _checkExtension($extension)
    {
        if (is_array($extension)) {
            $oneLoaded = false;
            foreach ($extension as $item) {
                if (extension_loaded($item)) {
                    $oneLoaded = true;
                }
            }

            if (!$oneLoaded) {
                WebTricks_Install_Session::singleton()->addError(
                    'One of PHP Extensions "%s" must be loaded.', implode(',', $extension)
                );
                return false;
            }
        } elseif(!extension_loaded($extension)) {
                WebTricks_Install_Session::singleton()->addError(
                    'PHP extension "%s" must be loaded.', $extension
                );
            return false;
        }
        return true;
    }
}
