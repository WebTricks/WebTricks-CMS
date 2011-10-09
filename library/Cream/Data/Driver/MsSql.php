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
 * MsSql database driver. This class processes all mssql queries.
 *
 * @package		Cream_Driver
 * @author		Danny Verkade
 */
class Cream_Data_Driver_MsSql extends Cream_Data_Driver 
{
	/**
	 * @var resource
	 */
	protected $_result;

	/**
	 * Connect to the database
	 *
	 * @return resource
	 */
	public function connect()
	{
		$server = $this->getConnection()->getServer();
		$database = $this->getConnection()->getDatabase();
		$username = $this->getConnection()->getUsername();
		$password = $this->getConnection()->getPassword();

		# Create Connection
		$connection = mssql_pconnect($server, $username, $password, true);

		# Check to see if connection is established
		if (!is_resource($connection)) {
			throw new Cream_Data_Driver_Exception('Database connection failed.<br>SERVER: '. $server .'<br>USERNAME: '. $username);
		}

		# Select database
		$db = mssql_select_db($database, $connection);

		# Check to see if database is selected
		if (!$db) {
			throw new Cream_Data_Driver_Exception('Database '. $database .' not available.');
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
		$this->getApplication()->getLog()->log(__CLASS__, $sql, __FILE__, __LINE__);

		// Get results
		$result = mssql_query($sql, $this->getDataConnection());

		// If a MsSql error occured throw an exception
		if (mssql_get_last_message()) {
			throw new Cream_Data_Driver_Exception(mssql_get_last_message() ."\n\n". $sql);
		}

		// Set results
		$this->_setResult($result);
	}

	/**
	 * Returns the row collection
	 *
	 * @return Cream_Data_RowCollection
	 */
	public function getRows()
	{
		$rowCollection = Cream_Data_RowCollection::instance();
		while ($row = mssql_fetch_assoc($this->getResult())) {
			$rowCollection->add(Cream_Data_Row::instance($row));
		}

		return $rowCollection;
	}

	/**
	 * Returns the number of affected rows by this query
	 *
	 * @return integer
	 */
	public function getAffectedRows()
	{
		return mssql_rows_affected($this->getDataConnection());
	}

	/**
	 * Returns the insert id
	 *
	 * @return integer
	 */
	public function getInsertId()
	{
		// TODO: get insert id
		//return mysql_insert_id($this->getDataConnection());
		throw new Cream_Exception_TodoException();
	}

	/**
	 * Returns the number of fields in this query
	 *
	 * @return integer
	 */
	public function getNumFields()
	{
		return mssql_num_fields($this->getResult());
	}

	/**
	 * Returns the number of rows of this query
	 *
	 * @return integer
	 */
	public function getNumRows()
	{
		return mssql_num_rows($this->getResult());
	}
}