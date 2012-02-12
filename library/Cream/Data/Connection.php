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
 * The Connection class represents a connection to a database.
 *
 * Connection works together with Cream_Data_Driver and Cream_Data_Statement
 * to execute a SQL statement on the specified DBMS.
 *
 * When the Connection class is instantiated no actual connection to de DB will
 * be made. The connection will be established when the first query is run by
 * the connection object.
 *
 * The following example shows how to create a Connection instance:
 *
 * <code>
 * $connection = Cream_Data_Connection::instance('server', 'database', 'username', 'password', 'MySql');
 * </code>
 *
 * After an instance of the connection class has been created, one can execute
 * an SQL statement like the following:
 *
 * <code>
 * $select = Cream_Data_Statement_Select::instance();
 * $select->from('User');
 *
 * $results = $connection->query($select);
 * </code>
 *
 * @package		Cream_Data
 * @author		Danny Verkade
 */
class Cream_Data_Connection
{
	protected $i = 0;
	/**
	 * @var Cream_Data_Driver_Abstract
	 */
	protected $_driver;

	/**
	 * @var string
	 */
	protected $_host;

	/**
	 * @var string
	 */
	protected $_database;

	/**
	 * @var string
	 */
	protected $_username;

	/**
	 * @var string
	 */
	protected $_password;
	
	/**
	 * Connection type
	 * 
	 * @var string
	 */
	protected $_type;

	/**
	 * Initialize connection instance.
	 *
	 * @param Cream_Config_Xml_Element|array
	 */
	public function __init($config)
	{
		if (Cream::isInstanceOf($config, 'Cream_Config_Xml_Element')) {
			$this->_host = (string) $config->host;
			$this->_database = (string) $config->database;
			$this->_username = (string) $config->username;
			$this->_password = (string) $config->password;
			$this->_type = (string) $config->type;
		} else {
			$this->_host = $config['host'];
			$this->_database = $config['database'];
			$this->_username = $config['username'];
			$this->_password = $config['password'];
			$this->_type = $config['type'];
		}

		$this->_driver = Cream::instance('Cream_Data_Driver_'. $this->_type, $this);
	}

	/**
	 * Creates an instance of this class
	 *
	 * @param Cream_Config_Xml_Element|array $config
	 * @return Cream_Connection
	 */
	public static function instance($config)
	{
		return Cream::instance(__CLASS__, $config);
	}

	/**
	 * Returns the server host which the connection uses.
	 *
	 * @return string
	 */
	public function getHost()
	{
		return $this->_host;
	}

	/**
	 * Returns the database name which the connection uses.
	 *
	 * @return string
	 */
	public function getDatabase()
	{
		return $this->_database;
	}

	/**
	 * Returns the username which is used by this connection.
	 *
	 * @return string
	 */
	public function getUsername()
	{
		return $this->_username;
	}

	/**
	 * Returns the password which is used by this connection.
	 *
	 * @return unknown
	 */
	public function getPassword()
	{
		return $this->_password;
	}

	/**
	 * Gets the current database driver
	 *
	 * @return Cream_Data_Driver
	 */
	public function getDriver()
	{
		return $this->_driver;
	}

	/**
	 * Execute a database query
	 *
	 * @param Cream_Data_Statement $statement
	 * @return Cream_Data_Result
	 */
	public function query($statement)
	{	
		//print $this->i++ .' '. $statement;
		//print '<hr>';
		
		// Execute query
		$this->getDriver()->query($statement);

		$result = Cream_Data_Result::instance();
		$result->setStatement($statement);
		$result->setAffectedRows($this->getDriver()->getAffectedRows());

		// Set insert statement info
		if ($statement instanceof Cream_Data_Statement_Insert) {
			$result->setInsertId($this->getDriver()->getInsertId());
		}

		// Set select statement info
		if ($statement instanceof Cream_Data_Statement_Select || is_string($statement)) {
			if (is_resource($this->getDriver()->getResult())) {
				$result->setRows($this->getDriver()->getRows());
				$result->setNumRows($this->getDriver()->getNumRows());
				$result->setNumFields($this->getDriver()->getNumFields());
			}
		}

		// Clear result set
		$this->getDriver()->clear();

		// Return Cream_Data_Result
		return $result;
	}
	
	/**
	 * Runs multiple queries to the databases. Returns an array with
	 * for each query a result object.
	 *  
	 * @param string $sql
	 * @return array
	 */
	public function multiQuery($sql)
	{
        $result = array();
        $statements = $this->_splitMultiQuery($sql);
        foreach ($statements as $statement) {
        	$result[] = $this->query($statement);
		}
		
		return $result;
	}
	
	/**
     * Split multi statement query
     *
     * @param $sql string
     * @return array
     */
    protected function _splitMultiQuery($sql)
    {
        $parts = preg_split('#(;|\'|"|\\\\|//|--|\n|/\*|\*/)#', $sql, null, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

        $q = false;
        $c = false;
        $stmts = array();
        $s = '';

        foreach ($parts as $i=>$part) {
            // strings
            if (($part==="'" || $part==='"') && ($i===0 || $parts[$i-1]!=='\\')) {
                if ($q===false) {
                    $q = $part;
                } else if ($q===$part) {
                    $q = false;
                }
            }

            // single line comments
            if (($part==='//' || $part==='--') && ($i===0 || $parts[$i-1]==="\n")) {
                $c = $part;
            } else if ($part==="\n" && ($c==='//' || $c==='--')) {
                $c = false;
            }

            // multi line comments
            if ($part==='/*' && $c===false) {
                $c = '/*';
            } else if ($part==='*/' && $c==='/*') {
                $c = false;
            }

            // statements
            if ($part===';' && $q===false && $c===false) {
                if (trim($s)!=='') {
                    $stmts[] = trim($s);
                    $s = '';
                }
            } else {
                $s .= $part;
            }
        }
        if (trim($s)!=='') {
            $stmts[] = trim($s);
        }

        return $stmts;
    }
	
    /**
     * Fetch pairs of a select statement. Returns an array with the
     * first column in the query as the array key, the second column
     * will be the value.
     * 
     * @param Cream_Data_Statement_Select $statement
     * @return array
     */
	public function fetchPairs($statement)
	{
		$data = array();
		$result = $this->query($statement);
		
		
		foreach($result->getRows() as $row) {
			$dataRow = $row->toArray();
			$dataKey = array_keys($dataRow);
			
			$data[$dataRow[$dataKey[0]]] = $dataRow[$dataKey[1]];
		}
		
		return $data;
	}
}