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
 * Encapsulates the DOM <form> element at the heart of the FormPanel class, and
 * provides input field management, validation, submission, and form loading 
 * services.
 * 
 * By default, Ext Forms are submitted through Ajax, using an instance of 
 * Ext.form.Action.Submit. To enable normal browser submission of an Ext Form, 
 * use the standardSubmit config option.
 * 
 * File Uploads
 * 
 * File uploads are not performed using Ajax submission, that is they are not 
 * performed using XMLHttpRequests. Instead the form is submitted in the 
 * standard manner with the DOM <form> element temporarily modified to have its 
 * target set to refer to a dynamically generated, hidden <iframe> which is 
 * inserted into the document but removed after the return data has been 
 * gathered.
 * 
 * The server response is parsed by the browser to create the document for the 
 * IFRAME. If the server is using JSON to send the return object, then the 
 * Content-Type header must be set to "text/html" in order to tell the browser 
 * to insert the text unchanged into the document body.
 * 
 * Characters which are significant to an HTML parser must be sent as HTML 
 * entities, so encode "<" as "&lt;", "&" as "&amp;" etc.
 * 
 * The response text is retrieved from the document, and a fake XMLHttpRequest 
 * object is created containing a responseText property in order to conform to 
 * the requirements of event handlers and callbacks.
 * 
 * Be aware that file upload packets are sent with the content type 
 * multipart/form and some server technologies (notably JEE) may require some 
 * custom processing in order to retrieve parameter names and parameter values 
 * from the packet content.
 * 
 * @package 	Cream_Web_UI_ExtControls_Form
 * @author 		Danny Verkade
 */
class Cream_Web_UI_ExtControls_Form_BasicForm extends Cream_Web_UI_ExtControls_Util_Observable
{
	/**
	 * Create a new instance of this class
	 *
	 * @return Cream_Web_UI_ExtControls_Form_BasicForm
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Initialize function, set the Ext JS control
	 *
	 */
	public function __init()
	{
		$this->setControl('Ext.form.BasicForm');
	}	

	/**
	 * If specified load and submit actions will be handled with 
	 * Ext.form.Action.DirectLoad and Ext.form.Action.DirectSubmit. Methods 
	 * which have been imported by Ext.Direct can be specified here to load and
	 * submit forms.
	 *  		
	 * @param object $api
	 */
	public function setApi($api)
	{
		$this->setAttribute('api', $api);
	}
	
	/**
	 * The request method to use (GET or POST) for form actions if one isn't 
	 * supplied in the action options.
	 *
	 * @param string $method
	 */
	public function setMethod($method)
	{
		$this->setAttribute('method', $method);
	}
	
	/**
	 * A list of params to be executed server side. Defaults to undefined. Only
	 * used for the api load configuration.
	 * 
	 * Specify the params in the order in which they must be executed on the 
	 * server-side as either (1) an Array of String values, or (2) a String of 
	 * params delimited by either whitespace, comma, or pipe.
	 * 
	 * @param string|array $paramOrder
	 */
	public function setParamOrder($paramOrder)
	{
		$this->setAttribute('paramOrder', $paramOrder);
	}
	
	/**
	 * Only used for the api load configuration. Send parameters as a 
	 * collection of named arguments (defaults to false). Providing a 
	 * paramOrder nullifies this configuration.
	 * 
	 * @param boolean $paramsAsHash
	 */
	public function setParamsAsHash($paramsAsHash)
	{
		$this->setAttribute('paramsAsHash', $paramsAsHash);		
	}

	/**
	 * An Ext.data.DataReader (e.g. Ext.data.XmlReader) to be used to read data
	 * when executing 'load' actions. This is optional as there is built-in 
	 * support for processing JSON. For additional information on using an 
	 * XMLReader see the example provided in examples/form/xml-form.html.
	 *
	 * @param datareader $reader
	 */
	public function setReader($reader)
	{
		$this->setAttribute('reader', $reader);
	}

	/**
	 * If set to true, standard HTML form submits are used instead of XHR 
	 * (Ajax) style form submissions. Defaults to false.
	 * 
	 * Note: When using standardSubmit, the options to submit are ignored 
	 * because Ext's Ajax infrastracture is bypassed. To pass extra parameters
	 * (e.g. baseParams and params), utilize hidden fields to submit extra
	 * data.
	 * 
	 * @param boolean $standardSubmit
	 */
	public function setStandardSubmit($standardSubmit)
	{
		$this->setAttribute('standardSubmit', $standardSubmit);		
	}

	/**
	 * An Ext.data.DataReader (e.g. Ext.data.XmlReader) to be used to read 
	 * field error messages returned from 'submit' actions. This is optional as
	 * there is built-in support for processing JSON.
	 * 
	 * The Records which provide messages for the invalid Fields must use the 
	 * Field name (or id) as the Record ID, and must contain a field called 
	 * 'msg' which contains the error message.
	 * 
	 * @param datareader $errorReader
	 */
	public function setErrorReader($errorReader)
	{
		$this->setAttribute('errorReader', $errorReader);
	}

	/**
	 * The URL to use for form actions if one isn't supplied in the doAction 
	 * options.
	 *
	 * @param string $url
	 */
	public function setUrl($url)
	{
		$this->setAttribute('url', $url);
	}

	/**
	 * Set to true if this form is a file upload. File uploads are not 
	 * performed using normal 'Ajax' techniques, that is they are not 
	 * performed using XMLHttpRequests. Instead the form is submitted in the
	 * standard manner with the DOM <form> element temporarily modified to have
	 * its target set to refer to a dynamically generated, hidden <iframe> 
	 * which is inserted into the document but removed after the return data 
	 * has been gathered.
	 *
	 * @param boolean $fileUpload
	 */
	public function setFileUpload($fileUpload)
	{
		$this->setAttribute('fileUpload', $fileUpload);
	}

	/**
	 * Parameters to pass with all requests. e.g. baseParams: {id: '123', foo: 
	 * 'bar'}. Parameters are encoded as standard HTTP parameters using 
	 * Ext.urlEncode.
	 *
	 * @param object $baseParams
	 */
	public function setBaseParams($baseParams)
	{
		$this->setAttribute('baseParams', $baseParams);
	}

	/**
	 * Timeout for form actions in seconds (default is 30 seconds).
	 *
	 * @param number $timeout
	 */
	public function setTimeout($timeout)
	{
		$this->setAttribute('timeout', $timeout);
	}

	/**
	 * If set to true, reset() resets to the last loaded or setValues() data 
	 * instead of when the form was first created. Defaults to false.
	 *
	 * @param boolean $trackResetOnLoad
	 */
	public function setTrackResetOnLoad($trackResetOnLoad)
	{
		$this->setAttribute('trackResetOnLoad', $trackResetOnLoad);
	}
	
	/**
	 * The default title to show for the waiting message box (defaults to 
	 * 'Please Wait...')
	 * 
	 * @param string $waitTitle
	 */
	public function setWaitTitle($waitTitle)
	{
		$this->setAttribute('waitTitle', $waitTitle);
	}
}