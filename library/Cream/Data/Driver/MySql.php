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
 * MySQL Database driver. This driver is used to connection to a MySQL 
 * database.
 *
 * @package		Cream_Data_Driver
 * @author		Danny Verkade
 */
class Cream_Data_Driver_MySql extends Cream_Data_Driver 
{
	/**
	 * Connect to the database
	 *
	 * @return resource
	 */
	public function connect()
	{
		$server = $this->getConnection()->getHost();
		$database = $this->getConnection()->getDatabase();
		$username = $this->getConnection()->getUsername();
		$password = $this->getConnection()->getPassword();

		# Create Connection
		$connection = mysql_pconnect($server, $username, $password, true);

		# Check to see if connection is established
		if (!is_resource($connection)) {
			throw new Cream_Data_Exception_ConnectionException('Database connection failed. SERVER: '. $server .' USERNAME: '. $username);
		}

		# Select database
		$db = mysql_select_db($database, $connection);
		
		# Check to see if database is selected
		if (!$db) {
			throw new Cream_Data_Exception_ConnectionException('Database not available: '. mysql_error());
		}

		return $connection;
	}

	/**
	 * Executes a query, a query can be a Cream_Data_Statement object or
	 *
	 * @param Cream_Data_Statement $statement
	 */
	public function query($statement)
	{
		// Query, or a statement object?
		if (is_string($statement)) {
			$sql = $statement;
		} else {
			$sql = $statement->__toString();
		}

		// Log query
		//$this->_getApplication()->getLog()->log(__CLASS__, $sql, __FILE__, __LINE__);

		// Get results
		$result = mysql_query($sql, $this->getDataConnection());

		// If a MYSQL error occured throw an exception
		if (mysql_error()) {
			throw new Cream_Data_Exception_QueryException(mysql_error() ."\n\n". $sql);
		}

		// Set results
		$this->_setResult($result);
	}

	/**
	 * Returns the result rows
	 *
	 * @return Cream_Data_RowCollection
	 */
	public function getRows()
	{
		$rows = Cream_Data_RowCollection::instance();
		while ($row = mysql_fetch_assoc($this->getResult())) {
			$rows->add(Cream_Data_Row::instance($row));
		}

		return $rows;
	}

	/**
	 * Returns the number of affected rows by this query
	 *
	 * @return integer
	 */
	public function getAffectedRows()
	{
		return mysql_affected_rows($this->getDataConnection());
	}

	/**
	 * Returns the insert id
	 *
	 * @return integer
	 */
	public function getInsertId()
	{
		return mysql_insert_id($this->getDataConnection());
	}

	/**
	 * Returns the number of fields in this query
	 *
	 * @return integer
	 */
	public function getNumFields()
	{
		return mysql_num_fields($this->getResult());
	}

	/**
	 * Returns the number of rows of this query
	 *
	 * @return integer
	 */
	public function getNumRows()
	{
		return mysql_num_rows($this->getResult());
	}
}