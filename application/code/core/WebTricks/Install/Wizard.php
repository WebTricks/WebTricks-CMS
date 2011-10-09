<?php
/**
 * WebTricks
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
 * @copyright Copyright (c) 2007-2011 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * Wizard
 * 
 * @package		WebTricks_Install
 * @author		WebTricks Core Team <core@webtricksframework.com>
 */
class WebTricks_Install_Wizard
{
	protected $_steps = array();
	
	/**
	 * Create an instance of this class
	 * 
	 * @return WebTricks_Install_Wizard
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}

	/**
	 * Initialize function
	 * 
	 * @return void
	 */
	public function __init()
	{
		$config = $this->_getConfig()->getNode(WebTricks_Install_Config::XML_PATH_WIZARD_STEPS);
		
        foreach ($config->children() as $stepName => $step) {
			$this->_steps[] = WebTricks_Install_Wizard_Step::instance($stepName, $step);        		
        }
        
        foreach ($this->_steps as $index => $step) {
            $this->_steps[$index]->setUrl(
                $this->_getUrl($this->_steps[$index]->getController(), $this->_steps[$index]->getAction())
            );

            if (isset($this->_steps[$index+1])) {
                $this->_steps[$index]->setNextUrl(
                    $this->_getUrl($this->_steps[$index+1]->getController(), $this->_steps[$index+1]->getAction())
                );
            }
            if (isset($this->_steps[$index-1])) {
                $this->_steps[$index]->setPreviousUrl(
                    $this->_getUrl($this->_steps[$index-1]->getController(), $this->_steps[$index-1]->getAction())
                );
            }
        }
        
	}
	
	/**
	 * Returns an array of installation steps
	 * 
	 * @return array
	 */
	public function getSteps()
	{
		return $this->_steps;
	}
	
	public function getStepByRequest(Zend_Controller_Request_Abstract $request)
	{
        foreach ($this->_steps as $step) {
            if ($step->getController() == $request->getControllerName() && $step->getAction() == $request->getActionName()) {
                return $step;
            }
        }
        return false;
	}
	
	/**
	 * Returns the step by the given name. 
	 *  
	 * @param string $name
	 * @return WebTricks_Install_Wizard_Step
	 */
	public function getStepByName($name)
	{
		foreach ($this->_steps as $step) {
			if ($step->getName() == $name) {
				return $step;
			}
		}
		
        return false;		
	}

	/**
	 * Returns the install config
	 * 
	 * @return WebTricks_Install_Config
	 */
	protected function _getConfig()
	{
		return WebTricks_Install_Config::singleton();
	}
	
    /**
     * Retrieve Url Path
     *
     * @param string $controller
     * @param string $action
     * @return string
     */
    protected function _getUrl($controller, $action)
    {
        return '/install/'.$controller.'/'.$action;
    }
}