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
 * A display-only text field which is not validated and not submitted.
 * 
 * @package 	Cream_Web_UI_ExtControls_Form
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Form_DisplayField extends Cream_Web_UI_ExtControls_Form_Field  
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Form_DisplayField
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
		$this->setControl('Ext.form.DisplayField');
		$this->setAttribute('xtype', 'displayfield');
	}
	
	/**
	 * The default CSS class for the field (defaults to "x-form-display-field")
	 *
	 * @param string $fieldClass
	 */
	public function setFieldClass($fieldClass)
	{
		$this->setAttribute('fieldClass', $fieldClass);
	}
	
	/**
	 * false to skip HTML-encoding the text when rendering it (defaults to 
	 * false). This might be useful if you want to include tags in the field's
	 * innerHTML rather than rendering them as string literals per the default 
	 * logic.
	 *
	 * @param boolean $htmlEncode
	 */
	public function setHtmlEncode($htmlEncode)
	{
		$this->setAttribute('htmlEncode', $htmlEncode);
	}
}	