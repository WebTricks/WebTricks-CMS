<?php
/**
 * WebTricks - PHP Framework
 *
 * LICENSE
 *
 * For the full copyright and license information, please view the 
 * following URL: http://www.webtricksframework.com/license 
 *
 * @copyright Copyright (c) 2007-2011 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * The database workflow history manager class. Stores history entries
 * into the database.
 * 
 * @package		Cream_Workflows
 * @author		WebTricks Core Team <core@webtricksframework.com>
 */
class Cream_Workflows_Data_Manager_Database extends Cream_Workflows_Data_Manager_Abstract
{
	/**
	 * Name of the read connection to use
	 * 
	 * @var string
	 */
	protected $_readConnection;
	
	/**
	 * Name of the write connection to use
	 * 
	 * @var string
	 */
	protected $_writeConnection;
		
	/**
	 * Initialize function
	 * 
	 * @param Cream_Config_Xml_Element $config
	 */
	public function __init(Cream_Config_Xml_Element $config)
	{
		$this->_readConnection = (string) $config->connection->read;
		$this->_writeConnection = (string) $config->connection->write;
	}	
	
	/**
	 * Adds a workflow history entry.
	 * 
	 * @param Cream_Content_Item $item
	 * @param Cream_Guid $oldStateId
	 * @param Cream_Guid $newStateId
	 * @param string $message
	 * @return void
	 */	
	public function addHistory(Cream_Content_Item $item, Cream_Guid $oldStateId, Cream_Guid $newStateId, $message)
	{
		$insert = Cream_Data_Statement_Insert::instance();
		$insert->into('workflow_history');
		$insert->values(array(
			'repository' => $item->getRepository()->getName(),
			'itemId' => $item->getItemId(),
			'culture' => $item->getCulture()->getCulture(),
			'version' => $item->getVersion(),
			'oldStateId' => $oldStateId,
			'newStateId' => $newStateId,
			'message' => $message,
			'user' => $this->_getApplication()->getContext()->getUser()->getName(),
			'date' => Cream_Expression::instance('NOW()')
		));
		
		$this->_getWriteConnection()->query($insert);
	}
	
	/**
	 * Clears the workflow history entries of an item.
	 *  
	 * @param Cream_Content_Item $item
	 * @return void
	 */	
	public function clearHistory(Cream_Content_Item $item)
	{
		$delete = Cream_Data_Statement_Delete::instance();
		$delete->from('workflow_history');
		$delete->where('repository = ?', $item->getRepository()->getName());
		$delete->where('itemId = ?', $item->getItemId());
		$delete->where('culture = ?', $item->getCulture()->getCulture());
		$delete->where('version = ?', $item->getVersion());
		
		$this->_getWriteConnection()->query($delete);
	}
	
	/**
	 * Retrieves the workflow history entries of an item.
	 * 
	 * @param Cream_Content_Item $item
	 * @return array
	 */	
	public function getHistory(Cream_Content_Item $item)
	{
		$history = array();
		
		$select = Cream_Data_Statement_Select::instance();
		$select->from('workflow_history');
		$select->where('repository = ?', $item->getRepository()->getName());
		$select->where('itemId = ?', $item->getItemId());
		$select->where('culture = ?', $item->getCulture()->getCulture());
		$select->where('version = ?', $item->getVersion());
		
		$result = $this->_getReadConnection()->query($select);
		
		foreach($result->getRows() as $row) {
			$history[] = Cream_Workflows_WorkflowEvent::instance($row->oldStateId, $row->newStateId, $row->message, $row->user, $row->date);
		}
		
		return $history;
	}
	
	/**
	 * Returns the read connection
	 *
	 * @return Cream_Data_Connection
	 */
	protected function _getReadConnection()
	{
		return $this->_getApplication()->getConnection($this->_readConnection);
	}

	/**
	 * Returns the write connection
	 *
	 * @return Cream_Data_Connection
	 */	
	protected function _getWriteConnection()
	{
		return $this->_getApplication()->getConnection($this->_writeConnection);
	}	
}