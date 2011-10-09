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
 * Data reader class to create an Array of Ext.data.Record objects from an XML
 * document based on mappings in a provided Ext.data.Record constructor.
 * 
 * Note: that in order for the browser to parse a returned XML document, the 
 * Content-Type header in the HTTP response must be set to "text/xml" or 
 * "application/xml".
 *  
 * @package 	Cream_Web_UI_ExtControls_Data
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Data_XmlReader extends Cream_Web_UI_ExtControls_Data_DataReader 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Data_XmlReader
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Initialize function
	 * 
	 * @return void
	 */
	public function __init()
	{
		$this->setControl('Ext.data.XmlReader');
	}	
	
	/**
	 * The DomQuery path from which to retrieve the total number of records in
	 * the dataset. This is only needed if the whole dataset is not passed in 
	 * one go, but is being paged from the remote server.
	 *
	 * @param string $totalProperty
	 */
	public function setTotalProperty($totalProperty)
	{
		$this->setAttribute('totalProperty', $totalProperty);
	}

	/**
	 * The DomQuery path to the repeated element which contains record 
	 * information.
	 *
	 * @param string $record
	 */
	public function setRecord($record)
	{
		$this->setAttribute('record', $record);
	}

	/**
	 * The DomQuery path to the success attribute used by forms.
	 *
	 * @param string $successProperty
	 */
	public function setSuccessProperty($successProperty)
	{
		$this->setAttribute('successProperty', $successProperty);
	}

	/**
	 * The DomQuery path relative from the record element to the element that 
	 * contains a record identifier value.
	 *
	 * @param string $idPath
	 */
	public function setIdPath($idPath)
	{
		$this->setAttribute('idPath', $idPath);
	}
} 