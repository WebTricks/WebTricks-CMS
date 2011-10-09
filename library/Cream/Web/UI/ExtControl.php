<?php
/**
 * WebTricks - PHP Framework
 *
 * LICENSE
 *
 * For the full copyright and license information, please view the 
 * following URL: http://www.webtricksframework.com/license 
 * 
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade to newer versions in
 * the future. If you wish to customize WebTricks for your needs please go to 
 * http://www.webtricksframework.com for more information.
 *
 * @copyright Copyright (c) 2007-2010 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * Base class for all EXT JS components
 *
 * @package 	Cream_Web_UI_ExtControls
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControl extends Cream_ApplicationComponent
{
	/**
	 * @var array
	 */
	protected $_attributes;
	
	/**
	 * @var string
	 */
	private $_control;

	/**
	 * @var boolean
	 */
	private $_renderControl = true;

	/**
	 * Sets the EXT control name
	 *
	 * @param string $control
	 */
	public function setControl($control)
	{
		$this->_control = $control;
	}

	/**
	 * Returns the ext control name to rnder
	 *
	 * @return string
	 */
	protected function getControl()
	{
		if ($this->_renderControl) {
			return $this->_control;
		} else {
			return null;
		}
	}

	/**
	 * Set if the control needs to be rendered in the writer or not.
	 *
	 * @param boolean $renderControl
	 */
	public function setRenderControl($renderControl)
	{
		$this->_renderControl = $renderControl;
	}

	/**
	 * Wrapper function for render()
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->render();
	}
	
	/**
	 * Returns an JSON formatted string of the EXT component
	 *
	 * @return string
	 */
	public function __toJson()
	{
		return $this->toJson();
	}	

	/**
	 * Returns an JSON formatted string of the EXT component
	 *
	 * @return string
	 */
	public function toJson()
	{
		return $this->render();
	}

	/**
	 * Returns the EXT JSON string.
	 *
	 * @return string
	 */
	public function render()
	{
		$str = '';

		if ($this->getControl()) {
			$str .= 'new '. $this->getControl() .'(';
		}

		$str .= Cream_Json::encode($this->_attributes);

		if ($this->getControl()) {
			$str .= ')';
		}

		return $str;
	}

	/**
	 * Associates an undocumented EXT attribute to the object.
	 *
	 * @param string $attribute
	 * @param mixed $value
	 */
	public function associate($attribute, $value)
	{
		$this->setAttribute($attribute, $value);
	}
	
	/**
	 * Sets an attribute to be rendered
	 *
	 * @param string name of the attribute
	 * @param mixed value of the attribute
	 */
	protected function setAttribute($name, $value)
	{
		$this->_attributes[$name] = $value;
	}

	/**
	 * Adds an attribute to be renderd.
	 *
	 * @param string $name
	 * @param mixed $value
	 */
	protected function addAttribute($name, $value)
	{
		if (!isset($this->_attributes[$name])) {
			$this->_attributes[$name] = array();
		}
		
		if (!is_array($this->_attributes[$name])) {
			if (isset($this->_attributes[$name]))	 {
				$this->_attributes[$name] = array($this->_attributes[$name]);
			} else {
				$this->_attributes[$name] = array();
			}
		}

		array_push($this->_attributes[$name], $value);
	}

	/**
	 * Removes the named attribute from rendering
	 *
	 * @param string name of the attribute to be removed
	 */
	protected function removeAttribute($name)
	{
		unset($this->_attributes[$name]);
	}
}