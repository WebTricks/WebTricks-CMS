<?php 

class WebTricks_Install_WebControls_AdminControl extends Cream_Web_UI_WebControls_TemplateControl
{
    public function __init($data = null)
    {
        parent::__init($data);
        $this->setTemplate('install/create_admin.phtml');
    }
    
    public function getFormData()
    {
        $data = $this->getData('form_data');
        if (is_null($data)) {
        	$data = WebTricks_Install_Session::singleton()->getAdminData(true);
        	if (empty($data)) {
            	$data = new Cream_Object();
        	}
            $this->setFormData($data);
        }
        return $data;
    }
}