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
 * Class to create correct SQL replace statements. REPLACE works exactly
 * like INSERT, except that if an old row in the table has the same 
 * value as a new row for a PRIMARY KEY or a UNIQUE index, the old row 
 * is deleted before the new row is inserted. REPLACE is a MySQL 
 * extension to the SQL standard. It either inserts, or deletes and 
 * inserts.
 * 
 * Note that unless the table has a PRIMARY KEY or UNIQUE index, using 
 * a REPLACE statement makes no sense. It becomes equivalent to INSERT, 
 * because there is no index to be used to determine whether a new row 
 * duplicates another. 
 *
 * @package		Cream_Data_Statement
 * @author		Danny Verkade
 */
class Cream_Data_Statement_Replace extends Cream_Data_Statement
{
	/**
	 * Create an instance of this class
	 *
	 * @return Cream_Data_Statement_Replace
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}

	/**
	 * Convert query object to a string
	 *
	 * @return string
	 */
	public function __toString()
	{
    	// Initial statement
   		$sql = "REPLACE";
        $sql .= "\n\t";

        // Add tables
        if ($this->getPart(self::FROM)) {
            $sql .= "\nINTO\n\t";
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

        // Add columns
        if ($this->getPart(self::VALUES)) {
        	$sql .= ' (';
        	$l = array();
        	foreach($this->getPart(self::VALUES) as $column) {
				$l[] = $this->quoteColumn($column['column']);
        	}
        	$sql .= implode(",\n\t", $l);
        	$sql .= ')';
        }

        // Add values
        if ($this->getPart(self::VALUES)) {
        	$sql .= ' VALUES (';
        	$l = array();

			foreach($this->getPart(self::VALUES) as $value) {
					$l[] = $this->quoteValue($value['value']);
			}

        	$sql .= implode(",\n\t", $l);
        	$sql .= ')';
        }

        return $sql;
	}

	/**
	 * Add the table
	 *
	 * @param array|string|Cream_Expression $table
	 */
	public function into($table)
	{
		if (is_array($table)) {
            // Must be array($correlationName => $tableName) or array($ident, ...)
            foreach ($table as $correlationName => $tableName) {
                if (!is_string($correlationName)) {
                	// Gaat hier om een nummerieke array, er is geen correlatie aanwezig
                    $correlationName = '';
                }
                break;
            }
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
	 * Set the values to replace in the table. Accepts an array, where the keys
	 * of the array are the column names and the values of the array will be
	 * the values to insert in the DB. Example:
	 * 
	 * $columns = array(
	 *  'columnName' = $value,
	 *  'columnName' = Cream_Expression::instance('NOW()')
	 * );
	 *
	 * @param array $values
	 */
	public function values($values)
	{
        foreach ($values as $column => $value) {
            $this->addPart(self::VALUES, array("value" => $value, "column" => $column));
        }
	}
}