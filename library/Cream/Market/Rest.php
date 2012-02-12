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

/**
 * Class to work with remote REST interface
 *
 * @category    Cream
 * @package     Cream_Market
 * @author      WebTricks Core Team <core@webtricksframework.com>
 */

class Cream_Market_Rest
{
    const CHANNELS_XML = "channels.xml";
    const CHANNEL_XML = "channel.xml";
    const PACKAGES_XML = "packages.xml";
    const RELEASES_XML = "releases.xml";
    const PACKAGE_XML = "package.xml";
    const EXT = "tgz";
	
    protected $states = array('b'=>'beta', 'd'=>'dev', 's'=>'stable', 'a'=>'alpha');	

    /**
     * HTTP Loader
	 * 
     * @var Cream_IO_Http_Client_Interface
     */
    protected $_loader = null;

    /**
     * XML parser
	 * 
     * @var Cream_Xml_Parser
     */
    protected $_parser = null;

    /**
     * Channel URI
	 * 
     * @var string
     */
    protected $_chanUri = '';

    /**
    * Protocol HTTP or FTP
    *
    * @var string http or ftp
    */
    protected $_protocol = '';

	/**
	 * Create a new instance of this class
	 * 
	 * @param string $protocol
	 * @return Cream_Market_Rest
	 */
	public static function instance($protocol = "http")
	{
		return Cream::instance(__CLASS__, $protocol);
	}

    /**
     * Initialize function
	 * 
	 * @param string $protocol
	 * @return void
     */
    public function __construct($protocol = "http")
    {
        switch ($protocol) {
            case 'http':default:
                $this->_protocol = 'http';
                break;
            case 'ftp':
                $this->_protocol = 'ftp';
                break;
        }
    }

    /**
     * Set channel info
     *
     * @param string $uri
     * @param sting $name
     */
    public function setChannel($uri)
    {
        $this->_chanUri = $uri;
    }

    /**
     * Get HTTP loader
	 * 
     * @return Cream_Market_Loader
     */
    protected function getLoader()
    {
        if(is_null($this->_loader)) {
            $this->_loader = Cream_Market_Loader::factory($this->_protocol);
        }

        return $this->_loader;
    }


    /**
     * Get parser
     *
     * @return Cream_Xml_Parser
     */
    protected function getParser()
    {
        if(is_null($this->_parser)) {
            $this->_parser = Cream_Xml_Parser::instance();
        }
        return $this->_parser;
    }

    /**
     * Load URI response
	 * 
     * @param string $uri
     */
    protected function loadChannelUri($uriSuffix)
    {
        $url = $this->_chanUri."/".$uriSuffix;
        //print $url."\n";
        $this->getLoader()->get($url);
        $statusCode = $this->getLoader()->getStatus();
        if($statusCode != 200) {
            return false;
        }
        return $this->getLoader()->getBody();
    }

    /**
     * Get channels list of URI
	 * 
     * @return array
     */
    public function getChannelInfo()
    {
        $out = $this->loadChannelUri(self::CHANNEL_XML);
        $statusCode = $this->getLoader()->getStatus();
        if($statusCode != 200) {
            throw new Exception("Invalid server response for {$this->_chanUri}");
        }
        $parser = $this->getParser();
        $out = $parser->loadXML($out)->xmlToArray();

        // TODO: add channel validator
        $vo = Cream_Market_Channel_VO::instance();
        $vo->fromArray($out['channel']);
        if(!$vo->validate()) {
            throw new Exception("Invalid channel.xml file");
        }
        return $vo;
    }


    /**
     * Get packages list of channel
	 * 
     * @return array
     */
    public function getPackages()
    {
        $out = $this->loadChannelUri(self::PACKAGES_XML);
        $statusCode = $this->getLoader()->getStatus();
        if($statusCode != 200) {
            return false;
        }
        $parser = $this->getParser();
        $out = $parser->loadXML($out)->xmlToArray();


        if(!isset($out['data']['p'])) {
            return array();
        }
        if(isset($out['data']['p'][0])) {
            return $out['data']['p'];
        }
        if(is_array($out['data']['p'])) {
            return array($out['data']['p']);
        }
        return array();
    }


