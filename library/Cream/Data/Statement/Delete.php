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
 * The Cream_Data_Statement_Delete class is used to create correct 
 * SQL delete statements. For the single-table syntax, the DELETE 
 * statement deletes rows from a table.
 * 
 * The WHERE clause, if given, specifies the conditions that 
 * identify which rows to delete. With no WHERE clause, all rows 
 * are deleted.
 *
 * @package		Cream_Data_Statement
 * @author		Danny Verkade
 */
class Cream_Data_Statement_Delete extends Cream_Data_Statement
{
	/**
	 * Create an instance of this class
	 *
	 * @return Cream_Data_Statement_Delete
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}

	/**
	 * Returns a valid SQL delete statement.
	 *
	 * @return string
	 */
	public function __toString()
	{
    	// Initial SQL statement
   		$sql = "DELETE";
        $sql .= "\n\t";

        // Add tables
        if ($this->getPart(self::FROM)) {
            $sql .= "\nFROM\n\t";
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

        // with these where conditions
        if ($this->getPart(self::WHERE)) {
            $sql .= "\nWHERE\n\t";
            $sql .= implode("\n\t", $this->getPart(self::WHERE));
        }

        return $sql;
	}

	/**
	 * Set the table to be used by the query
	 *
	 * @param string|array|Sytem_Data_Expression $table
	 */
	public function from($table)
	{
		if (is_array($table)) {
            // No allowd in a delete query
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
	 * Sets a where parameter for this query
	 *
	 * @param string $condition
	 * @param string|integer|array $value
	 */
	public function where($condition, $value = null)
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
	 * Sets an or where parameter for this query
	 *
	 * @param string $condition
	 * @param string|integer|array $value
	 */
	public function orWhere($condition, $value = null)
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