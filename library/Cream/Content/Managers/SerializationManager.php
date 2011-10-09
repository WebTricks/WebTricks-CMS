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
 * @copyright Copyright (c) 2007-2010 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * The serialization manager
 *
 * @package		Cream_Content
 * @author		Danny Verkade
 */
class Cream_Content_Managers_SerializationManager extends Cream_ApplicationComponent
{
	const FILE_EXTENSION = '.item';
	
	/**
	 * Create a new instance of this class.
	 * 
	 * @return Cream_Content_Managers_SerializationManager
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	public function dumpTree(Cream_Content_Item $item)
	{
		$this->_dumpTreeItems($item);	
	}
	
	protected function _dumpTreeItems(Cream_Content_Item $item)
	{
		$this->dumpItem($item);
		foreach($item->getChildren() as $child) {
			$this->_dumpTreeItems($child);
		}	
	}
	
	public function dumpItem(Cream_Content_Item $item)
	{
		$path = $this->_getPath($item);
		Cream_Content_Serialization_ItemSerialization::serialize($item);
	}
	
	protected function _getPath(Cream_Content_Item $item)
	{
		$path = $item->getRepository()->getName();
		$path .= DS;
		$path .= $item->getPaths()->getPath();
		
		return $path;
	}
	
	public function loadTree($path)
	{
		if (Cream_IO_Directory::exists($path)) {
			$this->_loadDirectory($path);	
		}
	}
	
	protected function _loadDirectory($path)
	{
		print 'Dir: '. $path; 
		print '<hr>';
		$directories = Cream_IO_Directory::getDirectories($path);
		$files = Cream_IO_Directory::getFiles($path, '*'. self::FILE_EXTENSION);
		
		foreach ($files as $file) {
			$this->_loadItem($file);
		}
		
		foreach ($directories as $directory) {
			$this->_loadDirectory($directory);
		}
	}
	
	protected function _loadItem($file)
	{
		print 'File: '. $file; 
		print '<hr>';		
		
		$data = file_get_contents($file);
		$tokenizer = Cream_Content_Serialization_Tokenizer::instance($data);
		Cream_Content_Serialization_ItemSerialization::unserialize($tokenizer);
	}
}