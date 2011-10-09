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
 * Abstract class for IO objects.
 *
 * @package		Cream_IO
 * @author		WebTricks Core Team <core@webtricksframework.com>
 */
abstract class Cream_IO_Abstract implements Cream_IO_Interface
{
    /**
     * If this variable is set to true, our library will be able to automaticaly
     * create non-existant directories
     *
     * @var bool
     */
    protected $_allowCreateFolders = false;

    /**
     * Allow automaticaly create non-existant directories
     *
     * @param bool $flag
     */
    public function setAllowCreateFolders($flag)
    {
        $this->_allowCreateFolders = (bool)$flag;
    }

    /**
     * Open a connection
     *
     * @param array $config
     * @return bool
     */
    public function open(array $args = array())
    {
        return false;
    }

    public function dirsep()
    {
        return '/';
    }

    public function getCleanPath($path)
    {
        if (empty($path)) {
            return './';
        }

        $path = trim(preg_replace("/\\\\/", "/", (string)$path));

        if (!preg_match("/(\.\w{1,4})$/", $path) && !preg_match("/\?[^\\/]+$/", $path) && !preg_match("/\\/$/", $path)) {
            $path .= '/';
        }

        $matches = array();
        $pattern = "/^(\\/|\w:\\/|https?:\\/\\/[^\\/]+\\/)?(.*)$/i";
        preg_match_all($pattern, $path, $matches, PREG_SET_ORDER);

        $pathTokR = $matches[0][1];
        $pathTokP = $matches[0][2];

        $pathTokP = preg_replace(array("/^\\/+/", "/\\/+/"), array("", "/"), $pathTokP);

        $pathParts = explode("/", $pathTokP);
        $realPathParts = array();

        for ($i = 0, $realPathParts = array(); $i < count($pathParts); $i++) {
            if ($pathParts[$i] == '.') {
                continue;
            }
            elseif ($pathParts[$i] == '..') {
                if ((isset($realPathParts[0])  &&  $realPathParts[0] != '..') || ($pathTokR != "")) {
                    array_pop($realPathParts);
                    continue;
                }
            }

            array_push($realPathParts, $pathParts[$i]);
        }

        return $pathTokR . implode('/', $realPathParts);
    }

    public function allowedPath($haystackPath, $needlePath)
    {
        return strpos($this->getCleanPath($haystackPath), $this->getCleanPath($needlePath)) === 0;
    }
}