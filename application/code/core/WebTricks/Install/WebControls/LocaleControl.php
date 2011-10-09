<?php
/**
 * WebTricks - PHP Framework
 *
 * LICENSE
 *
 * For the full copyright and license information, please view the 
 * following URL: http://www.webtricksframework.com/license 
 *
 * @copyright Copyright (c) 2007-2011 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * Install locale control
 * 
 * @package		WebTricks_Install
 * @author		Danny Verkade
 */
class WebTricks_Install_WebControls_LocaleControl extends Cream_Web_UI_WebControls_TemplateControl
{
	/**
	 * Initialize function.
	 * 
	 * @see library/Cream/Web/UI/WebControls/Cream_Web_UI_WebControls_TemplateControl::__init()
	 */
    public function __init($data = null)
    {
        parent::__init($data);
        $this->setTemplate('install/locale.phtml');
    }

    /**
     * Retrieve locale object
     *
     * @return Cream_Globalization_Culture
     */
    public function getCulture()
    {
        $culture = $this->_getData('culture');
        if (is_null($culture)) {
            $culture = $this->getApplication()->getContext()->getCulture();
            $this->_setData('culture', $culture);
        }
        return $culture;
    }

    /**
     * Retrieve locale change url
     *
     * @return string
     */
    public function getChangeUrl()
    {
        return $this->getUrl('*/*/localeChange');
    }

    /**
     * Retrieve locale dropdown HTML
     *
     * @return string
     */
    public function getLocaleSelect()
    {
    	$select = $this->getLayout()->createBlock('htmlcontrol/select');
    	$select->setName('config[locale]');
        $select->setId('locale');
		$select->setTitle('Locale');
		$select->setClass('required-entry');
		$select->setValue($this->getCulture()->__toString());
		$select->setOptions($this->getCulture()->getCultureInfo()->getOptionLocales());

        return $select->getHtml();
    }

    /**
     * Retrieve timezone dropdown HTML
     *
     * @return string
     */
    public function getTimezoneSelect()
    {
    	$select = $this->getLayout()->createBlock('htmlcontrol/select');
        $select->setName('config[timezone]');
		$select->setId('timezone');
		$select->setTitle('Time Zone');
		$select->setClass('required-entry');
		$select->setValue($this->getTimezone());
		$select->setOptions($this->getApplication()->getContext()->getCulture()->getCultureInfo()->getOptionTimezones());
		return $select->getHtml();
    }

    /**
     * Retrieve timezone
     *
     * @return string
     */
    public function getTimezone()
    {
        $timezone = WebTricks_Install_Session::singleton()->getTimezone()
            ? WebTricks_Install_Session::singleton()->getTimezone()
            : $this->getApplication()->getContext()->getCulture()->getCultureInfo()->getTimezone();
        if ($timezone == Cream_Globalization_Culture::DEFAULT_TIMEZONE) {
            $timezone = 'America/Los_Angeles';
        }
        
        return $timezone;
    }

    /**
     * Retrieve currency dropdown html
     *
     * @return string
     */
    public function getCurrencySelect()
    {
        $select = $this->getLayout()->createBlock('htmlcontrol/select');
        $select->setName('config[currency]');
		$select->setId('currency');
		$select->setTitle('Default Currency');
		$select->setClass('required-entry');
		$select->setValue($this->getCurrency());
		$select->setOptions($this->getApplication()->getContext()->getCulture()->getCultureInfo()->getOptionCurrencies());

		return $select->getHtml();
    }

    /**
     * Retrieve currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return WebTricks_Install_Session::singleton()->getCurrency()
            ? WebTricks_Install_Session::singleton()->getCurrency()
            : $this->getApplication()->getContext()->getCulture()->getCultureInfo()->getCurrency();
            
    }

    public function getFormData()
    {
        $data = $this->_getData('form_data');
        if (is_null($data)) {
            $data = new Cream_Object();
            $this->_setData('form_data', $data);
        }
        return $data;
    }
}