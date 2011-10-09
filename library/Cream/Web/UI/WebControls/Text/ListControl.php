<?php

class Cream_Web_UI_WebControls_Text_ListControl extends Cream_Web_UI_WebControls_TextControl
{
    protected function _toHtml()
    {
        $this->setText('');
        foreach ($this->getSortedChildren() as $name) {
            $block = $this->getLayout()->getBlock($name);
            if (!$block) {
                throw new Cream_Exceptions_Exception('Invalid block: %s', $name);
            }
            $this->addText($block->toHtml());
        }
        return parent::_toHtml();
    }
}