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
 * Class to create correct SQL select statements. SELECT is used to 
 * retrieve rows selected from one or more tables, and can include 
 * UNION statements and subqueries
 *
 * @package		Cream_Data_Statement
 * @author		Danny Verkade
 */
class Cream_Data_Statement_Select extends Cream_Data_Statement
{
	/**
	 * Create an instance of this class
	 *
	 * @return Cream_Data_Statement_Select
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}

    /**
     * Convert this object to a correct SQL statement
     *
     * @return string SQL SELECT statement
     */
    public function __toString()
    {

    	// Initial select and distinct
   		$sql = "SELECT";
        if ($this->getPart(self::DISTINCT)) {
            $sql .= ' DISTINCT';
        }
        $sql .= "\n\t";

        // Add columns
        if ($this->getPart(self::COLUMNS)) {
        	$l = array();
        	foreach($this->getPart(self::COLUMNS) as $column) {
        		if ($column['tableName'] && $column['alias']) {
					$l[] = $this->quoteColumn($column['tableName']) .".". $this->quoteColumn($column['column']) ." AS ". $this->quoteColumn($column['alias']);
        		} elseif ($column['tableName']) {
					$l[] = $this->quoteColumn($column['tableName']) .".". $this->quoteColumn($column['column']);
        		} elseif ($column['alias']) {
					$l[] = $this->quoteColumn($column['column']) ." AS ". $this->quoteColumn($column['alias']);
				} else {
					$l[] = $this->quoteColumn($column['column']);
				}
        	}
        	$sql .= implode(",\n\t", $l);
        }

        // Add the tables
        if ($this->getPart(self::FROM)) {
            $sql .= "\nFROM\n\t";
        	$l = array();
        	foreach($this->getPart(self::FROM) as $table) {
				if ($table['alias']) {
					$l[] = $this->quoteColumn($table['table']) ." AS ". $this->quoteColumn($table['alias']);
				} else {
					$l[] = $this->quoteColumn($table['table']);
				}
        	}
        	$sql .= implode(",\n\t", $l);
        }

        // Add the joins
        if ($this->getPart(self::JOIN)) {
        	$l = array();

        	foreach($this->getPart(self::JOIN) as $join) {

        		if (isset($join['alias'])) {
        			$l[] = "\n". $join['type'] . "\n\t ". $this->quoteColumn($join['table']) ." AS ". $this->quoteColumn($join['alias']);
        		} else {
        			$l[] = "\n". $join['type'] . "\n\t ". $this->quoteColumn($join['table']);
        		}

        		$l[] = "ON\n\t". $this->quoteColumn($join['correlation'][0]['alias']) .".". $this->quoteColumn($join['correlation'][0]['column']) ." = ". $this->quoteColumn($join['correlation'][1]['alias']) .".". $this->quoteColumn($join['correlation'][1]['column']);

        		if(!empty($join['and'])) {
        			if(!empty($join['value']))
        				$and = $this->quoteInto($join['and'], $join['value']);
        			else
        				$and = $join['and'];

        			$l[] = "AND ". $and;
        		}
        	}

        	$sql .= implode("\n", $l);
        }


        // with these where conditions
        if ($this->getPart(self::WHERE)) {
            $sql .= "\nWHERE\n\t";
            $sql .= implode("\n\t", $this->getPart(self::WHERE));
        }

        // grouped by these columns
        if ($this->getPart(self::GROUP_BY)) {
            $sql .= "\nGROUP BY\n\t";
            $l = array();
            foreach ($this->getPart(self::GROUP_BY) as $column) {
            	if ($column['alias']) {
                	$l[] = $this->quoteColumn($column['alias']) .".". $this->quoteColumn($column['column']);
            	} else {
            		$l[] = $this->quoteColumn($column['column']);
            	}
            }
            $sql .= implode(",\n\t", $l);
        }

        // having these conditions
        if ($this->getPart(self::HAVING)) {
            $sql .= "\nHAVING\n\t";
            $sql .= implode("\n\t", $this->getPart(self::HAVING));
        }

        // ordered by these columns
        if ($this->getPart(self::ORDER_BY)) {
            $sql .= "\nORDER BY\n\t";
            $l = array();
            foreach ($this->getPart(self::ORDER_BY) as $column) {
                if (is_array($column)) {
                	if ($column['alias']) {
                    	$l[] = $this->quoteColumn($column['alias']) .".". $this->quoteColumn($column['column']) .' '. $column['order'];
                	} else {
                     	$l[] = $this->quoteColumn($column['column']) .' '. $column['order'];
                	}
                } else {
                    $l[] = $this->quoteColumn($column);
                }
            }
            $sql .= implode(",\n\t", $l);
        }

        // limit
        if ($this->getPart(self::LIMIT_COUNT) != "") {
            $sql .= "\nLIMIT \n\t";
            $sql .= $this->getPart(self::LIMIT_OFFSET);

             if ($this->getPart(self::LIMIT_COUNT)) {
             	$sql .= ",";
             	$sql .= $this->getPart(self::LIMIT_COUNT);
             }
        }

		return $sql;
    }

