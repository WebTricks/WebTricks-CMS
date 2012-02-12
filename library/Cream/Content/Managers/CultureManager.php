<?php

class Cream_Content_Managers_CultureManager extends Cream_ApplicationComponent
{
	/**
	 * Inner cache of the cultures
	 *  
	 * @var array
	 */
	protected $_cultures;
	
	/**
	 * Create a new instance of this class
	 * 
	 * @return Cream_Content_Managers_CultureManager
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Get the cultures of the repository.
	 * 
	 * @param Cream_Content_Repository $repository
	 */
	public function getCultures(Cream_Content_Repository $repository)
	{
		$cultures = $this->_getCulturesFromCache($repository);
		
		if (!$cultures) {
			$cultures = $repository->getDataManager()->getCultures();
			$this->_addCulturesToCache($repository, $cultures);			
		}
		
		return $cultures;
	}
	
	/**
	 * Returns cultures from cache
	 * 
	 * @param Cream_Content_Repository $repository
	 */
	protected function _getCulturesFromCache(Cream_Content_Repository $repository)
	{
		$key = $this->_getCulturesCacheKey($repository);
		
		if ($this->_cultures[$key]) {
			return $this->_cultures[$key];
		} else {
			$cache = $this->_getApplication()->getCache()->load($key);
			
			if ($cache === false) {
				return null;
			} else {
				$this->_cultures[$key] = $cache;
				return $cache;
			}
		}
	}
	
	/**
	 * Add cultures to the cache.
	 * 
	 * @param Cream_Content_Repository $repository
	 * @param Cream_Globalization_CultureCollection $cultures
	 */
	protected function _addCulturesToCache(Cream_Content_Repository $repository, Cream_Globalization_CultureCollection $cultures)
	{
		$key = $this->_getCulturesCacheKey($repository);
		
		$this->_getApplication()->getCache()->save($cultures, $key);
	}
	
	/**
	 * Returns the unique cache key to cache the cultures.
	 * 
	 * @param Cream_Content_Repository $repository
	 */
	protected function _getCulturesCacheKey(Cream_Content_Repository $repository)
	{
		return $repository->getName() .'.cultures';
	}
}