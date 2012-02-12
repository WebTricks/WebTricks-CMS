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
 * Class to work with Market Hotfix
 *
 * @category    Cream
 * @package     Cream_Market
 * @author      WebTricks Core Team <core@webtricksframework.com>
 */
class Cream_Market_Package_Hotfix extends Cream_Market_Package
{
	/**
	 * Create a new instance of this class.
	 * 
	 * @return Cream_Market_Package_Hotfix
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
    /**
     * Initializes an empty package object
     *
     * @param null|string $definition optional package definition xml
     * @return void
     */
    public function __init($definition=null)
    {
        if (!is_null($definition)) {
            $this->_packageXml = simplexml_load_string($definition);
        } else {
            $packageXmlStub = <<<END
<?xml version="1.0"?>
<package>
    <name />
    <version />
    <stability />
    <license />
    <channel />
    <extends />
    <summary />
    <description />
    <notes />
    <authors />
    <date />
    <time />
    <replace />
    <compatible />
    <dependencies />
</package>
END;
            $this->_packageXml = simplexml_load_string($packageXmlStub);
        }
    }

    /**
    * Add content to node <replace/>
    *
    * @return void
    */
    public function addReplace($path, $targetName)
    {
        $found = false;
        $parent = $this->_getNode('target', $this->_packageXml->replace, $targetName);
        $path = str_replace('\\', '/', $path);
        $directories = explode('/', dirname($path));
        foreach ($directories as $directory) {
            $parent = $this->_getNode('dir', $parent, $directory);
        }
        $fileName = basename($path);
        if ($fileName!='') {
            $fileNode = $parent->addChild('file');
            $fileNode->addAttribute('name', $fileName);
        }
    }

    /**
     * Add directory recursively (with subdirectory and file).
     * Exclude and Include can be add using Regular Expression.
     *
     * @param string $targetName Target name
     * @param string $targetDir Path for target name
     * @param string $path Path to directory
     * @param string $exclude Exclude
     * @param string $include Include
     * @return void
     */
    public function addReplaceDir($targetName, $targetDir, $path, $exclude=null, $include=null)
    {
        $targetDirLen = strlen($targetDir);
        //get all subdirectories and files.
        $entries = @glob($targetDir.$path.DS."*");
        if (!empty($entries)) {
            foreach ($entries as $entry) {
                $filePath = substr($entry, $targetDirLen);
                if (!empty($include) && !preg_match($include, $filePath)) {
                    continue;
                }
                if (!empty($ignore) && preg_match($exclude, $filePath)) {
                    continue;
                }
                if (is_dir($entry)) {
                    $baseName = basename($entry);
                    if ('.'===$baseName || '..'===$baseName) {
                        continue;
                    }
                    //for subdirectory call method recursively
                    $this->addReplaceDir($targetName, $targetDir, $filePath, $exclude, $include);
                } elseif (is_file($entry)) {
                    $this->addReplace($filePath, $targetName);
                }
            }
        }
    }
}