    public function getPackagesHashed()
    {
        $out = $this->loadChannelUri(self::PACKAGES_XML);
        $statusCode = $this->getLoader()->getStatus();
        if($statusCode != 200) {
            return false;
        }
        $parser = $this->getParser();
        $out = $parser->loadXML($out)->xmlToArray();

        $return = array();
        if(!isset($out['data']['p'])) {
            return $return;
        }
        if(isset($out['data']['p'][0])) {
            $return = $out['data']['p'];
        }
        if(is_array($out['data']['p'])) {
            $return = array($out['data']['p']);
        }
        $c  = count($return);
        if($c) {
            $output = array();
            for($i=0,$c=count($return[0]); $i<$c; $i++) {
                $element = $return[0][$i];
                $output[$element['n']] = $element['r'];
            }
            $return = $output;
        }
        
        $out = array();
        foreach($return as $name=>$package) {
            $stabilities = array_map(array($this, 'shortStateToLong'), array_keys($package));
            $versions = array_map('trim', array_values($package));                
            $package = array_combine($versions, $stabilities);
            ksort($package);
            $out[$name] = $package;
        }        
        return $out;
    }

    /**
     * Stub
	 * 
     * @param $n
     * @return unknown_type
     */
    public function escapePackageName($n)
    {
        return $n;
    }

    /**
     * Get releases list of package on current channel
     * @param string $package package name
     */
    public function getReleases($package)
    {
        $out = $this->loadChannelUri($this->escapePackageName($package)."/".self::RELEASES_XML);
        $statusCode = $this->getLoader()->getStatus();
        if($statusCode != 200) {
            return false;
        }
        $parser = $this->getParser();
        $out = $parser->loadXML($out)->xmlToArray();
        if(!isset($out['releases']['r'])) {
            return array();
        }
        $src = $out['releases']['r'];
        if(!array_key_exists(0, $src)) {
            return array($src);
        }
        $this->sortReleases($src);
        return $src;
    }

    /**
     * Sort releases
	 * 
     * @param array $releases
     * @return void
     */
    public function sortReleases(array &$releases)
    {
        usort($releases, array($this, 'sortReleasesCallback'));
        $releases = array_reverse($releases);
    }

    /**
     * Sort releases callback
	 * 
     * @param string $a
     * @param srting $b
     * @return int
     */
    protected function sortReleasesCallback($a, $b)
    {
        return version_compare($a['v'],$b['v']);
    }

    /**
     * Get package info (package.xml)
     *
     * @param $package
     * @return unknown_type
     */
    public function getPackageInfo($package)
    {
        $out = $this->loadChannelUri($this->escapePackageName($package)."/".self::PACKAGE_XML);
        if(false === $out) {
            return false;
        }
        return Cream_Market_Package::instance($out);
    }

    /**
     *
     * @param $package
     * @param $version
     * @return Cream_Market_Package
     */
    public function getPackageReleaseInfo($package, $version)
    {
        $out = $this->loadChannelUri($this->escapePackageName($package)."/".$version."/".self::PACKAGE_XML);
        if(false === $out) {
            return false;
        }
		
        return Cream_Market_Package::instance($out);
    }

    /**
     * Get package archive file of release
     * @param string $package package name
     * @param string $version version
     */
    public function downloadPackageFileOfRelease($package, $version, $targetFile)
    {
        $package = $this->escapePackageName($package);
        $version = $this->escapePackageName($version);

        if(file_exists($targetFile)) {
            $chksum = $this->loadChannelUri($package."/".$version."/checksum");
            $statusCode = $this->getLoader()->getStatus();
            if($statusCode == 200) {
                if(md5_file($targetFile) == $chksum) {
                    return true;
                }
            }
        }
        
        $out = $this->loadChannelUri($package."/".$version."/".$package."-".$version.".".self::EXT);

        $statusCode = $this->getLoader()->getStatus();
        if($statusCode != 200)	{
            throw new Exception("Package not found: {$package} {$version}");
        }
        $dir = dirname($targetFile);
        @mkdir($dir, 0777, true);
        $result = @file_put_contents($targetFile, $out);
        if(false === $result) {
            throw new Exception("Cannot write to file {$targetFile}");
        }
        return true;
    }

    public function shortStateToLong($s)
    {
        return isset($this->states[$s]) ? $this->states[$s] : 'dev';
    }
}