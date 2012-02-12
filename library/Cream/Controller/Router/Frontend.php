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
 * Frontend router
 *
 * @package		Cream_Controller
 * @author		Danny Verkade
 */
class Cream_Controller_Router_Frontend extends Cream_Controller_Router_Abstract
{
    protected $_modules = array();
    protected $_routes = array();
    protected $_dispatchData = array();

    public function fetchDefault()
    {
        $this->getFront()->setDefault(array(
            'module' => 'webtricks',
            'controller' => 'index',
            'action' => 'index'
        ));
    }

    /**
     * Check before the module match
     *
     * @return bool
     */
    protected function _beforeModuleMatch()
    {
        return true;
    }

    /**
     * dummy call to pass through checking
     *
     * @return bool
     */
    protected function _afterModuleMatch()
    {
        return true;
    }

    public function match(Cream_Controller_Request_Http $request)
    {
    	$found = false;
        //checking before even try to find out that current module
        //should use this router
        if (!$this->_beforeModuleMatch()) {
            return false;
        }

        $this->fetchDefault();

        $front = $this->getFront();
        $path = trim($request->getPathInfo(), '/');
                
        if ($this->_getApplication()->getContext()->getItem()) {
        	
        	$module = 'Content';
        	$realModule = 'WebTricks_Content';
        	$controller = 'Page';
        	$action = 'view';
        	
            //checking if this place should be secure
            //$this->_checkShouldBeSecure($request, '/'.$module.'/'.$controller.'/'.$action);
            
            $controllerClassName = $this->_validateControllerClassName($realModule, $controller);

            // instantiate controller class
            $controllerInstance = new $controllerClassName($request, $front->getResponse());
            $found = true;
        }

        /**
         * if we did not find a match
         */
        if (!$found) {
            if ($this->_noRouteShouldBeApplied()) {
            	$module = 'Content';
            	$realModule = 'WebTricks_Content';
                $controller = 'Page';
                $action = 'noRoute';

                $controllerClassName = $this->_validateControllerClassName($realModule, $controller);
                if (!$controllerClassName) {
                    return false;
                }

                // instantiate controller class
            	$controllerInstance = new $controllerClassName($request, $front->getResponse());
                
                if (!$controllerInstance->hasAction($action)) {
                    return false;
                }
            } else {
                return false;
            }
        }

        // set values only after all the checks are done
        $request->setModuleName($module);
        $request->setControllerName($controller);
        $request->setActionName($action);
        $request->setControllerModule($realModule);

        // dispatch action
        $request->setDispatched(true);
        $controllerInstance->dispatch($action);

        return true;
    }

    /**
     * Allow to control if we need to enable no route functionality in current router
     *
     * @return bool
     */
    protected function _noRouteShouldBeApplied()
    {
        return true;
    }

    /**
     * Generating and validating class file name,
     * class and if evrything ok do include if needed and return of class name
     *
     * @return mixed
     */
    protected function _validateControllerClassName($realModule, $controller)
    {
        $controllerFileName = $this->getControllerFileName($realModule, $controller);
        
        if (!$this->validateControllerFileName($controllerFileName)) {
            return false;
        }

        $controllerClassName = $this->getControllerClassName($realModule, $controller);
        if (!$controllerClassName) {
            return false;
        }

        // include controller file if needed
        if (!$this->_includeControllerClass($controllerFileName, $controllerClassName)) {
            return false;
        }

        return $controllerClassName;
    }

    /**
     * Include the file containing controller class if this class is not defined yet
     *
     * @param string $controllerFileName
     * @param string $controllerClassName
     * @return bool
     */
    protected function _includeControllerClass($controllerFileName, $controllerClassName)
    {
        if (!class_exists($controllerClassName, false)) {
            if (!file_exists($controllerFileName)) {
                return false;
            }
            include $controllerFileName;

            if (!class_exists($controllerClassName, false)) {
                throw new Cream_Controller_Exception('Controller file was loaded but class does not exist');
            }
        }
        return true;
    }

    public function addModule($frontName, $moduleName, $routeName)
    {
        $this->_modules[$frontName] = $moduleName;
        $this->_routes[$routeName] = $frontName;
        return $this;
    }

    public function getModuleByFrontName($frontName)
    {
        if (isset($this->_modules[$frontName])) {
            return $this->_modules[$frontName];
        }
        return false;
    }

    public function getModuleByName($moduleName, $modules)
    {
        foreach ($modules as $module) {
            if ($moduleName === $module || (is_array($module)
                    && $this->getModuleByName($moduleName, $module))) {
                return true;
            }
        }
        return false;
    }

    public function getFrontNameByRoute($routeName)
    {
        if (isset($this->_routes[$routeName])) {
            return $this->_routes[$routeName];
        }
        return false;
    }

    public function getRouteByFrontName($frontName)
    {
        return array_search($frontName, $this->_routes);
    }

    public function getControllerFileName($realModule, $controller)
    {
        $parts = explode('_', $realModule);
        $realModule = implode('_', array_splice($parts, 0, 2));
        $file = $this->_getApplication()->getOptions()->getModuleDir(Cream_ApplicationOptions::MODULE_CONTROLLERS_DIRECTORY, $realModule);

        if (count($parts)) {
            $file .= DS . implode(DS, $parts);
        }
        
        $file .= DS . Cream_Utility::ucWords($controller, DS) .'Controller.php';
        return $file;
    }

    public function validateControllerFileName($fileName)
    {
        if ($fileName && is_readable($fileName) && false===strpos($fileName, '//')) {
            return true;
        }
        return false;
    }

    public function getControllerClassName($realModule, $controller)
    {
        $class = $realModule .'_'. Cream_Utility::ucWords($controller) .'Controller';
        return $class;
    }

    public function rewrite(array $p)
    {
        $rewrite = $this->_getApplication()->getConfig()->getNode('global/rewrite');
	    $module = $rewrite->{$p[0]};
        
        if ($module) {
            if (!$module->children()) {
                $p[0] = trim((string)$module);
            }
        }
        if (isset($p[1]) && ($controller = $rewrite->{$p[0]}->{$p[1]})) {
            if (!$controller->children()) {
                $p[1] = trim((string)$controller);
            }
        }
        if (isset($p[2]) && ($action = $rewrite->{$p[0]}->{$p[1]}->{$p[2]})) {
            if (!$action->children()) {
                $p[2] = trim((string)$action);
            }
        }
        return $p;
    }
}