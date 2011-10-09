<?php

class Cream_Content_Fields_Text extends Cream_Content_Fields_Field
{
	public static function instance(Cream_Guid $fieldId, Cream_Content_Item $item)
	{
		Cream::instance(__CLASS__, $fieldId, $item);
	}	
}