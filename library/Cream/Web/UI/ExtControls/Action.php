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
 * An Action is a piece of reusable functionality that can be abstracted out of
 * any particular component so that it can be usefully shared among multiple
 * components. Actions let you share handlers, configuration options and UI
 * updates across any components that support the Action interface (primarily
 * Ext.Toolbar, Ext.Button and Ext.menu.Menu components).
 *
 * Aside from supporting the config object interface, any component that needs
 * to use Actions must also support the following method list, as these will be
 * called as needed by the Action class: setText(string), setIconCls(string),
 * setDisabled(boolean), setVisible(boolean) and setHandler(function).
 *
 * Example usage:
 *
 * <code>
 * // Define the shared action.  Each component below will have the same
 * // display text and icon, and will display the same message on click.
 * var action = new Ext.Action({
 *     text: 'Do something',
 *     handler: function(){
 *         Ext.Msg.alert('Click', 'You did something.');
 *     },
 *     iconCls: 'do-something',
 *     itemId: 'myAction'
 * });
 *
 * var panel = new Ext.Panel({
 *     title: 'Actions',
 *     width: 500,
 *     height: 300,
 *     tbar: [
 *         // Add the action directly to a toolbar as a menu button
 *         action,
 *         {
 *             text: 'Action Menu',
 *             // Add the action to a menu as a text item
 *             menu: [action]
 *         }
 *     ],
 *     items: [
 *         // Add the action to the panel body as a standard button
 *         new Ext.Button(action)
 *     ],
 *     renderTo: Ext.getBody()
 * });
 *
 * // Change the text for all components using the action
 * action.setText('Something else');
 *
 * // Reference an action through a container using the itemId
 * var btn = panel.getComponent('myAction');
 * var aRef = btn.baseAction;
 * aRef.setText('New text');
 * </code>
 *
 * @package 	Cream_Web_UI_ExtControls
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Action extends Cream_Web_UI_ExtControl
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Action
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}	
		
	/**
	 * Initialize function, set the Ext JS control
	 *
	 */
	public function __init()
	{
		$this->setControl('Ext.Action');
	}

	/**
	 * The text to set for all components using this action (defaults to '').
	 *
	 * @param string $text
	 */
	public function setText($text)
	{
		$this->setAttribute('text', $text);
	}

	/**
	 * The icon CSS class for all components using this action (defaults to '').
	 *
	 * @param string $iconCls
	 */
	public function setIconCls($iconCls)
	{
		$this->setAttribute('iconCls', $iconCls);
	}
	
	/**
	 * See Ext.Component.itemId.
	 *
	 * @param string $itemId
	 */
	public function setItemId($itemId)
	{
		$this->setAttribute('itemId', $itemId);
	}	

	/**
	 * True to disable all components using this action, false to enable them
	 * (defaults to false).
	 *
	 * @param boolean $disabled
	 */
	public function setDisabled($disabled)
	{
		$this->setAttribute('disabled', $disabled);
	}

	/**
	 * True to hide all components using this action, false to show them
	 * (defaults to false).
	 *
	 * @param boolean $hidden
	 */
	public function setHidden($hidden)
	{
		$this->setAttribute('hidden', $hidden);
	}

	/**
	 * The function that will be invoked by each component tied to this action
	 *
	 * @param function $handler
	 */
	public function setHandler($handler)
	{
		$this->setAttribute('handler', $handler);
	}

	/**
	 * The scope in which the #handler function will execute.
	 *
	 * @param object $scope
	 */
	public function setScope($scope)
	{
		$this->setAttribute('scope', $scope);
	}
}