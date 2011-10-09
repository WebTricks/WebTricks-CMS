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
 * Standard container used for grouping items within a form. 
 * 
 * @package 	Cream_Web_UI_ExtControls_Form
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Form_FieldSet extends Cream_Web_UI_ExtControls_Panel 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Form_FieldSet
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
		$this->setControl('Ext.form.FieldSet');
		$this->setAttribute('xtype', 'fieldset');
	}
	
	/**
	 * true to animate the transition when the panel is collapsed, false to 
	 * skip the animation (defaults to false).
	 *
	 * @param boolean $animCollapse
	 */
	public function setAnimCollapse($animCollapse)
	{
		$this->setAttribute('animCollapse', $animCollapse);
	}	

	/**
	 * true to render a checkbox into the fieldset frame just in front of the
	 * legend to expand/collapse the fieldset when the checkbox is toggled. 
	 * (defaults to false). 
	 *
	 * @param mixed $checkboxToggle
	 */
	public function setCheckboxToggle($checkboxToggle)
	{
		$this->setAttribute('checkboxToggle', $checkboxToggle);
	}

	/**
	 * The name to assign to the fieldset's checkbox if #checkboxToggle = true
	 *
	 * @param string $checkboxName
	 */
	public function setCheckboxName($checkboxName)
	{
		$this->setAttribute('checkboxName', $checkboxName);
	}
	
	/**
	 * The width of labels. This property cascades to child containers.
	 *
	 * @param number $labelWidth
	 */
	public function setLabelWidth($labelWidth)
	{
		$this->setAttribute('labelWidth', $labelWidth);
	}

	/**
	 * A css class to apply to the x-form-item of fields. This property cascades to child containers.
	 *
	 * @param string $itemCls
	 */
	public function setItemCls($itemCls)
	{
		$this->setAttribute('itemCls', $itemCls);
	}

	/**
	 * The base CSS class applied to the fieldset (defaults to 'x-fieldset').
	 *
	 * @param string $baseCls
	 */
	public function setBaseCls($baseCls)
	{
		$this->setAttribute('baseCls', $baseCls);
	}

	/**
	 * The Ext.Container#layout to use inside the fieldset (defaults to 'form').
	 *
	 * @param string $layout
	 */
	public function setLayout($layout)
	{
		$this->setAttribute('layout', $layout);
	}
}