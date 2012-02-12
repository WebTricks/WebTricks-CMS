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
 * Class to work with gz archives
 *
 * @category    Cream
 * @package     Cream_Archive
 * @author      WebTricks Core Team <core@webtricksframework.com>
 */
class Cream_Archive_Gz extends Cream_Archive_Abstract implements Cream_Archive_Interface
{
    /**
     * Pack file by GZ compressor.
     *
     * @param string $source
     * @param string $destination
     * @return string
     */
    public function pack($source, $destination)
    {
        $data = $this->_readFile($source);
        $gzData = gzencode($data, 9);
        $this->_writeFile($destination, $gzData);
        return $destination;
    }

    /**
     * Unpack file by GZ compressor.
     *
     * @param string $source
     * @param string $destination
     * @return string
     */
    public function unpack($source, $destination)
    {
        $gzPointer = gzopen($source, 'r' );
        if (empty($gzPointer)) {
            throw new Cream_Exceptions_Exception('Can\'t open GZ archive : ' . $source);
        }
        $data = '';
        while (!gzeof($gzPointer)) {
            $data .= gzread($gzPointer, 131072);
        }
        gzclose($gzPointer);
        if (is_dir($destination)) {
            $file = $this->getFilename($source);
            $destination = $destination . $file;
        }
        $this->_writeFile($destination, $data);
        return $destination;
    }
}