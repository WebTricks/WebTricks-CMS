<?php
/**
 * WebTricks - PHP Framework
 *
 * LICENSE
 *
 * For the full copyright and license information, please view the 
 * following URL: http://www.webtricksframework.com/license 
 *
 * @copyright Copyright (c) 2007-2010 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * Controller action for the WebTricks Install module.
 * 
 * @package		WebTricks_Install
 * @author		Danny Verkade
 */
class WebTricks_Install_Controller_Action extends Cream_Controller_Action
{
	/**
	 * Initialize function
	 * 
	 * @see Cream_Controller_Action::__init()
	 * @return void
	 */
    protected function __init()
    {
        parent::__init();
        
        $this->getDesign()->setArea('install');
        $this->getDesign()->setPackageName('default');
        $this->getDesign()->setTheme('default');
    }	
}