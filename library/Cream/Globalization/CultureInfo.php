<?php

class Cream_Globalization_CultureInfo extends Cream_ApplicationComponent
{
	protected $_culture; 
	
	protected $_locale;
	
	public static function instance($culture)
	{
		return Cream::instance(__CLASS__, $culture);
	}
	
	public function __init($culture)
	{
		$this->_culture = $culture;	
	}
	
    /**
     * Retrieve locale object
     *
     * @return Zend_Locale
     */
    public function getLocale()
    {
        if (!$this->_locale || $this->_locale->__toString() != $this->_culture) {
            //Zend_Locale_Data::setCache($this->getApplication()->getCache());
            $this->_locale = new Zend_Locale($this->_culture);
        }

        return $this->_locale;
    }	
    
    /**
     * Get options array for locale dropdown in currunt locale
     *
     * @return array
     */
    public function getOptionLocales()
    {
        return $this->_getOptionLocales();
    }

    /**
     * Get translated to original locale options array for locale dropdown
     *
     * @return array
     */
    public function getTranslatedOptionLocales()
    {
        return $this->_getOptionLocales(true);
    }

    /**
     * Get options array for locale dropdown
     *
     * @param   bool $translatedName translation flag
     * @return  array
     */
    protected function _getOptionLocales($translatedName=false)
    {
        $options    = array();
        $locales    = $this->getLocale()->getLocaleList();
        $languages  = $this->getLocale()->getTranslationList('language', $this->_culture);
        $countries  = $this->getCountryTranslationList();

        $allowed    = $this->getAllowLocales();
        foreach ($locales as $code => $active) {
            if (strstr($code, '_')) {
                if (!in_array($code, $allowed)) {
                    continue;
                }
                $data = explode('_', $code);
                if (!isset($languages[$data[0]]) || !isset($countries[$data[1]])) {
                    continue;
                }
                if ($translatedName) {
                    $label = ucwords($this->getLocale()->getTranslation($data[0], 'language', $code))
                        . ' (' . $this->getLocale()->getTranslation($data[1], 'country', $code) . ') / '
                        . $languages[$data[0]] . ' (' . $countries[$data[1]] . ')';
                } else {
                    $label = $languages[$data[0]] . ' (' . $countries[$data[1]] . ')';
                }
                $options[] = array(
                    'value' => $code,
                    'label' => $label
                );
            }
        }
                
        return $this->_sortOptionArray($options);
    }
    
    protected function _sortOptionArray($option)
    {
        $data = array();
        foreach ($option as $item) {
            $data[$item['value']] = $item['label'];
        }
        asort($data);
        $option = array();
        foreach ($data as $key => $label) {
            $option[] = array(
               'value' => $key,
               'label' => $label
            );
        }
        return $option;
    }    
    
    /**
     * Retrieve timezone option list
     *
     * @return array
     */
    public function getOptionTimezones()
    {
        $options= array();
        $zones  = $this->getTranslationList('windowstotimezone');
        ksort($zones);
        foreach ($zones as $code=>$name) {
            $name = trim($name);
            $options[] = array(
               'label' => empty($name) ? $code : $name . ' (' . $code . ')',
               'value' => $code,
            );
        }
        return $this->_sortOptionArray($options);
    }    
    
    /**
     * Retrieve array of allowed locales
     *
     * @return array
     */
    public function getAllowLocales()
    {
        return Cream_Globalization_LocaleConfig::singleton()->getAllowedLocales();
    }

    /**
     * Returns localized informations as array, supported are several
     * types of informations.
     * For detailed information about the types look into the documentation
     *
     * @param  string             $path   (Optional) Type of information to return
     * @param  string             $value  (Optional) Value for detail list
     * @return array Array with the wished information in the given language
     */
    public function getTranslationList($path = null, $value = null)
    {
        return $this->getLocale()->getTranslationList($path, $this->getLocale(), $value);
    }    
    
    /**
     * Returns an array with the name of all countries translated to the given language
     *
     * @return array
     */
    public function getCountryTranslationList()
    {
        return $this->getLocale()->getTranslationList('territory', $this->_culture, 2);
    }    
    
    /**
     * Retrieve currency option list
     *
     * @return unknown
     */
    public function getOptionCurrencies()
    {
        $currencies = $this->getTranslationList('currencytoname');
        $options = array();
        $allowed = $this->getAllowCurrencies();

        foreach ($currencies as $name=>$code) {
            if (!in_array($code, $allowed)) {
                continue;
            }

            $options[] = array(
               'label' => $name,
               'value' => $code,
            );
        }
        return $this->_sortOptionArray($options);
    }

    /**
     * Retrieve array of allowed currencies
     *
     * @return unknown
     */
    public function getAllowCurrencies()
    {
        $data = array();
        if ($this->getApplication()->isInstalled()) {
			$data = Cream_Globalization_LocaleConfig::singleton()->getAllowedCurrencies();        	
            //$data = $this->getApplication()->getConfig()->getNode(self::XML_PATH_ALLOW_CURRENCIES_INSTALLED);
            //return explode(',', $data);
        } else {
            $data = Cream_Globalization_LocaleConfig::singleton()->getAllowedCurrencies();
        }
        return $data;
    }    
}