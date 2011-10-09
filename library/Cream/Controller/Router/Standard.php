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
 * Standard router.
 *
 * @package		Cream_Controller
 * @author		Danny Verkade
 */
class Cream_Controller_Router_Standard extends Cream_Controller_Router_Abstract
{
    public function match(Cream_Controller_Request_Http $request)
    {
        $d = explode('/', $this->getApplication()->getConfig()->getNode('web/default/no_route'));
        
        $request->setModuleName(isset($d[0]) ? $d[0] : 'core')
            ->setControllerName(isset($d[1]) ? $d[1] : 'index')
            ->setActionName(isset($d[2]) ? $d[2] : 'index');

        return true;
    }
}