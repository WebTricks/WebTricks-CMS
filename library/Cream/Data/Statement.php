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
 * Base class for all statements.
 *
 * @package		Cream_Data
 * @author		Danny Verkade
 */
class Cream_Data_Statement
{
	const DISTINCT     		= 'distinct';
    const FOR_UPDATE   		= 'forupdate';
    const COLUMNS      		= 'columns';
    const FROM         		= 'from';
    const WHERE        		= 'where';
    const GROUP_BY     		= 'group';
    const HAVING       		= 'having';
    const ORDER_BY     		= 'order by';
    const LIMIT_COUNT  		= 'limitcount';
    const LIMIT_OFFSET 		= 'limitoffset';

    const JOIN 		   		= 'join';

    const INNER_JOIN   		= 'INNER JOIN';
    const LEFT_JOIN    		= 'LEFT JOIN';
    const LEFTOUTER_JOIN	= 'LEFT OUTER JOIN';
    const RIGHT_JOIN   		= 'right join';
    const FULL_JOIN    		= 'full join';
    const CROSS_JOIN   		= 'cross join';
    const NATURAL_JOIN 		= 'natural join';

    const INTO         		= 'into';
    const VALUES       		= 'values';
    const SET          		= 'set';

	/**
	 * @var array
	 */
    protected $_parts = array();

    /**
     * Set query part
     *
     * @param string $part
     * @param mixed $value
     */
    protected function setPart($part, $value)
    {
		$this->_parts[$part] = $value;
    }

    /**
     * Add a query part
     *
     * @param string $part
     * @param mixed $value
     */
    protected function addPart($part, $value)
    {
    	$this->_parts[$part][] = $value;
    }

    /**
     * Get a query part
     *
     * @param string $part
     * @return mixed
     */
    protected function getPart($part)
    {
        $part = strtolower($part);
        if (!array_key_exists($part, $this->_parts)) {
			return;
        }
        return $this->_parts[$part];
    }

    /**
     * Verwijderd de query of een gedeelte daarvan.
     *
     * Wanneer er geen argumenten worden meegegeven zal de gehele query worden
     * verwijderd. Indien een $part wordt meegegeven zal alleen het desbetreffende
     * gedeelte van de query verwijderd worden.
     *
     * @param null|string $part naam van het te verwijderen gedeelte van de query.
     */
    public function reset($part = null)
    {
    	if ($part == null) {
			$this->_parts = array();
    	} else if (array_key_exists($part, $this->_parts)) {
    		unset($this->_parts[$part]);
    	}
    }

    /**
     * Maakt van een waarde een veilig geescapte waarde voor de query.
     *
     * @param string|integer $value
     * @return string|integer
     */
    protected function quoteValue($value)
    {
    	$val = null;

        if ($value instanceof Cream_Expression) {
            return $value->__toString();
        }

        if (is_array($value)) {
            foreach ($value as &$val) {
                $val = $this->quoteValue($val);
            }
            return '('. implode(', ', $value) .')';
        }

		if (is_int($value) || is_float($value)) {
            return $value;
        }

        //return "'". addcslashes($value, "\000\n\r\\'\"\032") ."'";
        return "'". addslashes($value) ."'";
    }

    /**
     * Vervangt een ? in een query gedeelte met de opgegeven value.
     *
     * @param string $text
     * @param string|integer $value
     * @return string
     */
    protected function quoteInto($text, $value)
    {
        return str_replace('?', $this->quoteValue($value), $text);
    }

    /**
     * Zorgt voor een correct gequote kolom
     *
     * @param string $value
     * @return string
     */
    protected function quoteColumn($value)
    {
    	$val = null;

		if ($value instanceof Cream_Expression) {
            return $value->__toString();
        }

        if (is_array($value)) {
            foreach ($value as &$val) {
                $val = $this->quoteColumn($val);
            }
            return implode(', ', $value);
        }

        if ($value == '*') {
        	return $value;
        } else {
        	//return "`". addcslashes($value, "\000\n\r\\'\"\032") ."`";
        	return "`". addslashes($value) ."`";
        }
    }
}