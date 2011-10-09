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
 * Flash component
 * 
 * @package		Cream_Web_UI_ExtControls
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_FlashComponent extends Cream_Web_UI_ExtControls_BoxComponent
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Panel
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
		$this->setControl('Ext.FlashComponent');
		$this->setXtype('flash');
	}

	/**
	 * The background color of the chart. Defaults to '#ffffff'.
	 *
	 * @param string $backgroundColor
	 */
	public function setBackgroundColor($backgroundColor)
	{
		$this->setAttribute('backgroundColor', $backgroundColor);
	}

	/**
	 * True to prompt the user to install flash if not installed.
	 * Note that this uses Ext.FlashComponent.EXPRESS_INSTALL_URL,
	 * which should be set to the local resource. Defaults to false.
	 *
	 * @param boolean $expressInstall
	 */
	public function setExpressInstall($expressInstall)
	{
		$this->setAttribute('expressInstall', $expressInstall);
	}

	/**
	 * A set of key value pairs to be passed to the flash object as
	 * parameters. Possible parameters can be found here:
	 * http://kb2.adobe.com/cps/127/tn_12701.html Defaults to undefined.
	 *
	 * @param object $flashParams
	 */
	public function setFlashParams($flashParams)
	{
		$this->setAttribute('flashParams', $flashParams);
	}

	/**
	 * A set of key value pairs to be passed to the flash object as
	 * flash variables. Defaults to undefined.
	 *
	 * @param object $flashVars
	 */
	public function setFlashVars($flashVars)
	{
		$this->setAttribute('flashVars', $flashVars);
	}

	/**
	 * Indicates the version the flash content was published for.
	 * Defaults to '9.0.45'.
	 *
	 * @param string $flashVersion
	 */
	public function setFlashVersion($flashVersion)
	{
		$this->setAttribute('flashVersion', $flashVersion);
	}

	/**
	 * The URL of the chart to include. Defaults to undefined.
	 *
	 * @param string $url
	 */
	public function setUrl($url)
	{
		$this->setAttribute('url', $url);
	}

	/**
	 * The wmode of the flash object. This can be used to control
	 * layering. Defaults to 'opaque'.
	 *
	 * @param string $wmode
	 */
	public function setWmode($wmode)
	{
		$this->setAttribute('wmode', $wmode);
	}
}