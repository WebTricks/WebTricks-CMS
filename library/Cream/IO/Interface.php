<?php
/**
 * WebTricks
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
 * @copyright Copyright (c) 2007-2011 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * Input/output client interface
 *
 * @package		Cream_IO
 * @author		WebTricks Core Team <core@webtricksframework.com>
 */
interface Cream_IO_Interface
{
    /**
     * Open a connection
     *
     */
    public function open(array $args=array());

    /**
     * Close a connection
     *
     */
    public function close();

    /**
     * Create a directory
     *
     */
    public function mkdir($dir, $mode=0777, $recursive=true);

    /**
     * Delete a directory
     *
     */
    public function rmdir($dir, $recursive=false);

    /**
     * Get current working directory
     *
     */
    public function pwd();

    /**
     * Change current working directory
     *
     */
    public function cd($dir);

    /**
     * Read a file
     *
     */
    public function read($filename, $dest=null);

    /**
     * Write a file
     *
     */
    public function write($filename, $src, $mode=null);

    /**
     * Delete a file
     *
     */
    public function rm($filename);

    /**
     * Rename or move a directory or a file
     *
     */
    public function mv($src, $dest);

    /**
     * Chamge mode of a directory or a file
     *
     */
    public function chmod($filename, $mode);

    /**
     * Get list of cwd subdirectories and files
     *
     */
    public function ls($grep=null);

    /**
     * Retrieve directory separator in context of io resource
     *
     */
    public function dirsep();
}