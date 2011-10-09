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
 * A TreeLoader provides for lazy loading of an Ext.tree.TreeNode's child nodes 
 * from a specified URL. The response must be a JavaScript Array definition 
 * whose elements are node definition objects.
 * 
 * A server request is sent, and child nodes are loaded only when a node is 
 * expanded. The loading node's id is passed to the server under the parameter 
 * name "node" to enable the server to produce the correct child nodes. 
 * 
 * @package		Cream_Web_UI_ExtControls_Tree
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Tree_TreeLoader extends Cream_Web_UI_ExtControl 
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Tree_TreeLoader
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
		$this->setControl('Ext.tree.TreeLoader');
	}

	/**
	 * The URL from which to request a Json string which specifies an array of
	 * node definition objects representing the child nodes to be loaded.
	 *
	 * @param string $dataUrl
	 */
	public function setDataUrl($dataUrl)
	{
		$this->setAttribute('dataUrl', $dataUrl);
	}
	
	/**
	 * Function to call when executing a request.
	 *
	 * @param string $directFn
	 */
	public function setDirectFn($directFn)
	{
		$this->setAttribute('directFn', $directFn);
	}	
	
	/**
	 * The name of the parameter sent to the server which contains the 
	 * identifier of the node. Defaults to 'node'.
	 *
	 * @param string $nodeParameter
	 */
	public function setNodeParameter($nodeParameter)
	{
		$this->setAttribute('nodeParameter', $nodeParameter);
	}

	/**
	 * Defaults to undefined. Only used when using directFn. Specifies the 
	 * params in the order in which they must be passed to the server-side 
	 * Direct method as either (1) an Array of String values, or (2) a String 
	 * of params delimited by either whitespace, comma, or pipe.
	 *
	 * @param string|array $paramOrder
	 */
	public function setParamOrder($paramOrder)
	{
		$this->setAttribute('paramOrder', $paramOrder);
	}

	/**
	 * Only used when using directFn. Send parameters as a collection of named 
	 * arguments (defaults to false). Providing a paramOrder nullifies this 
	 * configuration.
	 *
	 * @param boolean $paramsAsHash
	 */
	public function setParamsAsHash($paramsAsHash)
	{
		$this->setAttribute('paramsAsHash', $paramsAsHash);
	}	

	/**
	 * The HTTP request method for loading data (defaults to 'POST').
	 *
	 * @param string $requestMethod
	 */
	public function setRequestMethod($requestMethod)
	{
		$this->setAttribute('requestMethod', $requestMethod);
	}

	/**
	 * Equivalent to #dataUrl.
	 *
	 * @param string $url
	 */
	public function setUrl($url)
	{
		$this->setAttribute('url', $url);
	}

	/**
	 * If set to true, the loader recursively loads "children" attributes when 
	 * doing the first load on nodes.
	 *
	 * @param boolean $preloadChildren
	 */
	public function setPreloadChildren($preloadChildren)
	{
		$this->setAttribute('preloadChildren', $preloadChildren);
	}

	/**
	 * (optional) An object containing properties which
	 *
	 * @param object $baseParams
	 */
	public function setBaseParams($baseParams)
	{
		$this->setAttribute('baseParams', $baseParams);
	}

	/**
	 * (optional) An object containing attributes to be added to all nodes
	 *
	 * @param object $baseAttrs
	 */
	public function setBaseAttrs($baseAttrs)
	{
		$this->setAttribute('baseAttrs', $baseAttrs);
	}

	/**
	 * (optional) An object containing properties which
	 *
	 * @param object $uiProviders
	 */
	public function setUiProviders($uiProviders)
	{
		$this->setAttribute('uiProviders', $uiProviders);
	}

	/**
	 * (optional) Default to true. Remove previously existing
	 *
	 * @param boolean $clearOnLoad
	 */
	public function setClearOnLoad($clearOnLoad)
	{
		$this->setAttribute('clearOnLoad', $clearOnLoad);
	}
}