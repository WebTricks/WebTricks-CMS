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

final class Cream_Market_Command_Registry extends Cream_Market_Command
{
    /**
     * List-installed callback
	 * 
     * @param string $command
     * @param array $options
     * @param array $params
     * @return void
     */
    public function doList($command, $options, $params)
    {
        $this->cleanupParams($params);
        try {
            $packager = $this->getPackager();
            $ftp = empty($options['ftp']) ? false : $options['ftp'];
            if($ftp) {
                list($cache, $ftpObj) = $packager->getRemoteCache($ftp);
            } else {
                $cache = $this->getSconfig();
            }
            if(!empty($params[0])) {
                $chanName = $conf->chanName($params[0]);
                $data = $cache->getInstalledPackages($chanName);
            } else {
                $data = $cache->getInstalledPackages();
            }
            if($ftp) {
                @unlink($cache->getFilename());
            }
            $this->ui()->output(array($command=>array('data'=>$data, 'channel-title'=>"Installed package for channel '%s' :")));
        } catch (Exception $e) {
            if($ftp) {
                @unlink($cache->getFilename());
            }
            $this->doError($command, $e->getMessage());
        }

    }

    /**
     * list-files callback
     * @param string $command
     * @param array $options
     * @param array $params
     * @return void
     */
    public function doFileList($command, $options, $params)
    {
        $this->cleanupParams($params);
        //$this->splitPackageArgs($params);
        try {
            $channel = false;
            if(count($params) < 2) {
                throw new Exception("Argument count should be = 2");
            }
            $channel = $params[0];
            $package = $params[1];

            $packager = $this->getPackager();
            $ftp = empty($options['ftp']) ? false : $options['ftp'];
            if($ftp) {
                list($cache, $config, $ftpObj) = $packager->getRemoteConf($ftp);
            } else {
                $cache = $this->getSconfig();
                $confif = $this->config();
            }
            if(!$cache->hasPackage($channel, $package)) {
                return $this->ui()->output("No package found: {$channel}/{$package}");
            }

            $p = $cache->getPackageObject($channel, $package);
            $contents = $p->getContents();
            if($ftp) {
                $ftpObj->close();
            }
            if(!count($contents)) {
                return $this->ui()->output("No contents for package {$package}");
            }
            $title = ("Contents of '{$package}': ");
            if($ftp) {
                @unlink($config->getFilename());
                @unlink($cache->getFilename());
            }

            $this->ui()->output(array($command=>array('data'=>$contents, 'title'=>$title)));

        } catch (Exception $e) {
            if($ftp) {
                @unlink($config->getFilename());
                @unlink($cache->getFilename());
            }
            $this->doError($command, $e->getMessage());
        }

    }

    /**
     * Installed package info
     * info command callback
     * @param string $command
     * @param array $options
     * @param array $params
     * @return
     */
    public function doInfo($command, $options, $params)
    {
        $this->cleanupParams($params);
        //$this->splitPackageArgs($params);

        try {
            $channel = false;
            if(count($params) < 2) {
                throw new Exception("Argument count should be = 2");
            }
            $channel = $params[0];
            $package = $params[1];
            $packager = $this->getPackager();
            $ftp = empty($options['ftp']) ? false : $options['ftp'];
            if($ftp) {
                list($cache, $ftpObj) = $packager->getRemoteCache($ftp);
            } else {
                $cache = $this->getSconfig();
            }

            if(!$cache->isChannel($channel)) {
                throw new Exception("'{$channel}' is not a valid installed channel name/uri");
            }
            $channelUri = $cache->chanUrl($channel);
            $rest = $this->rest();
            $rest->setChannel($channelUri);
            $releases = $rest->getReleases($package);
            if(false === $releases) {
                throw new Exception("No information found about {$channel}/{$package}");
            }
            $data = array($command => array('releases'=>$releases));
            if($ftp) {
                @unlink($cache->getFilename());
            }
            $this->ui()->output($data);
        } catch (Exception $e) {
            if($ftp) {
                @unlink($cache->getFilename());
            }
            $this->doError($command, $e->getMessage());
        }
    }
}