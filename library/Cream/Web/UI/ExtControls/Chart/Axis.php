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
 * Defines a CartesianChart's vertical or horizontal axis.
 * 
 * @package 	Cream_Web_UI_ExtControls_Chart
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Chart_Axis extends Cream_Web_UI_ExtControl
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Chart_Axis
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
		$this->setControl('Ext.chart.Axis');
	}
		
	/**
	 * If true, labels that overlap previously drawn labels on the
	 * axis will be hidden.
	 *
	 * @param boolean $hideOverlappingLabels
	 */
	public function setHideOverlappingLabels($hideOverlappingLabels)
	{
		$this->setAttribute('hideOverlappingLabels', $hideOverlappingLabels);
	}

	/**
	 * A string reference to the globally-accessible function that
	 * may be called to determine each of the label values for this
	 * axis.
	 *
	 * @param string $labelFunction
	 */
	public function setLabelFunction($labelFunction)
	{
		$this->setAttribute('labelFunction ', $labelFunction);
	}

	/**
	 * The direction in which the axis is drawn. May be "horizontal" or "vertical".
	 *
	 * @param string $orientation
	 */
	public function setOrientation($orientation)
	{
		$this->setAttribute('orientation', $orientation);
	}

	/**
	 * If true, the items on the axis will be drawn in opposite direction.
	 *
	 * @param boolean $reverse
	 */
	public function setReverse($reverse)
	{
		$this->setAttribute('reverse', $reverse);
	}

	/**
	 * The type of axis.
	 *
	 * @param string $type
	 */
	public function setType($type)
	{
		$this->setAttribute('type', $type);
	}
}