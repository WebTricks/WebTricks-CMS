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
 * A specialized panel intended for use as an application window. Windows are 
 * floated and draggable by default, and also provide specific behavior like 
 * the ability to maximize and restore (with an event for minimizing, since the 
 * minimize behavior is application-specific). Windows can also be linked to a
 * Ext.WindowGroup or managed by the Ext.WindowManager to provide grouping, 
 * activation, to front/back and other application-specific behavior.
 *
 * @package Cream_Web_UI_ExtControls
 * @author Danny Verkade
 */
class Cream_Web_UI_ExtControls_Window extends Cream_Web_UI_ExtControls_Panel 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Window
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
		$this->setControl('Ext.Window');
	}

	/**
	 * True to make the window modal and mask everything behind it when
	 * displayed, false to display it without restricting access to other UI 
	 * elements (defaults to false).
	 *
	 * @param boolean $modal
	 */
	public function setModal($modal)
	{
		$this->setAttribute('modal', $modal);
	}

	/**
	 * Id or element from which the window should animate while opening 
	 * (defaults to null with no animation).
	 *
	 * @param string/element $animateTarget
	 */
	public function setAnimateTarget($animateTarget)
	{
		$this->setAttribute('animateTarget', $animateTarget);
	}

	/**
	 * A valid Ext.Resizable handles config string (defaults to 'all'). Only 
	 * applies when resizable = true.
	 *
	 * @param string $resizeHandles
	 */
	public function setResizeHandles($resizeHandles)
	{
		$this->setAttribute('resizeHandles', $resizeHandles);
	}

	/**
	 * A reference to the WindowGroup that should manage this window 
	 * (defaults to Ext.WindowMgr).
	 *
	 * @param ext.windowgroup $manager
	 */
	public function setManager($manager)
	{
		$this->setAttribute('manager', $manager);
	}

	/**
	 * The id / index of a button or a button instance to focus when this
	 * window received the focus.
	 *
	 * @param string/number/button $defaultButton
	 */
	public function setDefaultButton($defaultButton)
	{
		$this->setAttribute('defaultButton', $defaultButton);
	}

	/**
	 * Allows override of the built-in processing for the escape key. Default 
	 * action is to close the Window (performing whatever action is specified 
	 * in closeAction. To prevent the Window closing when the escape key is 
	 * pressed, specify this as Ext.emptyFn (See Ext.emptyFn).
	 *
	 * @param function $onEsc
	 */
	public function setOnEsc($onEsc)
	{
		$this->setAttribute('onEsc', $onEsc);
	}

	/**
	 * The base CSS class to apply to this panel's element (defaults to 
	 * 'x-window').
	 *
	 * @param string $baseCls
	 */
	public function setBaseCls($baseCls)
	{
		$this->setAttribute('baseCls', $baseCls);
	}

	/**
	 * True to allow user resizing at each edge and corner of the window, false
	 * to disable resizing (defaults to true).
	 *
	 * @param boolean $resizable
	 */
	public function setResizable($resizable)
	{
		$this->setAttribute('resizable', $resizable);
	}

	/**
	 * True to allow the window to be dragged by the header bar, false to 
	 * disable dragging (defaults to true). Note that by default the window 
	 * will be centered in the viewport, so if dragging is disabled the window
	 * may need to be positioned programmatically after render (e.g., 
	 * myWindow.setPosition(100, 100);).
	 *
	 * @param boolean $draggable
	 */
	public function setDraggable($draggable)
	{
		$this->setAttribute('draggable', $draggable);
	}

	/**
	 * True to display the 'close' tool button and allow the user to close the
	 * window, false to hide the button and disallow closing the window 
	 * (defaults to true).
	 *
	 * @param boolean $closable
	 */
	public function setClosable($closable)
	{
		$this->setAttribute('closable', $closable);
	}

	/**
	 * True to constrain the window to the viewport, false to allow it to fall
	 * outside of the viewport (defaults to false). Optionally the header only 
	 * can be constrained using constrainHeader.
	 *
	 * @param boolean $constrain
	 */
	public function setConstrain($constrain)
	{
		$this->setAttribute('constrain', $constrain);
	}

	/**
	 * True to constrain the window header to the viewport, allowing the window 
	 * body to fall outside of the viewport, false to allow the header to fall 
	 * outside the viewport (defaults to false). Optionally the window can be 
	 * constrained using constrain.
	 *
	 * @param boolean $constrainHeader
	 */
	public function setConstrainHeader($constrainHeader)
	{
		$this->setAttribute('constrainHeader', $constrainHeader);
	}

	/**
	 * True to render the window body with a transparent background so that it 
	 * will blend into the framing elements, false to add a lighter background 
	 * color to visually highlight the body element and separate it more 
	 * distinctly from the surrounding frame (defaults to false).
	 *
	 * @param boolean $plain
	 */
	public function setPlain($plain)
	{
		$this->setAttribute('plain', $plain);
	}

	/**
	 * True to display the 'minimize' tool button and allow the user to 
	 * minimize the window, false to hide the button and disallow minimizing 
	 * the window (defaults to false). Note that this button provides no 
	 * implementation -- the behavior of minimizing a window is implementation
	 * specific, so the minimize event  must be handled and a custom minimize 
	 * behavior implemented for this option to be useful.
	 *
	 * @param boolean $minimizable
	 */
	public function setMinimizable($minimizable)
	{
		$this->setAttribute('minimizable', $minimizable);
	}

	/**
	 * True to display the 'maximize' tool button and allow the user to 
	 * maximize the window, false to hide the button and disallow maximizing 
	 * the window (defaults to false). Note that when a window is maximized, 
	 * the tool button will automatically change to a 'restore' button with the
	 * appropriate behavior already built-in that will restore the window to 
	 * its previous size.
	 *
	 * @param boolean $maximizable
	 */
	public function setMaximizable($maximizable)
	{
		$this->setAttribute('maximizable', $maximizable);
	}
	
	/**
	 * True to initially display the window in a maximized state. (Defaults to 
	 * false).
	 *
	 * @param boolean $maximized
	 */
	public function setMaximized($maximized)
	{
		$this->setAttribute('maximized', $maximized);
	}	

	/**
	 * The minimum height in pixels allowed for this window (defaults to 100). 
	 * Only applies when resizable = true.
	 *
	 * @param number $minHeight
	 */
	public function setMinHeight($minHeight)
	{
		$this->setAttribute('minHeight', $minHeight);
	}

	/**
	 * The minimum width in pixels allowed for this window (defaults to 200). 
	 * Only applies when resizable = true.
	 *
	 * @param number $minWidth
	 */
	public function setMinWidth($minWidth)
	{
		$this->setAttribute('minWidth', $minWidth);
	}

	/**
	 * True to always expand the window when it is displayed, false to keep it 
	 * in its current state (which may be collapsed) when displayed (defaults 
	 * to true).
	 *
	 * @param boolean $expandOnShow
	 */
	public function setExpandOnShow($expandOnShow)
	{
		$this->setAttribute('expandOnShow', $expandOnShow);
	}
	
	/**
	 * Render this component hidden (default is true). If true, the hide method
	 * will be called internally.
	 *
	 * @param boolean $hidden
	 */
	public function setHidden($hidden)
	{
		$this->setAttribute('hidden', $hidden);
	}

	/**
	 * True to hide the window until show() is explicitly called (defaults to 
	 * true).
	 *
	 * @param boolean $initHidden
	 */
	public function setInitHidden($initHidden)
	{
		$this->setAttribute('initHidden', $initHidden);
	}	

	/**
	 * The action to take when the close button is clicked. The default action 
	 * is 'close' which will actually remove the window from the DOM and 
	 * destroy it. The other valid option is 'hide' which will simply hide the 
	 * window by setting visibility to hidden and applying negative offsets, 
	 * keeping the window available to be redisplayed via the show method.
	 *
	 * @param string $closeAction
	 */
	public function setCloseAction($closeAction)
	{
		$this->setAttribute('closeAction', $closeAction);
	}
	
	/**
	 * The X position of the left edge of the window on initial showing. 
	 * Defaults to centering the Window within the width of the Window's 
	 * container Ext.Element Element) (The Element that the Window is rendered 
	 * to).
	 *
	 * @param integer $x
	 */
	public function setX($x)
	{
		$this->setAttribute('x', $x);
	}

	/**
	 * The Y position of the top edge of the window on initial showing. 
	 * Defaults to centering the Window within the height of the Window's 
	 * container Ext.Element Element) (The Element that the Window is rendered 
	 * to).
	 *
	 * @param integer $y
	 */
	public function setY($y)
	{
		$this->setAttribute('y', $y);
	}	
}