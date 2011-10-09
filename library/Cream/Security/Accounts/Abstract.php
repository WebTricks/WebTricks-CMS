<?php

abstract class Cream_Security_Accounts_Abstract
{
	protected $_name;
	
	protected $_domain;
	
	public function __init($data = null)
	{
		if ($data) {
		/*$this->_name = $data->name;*/
		$this->_domain = $data->domain;
		}
	}
	
	public function getDescription()
	{
	}
	
	public function getName()
	{
		return $this->_name;
	}

	abstract function getDomain();
}