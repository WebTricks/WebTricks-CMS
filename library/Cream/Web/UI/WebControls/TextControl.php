<?php

class Cream_Web_UI_WebControls_TextControl extends Cream_Web_UI_WebControl
{
    public function setText($text)
    {
        $this->_setData('text', $text);
    }

    public function getText()
    {
        return $this->_getData('text');
    }

    public function addText($text, $before = false)
    {
        if ($before) {
            $this->setText($text . $this->getText());
        } else {
            $this->setText($this->getText() . $text);
        }
    }

    protected function _toHtml()
    {
        if (!$this->_beforeToHtml()) {
            return '';
        }
        
        return $this->getText();
    }
}