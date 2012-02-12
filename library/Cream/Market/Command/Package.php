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

final class Cream_Market_Command_Package extends Cream_Market_Command
{
    /**
     * Dependencies list
     * @var array
     */
    private $_depsList = array();

    /**
     * Releases list
     * @var array
     */
    private $_releasesList = array();

    /**
     * Package command callback
     * @param string $command
     * @param array $options
     * @param array $params
     * @return void
     */
    public function doPackage($command, $options, $params)
    {
        $this->cleanupParams($params);

        if(count($params) < 1) {
            return $this->doError($command, "Parameters count should be >= 1");
        }

        $file = strtolower($params[0]);
        $file = realpath($file);

        if(!file_exists($file)) {
            return $this->doError($command, "File {$params[0]} doesn't exist");
        }

        try {
            $packager = Cream_Market_Package::instance($file);
            $res = $packager->validate();
            if(!$res) {
                $this->doError($command, implode("\n", $packager->getErrors()));
                return;
            }
            $packager->save(dirname($file));
            $this->ui()->output('Done building package');
        } catch (Exception $e) {
            $this->doError( $command, $e->getMessage() );
        }
    }


    /**
     * Display/get dependencies
     * @param string $command
     * @param array $options
     * @param array $params
     * @return void/array
     */
    public function doPackageDependencies($command, $options, $params)
    {
        $this->cleanupParams($params);
        try {
            if(count($params) < 2) {
                return $this->doError($command, "Argument count should be >= 2");
            }

            $channel = $params[0];
            $package = $params[1];

            $argVersionMin = isset($params[3]) ? $params[3] : false;
            $argVersionMax = isset($params[2]) ? $params[2] : false;

            $ftp = empty($options['ftp']) ? false : $options['ftp'];
            $packager = $this->getPackager();
            if($ftp) {
                list($cache, $config, $ftpObj) = $packager->getRemoteConf($ftp);
            } else {
                $cache = $this->getSconfig();
                $config = $this->config();
            }
            $data = $packager->getDependenciesList($channel, $package, $cache, $config, $argVersionMax, $argVersionMin);
            $this->ui()->output(array($command=> array('data'=>$data['deps'], 'title'=>"Package deps for {$params[1]}: ")));

        } catch (Exception $e) {
            $this->doError($command, $e->getMessage());
        }
    }
}