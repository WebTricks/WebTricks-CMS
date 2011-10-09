<?php

class Cream_Content_Managers_ProxyManager extends Cream_ApplicationComponent
{
	public function isProxy(Cream_Content_Item $item)
	{
		if ((string) $item->getTemplateId() == Cream_Application_TemplateIds::PROXY) {
			return true;
		} else {
			return false;
		}
	}
	
	public function isVirtual(Cream_Content_Item $item)
	{
		
	}
	
	public function getRealItem(Cream_Content_Item $proxy)
	{
		
	}
}