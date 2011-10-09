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
 * Validates a required field.
 *
 * @package		Cream_Content_Validators_FieldValidators
 * @author		Danny Verkade
 */
class Cream_Content_Validators_FieldValidators_MaxLengthValidator extends Cream_Content_Validators_Abstract
{
	protected function _evaluate()
	{
		$value = $this->getValue();
		
		if (empty($value) || !$value) {
			return Cream_Content_Validators_ValidatorResult::ERROR;			
		}
		
		return Cream_Content_Validators_ValidatorResult::VALID;
	}
}