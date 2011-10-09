<?php

class Cream_Globalization_Dictionary extends Cream_ApplicationComponent
{
	/**
	 * Create a new instance of this class 
	 * 
	 * @param array $data
	 * @return Cream_Globalization_Dictionary
	 */
	public static function instance($data = null)
	{
		return Cream::instance(__CLASS__, $data);
	}
}