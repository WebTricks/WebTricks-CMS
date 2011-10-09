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
	public function indexAction()
	{
        $this->getDesign()->setArea('frontend');
        $this->getDesign()->setPackageName('base');
        $this->getDesign()->setTheme('default');
		
		//$item = $this->getApplication()->getContext()->getItem();
		//
		//print_r($item);
		$this->loadLayout('default');
		$this->renderLayout();
	}
}