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
 * @copyright Copyright (c) 2007-2011 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * HTML select element control.
 *
 * @package		Cream_Web_UI_HtmlControls
 * @author		WebTricks Core Team <core@webtricksframework.com>
 */
class Cream_Web_UI_HtmlControls_SelectControl extends Cream_Web_UI_HtmlControl
{

    protected $_options = array();

    public function getOptions()
    {
        return $this->_options;
    }

    public function setOptions($options)
    {
        $this->_options = $options;
        return $this;
    }

    public function addOption($value, $label, $params=array())
    {
        $this->_options[] = array('value'=>$value, 'label'=>$label);
        return $this;
    }

    public function setId($id)
    {
        $this->_setData('id', $id);
        return $this;
    }

    public function setClass($class)
    {
        $this->_setData('class', $class);
        return $this;
    }

    public function setTitle($title)
    {
        $this->_setData('title', $title);
        return $this;
    }

    public function getId()
    {
        return $this->_getData('id');
    }

    public function getClass()
    {
        return $this->_getData('class');
    }

    public function getTitle()
    {
        return $this->_getData('title');
    }

    protected function _toHtml()
    {
        if (!$this->_beforeToHtml()) {
            return '';
        }

        $html = '<select name="'.$this->getName().'" id="'.$this->getId().'" class="'
            .$this->getClass().'" title="'.$this->getTitle().'" '.$this->getExtraParams().'>';
        $values = $this->getValue();

        if (!is_array($values)){
            if (!is_null($values)) {
                $values = array($values);
            } else {
                $values = array();
            }
        }

        $isArrayOption = true;
        foreach ($this->getOptions() as $key => $option) {
            if ($isArrayOption && is_array($option)) {
                $value = $option['value'];
                $label = $option['label'];
            }
            else {
                $value = $key;
                $label = $option;
                $isArrayOption = false;
            }

            if (is_array($value)) {
                $html.= '<optgroup label="'.$label.'">';
                foreach ($value as $keyGroup => $optionGroup) {
                    if (!is_array($optionGroup)) {
                        $optionGroup = array(
                            'value' => $keyGroup,
                            'label' => $optionGroup
                        );
                    }
                    $html.= $this->_optionToHtml(
                        $optionGroup,
                        in_array($optionGroup['value'], $values)
                    );
                }
                $html.= '</optgroup>';
            } else {
                $html.= $this->_optionToHtml(array(
                    'value' => $value,
                    'label' => $label
                ),
                    in_array($value, $values)
                );
            }
        }
        $html.= '</select>';
        return $html;
    }

    protected function _optionToHtml($option, $selected = false)
    {
        $selectedHtml = $selected ? ' selected="selected"' : '';
        if ($this->getIsRenderToJsTemplate() === true) {
            $selectedHtml .= ' #{option_extra_attr_' . self::calcOptionHash($option['value']) . '}';
        }
        $html = '<option value="'.$this->escapeHtml($option['value']).'"'.$selectedHtml.'>'.$this->escapeHtml($option['label']).'</option>';

        return $html;
    }

    public function getHtml()
    {
        return $this->toHtml();
    }

    public function calcOptionHash($optionValue)
    {
        return sprintf('%u', crc32($this->getName() . $this->getId() . $optionValue));
    }
}