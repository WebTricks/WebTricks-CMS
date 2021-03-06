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
 * Default router.
 *
 * @package		Cream_Controller
 * @author		Danny Verkade
 */
class Cream_Controller_Router_Default extends Cream_Controller_Router_Abstract
{
    protected $_modules = array();
    protected $_routes = array();
    protected $_dispatchData = array();

    public function collectRoutes($configArea, $useRouterName)
    {
        $routers = array();
        $routersConfigNode = $this->_getApplication()->getConfig()->getNode($configArea.'/routers');
        
        if($routersConfigNode) {
            $routers = $routersConfigNode->children();
        }
        
        foreach ($routers as $routerName => $routerConfig) {
            $use = (string)$routerConfig->use;
            if ($use == $useRouterName) {
                $modules = array((string)$routerConfig->args->module);
                if ($routerConfig->args->modules) {
                    foreach ($routerConfig->args->modules->children() as $customModule) {
                        if ($customModule) {
                        	
                        	$before = $customModule->getAttribute('before');
                        	$after = $customModule->getAttribute('after');
                        	
                            if ($before) {
                                $position = array_search($before, $modules);
                                if ($position === false) {
                                    $position = 0;
                                }
                                array_splice($modules, $position, 0, (string)$customModule);
                            } elseif ($after) {
                                $position = array_search($after, $modules);
                                if ($position === false) {
                                    $position = count($modules);
                                }
                                array_splice($modules, $position+1, 0, (string)$customModule);
                            } else {
                                $modules[] = (string)$customModule;
                            }
                        }
                    }
                }

                $frontName = (string)$routerConfig->args->frontName;
                $this->addModule($frontName, $modules, $routerName);
            }
        }
    }

    public function fetchDefault()
    {
        $this->getFront()->setDefault(array(
            'module' => 'webtricks',
            'controller' => 'index',
            'action' => 'index'
        ));
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
        //checking before even try to find out that current module
        //should use this router
        //if (!$this->_beforeModuleMatch()) {
        //    return false;
        //}

        $this->fetchDefault();    	        

        $front = $this->getFront();
        $path = trim($request->getPathInfo(), '/');
        
        if ($path) {
            $p = explode('/', $path);
        } else {
            //$p = explode('/', $this->_getApplication()->getConfig()->getNode('web/default/front'));
        }

        // get module name
        if ($request->getModuleName()) {
            $module = $request->getModuleName();
        } else {
            if (!empty($p[0])) {
                $module = $p[0];
            } else {
                $module = $this->getFront()->getDefault('module');
            }
        }
        
        if (!$module) {
			return false;
        }

        /**
         * Searching router args by module name from route using it as key
         */
        $modules = $this->getModuleByFrontName($module);

        /**
         * If we did not found anything  we searching exact this module
         * name in array values
         */
        if ($modules === false) {
        	
        	$moduleFrontName = $this->getModuleByName($module, $this->_modules);
        	
            if ($moduleFrontName) {
                $modules = array($module);
                $module = $moduleFrontName;
            } else {
                return false;
            }
        }
        
        //checkings after we foundout that this router should be used for current module
        if (!$this->_afterModuleMatch()) {
            return false;
        }

        /**
         * Going through modules to find appropriate controller
         */
        $found = false;
        foreach ($modules as $realModule) {
            $request->setRouteName($this->getRouteByFrontName($module));

            // get controller name
            if ($request->getControllerName()) {
                $controller = $request->getControllerName();
            } else {
                if (!empty($p[1])) {
                    $controller = $p[1];
                } else {
                    $controller = $front->getDefault('controller');
                }
            }
            
            // get action name
            //if (empty($action)) {
                if ($request->getActionName()) {
                    $action = $request->getActionName();
                } else {
                    $action = !empty($p[2]) ? $p[2] : $front->getDefault('action');
                }
            //}
                        
            $controllerClassName = $this->_validateControllerClassName($realModule, $controller);
            if (!$controllerClassName) {
                continue;
            }         

            // instantiate controller class
            $controllerInstance = new $controllerClassName($request, $front->getResponse());
                        
            if (!$controllerInstance->hasAction($action)) {       	
                continue;
            }
                        
            $found = true;
            break;
        }

        /**
         * if we did not found any siutibul
         */
        if (!$found) {
            if ($this->_noRouteShouldBeApplied()) {
                $controller = 'index';
                $action = 'noroute';

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

        // set parameters from pathinfo
        for ($i=3, $l=sizeof($p); $i<$l; $i+=2) {
            $request->setParam($p[$i], isset($p[$i+1]) ? $p[$i+1] : '');
        }

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
        return false;
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
                throw new Cream_Exceptions_ControllerException('Controller file was loaded but class does not exist');
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
