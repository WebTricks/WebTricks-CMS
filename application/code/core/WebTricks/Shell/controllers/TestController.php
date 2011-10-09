<?php

class WebTricks_Shell_TestController extends WebTricks_Shell_Controller_Action
{
	/**
	 * Controller is publicly available
	 * 
	 * @var boolean
	 */
	protected $_isPublic = true;
		
	public function unserializeAction()
	{
		$path = 'c:\development\webtrickscms\serialization\master';
		
		Cream_Content_Managers_SerializationProvider::loadTree($path);
	}
}