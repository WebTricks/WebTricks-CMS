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
 * Provides a convenient wrapper for TextFields that adds a clickable trigger 
 * button (looks like a combobox by default). The trigger has no default 
 * action, so you must assign a function to implement the trigger click handler
 * by overriding onTriggerClick. You can create a TriggerField directly, as it 
 * renders exactly like a combobox for which you can provide a custom 
 * implementation. 
 * 
 * @package 	Cream_Web_UI_ExtControls_Form
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Form_TinyMCE extends Cream_Web_UI_ExtControls_Form_Field 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Form_TinyMCE
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}

	/**
	 * Initialize function
	 *
	 */
	public function __init()
	{
		//$this->setControl('Ext.ux.TinyMCE');
		$this->setAttribute('xtype', 'tinymce');
	}

	/**
	 * Set the settings for this tiny MCE object
	 *
	 * @param object $settings
	 */
	public function setTinyMceSettings($settings)
	{
		$this->setAttribute('tinymceSettings', $settings);		
	}
}