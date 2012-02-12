<?php

class Cream_Globalization_Translate extends Cream_ApplicationComponent
{
	const CACHE_TAG = 'DICTIONARY';
	
	protected static $_dictionary = array();
	
	public static function text($key)
	{
		//$culture = self::getApplication()->getGlobalization()->getCurrentCulture();
		//return self::textByCulture($key, $culture);
		return $key;
	}
	
	public static function textByCulture($key, Cream_Globalization_Culture $culture)
	{
		if (!isset(self::$_dictionary[$culture->getCulture()])) {
			self::load($culture);
		}

		$dictionary = self::$_dictionary[$culture->getCulture()];
		
		if (isset($dictionary[$key])) {
			return $dictionary[$key];			
		} else {
			throw new Cream_Globalization_Exception_TranslationException("Translation not found for key '". $key ."'");
		}
	}
	
	protected static function load(Cream_Globalization_Culture $culture)
	{
		$cacheKey = 'dictionary.'. $culture->getCulture();
		$dictionary = Cream::getApplication()->getCache()->load($cacheKey);
		
		if ($dictionary) {
			self::$_dictionary[$culture->getCulture()] = $dictionary;
		} else {
			$dictionary = Cream_Globalization_Dictionary::instance();
		
			$repository = Cream_Content_Managers_RepositoryProvider::getRepository('core');
			$itemId = $repository->getDataManager()->resolvePath('webtricks/system/dictionary');
			$item = $repository->getItem($itemId);
			
			self::loadItem($item, $dictionary);
			Cream::getApplication()->getCache()->save($dictionary, $cacheKey, array(self::CACHE_TAG));
			self::$_dictionary[$culture->getCulture()] = $dictionary;			
		}
	}
	
	protected static function loadItem(Cream_Content_Item $item, Cream_Globalization_Dictionary &$dictionary)
	{
		$template = $item->getTemplate();
		
		if ($template) {
			
			$key = $item->key;
			$translation = $item->translation;
			
			$dictionary->_setData($key, $translation);
			
			foreach($item->getChildren() as $child) {
				self::loadItem($child, $dictionary);	
			}
		}
	}
}