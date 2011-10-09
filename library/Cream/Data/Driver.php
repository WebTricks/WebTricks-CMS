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
 * Abstract base class for all SQL Database drivers.
 *
 * @package		Cream_Data
 * @author		Danny Verkade
 */
abstract class Cream_Data_Driver extends Cream_ApplicationComponent
{
	/**
	 * @var Cream_Data_Connection
	 */
	protected $_connection;

	/**
	 * @var resource
	 */
	protected $_dataConnection;

	/**
	 * @var resource
	 */
	protected $_result;

	/**
	 * Initialize function
	 *
	 * @param Cream_Data_Connection $connection
	 */
	public function __init($connection)
	{
		$this->connection = $connection;
	}

	/**
	 * Establish the connection to the database
	 *
	 */
	abstract function connect();

	/**
	 * Execute a SQL statement
	 *
	 * @param Cream_Data_Statement $statement
	 */
	abstract function query($statement);

	/**
	 * Returns the number of rows affected by the query
	 *
	 * @return integer
	 */
	abstract function getAffectedRows();

	/**
	 * Returns the insert ID when an insert SQL statement is executed, otherwise
	 * returns NULL.
	 *
	 * @return integer
	 */
	abstract function getInsertId();

	/**
	 * Returns the number of rows in the resultset of the query
	 *
	 * @return integer
	 */
	abstract function getNumRows();

	/**
	 * Returns the number of fields in the resultset of the query
	 *
	 * @return integer
	 */
	abstract function getNumFields();

	/**
	 * Returns a collection of row objects
	 *
	 * @return Cream_Data_RowCollection
	 */
	abstract function getRows();

	/**
	 * Sets the connection resource to the database
	 *
	 * @param resource $connection
	 */
	public function setDataConnection($dataConnection)
	{
		$this->dataConnection = $dataConnection;
	}

	/**
	 * Returns the connection resource to the database
	 *
	 * @return resource
	 */
	public function getDataConnection()
	{
		if (!$this->isDataConnected()) {
			$this->_dataConnection = $this->connect();
		}

		return $this->_dataConnection;
	}

	/**
	 * Check to see if database is connected. Returns true if a connection is
	 * established, otherwise return false.
	 *
	 * @return integer
	 */
	public function isDataConnected()
	{
		if (is_resource($this->_dataConnection)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Returns the Cream_Data_Connection object this driver belongs too.
	 *
	 * @return Cream_Data_Connection
	 */
	public function getConnection()
	{
		return $this->connection;
	}

	/**
	 * Returns the query result resource
	 *
	 * @return resource
	 */
	public function getResult()
	{
		return $this->_result;
	}

	/**
	 * Sets the query result resource
	 *
	 * @param resource $result
	 */
	protected function _setResult($result)
	{
		$this->_result = $result;
	}

	/**
	 * Clears the query result resource, so it will be ready for a new query.
	 *
	 */
	public function clear()
	{
		$this->_result = null;
	}
}