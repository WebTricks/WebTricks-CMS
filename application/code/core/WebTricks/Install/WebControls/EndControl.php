<?php 

class WebTricks_Install_WebControls_EndControl extends Cream_Web_UI_WebControls_TemplateControl
{
    public function __init($data = null)
    {
        parent::__init($data);
        $this->setTemplate('install/end.phtml');
    }
}