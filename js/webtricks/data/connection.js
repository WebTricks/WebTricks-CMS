/**
 * @class WebTricks.Data.Connection
 * @extends Ext.data.Connection
 * 
 * This class extends the default Ext connection and it will handle authentication 
 * automatically.
 * 
 * The class encapsulates a connection to the page's originating domain, allowing requests to be made
 * either to a configured URL, or to a URL specified at request time.<br><br>
 * <p>
 * Requests made by this class are asynchronous, and will return immediately. No data from
 * the server will be available to the statement immediately following the {@link #request} call.
 * To process returned data, use a callback in the request options object, or an event listener.</p><br>
 * <p>
 * Note: If you are doing a file upload, you will not get a normal response object sent back to
 * your callback or event handler.  Since the upload is handled via in IFRAME, there is no XMLHttpRequest.
 * The response object is created using the innerHTML of the IFRAME's document as the responseText
 * property and, if present, the IFRAME's XML document as the responseXML property.</p><br>
 * This means that a valid XML or HTML document must be returned. If JSON data is required, it is suggested
 * that it be placed either inside a &lt;textarea> in an HTML document and retrieved from the responseText
 * using a regex, or inside a CDATA section in an XML document and retrieved from the responseXML using
 * standard DOM methods.
 * @constructor
 * @param {Object} config a configuration object.
 */
WebTricks.Data.Connection = Ext.extend(Ext.data.Connection, {

	extraParams : {
		isAjax: true
	},
	 
	timeout : 60000,
	
	/**
     * Sends an HTTP request to a remote server.<p>
     * <b>Important:<b> Ajax server requests are asynchronous, and this call will
     * return before the response has been recieved. Process any returned data
     * in a callback function.
     * @param {Object} options An object which may contain the following properties:<ul>
     * <li><b>url</b> : String (Optional)<p style="margin-left:1em">The URL to
     * which to send the request. Defaults to configured URL</p></li>
     * <li><b>params</b> : Object/String/Function (Optional)<p style="margin-left:1em">
     * An object containing properties which are used as parameters to the
     * request, a url encoded string or a function to call to get either.</p></li>
     * <li><b>method</b> {String} (Optional) The HTTP method to use for the request. Defaults to the configured method, or
     * if no method was configured, "GET" if no parameters are being sent, and "POST" if parameters are being sent.</li>
     * <li><b>callback</b> : Function} (Optional)<p style="margin-left:1em">The
     * function to be called upon receipt of the HTTP response. The callback is
     * called regardless of success or failure and is passed the following
     * parameters:<ul>
     * <li><b>options</b> : Object<p style="margin-left:1em">The parameter to the request call.</p></li>
     * <li><b>success</b> : Boolean<p style="margin-left:1em">True if the request succeeded.</p></li>
     * <li><b>response</b> : Object<p style="margin-left:1em">The XMLHttpRequest object containing the response data. See http://www.w3.org/TR/XMLHttpRequest/ for details about accessing elements of the response.</p></li>
     * </ul></p></li>
     * <li><b>success</b> : Function (Optional)<p style="margin-left:1em">The function
     * to be called upon success of the request. The callback is passed the following
     * parameters:<ul>
     * <li><b>response</b> : Object<p style="margin-left:1em">The XMLHttpRequest object containing the response data.</p></li>
     * <li><b>options</b> : Object<p style="margin-left:1em">The parameter to the request call.</p></li>
     * </ul></p></li>
     * <li><b>failure</b> : Function (Optional)<p style="margin-left:1em">The function
     * to be called upon failure of the request. The callback is passed the
     * following parameters:<ul>
     * <li><b>response</b> : Object<p style="margin-left:1em">The XMLHttpRequest object containing the response data.</p></li>
     * <li><b>options</b> : Object<p style="margin-left:1em">The parameter to the request call.</p></li>
     * </ul></p></li>
     * <li><b>scope</b> : Object (Optional)<p style="margin-left:1em">The scope in
     * which to execute the callbacks: The "this" object for the callback function.
     * Defaults to the browser window.</p></li>
     * <li><b>form</b> : Object/String (Optional)<p style="margin-left:1em">A form
     * object or id to pull parameters from.</p></li>
     * <li><b>isUpload</b> : Boolean (Optional)<p style="margin-left:1em">True if
     * the form object is a file upload (will usually be automatically detected).</p></li>
     * <li><b>headers</b> : Object (Optional)<p style="margin-left:1em">Request
     * headers to set for the request.</p></li>
     * <li><b>xmlData</b> : Object (Optional)<p style="margin-left:1em">XML document
     * to use for the post. Note: This will be used instead of params for the post
     * data. Any params will be appended to the URL.</p></li>
     * <li><b>jsonData</b> : Object/String (Optional)<p style="margin-left:1em">JSON
     * data to use as the post. Note: This will be used instead of params for the post
     * data. Any params will be appended to the URL.</p></li>
     * <li><b>disableCaching</b> : Boolean (Optional)<p style="margin-left:1em">True
     * to add a unique cache-buster param to GET requests.</p></li>
     * </ul>
     * @return {Number} transactionId The id of the server transaction. This may be used
     * to cancel the request.
     */
	request : function(o)
	{			
		if(o.callback)
		{
			o.originalCallback = o.callback;
		}
			
		o.loginCallback = function(){
			var cbOptions=o;
			cbOptions['callback']=o.originalCallback;			
			this.request(cbOptions);
		};
		o.loginCallbackScope = this;
		o.callback = this.authHandler;
	
		WebTricks.Data.Connection.superclass.request.call(this, o);
	},
	
	/**
	 * Useful in a connection callback function.
	 * Handles default error messages from the Group-Office server. It checks for the 
	 * precense of UNAUTHORIZED or NOTLOGGEDIN as error message. It will present a 
	 * login dialog if the user needs to login
	 * 
	 * @param {Boolean} success True if the request was sent successful 
	 * @param (Function} callback Callback function to call after successful login
	 * @param {Object} scope	Scope the function to this object
	 * 
	 * @returns {Boolean} True if no errors have been returned.
	 */
	authHandler : function(options, success, response)
	{		
		if(success) {
			ajaxResponse = Ext.decode(response.responseText)
			
			if (ajaxResponse.success) {
				Ext.callback(options.originalCallback, options.scope, [options, success, response]);				
			} else {
				location.href = ajaxResponse.redirect;				
			}
		} else {
			Ext.Msg.alert('Request failed');
		}
	}
});


/**
 * @class Ext.Ajax
 * @extends WebTricks.Data.Connection
 * 
 * Global Ajax request class.  Provides a simple way to make Ajax requests with maximum flexibility.
 * 
 * @singleton
 */
//Ext.Ajax = new WebTricks.Data.Connection({
//});