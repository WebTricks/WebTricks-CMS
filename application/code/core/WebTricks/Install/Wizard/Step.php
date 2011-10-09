<?php
/**
 * WebTricks - PHP Framework
 *
 * LICENSE
 *
 * For the full copyright and license information, please view the 
 * following URL: http://www.webtricksframework.com/license 
 *
 * @copyright Copyright (c) 2007-2011 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * Wizard step
 * 
 * @package		WebTricks_Install
 * @author		Danny Verkade
 */
class WebTricks_Install_Wizard_Step
{
	/**
	 * Determines if the step is active.
	 * 
	 * @var boolean
	 */
	protected $_active = false;
	
	/**
	 * Name of the controller of this step.
	 * 
	 * @var string
	 */
	protected $_controller;
	
	/**
	 * Name of the action of this step.
	 * 
	 * @var string
	 */
	protected $_action;
	
	/**
	 * Name of the step.
	 * 
	 * @var string
	 */
	protected $_name; 
	
	/**
	 * Title of the step.
	 * 
	 * @var string
	 */
	protected $_title;
	
	/**
	 * URL of the step.
	 * 
	 * @var string
	 */
	protected $_url;
	
	/**
	 * URL of the next step.
	 * 
	 * @var string
	 */
	protected $_nextUrl;
	
	/**
	 * URL of the previous step.
	 * 
	 * @var string
	 */
	protected $_previousUrl;
	
	/**
	 * Create a new instance of this class.
	 * 
	 * @param string $name
	 * @param Cream_Config_Xml_Element $data
	 */
	public static function instance($name, $data)
	{
		return Cream::instance(__CLASS__, $name, $data);
	}
	
	/**
	 * Initialize function
	 * 
	 * @param string $name
	 * @param Cream_Config_Xml_Element $data
	 */
	public function __init($name, $data)
	{		
		$this->_name = $name;
		$this->_controller = (string) $data->controller;
		$this->_action = (string) $data->action;
		$this->_title = (string) $data->title;
	}
	
	/**
	 * Determines if the step is active. Returns true if the step is
	 * active, otherwise returns false.
	 * 
	 * @return boolean
	 */
	public function isActive()
	{
		return $this->_active;
	}
	
	/**
	 * Set if the step is active.
	 * 
	 * @param boolean $active
	 */
	public function setActive($active)
	{
		$this->_active = $active;
	}
	
	/**
	 * Returns the name of the controller for the step.
	 * 
	 * @return string
	 */
	public function getController()
	{
		return $this->_controller;
	}
	
	/**
	 * Returns the name of the action for the step.
	 * 
	 * @return string
	 */
	public function getAction()
	{
		return $this->_action;
	}
	
	/**
	 * Returns the name of the step.
	 * 
	 * @return string
	 */
	public function getName()
	{
		return $this->_name;
	}
	
	/**
	 * Returns the step title.
	 * 
	 * @return string
	 */
	public function getTitle()
	{
		return $this->_title;
	}
	
	/**
	 * Returns the step URL.
	 * 
	 * @return string
	 */
	public function getUrl()
	{
		return $this->_url;
	}
	
	/**
	 * Sets the step URL.
	 * 
	 * @param string $url
	 */
	public function setUrl($url)
	{
		$this->_url = $url;
	}
	
	/**
	 * Returns the URL of the next step.
	 * 
	 * @return string
	 */
	public function getNextUrl()
	{
		return $this->_nextUrl;
	}
	
	/**
	 * Sets the URL of the next step.
	 * 
	 * @param string $url
	 */
	public function setNextUrl($url)
	{
		$this->_nextUrl = $url;
	}
	
	/**
	 * Returns the URL of the previous step.
	 * 
	 * @return string
	 */
	public function getPreviousUrl()
	{
		return $this->_previousUrl;
	}
	
	/**
	 * Sets hte URL of the previous step.
	 * 
	 * @param string $url
	 */
	public function setPreviousUrl($url)
	{
		$this->_previousUrl = $url;
	}
}