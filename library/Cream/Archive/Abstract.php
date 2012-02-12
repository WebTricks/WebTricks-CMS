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
class Cream_Archive_Abstract
{
    /**
     * Write data to file. If file can't be opened,
     *
     * @param string $destination
     * @param string $data
     * @return boolean
     */
    protected function _writeFile($destination, $data)
    {
        if(false === file_put_contents($destination, $data)) {
            throw new Cream_Exceptions_Exception("Can't write to file: " . $destination);
        }
        return true;
    }

    /**
     * Read data from file. If file can't be opened, throw to exception.
     *
     * @param string $source
     * @return string
     */
    protected function _readFile($source)
    {
        $data = '';
        if (is_file($source) && is_readable($source)) {
            $data = @file_get_contents($source);
            if ($data === false) {
                throw new Cream_Exceptions_Exception("Can't get contents from: " . $source);
            }
        }
        return $data;
    }

    /**
     * Get file name from source (URI) without last extension.
     *
     * @param string $source
     * @return string
     */
    public function getFilename($source, $withExtension=false)
    {
        $file = str_replace(dirname($source) . DS, '', $source);
        if (!$withExtension) {
            $file = substr($file, 0, strrpos($file, '.'));
        }
        return $file;
    }

}