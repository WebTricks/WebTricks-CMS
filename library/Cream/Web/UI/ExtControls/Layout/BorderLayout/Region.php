<?php

/**
 * BorderLayout region class
 *
 * @author Danny Verkade
 * @copyright © 2008 MBWP Internetbureau
 */
class Cream_Web_UI_ExtControls_Layout_BorderLayout_Region extends Cream_Web_UI_ExtControls_Panel 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Layout_BorderLayout_Region
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}	
	
	/**
	 * When a collapsed region's bar is clicked, the region's panel will be displayed as a floated panel that
	 * will close again once the user mouses out of that panel (or clicks out if autoHide = false). Setting
	 * animFloat to false will prevent the open and close of these floated panels from being animated
	 * (defaults to true).
	 *
	 * @param boolean $animFloat
	 */
	public function setAnimFloat($animFloat)
	{
		$this->setAttribute('animFloat', $animFloat);
	}

	/**
	 * When a collapsed region's bar is clicked, the region's panel will be displayed as a floated panel. If
	 * autoHide is true, the panel will automatically hide after the user mouses out of the panel. If autoHide
	 * is false, the panel will continue to display until the user clicks outside of the panel (defaults to true).
	 *
	 * @param boolean $autoHide
	 */
	public function setAutoHide($autoHide)
	{
		$this->setAttribute('autoHide', $autoHide);
	}

	/**
	 * An object containing margins to apply to the region's collapsed element in the format
	 * {left: (left margin), top: (top margin), right: (right margin), bottom: (bottom margin)}
	 *
	 * @param string $cmargins
	 */
	public function setCmargins($cmargins)
	{
		$this->setAttribute('cmargins', $cmargins);
	}

	/**
	 * True to allow the user to collapse this region (defaults to false). If true, an expand/collapse tool button
	 * will automatically be rendered into the title bar of the region, otherwise the button will not be shown.
	 * Note that a title bar is required to display the toggle button -- if no region title is specified, the region
	 * will only be collapsible if collapseMode is set to 'mini'.
	 *
	 * @param boolean $collapseMode
	 */
	public function setCollapsible($collapsible)
	{
		$this->setAttribute('collapsible', $collapsible);
	}

	/**
	 * True to allow clicking a collapsed region's bar to display the region's panel floated above the layout, false
	 * to force the user to fully expand a collapsed region by clicking the expand button to see it again
	 * (defaults to true).
	 *
	 * @param boolean $flootable
	 */
	public function setFlootable($flootable)
	{
		$this->setAttribute('flootable', $flootable);
	}

	/**
	 * The minimum allowable height in pixels for this region (defaults to 50)
	 *
	 * @param integer $minHeight
	 */
	public function setMinHeight($minHeight)
	{
		$this->setAttribute('minHeight', $minHeight);
	}

	/**
	 * The minimum allowable width in pixels for this region (defaults to 50)
	 *
	 * @param integer $minWidth
	 */
	public function setMinWidth($minWidth)
	{
		$this->setAttribute('minWidth', $minWidth);
	}

	public function setPlain($plain)
	{
		$this->setAttribute('plain', $plain);
	}
}