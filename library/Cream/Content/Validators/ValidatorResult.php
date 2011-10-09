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
 * Class holding validator result constants
 *
 * @package		Cream_Content
 * @author		Danny Verkade
 */
class Cream_Content_Validators_ValidatorResult
{
	/**
	 * Validation result not known.
	 *  
	 * @var integer
	 */
	const UNKNOWN = 0;

	/**
	 * Validator is valid.
	 * 
	 * @var integer
	 */
	const VALID = 1;
	
	/**
	 * Validator has a suggestion.
	 * 
	 * @var integer
	 */
	const SUGGESTION = 2;
	
	/**
	 * Validator has a warning.
	 * 
	 * @var integer
	 */
	const WARNING = 3;
	
	/**
	 * Validator has an error.
	 * 
	 * @var integer
	 */
	const ERROR = 4;
}