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
 * Class to create correct SQL update statements
 *
 * @package		Cream_Data_Statement
 * @author		Danny Verkade
 */
class Cream_Data_Statement_Update extends Cream_Data_Statement
{
	/**
	 * Create an instance of this class
	 *
	 * @return Cream_Data_Statement_Update
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}

    /**
     * Converteert dit object naar een SQL SELECT statement.
     *
     * @return string SQL SELECT statement
     */
    public function __toString()
    {
    	// Initiele select en eventueel distinct
   		$sql = "UPDATE";
        $sql .= "\n\t";

        // Voeg tabellen toe
        if ($this->getPart(self::FROM)) {
        	$l = array();
        	foreach($this->getPart(self::FROM) as $table) {
				if ($table['alias']) {
					$l[] = $this->quoteColumn($table['table']) ." AS ". $table['alias'];
				} else {
					$l[] = $this->quoteColumn($table['table']);
				}
        	}
        	$sql .= implode(",\n\t", $l);
        }

        // Voeg kolommen toe
        if ($this->getPart(self::SET)) {
            $sql .= "\nSET\n\t";
        	$l = array();
        	foreach($this->getPart(self::SET) as $column) {
				$l[] = $this->quoteColumn($column['column']) .' = '. $this->quoteValue($column['value']);
        	}
        	$sql .= implode(",\n\t", $l);
        }

        // with these where conditions
        if ($this->getPart(self::WHERE)) {
            $sql .= "\nWHERE\n\t";
            $sql .= implode("\n\t", $this->getPart(self::WHERE));
        }

        return $sql;
    }

    /**
	 * Set the table to update
	 *
	 * @param string|array|Sytem_Data_Expression $table
	 */
	public function from($table)
	{
		if (is_array($table)) {
            // Mag niet bij een delete query
        } else if ($table instanceof Cream_Expression) {
            $tableName = $table;
            $correlationName = '';
        } else if (preg_match('/^(.+)\s+AS\s+(.+)$/i', $table, $m)) {
            $tableName = $m[1];
            $correlationName = $m[2];
        } else {
            $tableName = $table;
            $correlationName = '';
        }

        $this->addPart(self::FROM, array("alias" => $correlationName, "table" => $table));
	}

	/**
	 * Set the column to update and its value
	 *
	 * @param string $condition
	 * @param string|array|Cream_Expression $value
	 */
	public function set ($column, $value)
	{
		$this->addPart(self::SET, array("column" => $column, "value" => $value));
	}

	/**
	 * Add a where condition to the statement
	 *
	 * @param string $condition
	 * @param string|array|Cream_Expression $value
	 */
	public function where ($condition, $value = null)
	{
        if ($value !== null) {
            $condition = $this->quoteInto($condition, $value);
        }

        if ($this->getPart(self::WHERE)) {
            $this->addPart(self::WHERE, "AND ($condition)");
        } else {
            $this->addPart(self::WHERE, "($condition)");
        }
	}

	/**
	 * Add an or where condition to the statement. 
	 *
	 * @param string $condition
	 * @param string|array|Cream_Expression $value
	 */
	public function orWhere ($condition, $value = null)
	{
        if ($value !== null) {
            $condition = $this->quoteInto($condition, $value);
        }

        if ($this->getPart(self::WHERE)) {
            $this->addPart(self::WHERE, "OR ($condition)");
        } else {
            $this->addPart(self::WHERE, "($condition)");
        }
	}
}