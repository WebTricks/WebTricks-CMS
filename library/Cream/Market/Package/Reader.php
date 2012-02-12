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
 * Class to get package.xml from different places.
 *
 * @category    Cream
 * @package     Cream_Market
 * @author      WebTricks Core Team <core@webtricksframework.com>
 */
class Cream_Market_Package_Reader
{
    /**
     * Name of package file
     */
    const DEFAULT_NAME_PACKAGE = 'package.xml';

    /**
     * Temporary dir for extract DEFAULT_NAME_PACKAGE.
     */
    const PATH_TO_TEMPORARY_DIRECTORY = 'var/package/tmp/';

    /**
     * Current path to file.
     *
     * @var string
     */
    protected $_file = '';

    /**
     * Archivator is used for extract DEFAULT_NAME_PACKAGE.
     *
     * @var Cream_Archive
     */
    protected $_archivator = null;

	/**
	 * Create a new instance of this class.
	 * 
	 * @return Cream_Market_Package_Reader
	 */
	public static function instance($file = '')
	{
		return Cream::instance(__CLASS__, $file);
	}
	
    /**
     * Constructor initializes $_file.
     *
     * @param string $file
     * @return void
     */
    public function __init($file = '')
    {
        if ($file) {
            $this->_file = $file;
        } else {
            $this->_file = self::DEFAULT_NAME_PACKAGE;
        }
    }

    /**
     * Retrieve archivator.
     *
     * @return Cream_Archive
     */
    protected function _getArchivator()
    {
        if (is_null($this->_archivator)) {
            $this->_archivator = Cream_Archive::instance();
        }
		
        return $this->_archivator;
    }

    /**
    * Open file directly or from archive and return his content.
    *
    * @return string Content of file $file
    */
    public function load()
    {
        if (!is_file($this->_file) || !is_readable($this->_file)) {
            throw new Exception('Invalid package file specified.');
        }
        if ($this->_getArchivator()->isArchive($this->_file)) {
            @mkdir(self::PATH_TO_TEMPORARY_DIRECTORY, 0777, true);
            $this->_file = $this->_getArchivator()->extract(
                self::DEFAULT_NAME_PACKAGE,
                $this->_file,
                self::PATH_TO_TEMPORARY_DIRECTORY
            );
        }
        $xmlContent = $this->_readFile();
        return $xmlContent;
    }

    /**
    * Read content file.
    *
    * @return string Content of file $file
    */
    protected function _readFile()
    {
        $handle = fopen($this->_file, 'r');
        try {
            $data = $this->_loadResource($handle);
        } catch (Cream_Exceptions_Exception $e) {
            fclose($handle);
            throw $e;
        }
        fclose($handle);
        return $data;
    }

    /**
    * Loads a package from specified resource
    *
    * @param resource $resource only file resources are supported at the moment
    * @return string
    */
    protected function _loadResource(&$resource)
    {
        $data = '';
        if ('stream' === get_resource_type($resource)) {
            while (!feof($resource)) {
                $data .= fread($resource, 10240);
            }
        } else {
            throw new Cream_Exceptions_Exception('Unsupported resource type');
        }
        return $data;
    }
}