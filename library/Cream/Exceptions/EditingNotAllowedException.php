<?php

class Cream_Exceptions_EditingNotAllowedException extends Cream_Exceptions_Exception
{
	public function __construct(Cream_Content_Item $item)
	{
		parent::__construct('Editing not allowed for item "'. $item->getName() .'" with ID: '. $item->getItemId());
	}	
}