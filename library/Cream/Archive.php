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
 * Class to work with archives
 *
 * @category    Cream
 * @package     Cream_Archive
 * @author      WebTricks Core Team <core@webtricksframework.com>
 */
class Cream_Archive
{
    /**
    * Archiver is used for compress.
    */
    const DEFAULT_ARCHIVER   = 'gz';

    /**
    * Default packer for directory.
    */
    const TAPE_ARCHIVER      = 'tar';

    /**
    * Current archiver is used for compress.
    *
    * @var Cream_Archive_Tar|Cream_Archive_Gz|Cream_Archive_Bz
    */
    protected $_archiver=null;

    /**
    * Accessible formats for compress.
    *
    * @var array
    */
    protected $_formats = array(
        'tar'        => 'tar',
        'gz'         => 'gz',
        'gzip'       => 'gz',
        'tgz'        => 'tar.gz',
        'tgzip'      => 'tar.gz',
        'bz'         => 'bz',
        'bzip'       => 'bz',
        'bzip2'      => 'bz',
        'bz2'        => 'bz',
        'tbz'        => 'tar.bz',
        'tbzip'      => 'tar.bz',
        'tbz2'       => 'tar.bz',
        'tbzip2'     => 'tar.bz');

	/**
	 * Create a new instance of this class.
	 * 
	 * @return Cream_Archive
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}

    /**
     * Create object of current archiver by $extension.
     *
     * @param string $extension
     * @return Cream_Archive_Tar|Cream_Archive_Gz|Cream_Archive_Bz
     */
    protected function _getArchiver($extension)
    {
        if(array_key_exists(strtolower($extension), $this->_formats)) {
            $format = $this->_formats[$extension];
        } else {
            $format = self::DEFAULT_ARCHIVER;
        }
        $class = 'Cream_Archive_'.ucfirst($format);
        $this->_archiver = Cream::instance($class);
        return $this->_archiver;
    }

    /**
     * Split current format to list of archivers.
     *
     * @param string $source
     * @return array
     */
    protected function _getArchivers($source)
    {
        $ext = pathinfo($source, PATHINFO_EXTENSION);
        if(!isset($this->_formats[$ext])) {
            return array();
        }
        $format = $this->_formats[$ext];
        if ($format) {
            $archivers = explode('.', $format);
            return $archivers;
        }
        return array();
    }

    /**
     * Pack file or directory to archivers are parsed from extension.
     *
     * @param string $source
     * @param string $destination
     * @param boolean $skipRoot skip first level parent
     * @return string Path to file
     */
    public function pack($source, $destination='packed.tgz', $skipRoot=false)
    {
        $archivers = $this->_getArchivers($destination);
        $interimSource = '';
        for ($i=0; $i<count($archivers); $i++ ) {
            if ($i == (count($archivers) - 1)) {
                $packed = $destination;
            } else {
                $packed = dirname($destination) . DS . '~tmp-'. microtime(true) . $archivers[$i] . '.' . $archivers[$i];
            }
            $source = $this->_getArchiver($archivers[$i])->pack($source, $packed, $skipRoot);
            if ($interimSource && $i < count($archivers)) {
                unlink($interimSource);
            }
            $interimSource = $source;
        }
        return $source;
    }

    /**
     * Unpack file from archivers are parsed from extension.
     * If $tillTar == true unpack file from archivers till
     * meet TAR archiver.
     *
     * @param string $source
     * @param string $destination
     * @param boolean $tillTar
     * @return string Path to file
     */
    public function unpack($source, $destination='.', $tillTar=false, $clearInterm = true)
    {
        $archivers = $this->_getArchivers($source);
        $interimSource = '';
        for ($i=count($archivers)-1; $i>=0; $i--) {
            if ($tillTar && $archivers[$i] == self::TAPE_ARCHIVER) {
                break;
            }
            if ($i == 0) {
                $packed = rtrim($destination, DS) . DS;
            } else {
                $packed = rtrim($destination, DS) . DS . '~tmp-'. microtime(true) . $archivers[$i-1] . '.' . $archivers[$i-1];
            }
            $source = $this->_getArchiver($archivers[$i])->unpack($source, $packed);
            
            //var_dump($packed, $source);
            
            if ($clearInterm && $interimSource && $i >= 0) {
                unlink($interimSource);
            }
            $interimSource = $source;
        }
        return $source;
    }

    /**
     * Extract one file from TAR (Tape Archiver).
     *
     * @param string $file
     * @param string $source
     * @param string $destination
     * @return string Path to file
     */
    public function extract($file, $source, $destination='.')
    {
        $tarFile = $this->unpack($source, $destination, true);
        $resFile = $this->_getArchiver(self::TAPE_ARCHIVER)->extract($file, $tarFile, $destination);
        if (!$this->isTar($source)) {
            unlink($tarFile);
        }
        return $resFile;
    }

    /**
     * Check file is archive.
     *
     * @param string $file
     * @return boolean
     */
    public function isArchive($file)
    {
        $archivers = $this->_getArchivers($file);
        if (count($archivers)) {
            return true;
        }
        return false;
    }

    /**
     * Check file is TAR.
     *
     * @param mixed $file
     * @return boolean
     */
    public function isTar($file)
    {
        $archivers = $this->_getArchivers($file);
        if (count($archivers)==1 && $archivers[0] == self::TAPE_ARCHIVER) {
            return true;
        }
        return false;
    }
}