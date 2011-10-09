<?php
/**
 * WebTricks - PHP Framework
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
 * The Store class encapsulates a client side cache of Record objects which 
 * provide input data for Components such as the GridPanel, the ComboBox, or 
 * the DataView.
 * 
 * @package 	Cream_Web_UI_ExtControls_Data
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Data_Store extends Cream_Web_UI_ExtControls_Util_Observable 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Data_Store
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Initialize function
	 *
	 */
	public function __init()
	{
		$this->setControl('Ext.data.Store');
	}

	/**
	 * If passed, the id to use to register with the StoreMgr
	 *
	 * @param string $storeId
	 */
	public function setStoreId($storeId)
	{
		$this->setAttribute('storeId', $storeId);
	}

	/**
	 * If passed, an HttpProxy is created for the passed URL
	 *
	 * @param string $url
	 */
	public function setUrl($url)
	{
		$this->setAttribute('url', $url);
	}

	/**
	 * If passed, this store's load method is automatically called after 
	 * creation with the autoLoad object
	 *
	 * @param boolean/object $autoLoad
	 */
	public function setAutoLoad($autoLoad)
	{
		$this->setAttribute('autoLoad', $autoLoad);
	}

	/**
	 * The Proxy object which provides access to a data object.
	 *
	 * @param ext.data.dataproxy $proxy
	 */
	public function setProxy($proxy)
	{
		$this->setAttribute('proxy', $proxy);
	}

	/**
	 * Inline data to be loaded when the store is initialized.
	 *
	 * @param array $data
	 */
	public function setData($data)
	{
		$this->setAttribute('data', $data);
	}

	/**
	 * The DataReader object which processes the data object and returns
	 *
	 * @param ext.data.datareader $reader
	 */
	public function setReader($reader)
	{
		$this->setAttribute('reader', $reader);
	}

	/**
	 * An object containing properties which are to be sent as parameters
	 *
	 * @param object $baseParams
	 */
	public function setBaseParams($baseParams)
	{
		$this->setAttribute('baseParams', $baseParams);
	}

	/**
	 * A config object in the format: {field: "fieldName", direction: 
	 * "ASC|DESC"}.  The direction
	 *
	 * @param object $sortInfo
	 */
	public function setSortInfo($sortInfo)
	{
		$this->setAttribute('sortInfo', $sortInfo);
	}

	/**
	 * True if sorting is to be handled by requesting the
	 *
	 * @param boolean $remoteSort
	 */
	public function setRemoteSort($remoteSort)
	{
		$this->setAttribute('remoteSort', $remoteSort);
	}

	/**
	 * True to clear all modified record information each time the store is
	 *
	 * @param boolean $pruneModifiedRecords
	 */
	public function setPruneModifiedRecords($pruneModifiedRecords)
	{
		$this->setAttribute('pruneModifiedRecords', $pruneModifiedRecords);
	}
}