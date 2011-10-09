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
 * Result class represents the results of a database query
 *
 * @package		Cream_Data
 * @author		Danny Verkade
 */
class Cream_Data_Result extends Cream_Component
{
	/**
	 * @var integer
	 */
	protected $_affectedRows;

	/**
	 * @var integer
	 */
	protected $_insertId;

	/**
	 * @var integer
	 */
	protected $_numFields;

	/**
	 * @var integer
	 */
	protected $_numRows;

	/**
	 * @var Cream_Data_Statement
	 */
	protected $_statement;

	/**
	 * @var Cream_Data_RowCollection
	 */
	protected $_rows;

	/**
	 * Creates an instance of this class
	 *
	 * @return Cream_Data_Result
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}

	/**
	 * Geeft aantal rijen dat gewijzigd is terug van de query.
	 *
	 * @return integer
	 */
	public function getAffectedRows()
	{
		return $this->_affectedRows;
	}

	/**
	 * Zet het aantal gewijzigde rijen van de query
	 *
	 * @param integer $affectedRows
	 */
	public function setAffectedRows($affectedRows)
	{
		$this->_affectedRows = $affectedRows;
	}

	/**
	 * Geeft het id terug van de primary key van een INSERT statement
	 *
	 * @return integer
	 */
	public function getInsertId()
	{
		return $this->_insertId;
	}

	/**
	 * Zet het insert id van de primary key
	 *
	 * @param integer $insertId
	 */
	public function setInsertId($insertId)
	{
		$this->_insertId = $insertId;
	}

	/**
	 * Geeft het aantal velden van de result set terug
	 *
	 * @return integer
	 */
	public function getNumFields()
	{
		return $this->_numFields;
	}

	/**
	 * Zet het aantal velden van de result set
	 *
	 * @param integer $numFields
	 */
	public function setNumFields($numFields)
	{
		$this->_numFields = $numFields;
	}

	/**
	 * Geeft het aantal rijen in de resultset terug
	 *
	 * @return integer
	 */
	public function getNumRows()
	{
		return $this->_numRows;
	}

	/**
	 * Zet het aantal rijen uit de result set
	 *
	 * @param integer $numRows
	 */
	public function setNumRows($numRows)
	{
		$this->_numRows = $numRows;
	}

	/**
	 * Geeft het statement object terug dat is gebruikt voor het uitvoeren
	 * van de query
	 *
	 * @return Cream_Data_Statement
	 */
	public function getStatement()
	{
		return $this->_statement;
	}

	/**
	 * Zet het statement object dat is gebruikt voor het uitvoeren van de query
	 *
	 * @param Cream_Data_Statement $statement
	 */
	public function setStatement($statement)
	{
		$this->_statement = $statement;
	}

	/**
	 * Returns the collection of result rows
	 *
	 * @return Cream_Data_RowCollection
	 */
	public function getRows()
	{
		return $this->_rows;
	}

	/**
	 * Sets the row collection
	 *
	 * @param Cream_Data_RowCollection $rows
	 */
	public function setRows(Cream_Data_RowCollection $rows)
	{
		$this->_rows = $rows;
	}

	/**
	 * Returns the first row of the result set
	 *
	 * @return Cream_Data_Row
	 */
	public function getRow()
	{
		return $this->getRows()->getRow(0);
	}
}