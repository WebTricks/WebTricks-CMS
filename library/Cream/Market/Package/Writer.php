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
 * Class to create archive.
 *
 * @category    Cream
 * @package     Cream_Market
 * @author      WebTricks Core Team <core@webtricksframework.com>
 */
class Cream_Market_Package_Writer
{
    /**
     * Name of package configuration file
     */
    const DEFAULT_NAME_PACKAGE_CONFIG = 'package.xml';

    /**
     * Temporary dir for extract DEFAULT_NAME_PACKAGE.
     */
    const PATH_TO_TEMPORARY_DIRECTORY = 'var/package/tmp/';

    /**
     * Files are used in package.
     *
     * @var array
     */
    protected $_files = array();

    /**
     * Archivator is used for extract DEFAULT_NAME_PACKAGE.
     *
     * @var Cream_Archive
     */
    protected $_archivator = null;

    /**
     * Name of package with extension. Extension should be only one.
     * "package.tar.gz" is not ability, only "package.tgz".
     *
     * @var string
     */
    protected $_namePackage = 'package';

    /**
     * Temporary directory where package is situated.
     *
     * @var string
     */
    protected $_temporaryPackageDir = '';

    /**
     * Path to archive with package.
     *
     * @var mixed
     */
    protected $_pathToArchive = '';

	/**
	 * Create a new instance of this class.
	 * 
	 * @return Cream_Market_Package_Writer
	 */
	public static function instance($files, $namePackage = '')
	{
		return Cream::instance(__CLASS__, $files, $namePackage);
	}

    /**
     * Constructor initializes $_file.
     *
     * @param array $files
     * @param string $namePackage
     * @return void
     */
    public function __init($files, $namePackage = '')
    {
        $this->_files = $files;
        $this->_namePackage = $namePackage;
    }

    /**
     * Retrieve archivator.
     *
     * @return Cream_Archive
     */
    protected function _getArchivator()
    {
        if (is_null($this->_archivator)) {
            $this->_archivator = Cream_Archive::instance;
        }
        return $this->_archivator;
    }

    /**
     * Create dir in PATH_TO_TEMPORARY_DIRECTORY and move all files
     * to this dir.
     *
     * @return void
     */
    public function composePackage()
    {
        @mkdir(self::PATH_TO_TEMPORARY_DIRECTORY, 0777, true);        
        $root = self::PATH_TO_TEMPORARY_DIRECTORY . basename($this->_namePackage);
        @mkdir($root, 0777, true);
        foreach ($this->_files as $file) {
            
            if (is_dir($file) || is_file($file)) {
                $fileName = basename($file);
                $filePath = dirname($file);
                @mkdir($root . DS . $filePath, 0777, true);
                if (is_file($file)) {
                    copy($file, $root . DS . $filePath . DS . $fileName);
                } else {
                    @mkdir($root . DS . $filePath . $fileName, 0777);
                }
            }
        }
        $this->_temporaryPackageDir = $root;
    }

    /**
     * Create dir in PATH_TO_TEMPORARY_DIRECTORY and move all files
     * to this dir.
     *
     * @param array $destinationFiles
     * @return void
     */
    public function composePackageV1x(array $destinationFiles)
    {
        @mkdir(self::PATH_TO_TEMPORARY_DIRECTORY, 0777, true);
        $root = self::PATH_TO_TEMPORARY_DIRECTORY . basename($this->_namePackage);
        @mkdir($root, 0777, true);
        $packageFilesDir = $root . DS . basename($this->_namePackage);
        @mkdir($packageFilesDir, 0777, true);
        foreach ($this->_files as $index => $file) {
            $destinationFile = $destinationFiles[$index];
            if (is_dir($file) || is_file($file)) {
                $fileName = basename($destinationFile);
                $filePath = dirname($destinationFile);
                @mkdir($packageFilesDir . DS . $filePath, 0777, true);
                if (is_file($file)) {
                    copy($file, $packageFilesDir . DS . $filePath . DS . $fileName);
                } else {
                    @mkdir($packageFilesDir . DS . $filePath . $fileName, 0777);
                }
            }
        }
        $this->_temporaryPackageDir = $root;
    }

    /**
     * Add package.xml to temporary package directory.
     *
     * @param $content
     * @return void
     */
    public function addPackageXml($content)
    {
        file_put_contents($this->_temporaryPackageDir . DS . self::DEFAULT_NAME_PACKAGE_CONFIG, $content);
    }

    /**
     * Archives package.
     *
     * @return void
     */
    public function archivePackage()
    {
        $this->_pathToArchive = $this->_getArchivator()->pack(
            $this->_temporaryPackageDir,
            $this->_namePackage.'.tgz',
            true);

        //delete temporary dir
        Cream_IO_Directory::remove($this->_temporaryPackageDir);
    }
    
    /**
     * Getter for pathToArchive
     *
     * @return string
     */
    public function getPathToArchive()
    {
        return $this->_pathToArchive;
    }
}