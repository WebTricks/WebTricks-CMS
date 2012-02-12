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
 * @copyright Copyright (c) 2007-2011 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * Directory class
 *
 * @package		Cream_IO
 * @author		WebTricks Core Team <core@webtricksframework.com>
 */
class Cream_IO_Directory
{
	/**
	 * Determine if the gives directory exists
	 *
	 * @return bool
	 */
	public static function exists($dir) 
	{
		return is_dir($dir);
	}
	
	/**
	 * Check to see if a directory is writable. Returns true if it
	 * is, otherwise false.
	 *
	 * @return bool
	 */
	public static function isWritable($dir)
	{
	    if (is_dir($dir) && is_writable($dir)) {
	        if (stripos(PHP_OS, 'win') === 0) {
	            $dir    = ltrim($dir, DIRECTORY_SEPARATOR);
	            $file   = $dir . DIRECTORY_SEPARATOR . uniqid(mt_rand()).'.tmp';
	            $exist  = file_exists($file);
	            $fp     = @fopen($file, 'a');
	            if ($fp === false) {
	                return false;
	            }
	            fclose($fp);
	            if (!$exist) {
	                unlink($file);
	            }
	        }
	        return true;
	    }
	    return false;		
	}
	
	public static function getFiles($path, $pattern = '')
	{
		$files = array();
		
		if ($pattern) {
			$iterator = glob($path . DS . $pattern);
			
			foreach($iterator as $file) {
				if (is_file($file)) {
					$files[] = $file;
				}
			}
		} 
		
		return $files;
	}
	
	public static function getDirectories($path)
	{
		$directories = array();
		$iterator = new DirectoryIterator($path);
		
		foreach($iterator as $dir) {
			if ($dir->isDir() && !$dir->isDot()) {
				$directories[] = $dir->getPathname();
			}
		}
		
		return $directories;
	}	
	
    public static function remove($dirname)
    {
        // Sanity check
        if (!@file_exists($dirname)) {
            return false;
        }
     
        // Simple delete for a file
        if (@is_file($dirname) || @is_link($dirname)) {
            return unlink($dirname);
        }
     
        // Create and iterate stack
        $stack = array($dirname);
        while ($entry = array_pop($stack)) {
            // Watch for symlinks
            if (@is_link($entry)) {
                @unlink($entry);
                continue;
            }
     
            // Attempt to remove the directory
            if (@rmdir($entry)) {
                continue;
            }
     
            // Otherwise add it to the stack
            $stack[] = $entry;
            $dh = opendir($entry);
            while (false !== $child = readdir($dh)) {
                // Ignore pointers
                if ($child === '.' || $child === '..') {
                    continue;
                }     
                // Unlink files and add directories to stack
                $child = $entry . DIRECTORY_SEPARATOR . $child;
                if (is_dir($child) && !is_link($child)) {
                    $stack[] = $child;
                } else {
                    @unlink($child);
                }
            }
            @closedir($dh);
        }     
        return true;
    }  	
}