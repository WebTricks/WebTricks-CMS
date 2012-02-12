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
 * Default controller for the WebTricks Shell.
 * 
 * @package		WebTricks_Shell
 * @author		Danny Verkade
 */
class WebTricks_Shell_IndexController extends WebTricks_Shell_Controller_Action
{
	/**
	 * Controller is publicly available
	 * 
	 * @var boolean
	 */
	protected $_isPublic = true;
	
	/**
     * Prepare layout
     *
     * @return unknown
     */
    protected function _prepareLayout()
    {
        $this->loadLayout('shell_page');
    }
	
	/**
	 * Index action, redirects the user to the login page to login.
	 * 
	 */
	public function indexAction()
	{
        $this->_redirect('*/shell/desktop');
	}
	
	/**
	 * Shows the login screen and logs the user in.
	 * 
	 */
	public function loginAction()
	{
		$this->_prepareLayout();
		
        if ($this->_getApplication()->getContext()->getUser()->isAuthenticated()) {
            $this->_redirect('*');
        }
		
		if ($this->getRequest()->isPost()) {
			$email = $this->getRequest()->getParam('email');
			$password = $this->getRequest()->getParam('password');
						
			$user = Cream_Security_MembershipProvider::getUserByEmail($email, 'shell');
			
			if ($user) {
				$result = Cream_Security_AuthenticationProvider::login($user, $password);
								
				if ($result) {
					$this->_getSession()->user = $user;
					
					$this->_redirect('*');
				} else {
					throw new Exception('Password invalid');
				}
			} else {
				throw new Exception('User not found');
			}
		}
		
        $template = $this->getLayout()->createBlock('webcontrol/template');
        $template->setTemplate('index/login.phtml');
        $template->assign('cultures', $this->_getCultures());
        
        $this->getLayout()->getBlock('content')->append($template);
        $this->renderLayout();
	}
	
	/**
	 * Logs the user out and shows the logout screen.
	 * 
	 */
	public function logoutAction()
	{
		$this->_getSession()->unsetAll();
		
		$this->_prepareLayout();
		
        $template = $this->getLayout()->createBlock('webcontrol/template');
        $template->setTemplate('index/logout.phtml');
        
        $this->getLayout()->getBlock('content')->append($template);
        $this->renderLayout();		        
	}
	
	/**
	 * Shows the forgot password screen, generates a new password for
	 * the given user and e-mails the new password.
	 *  
	 */
	public function forgotpasswordAction()
	{
		$this->_prepareLayout();
		
        if ($this->_getApplication()->getContext()->getUser()->isAuthenticated()) {
            $this->_redirect('*');
        }
		
		if ($this->getRequest()->isPost()) {
			$email = $this->getRequest()->getParam('email');

			if ($email) {
				
				$user = Cream_Security_MembershipProvider::getUserByEmail($email, 'shell');
				
				if ($user) {
					$password = substr(md5(uniqid(rand(), true)), 0, 7);
					$user->changePassword($password);
					
				} else {
					WebTricks_Shell_Session::singleton()->addError('not_found', 'Cannot find the email address.');
				}
			} else {
				WebTricks_Shell_Session::singleton()->addError('empty', 'The email address is empty.');
			}
		}
		
        $template = $this->getLayout()->createBlock('webcontrol/template');
        $template->setTemplate('index/forgotpassword.phtml');
        
        $this->getLayout()->getBlock('content')->append($template);
        $this->renderLayout();		
	}
	
	public function testAction()
	{        		
		$item = $this->_getApplication()->getContext()->getRepository()->getItem(Cream_Application_ItemIds::getRootId());
		
		foreach ($item->getChildren() as $child)
		{
			print $child->getName() .' '. $child->getItemId() .'<hr>';
			foreach($child->getChildren() as $childchild) {
				print '>>>'. $childchild->getName() .'<hr>';		
					foreach($childchild->getChildren() as $childchildchild) {
						print '>>>>>>'. $childchildchild->getName() .'<hr>';			
					} 					
			} 
		}
	}
	
	/**
	 * Sets the JSON denied response
	 * 
	 */
    public function deniedJsonAction()
    {
        $this->getResponse()->setBody($this->_getDeniedJson());
    }

    /**
     * Returns an JSON encoded string to redirect the user to the
     * login page.
     * 
     * @return string
     */
    protected function _getDeniedJson()
    {
    	return Cream_Json::encode(
            array(
                'success'  => false,
                'redirect' => $this->getUrl('*/index/login')
            )
        );
    }

    /**
     * Retrieves the cultures defined for the WebTricks Shell.
     * 
     * @return array
     */
	protected function _getCultures()
	{
		$cultures = array();
		$item = $this->_getApplication()->getContext()->getRepository()->getItemByPath('webtricks/system/languages');

		foreach ($item->getChildren() as $child) {
			$cultures[] = Cream_Globalization_Culture::instance($child->getName());
		} 
		
		return $cultures;
	}
}