<?php
/**
 * WebTricks - PHP Framework
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
 * @copyright Copyright (c) 2007-2012 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

final class Cream_Market_Command_Channels extends Cream_Market_Command
{
    /**
     * List available channels
	 * 
     * @param $command
     * @param $params
     * @param $options
     */
    public function doList($command, $options, $params)
    {
        try {
            $title = "Available channels:";
            $aliasT = "Available aliases:";
            $packager = $this->getPackager();
            $ftp = empty($options['ftp']) ? false : $options['ftp'];
            if($ftp) {
                list($cache, $config, $ftpObj) = $packager->getRemoteConf($ftp);
                $data = $cache->getData();
                @unlink($config->getFilename());
                @unlink($cache->getFilename());
            } else {
                $cache = $this->getSconfig();
                $config = $this->config();
                $data = $cache->getData();
            }            
            $out = array($command => array('data'=>$data, 'title'=>$title, 'title_aliases'=>$aliasT));
            $this->ui()->output($out);
        } catch (Exception $e) {
            $this->doError($command, $e->getMessage());
        }
    }

    /**
     * channel-delete callback method
     * @param string $command
     * @param array $options
     * @param array $params
     */
    public function doDelete($command, $options, $params)
    {
        $this->cleanupParams($params);
        try {
            if(count($params) != 1) {
                throw new Exception("Parameters count should be equal to 1");
            }
            $packager = $this->getPackager();

            $ftp = empty($options['ftp']) ? false : $options['ftp'];
            if($ftp) {
                list($cache, $config, $ftpObj) = $packager->getRemoteConf($ftp);
                $cache->deleteChannel($params[0]);                
                $packager->writeToRemoteCache($cache, $ftpObj);
                @unlink($config->getFilename());
            } else {
                $config = $this->config();
                $cache = $this->getSconfig();
                $cache->deleteChannel($params[0]);
            }
            $this->ui()->output("Successfully deleted");

        } catch (Exception $e) {
            $this->doError($command, $e->getMessage());
        }
    }

    /**
     * Channel-add callback
	 * 
     * @param string $command
     * @param array $options
     * @param array $params
     */
    public function doAdd($command, $options, $params)
    {
        $this->cleanupParams($params);
        try {
            if(count($params) != 1) {
                throw new Exception("Parameters count should be equal to 1");
            }
            $url = $params[0];
            $rest = $this->rest();
            $rest->setChannel($url);
            $data = $rest->getChannelInfo();
            $data->url = $url;
                        
            $packager = $this->getPackager();
            $ftp = empty($options['ftp']) ? false : $options['ftp'];
            if($ftp) {
                 list($cache, $config, $ftpObj) = $packager->getRemoteConf($ftp);
                 $cache->addChannel($data->name, $url);
                 $packager->writeToRemoteCache($cache, $ftpObj); 
                 @unlink($config->getFilename());                 
            } else {
                $cache = $this->getSconfig();               
                $config = $this->config();   
                $cache->addChannel($data->name, $url);
            }
            
            $this->ui()->output("Successfully added: ".$url);
        } catch (Exception $e) {
            $this->doError($command, $e->getMessage());
        }
    }

    /**
     * Get information about given channel callback
	 * 
     * @param string $command
     * @param array $options
     * @param array $params
     */
    public function doInfo($command, $options, $params)
    {

    }

    /**
     * channel-alias
	 * 
     * @param $command
     * @param $options
     * @param $params
     * @return unknown_type
     */
    public function doAlias($command, $options, $params)
    {
        $this->cleanupParams($params);
        try {
            if(count($params) != 2) {
                throw new Exception("Parameters count should be equal to 2");
            }

            $packager = $this->getPackager();
            $chanUrl = $params[0];
            $alias = $params[1];            
            $ftp = empty($options['ftp']) ? false : $options['ftp'];
            if($ftp) {
                list($cache, $config,  $ftpObj) = $packager->getRemoteConf($ftp);
                $cache->addChannelAlias($chanUrl, $alias);
                $packager->writeToRemoteCache($cache, $ftpObj);
                @unlink($config->getFilename());
            } else {                
                $cache = $this->getSconfig();
                $config = $this->config();
                $cache->addChannelAlias($chanUrl, $alias);                
            }
            $this->ui()->output("Successfully added: ".$alias);
        } catch (Exception $e) {
            $this->doError($command, $e->getMessage());
        }
    }

    public function doLogin($command, $options, $params)
    {

    }

    public function doLogout($command, $options, $params)
    {

    }
}