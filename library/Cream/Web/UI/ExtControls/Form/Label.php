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
 * Basic label field
 * 
 * @package		Cream_Web_UI_ExtControls_Form
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Form_Label extends Cream_Web_UI_ExtControls_BoxComponent
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Form_Label
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
		$this->setControl('Ext.form.Label');
		$this->setAttribute('xtype', 'label');
	}	
	
	/**
	 * The id of the input element to which this label will be bound via the 
	 * standard HTML 'for' attribute. If not specified, the attribute will not
	 *  be added to the label.
	 *
	 * @param string $forId
	 */
	public function setForId($forId)
	{
		$this->setAttribute('forId', $forId);
	}

	/**
	 * An HTML fragment that will be used as the label's innerHTML (defaults to
	 * ''). Note that if text is specified it will take precedence and this 
	 * value will be ignored.
	 *
	 * @param string $html
	 */
	public function setHtml($html)
	{
		$this->setAttribute('html', $html);
	}

	/**
	 * The plain text to display within the label (defaults to ''). If you need 
	 * to include HTML tags within the label's innerHTML, use the html config 
	 * instead.
	 *
	 * @param string $text
	 */
	public function setLabelStyle($text)
	{
		$this->setAttribute('text', $text);
	}	
}