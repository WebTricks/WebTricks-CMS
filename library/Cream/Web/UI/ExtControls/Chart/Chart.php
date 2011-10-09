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
 * The Ext.chart package provides the capability to visualize data
 * with flash based charting. Each chart binds directly to an
 * Ext.data.Store enabling automatic updates of the chart.
 *
 * @package		Cream_Web_UI_ExtControls_Chart
 * @author		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Chart_Chart extends Cream_Web_UI_ExtControls_FlashComponent
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Chart_Chart
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
		$this->setControl('Ext.chart.Chart');
		$this->setXtype('chart');
	}

	/**
	 * Sets styles for this chart. Contains a number of default
	 * values. Modifying this property will override the base styles
	 * on the chart.
	 *
	 * @param object $chartStyle
	 */
	public function setChartStyle($chartStyle)
	{
		$this->setAttribute('chartStyle', $chartStyle);
	}

	/**
	 * True to add a "cache buster" to the end of the chart url.
	 * Defaults to true for Opera and IE.
	 *
	 * @param boolean $disableCaching
	 */
	public function setDisableCaching($disableCaching)
	{
		$this->setAttribute('disableCaching', $disableCaching);
	}

	/**
	 * Contains extra styles that will be added or overwritten to the
	 * default chartStyle. Defaults to null.
	 *
	 * @param object $extraStyle
	 */
	public function setExtraStyle($extraStyle)
	{
		$this->setAttribute('extraStyle', $extraStyle);
	}

	/**
	 * The url to load the chart from. This defaults to
	 * Ext.chart.Chart.CHART_URL, which should be modified to point
	 * to the local charts resource.
	 *
	 * @param string $url
	 */
	public function setUrl($url)
	{
		$this->setAttribute('url', $url);
	}

	public function setStore($store)
	{
		$this->setAttribute('store', $store);
	}
}