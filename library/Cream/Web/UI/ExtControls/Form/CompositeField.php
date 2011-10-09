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
 * Composite field allowing a number of form Fields to be rendered on the same 
 * row. The fields are rendered using an hbox layout internally, so all of the 
 * normal HBox layout config items are available. Example usage:
 * 
 * <code>
 * {
 *		xtype: 'compositefield',
 *		labelWidth: 120,
 *		items: [
 *			{
 *				xtype     : 'textfield',
 *				fieldLabel: 'Title',
 *				width     : 20
 *			},
 *			{
 *				xtype     : 'textfield',
 *				fieldLabel: 'First',
 *				flex      : 1
 *			},
 *			{
 *				xtype     : 'textfield',
 *				fieldLabel: 'Last',
 *				flex      : 1
 *			}
 *		]
 * }
 * </code>
 * 
 * In the example above the composite's fieldLabel will be set to 'Title, 
 * First, Last' as it groups the fieldLabels of each of its children. This can 
 * be overridden by setting a fieldLabel on the compositefield itself:
 * 
 * <code>
 * {
 * 		xtype: 'compositefield',
 * 		fieldLabel: 'Custom label',
 * 		items: [...]
 * }
 * </code>
 * 
 * Any Ext.form.* component can be placed inside a composite field.
 * 
 * @package		Cream_Web_UI_ExtControls
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Form_CompositeField extends Cream_Web_UI_ExtControls_Form_Field
{
	/**
	 * Create a new instance of this class.
	 * 
	 * @return Cream_Web_UI_ExtControls_Form_CompositeField
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
		$this->setControl('Ext.form.CompositeField');
		$this->setXtype('compositefield');
	}
	
	/**
	 * Any default properties to assign to the child fields.
	 * 
	 * @param object $defaults
	 */
	public function setDefaults($defaults)
	{
		$this->setAttribute('defaults', $defaults);
	}
	
	/**
	 * The string to use when joining segments of the built label together 
	 * (defaults to ', ')
	 * 
	 * @param string $labelConnector
	 */
	public function setLabelConnector($labelConnector)
	{
		$this->setAttribute('labelConnector', $labelConnector);
	}
}