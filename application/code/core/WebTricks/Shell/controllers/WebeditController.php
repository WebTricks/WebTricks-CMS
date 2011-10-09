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
 * Controller for the WebTricks Shell
 * 
 * @package		WebTricks_Shell
 * @author		Danny Verkade
 */
class WebTricks_Shell_WebeditController extends WebTricks_Shell_Controller_Action
{
	public function applicationAction()
	{
		$webedit = WebTricks_Shell_Applications_Webedit::instance();

        $this->getResponse()->setBody('var application = '. Cream_Json::encode($webedit->getWebedit()));			
	}
}