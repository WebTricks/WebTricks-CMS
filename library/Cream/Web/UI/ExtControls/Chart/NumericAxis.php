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
 * A type of axis whose units are measured in numeric values.
 * 
 * @package 	Cream_Web_UI_ExtControls_Chart
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Chart_NumericAxis extends Cream_Web_UI_ExtControls_Chart_Axis
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Chart_NumericAxis
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
		$this->setControl('Ext.chart.NumericAxis');
	}
		
	/**
	 * If true, and the bounds are calculated automatically, either
	 * the minimum or maximum will be set to zero.
	 *
	 * @param boolean $alwaysShowZero
	 */
	public function setAlwaysShowZero($alwaysShowZero)
	{
		$this->setAttribute('alwaysShowZero', $alwaysShowZero);
	}

	/**
	 * The spacing between major intervals on this axis.
	 *
	 * @param integer $majorUnit
	 */
	public function setMajorUnit($majorUnit)
	{
		$this->setAttribute('majorUnit', $majorUnit);
	}

	/**
	 * The maximum value drawn by the axis. If not set explicitly,
	 * the axis maximum will be calculated automatically.
	 *
	 * @param integer $maximum
	 */
	public function setMaximum($maximum)
	{
		$this->setAttribute('maximum', $maximum);
	}

	/**
	 * The minimum value drawn by the axis. If not set explicitly,
	 * the axis minimum will be calculated automatically.
	 *
	 * @param integer $minimum
	 */
	public function setMinimum($minimum)
	{
		$this->setAttribute('minimum', $minimum);
	}

	/**
	 * The spacing between minor intervals on this axis.
	 *
	 * @param boolean $minorUnit
	 */
	public function setMinorUnit($minorUnit)
	{
		$this->setAttribute('minorUnit', $minorUnit);
	}

	/**
	 * The scaling algorithm to use on this axis. May be "linear" or
	 * "logarithmic".
	 *
	 * @param string $scale
	 */
	public function setScale($scale)
	{
		$this->setAttribute('scale', $scale);
	}

	/**
	 * If true, the labels, ticks, gridlines, and other objects will
	 * snap to the nearest major or minor unit. If false, their
	 * position will be based on the minimum value.
	 *
	 * @param boolean $snapToUnits
	 */
	public function setSnapToUnits($snapToUnits)
	{
		$this->setAttribute('snapToUnits', $snapToUnits);
	}
}