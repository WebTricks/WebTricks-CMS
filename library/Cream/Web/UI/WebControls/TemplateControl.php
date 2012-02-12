<?php

class Cream_Web_UI_WebControls_TemplateControl extends Cream_Web_UI_WebControl
{

    /**
     * View scripts directory
     *
     * @var string
     */
    protected $_viewDir = '';

    /**
     * Assigned variables for view
     *
     * @var array
     */
    protected $_viewVars = array();

    /**
     * Path to template file in theme.
     *
     * @var string
     */
    protected $_template;

    /**
     * Create a new instance of this class.
     *
     * @return Cream_Web_UI_WebControls_TemplateControl
     */
    public static function instance($data = null)
    {
    	return Cream::instance(__CLASS__, $data);
    }
    
    /**
     * Internal constructor, that is called from real constructor
     *
     */
    public function __init($data = null)
    {
        parent::__init($data);

        /*
         * In case template was passed through constructor
         * we assign it to block's property _template
         * Mainly for those cases when block created
         * not via Cream_Layout::addBlock()
         */
        //if ($this->_hasData('template')) {
        //    $this->setTemplate($this->_getData('template'));
        //}
    }

    /**
     * Get relevant path to template
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->_template;
    }

    /**
     * Set path to template used for generating block's output.
     *
     * @param string $template
     * @return void
     */
    public function setTemplate($template)
    {
        $this->_template = $template;
    }

    /**
     * Get absolute path to template
     *
     * @return string
     */
    public function getTemplateFile()
    {
        $params = array('_relative'=>true);
        $area = $this->getArea();
        if ($area) {
            $params['_area'] = $area;
        }
        $templateName = $this->getLayout()->getController()->getDesign()->getTemplateFilename($this->getTemplate(), $params);
        return $templateName;
    }

    /**
     * Get design area
     * @return string
     */
    public function getArea()
    {
        //return $this->_getData('area');
    }

    /**
     * Assign variable
     *
     * @param   string|array $key
     * @param   mixed $value
     * @return  void
     */
    public function assign($key, $value=null)
    {
        if (is_array($key)) {
            foreach ($key as $k=>$v) {
                $this->assign($k, $v);
            }
        }
        else {
            $this->_viewVars[$key] = $value;
        }
    }

    /**
     * Set template location dire
     *
     * @param string $dir
     * @return void
     */
    public function setScriptPath($dir)
    {
        $this->_viewDir = $dir;
    }

    /**
     * Check if dirrect output is allowed for block
     * @return bool
     */
    public function getDirectOutput()
    {
        if ($this->getLayout()) {
            return $this->getLayout()->getDirectOutput();
        }
        return false;
    }

    /**
     * Retrieve block view from file (template)
     *
     * @param   string $fileName
     * @return  string
     */
    public function fetchView($fileName)
    {
        extract ($this->_viewVars);
        $do = $this->getDirectOutput();

        if (!$do) {
            ob_start();
        }

        try {
            include $this->_viewDir . DS . $fileName;
        } catch (Exception $e) {
            ob_get_clean();
            throw $e;
        }

        if (!$do) {
            $html = ob_get_clean();
        } else {
            $html = '';
        }

        return $html;
    }

    /**
     * Render block
     *
     * @return string
     */
    public function renderView()
    {
        $this->setScriptPath($this->_getApplication()->getOptions()->getDesignDir());
        $html = $this->fetchView($this->getTemplateFile());
        return $html;
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (!$this->getTemplate()) {
            return '';
        }
        $html = $this->renderView();
        return $html;
    }
}