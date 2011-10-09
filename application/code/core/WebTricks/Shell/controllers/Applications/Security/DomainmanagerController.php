<?php
/**
 * WebTricks - PHP Framework
 *
 * LICENSE
 *
 * For the full copyright and license information, please view the 
 * following URL: http://www.webtricksframework.com/license 
 *
 * @copyright Copyright (c) 2007-2011 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

class WebTricks_Shell_Applications_Security_DomainmanagerController extends WebTricks_Shell_Controller_CommandAction
{
	public function dataAction()
	{
		$data = array();
		$users = array();	
		$domains = Cream_Security_Managers_DomainProvider::getDomains();
		
		foreach ($domains as $domain) {
			$domainData[] = array(
				'name' => $domain->getName(),
				'description' => $domain->getDescription()
			);
		}
		
		$data['data'] = $domainData;
		$data['success'] = true;
		
		$this->getResponse()->setBody(Cream_Json::encode($data));		
	}
}