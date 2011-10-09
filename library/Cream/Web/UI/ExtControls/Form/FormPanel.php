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
 * Standard form container.
 * 
 * @package 	Cream_Web_UI_ExtControls_Form
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Form_FormPanel extends Cream_Web_UI_ExtControls_Panel
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Form_FormPanel
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
		$this->setControl('Ext.form.FormPanel');
		$this->setAttribute('xtype', 'form');
	}
	
	/**
	 * (optional) The id of the FORM tag (defaults to an auto-generated id).
	 *
	 * @param string $formId
	 */
	public function setFormId($formId)
	{
		$this->setAttribute('formId', $formId);
	}
	
	/**
	 * true to hide field labels by default (sets display:none). Defaults to 
	 * false.
	 * 
	 * @param boolean $hideLabels
	 */
	public function setHideLabels($hideLabels)
	{
		$this->setAttribute('hideLabels', $hideLabels);		
	}
	
	/**
	 * The default padding in pixels for field labels (defaults to 5). labelPad
	 * only applies if labelWidth is also specified, otherwise it will be 
	 * ignored.
	 *
	 * @param integer $labelPad
	 */
	public function setLabelPad($labelPad)
	{
		$this->setAttribute('labelPad', $labelPad);
	}

	/**
	 * Label seperator
	 *
	 * @param string $labelSeparator
	 */
	public function setLabelSeparator($labelSeparator)
	{
		$this->setAttribute('labelSeparator', $labelSeparator);
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
	 * Minimum width of all buttons in pixels (defaults to 75)
	 *
	 * @param number $minButtonWidth
	 */
	public function setMinButtonWidth($minButtonWidth)
	{
		$this->setAttribute('minButtonWidth', $minButtonWidth);
	}

	/**
	 * Valid values are "left," "top" and "right" (defaults to "left").
	 *
	 * @param string $labelAlign
	 */
	public function setLabelAlign($labelAlign)
	{
		$this->setAttribute('labelAlign', $labelAlign);
	}

	/**
	 * If true, the form monitors its valid state client-side and regularly 
	 * fires the clientvalidation event passing that state.
	 * 
	 * When monitoring valid state, the FormPanel enables/disables any of its
	 * configured buttons which have been configured with formBind: true 
	 * depending on whether the form is valid or not. Defaults to false.
	 *
	 * @param boolean $monitorValid
	 */
	public function setMonitorValid($monitorValid)
	{
		$this->setAttribute('monitorValid', $monitorValid);
	}

	/**
	 * The milliseconds to poll valid state, ignored if monitorValid is not 
	 * true (defaults to 200)
	 *
	 * @param number $monitorPoll
	 */
	public function setMonitorPoll($monitorPoll)
	{
		$this->setAttribute('monitorPoll', $monitorPoll);
	}

	/**
	 * Defaults to 'form'. Normally this configuration property should not be 
	 * altered.
	 *
	 * @param string $layout
	 */
	public function setLayout($layout)
	{
		parent::setLayout($layout);
	}
}