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
 * DataWriter extension for writing an array or single Ext.data.Record 
 * object(s) in preparation for executing a remote CRUD action via XML. 
 * XmlWriter uses an instance of Ext.XTemplate for maximum flexibility in 
 * defining your own custom XML schema if the default schema is not appropriate
 * for your needs. See the tpl configuration-property.
 * 
 * @package		Cream_Web_UI_ExtControls_Data
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Data_XmlWriter extends Cream_Web_UI_ExtControls_Data_DataWriter
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Data_XmlWriter
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
		$this->setControl('Ext.data.XmlStore');
	}
	
	/**
	 * The name of the XML document root-node. Note: this parameter is required 
	 * only when sending extra baseParams to the server during a write-request 
	 * If no baseParams are set, the Ext.data.XmlReader.record meta-property can 
	 * suffice as the XML document root-node for write-actions involving just a 
	 * single record. For requests involving multiple records and NO baseParams, 
	 * the Ext.data.XmlWriter.root property can act as the XML document root.
	 *
	 * @param string $documentRoot
	 */
	public function setDocumentRoot($documentRoot)
	{
		$this->setAttribute('documentRoot', $documentRoot);
	}	
	
	/**
	 * Set to true to force XML documents having a root-node as defined by 
	 * documentRoot, even with no baseParams defined.
	 *
	 * @param boolean $forceDocumentRoot
	 */
	public function setForceDocumentRoot($forceDocumentRoot)
	{
		$this->setAttribute('forceDocumentRoot', $forceDocumentRoot);
	}		
	
	/**
	 * The name of the containing element which will contain the nodes of an 
	 * write-action involving multiple records. Each xml-record written to the
	 * server will be wrapped in an element named after 
	 * Ext.data.XmlReader.record property.
	 * 
	 * @param string $root
	 */
	public function setRoot($root)
	{
		$this->setAttribute('root', $root);
	}		
	
	/**
	 * The XML template used to render write-actions to your server. 
	 * 
	 * One can easily provide his/her own custom template-definition if the 
	 * default does not suffice.
	 * 
	 * @param string|Cream_Web_UI_ExtControls_XTemplate $tpl
	 */
	public function setTpl($tpl)
	{
		$this->setAttribute('tpl', $tpl);
	}	

	/**
	 * The encoding written to header of xml documents. 
	 * 
	 * @param string $xmlEncoding
	 */
	public function setXmlEncoding($xmlEncoding)
	{
		$this->setAttribute('xmlEncoding', $xmlEncoding);
	}	

	/**
	 * The version written to header of xml documents. 
	 * 
	 * @param string $xmlVersion
	 */
	public function setXmlVersion($xmlVersion)
	{
		$this->setAttribute('xmlVersion', $xmlVersion);
	}		
}