<?php

abstract class Cream_Security_Access_Data_Manager_Abstract
{
	abstract public function getAccessRules(Cream_Content_Item $item);	
}