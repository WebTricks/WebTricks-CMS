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
 * Applies drag handles to an element to make it resizable. The drag handles 
 * are inserted into the element and positioned absolute. Some elements, such 
 * as a textarea or image, don't support this. To overcome that, you can wrap 
 * the textarea in a div and set 'resizeChild' to true (or to the id of the 
 * element), or set wrap:true in your config and the element will be wrapped 
 * for you automatically.
 * 
 * @package 	Cream_Web_UI_ExtControls
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Resizable extends Cream_Web_UI_ExtControl 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Resizable
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
		$this->setControl('Ext.Resizable');
	}
		
	/**
	 * True to resize the first child, or id/element to resize (defaults to false)
	 *
	 * @param boolean/string/element $resizeChild
	 */
	public function setResizeChild($resizeChild) 
	{
		$this->setAttribute('resizeChild', $resizeChild);
	}

	/**
	 * String "auto" or an array [width, height] with values to be <b>added</b> to the
	 *
	 * @param array/string $adjustments
	 */
	public function setAdjustments($adjustments) 
	{
		$this->setAttribute('adjustments', $adjustments);
	}

	/**
	 * The minimum width for the element (defaults to 5)
	 *
	 * @param number $minWidth
	 */
	public function setMinWidth($minWidth) 
	{
		$this->setAttribute('minWidth', $minWidth);
	}

	/**
	 * The minimum height for the element (defaults to 5)
	 *
	 * @param number $minHeight
	 */
	public function setMinHeight($minHeight) 
	{
		$this->setAttribute('minHeight', $minHeight);
	}

	/**
	 * The maximum width for the element (defaults to 10000)
	 *
	 * @param number $maxWidth
	 */
	public function setMaxWidth($maxWidth) 
	{
		$this->setAttribute('maxWidth', $maxWidth);
	}

	/**
	 * The maximum height for the element (defaults to 10000)
	 *
	 * @param number $maxHeight
	 */
	public function setMaxHeight($maxHeight) 
	{
		$this->setAttribute('maxHeight', $maxHeight);
	}

	/**
	 * False to disable resizing (defaults to true)
	 *
	 * @param boolean $enabled
	 */
	public function setEnabled($enabled) 
	{
		$this->setAttribute('enabled', $enabled);
	}

	/**
	 * True to wrap an element with a div if needed (required for textareas and images, defaults to false)
	 *
	 * @param boolean $wrap
	 */
	public function setWrap($wrap) 
	{
		$this->setAttribute('wrap', $wrap);
	}

	/**
	 * The width of the element in pixels (defaults to null)
	 *
	 * @param number $width
	 */
	public function setWidth($width) 
	{
		$this->setAttribute('width', $width);
	}

	/**
	 * The height of the element in pixels (defaults to null)
	 *
	 * @param number $height
	 */
	public function setHeight($height) 
	{
		$this->setAttribute('height', $height);
	}

	/**
	 * True to animate the resize (not compatible with dynamic sizing, defaults to false)
	 *
	 * @param boolean $animate
	 */
	public function setAnimate($animate) 
	{
		$this->setAttribute('animate', $animate);
	}

	/**
	 * Animation duration if animate = true (defaults to .35)
	 *
	 * @param number $duration
	 */
	public function setDuration($duration) 
	{
		$this->setAttribute('duration', $duration);
	}

	/**
	 * True to resize the element while dragging instead of using a proxy (defaults to false)
	 *
	 * @param boolean $dynamic
	 */
	public function setDynamic($dynamic) 
	{
		$this->setAttribute('dynamic', $dynamic);
	}

	/**
	 * String consisting of the resize handles to display (defaults to undefined)
	 *
	 * @param string $handles
	 */
	public function setHandles($handles) 
	{
		$this->setAttribute('handles', $handles);
	}
	
	/**
	 * A css class to add to each handle. Defaults to ''.
	 *
	 * @param string $handleCls
	 */
	public function setHandleCls($handleCls) 
	{
		$this->setAttribute('handleCls', $handleCls);
	}	

	/**
	 * <b>Deprecated</b>.  The old style of adding multi-direction resize handles, deprecated
	 *
	 * @param boolean $multiDirectional
	 */
	public function setMultiDirectional($multiDirectional) 
	{
		$this->setAttribute('multiDirectional', $multiDirectional);
	}

	/**
	 * True to disable mouse tracking. This is only applied at config time. (defaults to false)
	 *
	 * @param boolean $disableTrackOver
	 */
	public function setDisableTrackOver($disableTrackOver) 
	{
		$this->setAttribute('disableTrackOver', $disableTrackOver);
	}

	/**
	 * Animation easing if animate = true (defaults to 'easingOutStrong')
	 *
	 * @param string $easing
	 */
	public function setEasing($easing) 
	{
		$this->setAttribute('easing', $easing);
	}

	/**
	 * The increment to snap the width resize in pixels (dynamic must be true, defaults to 0)
	 *
	 * @param number $widthIncrement
	 */
	public function setWidthIncrement($widthIncrement) 
	{
		$this->setAttribute('widthIncrement', $widthIncrement);
	}

	/**
	 * The increment to snap the height resize in pixels (dynamic must be true, defaults to 0)
	 *
	 * @param number $heightIncrement
	 */
	public function setHeightIncrement($heightIncrement) 
	{
		$this->setAttribute('heightIncrement', $heightIncrement);
	}

	/**
	 * True to ensure that the resize handles are always visible, false to display them only when the
	 *
	 * @param boolean $pinned
	 */
	public function setPinned($pinned) 
	{
		$this->setAttribute('pinned', $pinned);
	}

	/**
	 * True to preserve the original ratio between height and width during resize (defaults to false)
	 *
	 * @param boolean $preserveRatio
	 */
	public function setPreserveRatio($preserveRatio)
	{
		$this->setAttribute('preserveRatio', $preserveRatio);
	}

	/**
	 * True for transparent handles. This is only applied at config time. (defaults to false)
	 *
	 * @param boolean $transparent
	 */
	public function setTransparent($transparent) 
	{
		$this->setAttribute('transparent', $transparent);
	}

	/**
	 * The minimum allowed page X for the element (only used for west resizing, defaults to 0)
	 *
	 * @param number $minX
	 */
	public function setMinX($minX) 
	{
		$this->setAttribute('minX', $minX);
	}

	/**
	 * The minimum allowed page Y for the element (only used for north resizing, defaults to 0)
	 *
	 * @param number $minY
	 */
	public function setMinY($minY) 
	{
		$this->setAttribute('minY', $minY);
	}

	/**
	 * Convenience to initialize drag drop (defaults to false)
	 *
	 * @param boolean $draggable
	 */
	public function setDraggable($draggable) 
	{
		$this->setAttribute('draggable', $draggable);
	}

	/**
	 * Constrain the resize to a particular element
	 *
	 * @param mixed $constrainTo
	 */
	public function setConstrainTo($constrainTo) 
	{
		$this->setAttribute('constrainTo', $constrainTo);
	}

	/**
	 * Constrain the resize to a particular region
	 *
	 * @param ext.lib.region $resizeRegion
	 */
	public function setResizeRegion($resizeRegion) 
	{
		$this->setAttribute('resizeRegion', $resizeRegion);
	}
}