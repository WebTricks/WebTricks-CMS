<?php

class Cream_Security_Access_Data_Manager_Item extends Cream_Security_Access_Data_Manager_Abstract
{
	public function getAccessRules(Cream_Content_Item $item)
	{
		$field = $item->get(Cream_Application_FieldIds::getSecurity());
	}
}