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
 * @copyright Copyright (c) 2007-2011 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * Base class for any visual Ext.Component that uses a box container. 
 * BoxComponent provides automatic box model adjustments for sizing 
 * and positioning and will work correctly withnin the Component 
 * rendering model. All container classes should subclass BoxComponent 
 * so that they will work consistently when nested within other Ext 
 * layout containers.
 *
 * @package 	Cream_Web_UI_ExtControls
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_BoxComponent extends Cream_Web_UI_ExtControls_Component 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_BoxComponent
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
		$this->setControl('Ext.BoxComponent');
	}	
	
	/**
	 * This config is only used when this Component is rendered by a Container 
	 * which has been configured to use an AnchorLayout (or subclass thereof)
	 * based layout manager
	 *
	 * @param string $anchor
	 */
	public function setAnchor($anchor) 
	{
		$this->setAttribute('anchor', $anchor);
	}
	
	/**
	 * The height of this component in pixels (defaults to auto).
	 *
	 * @param integer $height
	 */
	public function setHeight($height) 
	{
		$this->setAttribute('height', $height);
	}

	/**
	 * The width of this component in pixels (defaults to auto).
	 *
	 * @param integer $width
	 */
	public function setWidth($width) 
	{
		$this->setAttribute('width', $width);
	}

	/**
	 * True to use height:'auto', false to use fixed height (defaults to 
	 * false).
	 *
	 * @param boolean $autoHeight
	 */
	public function setAutoHeight($autoHeight) 
	{
		$this->setAttribute('autoHeight', $autoHeight);
	}
	
	/**
	 * True to use height:'auto', false to use fixed height (defaults to 
	 * false).
	 *
	 * @param boolean $autoScroll
	 */
	public function setAutoScroll($autoScroll) 
	{
		$this->setAttribute('autoScroll', $autoScroll);
	}	

	/**
	 * True to use width:'auto', false to use fixed width (defaults to false).
	 *
	 * @param boolean $autoWidth
	 */
	public function setAutoWidth($autoWidth) 
	{
		$this->setAttribute('autoWidth', $autoWidth);
	}
	
	/**
	 * The maximum value in pixels which this BoxComponent will set its height 
	 * to.
	 * 
	 * Warning: This will override any size management applied by layout 
	 * managers.
	 *
	 * @param integer $boxMaxHeight
	 */
	public function setBoxMaxHeight($boxMaxHeight) 
	{
		$this->setAttribute('boxMaxHeight', $boxMaxHeight);
	}

	/**
	 * The maximum value in pixels which this BoxComponent will set its width
	 * to.
	 * 
	 * Warning: This will override any size management applied by layout 
	 * managers.
	 *
	 * @param integer $boxMaxWidth
	 */
	public function setBoxMaxWidth($boxMaxWidth) 
	{
		$this->setAttribute('boxMaxWidth', $boxMaxWidth);
	}	

	/**
	 * The minimum value in pixels which this BoxComponent will set its height 
	 * to.
	 * 
	 * Warning: This will override any size management applied by layout 
	 * managers.
	 *
	 * @param integer $boxMinHeight
	 */
	public function setBoxMinHeight($boxMinHeight) 
	{
		$this->setAttribute('boxMinHeight', $boxMinHeight);
	}

	/**
	 * The minimum value in pixels which this BoxComponent will set its width
	 * to.
	 * 
	 * Warning: This will override any size management applied by layout 
	 * managers.
	 *
	 * @param integer $boxMinWidth
	 */
	public function setBoxMinWidth($boxMinWidth) 
	{
		$this->setAttribute('boxMinWidth', $boxMinWidth);
	}	
	
	/**
	 * This config is only used when this Component is rendered by a Container 
	 * which has been configured to use a BoxLayout. Each child Component with 
	 * a flex property will be flexed either vertically (by a VBoxLayout) or 
	 * horizontally (by an HBoxLayout) according to the item's relative flex 
	 * value compared to the sum of all Components with flex value specified. 
	 * Any child items that have either a flex = 0 or flex = undefined will 
	 * not be 'flexed' (the initial size will not be changed).
	 *
	 * @param integer $flex
	 */
	public function setFlex($flex) 
	{
		$this->setAttribute('flex', $flex);
	}		
	
	/**
	 * This config is only used when this BoxComponent is rendered by a 
	 * Container which has been configured to use the BorderLayout or one of 
	 * the two BoxLayout subclasses.
	 *
	 * @param object $margins
	 */
	public function setMargins($margins) 
	{
		$this->setAttribute('margins', $margins);
	}			
	
	/**
	 * The page level x coordinate for this component if contained within a 
	 * positioning container.
	 *
	 * @param integer $pageX
	 */
	public function setPageX($pageX) 
	{
		$this->setAttribute('pageX', $pageX);
	}	

	/**
	 * The page level y coordinate for this component if contained within a 
	 * positioning container.
	 *
	 * @param integer $pageY
	 */
	public function setPageY($pageY) 
	{
		$this->setAttribute('pageY', $pageY);
	}		
	
	/**
	 * This config is only used when this BoxComponent is rendered by a 
	 * Container which has been configured to use the BorderLayout layout 
	 * manager (e.g. specifying layout:'border').
	 *
	 * @param string $region
	 */
	public function setRegion($region) 
	{
		$this->setAttribute('region', $region);
	}
	
	/**
	 * This config is only used when this BoxComponent is a child item of a 
	 * TabPanel.
	 * 
	 * A string to be used as innerHTML (html tags are accepted) to show in a 
	 * tooltip when mousing over the associated tab selector element. 
	 *
	 * @param string $tabTip
	 */
	public function setTabTip($tabTip) 
	{
		$this->setAttribute('tabTip', $tabTip);
	}	
	
	/**
	 * The local x (left) coordinate for this component if contained within a 
	 * positioning container.
	 *
	 * @param integer $x
	 */
	public function setX($x) 
	{
		$this->setAttribute('x', $x);
	}	

	/**
	 * The local y (top) coordinate for this component if contained within a 
	 * positioning container.
	 *
	 * @param integer $y
	 */
	public function setY($y) 
	{
		$this->setAttribute('y', $y);
	}
}