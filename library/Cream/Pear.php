<?php

class Cream_Pear 
{
	
    public function getConfig()
    {
        if (!$this->_config) {
            $pear_dir = $this->getPearDir();

            $config = PEAR_Config::singleton($pear_dir.DS.'pear.ini', '-');
            //$config = PEAR_Config::singleton();

            $config->set('auto_discover', 1);
            $config->set('cache_ttl', 60);
            #$config->set('preferred_state', 'beta');

            $config->set('bin_dir', $pear_dir);
            $config->set('php_dir', $pear_dir.DS.'php');
            $config->set('download_dir', $pear_dir.DS.'download');
            $config->set('temp_dir', $pear_dir.DS.'temp');
            $config->set('data_dir', $pear_dir.DS.'data');
            $config->set('cache_dir', $pear_dir.DS.'cache');
            $config->set('test_dir', $pear_dir.DS.'tests');
            $config->set('doc_dir', $pear_dir.DS.'docs');

            foreach ($config->getKeys() as $key) {
                $config->set($key, preg_replace('#^\.#', addslashes($this->getBaseDir()), $config->get($key)));
                //echo $key.' : '.$config->get($key).'<br>';
            }

            $reg = $this->getRegistry();
            $config->setRegistry($reg);

            PEAR_DependencyDB::singleton($config, $pear_dir.DS.'php'.DS.'.depdb');

            PEAR_Frontend::setFrontendObject($this->getFrontend());

            PEAR_Command::registerCommands(false, $pear_dir.DS.'php'.DS.'PEAR'.DS.'Command'.DS);

            $this->_config = $config;
        }
        return $this->_config;
    }
	
    public function run($command, $options=array(), $params=array())
    {
        @set_time_limit(0);
        @ini_set('memory_limit', '256M');

        if (empty($this->_cmdCache[$command])) {
            $cmd = PEAR_Command::factory($command, $this->getConfig());
            if ($cmd instanceof PEAR_Error) {
                return $cmd;
            }
            $this->_cmdCache[$command] = $cmd;
        } else {
            $cmd = $this->_cmdCache[$command];
        }
        $cmd = PEAR_Command::factory($command, $this->getConfig());
        $result = $cmd->run($command, $options, $params);
        return $result;
    }	
}