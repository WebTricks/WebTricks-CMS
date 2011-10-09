<?php

class Cream_Controller_Request_Resolver_Repository extends Cream_Controller_Request_Resolver_Abstract
{
	public function process()
	{
		$repositoryName = $this->getApplication()->getRequest()->getParam('__repository');
		
		if ($repositoryName) {
			$repository = $this->getApplication()->getRepository($repositoryName);
		
			if ($repository) {
				$this->getApplication()->getContext()->setRepository($repository);
			} else {
				throw new Cream_Controller_Exception('Could not find repository "'. $repositoryName .'" from query string.');
			}
		}
	}
}