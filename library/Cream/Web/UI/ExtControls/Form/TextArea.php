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
 * Multiline text field. Can be used as a direct replacement for traditional 
 * textarea fields, plus adds support for auto-sizing.
 * 
 * @package 	Cream_Web_UI_ExtControls_Form
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Form_TextArea extends Cream_Web_UI_ExtControls_Form_TextField 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Form_TextArea
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
		$this->setControl('Ext.form.TextArea');
		$this->setAttribute('xtype', 'textarea');
	}	

	/**
	 * The minimum height to allow when grow = true (defaults to 60)
	 *
	 * @param number $growMin
	 */
	public function setGrowMin($growMin)
	{
		$this->setAttribute('growMin', $growMin);
	}

	/**
	 * The maximum height to allow when grow = true (defaults to 1000)
	 *
	 * @param number $growMax
	 */
	public function setGrowMax($growMax)
	{
		$this->setAttribute('growMax', $growMax);
	}

	/**
	 * True to prevent scrollbars from appearing regardless of how much text is
	 * in the field. This option is only relevant when grow is true. Equivalent
	 * to setting overflow: hidden, defaults to false.
	 *
	 * @param boolean $preventScrollbars
	 */
	public function setPreventScrollbars($preventScrollbars)
	{
		$this->setAttribute('preventScrollbars', $preventScrollbars);
	}

	/**
	 * A DomHelper element spec, or true for a default element spec (defaults to
	 *
	 * @param string/object $autoCreate
	 */
	public function setAutoCreate($autoCreate)
	{
		$this->setAttribute('autoCreate', $autoCreate);
	}
}