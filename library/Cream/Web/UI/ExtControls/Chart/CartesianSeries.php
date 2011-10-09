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
 * CartesianSeries class for the charts widget.
 * 
 * @package 	Cream_Web_UI_ExtControls_Chart
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Chart_CartesianSeries extends Cream_Web_UI_ExtControls_Chart_Series
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Chart_CartesianSeries
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
		$this->setControl('Ext.chart.CartesianSeries');
	}
		
	/**
	 * The field used to access the x-axis value from the items from
	 * the data source.
	 *
	 * @param string $xField
	 */
	public function setXField($xField)
	{
		$this->setAttribute('xField', $xField);
	}

	/**
	 * The field used to access the y-axis value from the items from
	 * the data source.
	 *
	 * @param string $yField
	 */
	public function setYField($yField)
	{
		$this->setAttribute('yField', $yField);
	}
}