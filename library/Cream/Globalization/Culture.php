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
 * @copyright Copyright (c) 2007-2010 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * Represents a culture.
 *
 * @package		Cream_Globalization
 * @author		Danny Verkade
 */
class Cream_Globalization_Culture
{
    /**
     * Default locale name
     */
    const DEFAULT_LOCALE    = 'en_US';
    const DEFAULT_TIMEZONE  = 'UTC';
    const DEFAULT_CURRENCY  = 'USD';
	
	/**
	 * String representing the culture
	 * 
	 * @var string
	 */
	protected $culture;
	
	/**
	 * Contains the culture info of the specified culture
	 * 
	 * @var Cream_Globalization_CultureInfo
	 */
	protected $cultureInfo;
	
	/**
	 * Create a new instance of this class
	 *  
	 * @param string $culture
	 * @return Cream_Globalization_Language
	 */
	public static function instance($culture)
	{
		return Cream::instance(__CLASS__, $culture);		
	}
	
	/**
	 * Initialize function
	 * 
	 * @param string $language
	 * @return void
	 */
	public function __init($culture) 
	{
		$this->culture = $culture;
	}

	/**
	 * Returns the display name
	 * 
	 * @return string
	 */
	public function getDisplayName()
	{
		return $this->getCultureInfo()->getEnglishName() .' : '. $this->getCultureInfo->getNativeName() .'('. $this->culture .')';
	}
	
	public function getIcon()
	{
		
	}
	
	/**
	 * Returns the string representing this culture.
	 * 
	 * @return string
	 */
	public function getCulture()
	{
		return $this->culture;
	}
	
	/**
	 * Returns the culture info object 
	 * 
	 * @return Cream_Globalization_CultureInfo
	 */
	public function getCultureInfo()
	{
		if (!$this->cultureInfo) {
			$this->cultureInfo = Cream_Globalization_CultureInfo::instance($this->culture);
		}
		
		return $this->cultureInfo;
	}
	
	/**
	 * Returns the string representing this language.
	 * 
	 * @return string
	 */
	public function __toString()
	{
		return $this->culture;
	}
}