<?php
/**
 * WebTricks - PHP Framework
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
 * A base editor field that handles displaying/hiding on demand and has some 
 * built-in sizing and event handling logic.
 * 
 * @package		Cream_Web_UI_ExtControls
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Editor extends Cream_Web_UI_ExtControls_Component
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Editor
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}	
	
	/**
	 * Initialize function
	 *
	 */
	public function __init()
	{
		$this->setControl('Ext.Editor');
	}	
	
	/**
	 * True for the editor to automatically adopt the size of the underlying 
	 * field, "width" to adopt the width only, or "height" to adopt the height 
	 * only, "none" to always use the field dimensions. (defaults to false)
	 *
	 * @param boolean/string $autoSize
	 */
	public function setAutoSize($autoSize) 
	{
		$this->setAttribute('autoSize', $autoSize);
	}

	/**
	 * True to automatically revert the field value and cancel the edit when 
	 * the user completes an edit and the field validation fails (defaults to 
	 * true)
	 *
	 * @param boolean $revertInvalid
	 */
	public function setRevertInvalid($revertInvalid) 
	{
		$this->setAttribute('revertInvalid', $revertInvalid);
	}

	/**
	 * True to skip the edit completion process (no save, no events fired) if 
	 * the user completes an edit and the value has not changed (defaults to 
	 * false). Applies only to string values - edits for other data types will 
	 * never be ignored.
	 *
	 * @param boolean $ignoreNoChange
	 */
	public function setIgnoreNoChange($ignoreNoChange) 
	{
		$this->setAttribute('ignoreNoChange', $ignoreNoChange);
	}

	/**
	 * False to keep the bound element visible while the editor is displayed 
	 * (defaults to true)
	 *
	 * @param boolean $hideEl
	 */
	public function setHideEl($hideEl) 
	{
		$this->setAttribute('hideEl', $hideEl);
	}

	/**
	 * The data value of the underlying field (defaults to "")
	 *
	 * @param mixed $value
	 */
	public function setValue($value) 
	{
		$this->setAttribute('value', $value);
	}

	/**
	 * The position to align to (see Ext.Element.alignTo for more details, 
	 * defaults to "c-c?").
	 *
	 * @param string $alignment
	 */
	public function setAlignment($alignment) 
	{
		$this->setAttribute('alignment', $alignment);
	}
	
	/**
	 * True to complete the editing process if in edit mode when the field is 
	 * blurred. Defaults to false.
	 *
	 * @param boolean $allowBlur
	 */
	public function setAllowBlur($allowBlur) 
	{
		$this->setAttribute('allowBlur', $allowBlur);
	}

	/**
	 * "sides" for sides/bottom only, "frame" for 4-way shadow, and "drop"
	 *
	 * @param boolean/string $shadow
	 */
	public function setShadow($shadow) 
	{
		$this->setAttribute('shadow', $shadow);
	}

	/**
	 * True to constrain the editor to the viewport
	 *
	 * @param boolean $constrain
	 */
	public function setConstrain($constrain) 
	{
		$this->setAttribute('constrain', $constrain);
	}
	
	/**
	 * The Field object (or descendant) or config object for field
	 *
	 * @param Cream_Web_UI_ExtControls_Form_Field $constrain
	 */
	public function setField($field) 
	{
		$this->setAttribute('field', $field);
	}	

	/**
	 * Handle the keydown/keypress events so they don't propagate (defaults to 
	 * true)
	 *
	 * @param boolean $swallowKeys
	 */
	public function setSwallowKeys($swallowKeys) 
	{
		$this->setAttribute('swallowKeys', $swallowKeys);
	}

	/**
	 * True to complete the edit when the enter key is pressed (defaults to 
	 * false)
	 *
	 * @param boolean $completeOnEnter
	 */
	public function setCompleteOnEnter($completeOnEnter) 
	{
		$this->setAttribute('completeOnEnter', $completeOnEnter);
	}

	/**
	 * True to cancel the edit when the escape key is pressed (defaults to 
	 * false)
	 *
	 * @param boolean $cancelOnEsc
	 */
	public function setCancelOnEsc($cancelOnEsc) 
	{
		$this->setAttribute('cancelOnEsc', $cancelOnEsc);
	}

	/**
	 * True to update the innerHTML of the bound element when the update 
	 * completes (defaults to false)
	 *
	 * @param boolean $updateEl
	 */
	public function setUpdateEl($updateEl) 
	{
		$this->setAttribute('updateEl', $updateEl);
	}
	
	/**
	 * The offsets to use when aligning (see Ext.Element.alignTo for more 
	 * details. Defaults to [0, 0].
	 *
	 * @param array $offsets
	 */
	public function setOffsets($offsets) 
	{
		$this->setAttribute('offsets', $offsets);
	}	
}