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
 * @copyright Copyright (c) 2007-2012 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * The repository manager
 *
 * @package		Cream_Content
 * @author		Danny Verkade
 */
class Cream_Content_Managers_RepositoryManager extends Cream_ApplicationComponent
{
	/**
	 * Holds the repository objects.
	 * 
	 * @var array
	 */
	protected $_repository = array();
	
	/**
	 * Create a new instance of this class.
	 * 
	 * @return Cream_Content_Managers_RepositoryManager
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}

    /**
     * Retrieves a content repository.
     * 
     * @param string $name
     * @return Cream_Content_Repository
     */
    public function getRepository($name)
    {
    	if (!isset($this->_repository[$name])) {

    		$config = $this->_getApplication()->getConfig()->getNode('global/content/repository/'. $name);

    		if ($config) {
    			$repository = Cream_Content_Repository::instance($name, $config);
	    		$this->_repository[$name] = $repository;
    		} else {
    			throw new Cream_Exceptions_Exception('Repository with name "'. $name .'" not found.');
    		}
    	}
    	
    	return $this->_repository[$name];
    }
}