	/**
	 * Set the distinct flag
	 *
	 * @param boolean $flag
	 */
	public function distinct($flag = true)
	{
		$this->setPart(self::DISTINCT, $flag);
	}

	/**
	 * Selects the columns should be returned to the resultset and on 
	 * which tables the query should be performed on.
	 *
	 * @param string|array|Sytem_Data_Expression $table
	 * @param string|array $columns
	 */
	public function from($table, $columns = null)
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
        
        $this->addPart(self::FROM, array("alias" => $correlationName, "table" => $tableName));
        
		if ($columns == null) {
			$columns = Cream_Expression::instance('*');
		}

        if (!is_array($columns)) {
            $columns = array($columns);
        }

        foreach ($columns as $key => $column) {

			$alias = '';
			$tableName = $correlationName;

        	if (is_string($column)) {
                // Check for a column matching "<column> AS <alias>" and extract the alias name
                if (preg_match('/^(.+)\s+AS\s+(.+)$/i', $column, $m)) {
                    $column = $m[1];
                    $alias = $m[2];
                }
                // Check for columns that look like functions and convert to Cream_Expression
                if (preg_match('/\(.*\)/', $column)) {
                    $column = Cream_Expression::instance($column);
                } elseif (preg_match('/(.+)\.(.+)/', $column, $m)) {
                    $tableName = $m[1];
                    $column = $m[2];
                }
            }
            $this->addPart(self::COLUMNS, array("tableName" => $tableName, "alias" => $alias, "column" => $column));
        }       
	}

	/**
	 * Add a join to the statement
	 *
	 * @param string $type
	 * @param string|array|Cream_Expression $table
	 * @param string|array|Cream_Expression $correlation
	 */
	private function join($type, $table, $correlation, $and = "", $value = "")
	{
		$columns = array();

		foreach($correlation as $column) {
			$alias = $table;

			if (preg_match('/(.+)\.(.+)/', $column, $m)) {
				$alias = $m[1];
				$column = $m[2];
			}

			array_push($columns, array('column' => $column, 'alias' => $alias));
		}

		$alias = "";

		if (preg_match('/^(.+)\s+AS\s+(.+)$/i', $table, $m)) {
            $alias = $m[2];
            $table = $m[1];
        } else {
        	$alias = $table;
        }

		$this->addPart(self::JOIN, array("type" => $type, "alias" => $alias, "table" => $table, "correlation" => $columns, "and" => $and, "value" => $value));
	}

	/**
	 * Add an inner join to the statement
	 *
	 * @param string|array $table
	 * @param array $correlation
	 */
	public function innerJoin($table, $correlation, $and = '', $value = '')
	{
		$this->join(self::INNER_JOIN, $table, $correlation, $and, $value);
	}

	/**
	 * Add an outer join to the statement
	 *
	 * @param string|array $table
	 * @param array $correlation
	 */
	public function outerJoin($table, $correlation, $and = '', $value = '')
	{
		$this->join(self::RIGHT_JOIN, $table, $correlation, $and, $value);
	}

	/**
	 * Add a left outer join to the statement
	 *
	 * @param string|array $table
	 * @param array $correlation
	 */
	public function leftOuterJoin($table, $correlation, $and = '', $value = '')
	{
		$this->join(self::LEFTOUTER_JOIN, $table, $correlation, $and, $value);
	}

	/**
	 * Add a left join to the statement
	 *
	 * @param string|array $table
	 * @param array $correlation
	 */
	public function leftJoin($table, $correlation, $and = '', $value = '')
	{
		$this->join(self::LEFT_JOIN, $table, $correlation, $and, $value);
	}

	/**
	 * Add a right join to the statement
	 *
	 * @param string|array $table
	 * @param array $correlation
	 */
	public function rightJoin($table, $correlation, $and = '', $value = '')
	{
		$this->join(self::RIGHT_JOIN, $table, $correlation, $and, $value);
	}

	/**
	 * Add a full join to the statement
	 *
	 * @param string|array $table
	 * @param array $correlation
	 */
	public function fullJoin($table, $correlation, $and = '', $value = '')
	{
		$this->join(self::FULL_JOIN, $table, $correlation, $and, $value);
	}

	/**
	 * Add a cross join to the statement
	 *
	 * @param string|array $table
	 * @param array $correlation
	 */
	public function crossJoin($table, $correlation, $and = '', $value = '')
	{
		$this->join(self::CROSS_JOIN, $table, $correlation, $and, $value);
	}

	/**
	 * Add a natural join to the statement
	 *
	 * @param string|array $table
	 * @param array $correlation
	 */
	public function naturalJoin($table, $correlation, $and = '', $value = '')
	{
		$this->join(self::NATURAL_JOIN, $table, $correlation, $and, $value);
	}

	/**
	 * Add a where condition to the statement.
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
	 * Add a or where condition to the statement
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

	/**
	 * Add an having condition to the statement
	 *
	 * @param string $condition
	 * @param string|array|Cream_Expression $value
	 */
	public function having ($condition, $value = null)
	{
        if ($value !== null) {
            $condition = $this->quoteInto($condition, $value);
        }

        if ($this->getPart(self::HAVING)) {
            $this->addPart(self::HAVING, "AND ($condition)");
        } else {
            $this->addPart(self::HAVING, "($condition)");
        }
	}

	/**
	 * Add an or having condition to the statement
	 *
	 * @param string $condition
	 * @param string|array|Cream_Expression $value
	 */
	public function orHaving ($condition, $value = null)
	{
        if ($value !== null) {
            $condition = $this->quoteInto($condition, $value);
        }

        if ($this->getPart(self::HAVING)) {
            $this->addPart(self::HAVING, "AND ($condition)");
        } else {
            $this->addPart(self::HAVING, "($condition)");
        }
	}

	/**
	 * Add a group by to the statament
	 *
	 * @param string $column
	 */
	public function groupBy($column)
	{
		$alias = '';

		if (preg_match('/(.+)\.(.+)/', $column, $m)) {
	        $alias = $m[1];
	        $column = $m[2];
        }

		$this->addPart(self::GROUP_BY, array('alias' => $alias, 'column' => $column));
	}

	/**
	 * Sets the ordering of the results
	 *
	 * @param string $column
	 * @param string $order ASC of DESC
	 */
	public function orderBy ($column, $order = "ASC")
	{
		$alias = '';

		if (!Cream::isInstanceOf($column, 'Cream_Expression')) {
			if (preg_match('/(.+)\.(.+)/', $column, $m)) {
				$alias = $m[1];
				$column = $m[2];
	        }
		}

		$this->addPart(self::ORDER_BY, array("alias" => $alias, "column" => $column, "order" => $order));
	}

	/**
	 * Set which rows to fetch
	 *
	 * @param integer $offset
	 * @param integer $count
	 */
	public function limit ($offset = null, $count = null)
	{
        $this->setPart(self::LIMIT_COUNT, $count);
        $this->setPart(self::LIMIT_OFFSET, $offset);
	}
}