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
 * Controller to display a basic content page
 * 
 * @package		WebTricks_Content
 * @author		Danny Verkade
 */
class WebTricks_Content_PageController extends WebTricks_Content_Controller_Action
{
	/**
	 * Display page action
	 * 
	 */
	public function indexAction()
	{
		$this->_forward('noRoute');
	}
	
	/**
	 * Display page action
	 * 
	 */
	public function viewAction()
	{
		$item = $this->_getApplication()->getContext()->getItem();
		
		$this->renderLayout();
	}
	
    /**
     * Render CMS 404 Not found page
     *
     * @param string $coreRoute
     */
    public function noRouteAction($coreRoute = null)
    {   	
        $this->getResponse()->setHeader('HTTP/1.1','404 Not Found');
        $this->getResponse()->setHeader('Status','404 File not found');
        
        print '404 page not found';

        //$pageId = Mage::getStoreConfig(Mage_Cms_Helper_Page::XML_PATH_NO_ROUTE_PAGE);
        //if (!Mage::helper('cms/page')->renderPage($this, $pageId)) {
        	//$this->_forward('defaultNoRoute');
        //}
    }

    /**
     * Default no route page action
     * Used if no route page don't configure or available
     *
     */
    public function defaultNoRouteAction()
    {
        $this->getResponse()->setHeader('HTTP/1.1','404 Not Found');
        $this->getResponse()->setHeader('Status','404 File not found');

        $this->loadLayout();
        $this->renderLayout();
    }	
}