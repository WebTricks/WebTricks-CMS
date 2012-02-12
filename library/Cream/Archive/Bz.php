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
 * Class to work with bzip2 archives
 *
 * @category    Cream
 * @package     Cream_Archive
 * @author      WebTricks Core Team <core@webtricksframework.com>
 */
class Cream_Archive_Bz extends Cream_Archive_Abstract implements Cream_Archive_Interface
{

    /**
    * Pack file by BZIP2 compressor.
    *
    * @param string $source
    * @param string $destination
    * @return string
    */
    public function pack($source, $destination)
    {
        $data = $this->_readFile($source);
        $bzData = bzcompress($data, 9);
        $this->_writeFile($destination, $bzData);
        return $destination;
    }

    /**
    * Unpack file by BZIP2 compressor.
    *
    * @param string $source
    * @param string $destination
    * @return string
    */
    public function unpack($source, $destination)
    {
        $data = '';
        $bzPointer = bzopen($source, 'r' );
        if (empty($bzPointer)) {
            throw new Exception('Can\'t open BZ archive : ' . $source);
        }
        while (!feof($bzPointer)) {
            $data .= bzread($bzPointer, 131072);
        }
        bzclose($bzPointer);
        if (is_dir($destination)) {
            $file = $this->getFilename($source);
            $destination = $destination . $file;
        }
        echo $destination;
        $this->_writeFile($destination, $data);
        return $destination;
    }
}