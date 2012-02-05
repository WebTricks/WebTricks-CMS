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
 * @copyright Copyright (c) 2007-2010 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * Base webtricks content controller
 *
 * @package		WebTricks_Content
 * @author		Danny Verkade
 */
class WebTricks_Content_Controller_Action extends Cream_Controller_Action
{
	public function preDispatch()
	{
		$this->_setDesign();
		$this->_setLayout();	
	}
	
	protected function _setLayout()
	{
		$item = $this->_getApplication()->getContext()->getItem();
		
        $update = $this->getLayout()->getUpdate();
        $update->addHandle('default');
        
        //if ($item->get('Layout')) {
        //	
        //}
        
		$this->getLayout()->getUpdate()->load();        		
		$this->getLayout()->generateXml();
		$this->getLayout()->generateBlocks();
	}
	
	protected function _setDesign()
	{
        $this->getDesign()->setArea('frontend');
        $this->getDesign()->setPackageName('base');
        $this->getDesign()->setTheme('default');
	}
}