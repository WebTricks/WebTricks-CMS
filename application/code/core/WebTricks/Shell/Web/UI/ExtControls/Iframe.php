<?php

class WebTricks_Shell_Web_UI_ExtControls_Iframe extends Cream_Web_UI_ExtControls_BoxComponent
{
	/**
	 * Create a new instance of this class.
	 * 
	 * @return WebTricks_Shell_Web_UI_ExtControls_Iframe
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Initialize function.
	 * 
	 */
	public function __init()
	{
		$this->setControl('Ext.ux.IFrameComponent');
		$this->setXtype('IFrameComponent');
	}

	/**
	 * Sets source of the iframe.
	 * 
	 * @param string $url
	 */
	public function setUrl($url)
	{
		$this->setAttribute('url', $url);
	}
}