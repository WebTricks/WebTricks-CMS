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
 * Base webtricks shell controller
 *
 * @package		Cream
 * @author		Danny Verkade
 */
class WebTricks_Shell_Controller_Action extends Cream_Controller_Action
{
	const CONFIG_PATH_DEFAULT_CONTENT_REPOSITORY = 'global/content/repository/default_content_repository';
	
	/**
	 * Determines if the user needs to be logged in to view the page
	 * 
	 * @var boolean
	 */
	protected $_isPublic = false;
	
	/**
	 *  Holds the shell session
	 * 
	 * @var WebTricks_Shell_Session
	 */
	protected $_session;
	
	/**
	 * Initialize function
	 * 
	 * @see Cream_Controller_Action::__init()
	 * @return void
	 */
    protected function __init()
    {
        parent::__init();
        
        $this->getDesign()->setArea('shell');
        $this->getDesign()->setPackageName('base');
        $this->getDesign()->setTheme('default');
    }		
	
    /**
     * Controller predispatch method
     *
     */	
	public function preDispatch()
	{
		$this->_setUserContext();
		$this->_setContentRepositoryContext();
		
		$user = $this->_getApplication()->getContext()->getUser();
		$request = $this->getRequest();

		if ($request->isDispatched() && !$this->_isPublic) {
            if (!$user->isAuthenticated()) {
                if (!$request->getParam('forwarded')) {
                    if ($request->getParam('isIframe')) {
                        $request->setParam('forwarded', true)
                            ->setControllerName('index')
                            ->setActionName('deniedIframe')
                            ->setDispatched(false);
                    } elseif($request->getParam('isAjax')) {
                        $request->setParam('forwarded', true)
                            ->setControllerName('index')
                            ->setActionName('deniedJson')
                            ->setDispatched(false);
                    } else {
                        $request->setParam('forwarded', true)
                            ->setControllerName('index')
                            ->setActionName('login')
                            ->setDispatched(false);
                    }
                }
            }
        }   
	}

	/**
	 * Returns the shell session.
	 * 
	 * @return WebTricks_Shell_Session
	 */
	protected function _getSession()
	{
		if (!$this->_session) {
			$this->_session = WebTricks_Shell_Session::singleton();		
		}
		
		return $this->_session;
	}
	
	public function _setContentRepositoryContext()
	{
		if (!$this->_getSession()->contentRepositoryName) {
			$node = $this->_getApplication()->getConfig()->getNode(self::CONFIG_PATH_DEFAULT_CONTENT_REPOSITORY);
			$this->_getSession()->contentRepositoryName = (string) $node;
		}
		
		if ($this->getRequest()->getParam('__content')) {
			$this->_getSession()->contentRepositoryName = $this->getRequest()->getParam('__content');
		}
				
		$repositoryName = $this->_getSession()->contentRepositoryName;
		$repository = Cream_Content_Managers_RepositoryProvider::getRepository($repositoryName);
		$this->_getApplication()->getContext()->setContentRepository($repository);
	}
	
	/**
	 * Sets the user context to the current user. Loads the user from
	 * the session, if no session is found creates an anonymous
	 * session user. 
	 *  
	 */
	private function _setUserContext()
	{
		$user = $this->_getSession()->getUser();
	
		$this->_getApplication()->getContext()->setUser($user);		
	}
}