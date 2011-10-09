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
 * @copyright Copyright (c) 2007-2011 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * Cream_Exception_ErrorHandler handles all PHP user errors and exceptions generated
 * during servicing user requests. It displays these errors using different templates.
 *
 * Note, PHP parsing errors cannot be caught and handled by this class.
 *
 * The templates used to format the error output are stored in the
 * Content/general/templates/exception folder.
 *
 * There are two sets of templates, one for errors to be displayed to client users
 * (called external errors), one for errors to be displayed to system developers
 * (called internal errors). The template file name for the former is
 * <b>error[StatusCode].html</b>, and for the latter it is
 * <b>exception.html</b>, where StatusCode refers to response status
 * code (e.g. 404, 500) specified when {@link Cream_Exception_Http} is thrown.
 * The templates <b>error.html</b> and <b>exception.html</b> are default ones
 * that are used if no other appropriate templates are available.
 *
 * By default, Cream_Exception_ErrorHandler is registered with {@link Cream_Application}
 * as the error handler module. It can be accessed via {@link Application::getErrorHandler()}.
 * You seldom need to deal with the error handler directly. It is mainly used
 * by the application object to handle errors.
 *
 * @category	Cream
 * @package 	Cream_Exception
 * @author 		WebTicks Core Team <core@webtricksframework.com>
 */
class Cream_Exceptions_ErrorHandler extends Cream_ApplicationComponent
{
	/**
	 * error template file basename
	 */
	const ERROR_FILE_NAME = 'error';

	/**
	 * exception template file basename
	 */
	const EXCEPTION_FILE_NAME = 'exception';

	/**
	 * number of lines before and after the error line to be displayed in case of an exception
	 */
	const SOURCE_LINES = 20;

	/**
	 * Create a new instance of this class.
	 * 
	 * @return Cream_Exception_ErrorHandler
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Handles PHP user errors and exceptions.
	 *
	 * The method mainly uses appropriate template to display the error/exception.
	 * It terminates the application immediately after the error is displayed.
	 *
	 * @param Cream_Exception $exception
	 */
	public function handleError($exception)
	{		
		// Default status code
		$statusCode = 500;

		// We need to restore error and exception handlers,
		// because within error and exception handlers, new errors and exceptions
		// cannot be handled properly by PHP
		restore_error_handler();
		restore_exception_handler();

		if (($response = $this->getApplication()->getResponse())!==null) {
			$response->clear();
		}

		if ($exception instanceof Cream_Exceptions_HttpException) {

			// An HTTP error occured. Display the HTTP error.
			$content = $this->getError($exception->getStatusCode(), $exception);
			$statusCode = $exception->getStatusCode();

		//} elseif ($this->getApplication()->getMode() === Cream_Application::MODE_DEBUG) {
		} else {
			// Application in DEBUG mode, display the exception
			$content = $this->getException($exception);

		//} else {

			// Application in normal mode, display the internatl server error page
			// Email the exception to the specified email adress.
		//	$content = $this->getError($statusCode, $exception);
		//	$this->emailError($exception);

		}

		header("HTTP/1.0 ". $statusCode);
		header('Content-Type: text/html; charset=UTF-8');
		print $content;
		exit();
	}

	/**
	 * Retrieves the template used for displaying external exceptions.
	 * External exceptions are those displayed to end-users. They do not contain
	 * error source code. Therefore, you might want to override this method
	 * to provide your own error template for displaying certain external exceptions.
	 * The following tokens in the template will be replaced with corresponding content:
	 * $statusCode   : the status code of the exception
	 * $errorMessage : the error message (HTML encoded).
	 * $version      : the version information of the Web server.
	 * $datetime     : the time the exception occurs at
	 *
	 * @param integer status code (such as 404, 500, etc.)
	 * @param Cream_Exception the exception to be displayed
	 * @return Cream_Web_UI_Template
	 */
	protected function getError($statusCode, $exception)
	{

		// Log Http errors to the apache log file
		error_log($exception->__toString());

		/* @var $template Cream_Web_UI_Template */
		$template = Cream::instance('System.Web.UI.Template');
		$template->setTemplate($this->getErrorTemplate($statusCode, $exception));
		$template->set('version', Cream::getVersion());
		$template->set('statusCode', $statusCode);
		$template->set('errorMessage', htmlspecialchars($exception->getMessage()));
		$template->set('dateTime', date("Y-m-d H:i"));

		return $template;
	}

	/**
	 * Determines the location of the template file to user for displaying an
	 * error message
	 *
	 * @param integer status code (such as 404, 500, etc.)
	 * @param Exception the exception to be displayed
	 * @return string location of the template file
	 */
	protected function getErrorTemplate($statusCode, $exception)
	{
		$base = dirname(__FILE__) .'/../../Content/general/templates/exception/'. self::ERROR_FILE_NAME;

		if (is_file($base . $statusCode .".html")) {
			$errorFile = $base . $statusCode .".html";
		} else {
			$errorFile = $base .".html";
		}

		return $errorFile;
	}

	/**
	 * Determines the location of the template file to user for displaying an
	 * exception message
	 *
	 * @param integer status code (such as 404, 500, etc.)
	 * @param Exception the exception to be displayed
	 * @return string location of the template file
	 */
	protected function getExceptionTemplate($exception)
	{
		$base = self::EXCEPTION_FILE_NAME;

		if (is_file($base .".html")) {
			$errorFile = $base .".html";
		} else {
			$errorFile = $base .".html";
		}

		return $errorFile;
	}

	/**
	 * Displays exception information.
	 *
	 * Exceptions are displayed with rich context information, including
	 * the call stack and the context source code.
	 *
	 * This method is only invoked when application is in <b>Debug</b> mode.
	 *
	 * @param Cream_Exception exception instance
	 */
	protected function getException($exception)
	{

		// Display exception when run from command line
		//if(php_sapi_name()==='cli')
		//{
		//	echo $exception->getMessage()."\n";
		//	echo $exception->getTraceAsString();
		//	return;
		//}
		
		if(($trace = $this->getExactTrace($exception))!==null) {
			$fileName = $trace['file'];
			$errorLine = $trace['line'];
		} else {
			$fileName = $exception->getFile();
			$errorLine = $exception->getLine();
		}

		$requestInfo = $this->getApplication()->getRequest();

		$template = Cream_Web_UI_WebControls_TemplateControl::instance();
		$template->setTemplate($this->getExceptionTemplate($exception));
		$template->set('version', Cream::getVersion());
		$template->set('errorType', get_class($exception));
		$template->set('errorMessage', nl2br(htmlspecialchars($exception->getMessage())));
		$template->set('sourceFile', htmlspecialchars($fileName).' ('.$errorLine.')');
		$template->set('sourceCode', $this->getSourceCode(@file($fileName),$errorLine));
		$template->set('stackTrace', htmlspecialchars($exception->getTraceAsString()));
		$template->set('dateTime', date("Y-m-d H:i"));
		$template->set('requestInfo', $requestInfo);
		
		//return $template->toHtml();
	}

	/**
	 * Returns the lines of the source code to display in the exception message.
	 *
	 * @param array $lines
	 * @param integer $errorLine
	 * @return string
	 */
	private function getSourceCode($lines,$errorLine)
	{
		$source = '';
		$beginLine = $errorLine - self::SOURCE_LINES>=0?$errorLine-self::SOURCE_LINES:0;
		$endLine = $errorLine + self::SOURCE_LINES<=count($lines)?$errorLine+self::SOURCE_LINES:count($lines);

		for($i = $beginLine; $i < $endLine; ++$i)
		{
			if($i === $errorLine-1) {
				$line = htmlspecialchars(sprintf("%04d: %s",$i+1,str_replace("\t",'    ',$lines[$i])));
				$source .= "<div class=\"error\">".$line."</div>";
			} else {
				$source .= htmlspecialchars(sprintf("%04d: %s",$i+1,str_replace("\t",'    ',$lines[$i])));
			}
		}

		return $source;
	}

	/**
	 * When a PHP error is thrown the 1st stack level is of little use, because
	 * it is in the error handler throwing the PHP exception. This function will
	 * give the correct stack trace.
	 *
	 * @param Cream_Exception $exception
	 * @return array
	 */
	private function getExactTrace($exception)
	{
		$trace = $exception->getTrace();
		$result = null;

		// if PHP exception, we want to show the 2nd stack level context
		// because the 1st stack level is of little use (it's in error handler)
		if($exception instanceof Cream_Exception_PhpException) {

			if (isset($trace[0]['file'])) {
				$result = $trace[0];
			} else {
				$result = $trace[1];
			}
		}

		if ($result!==null && strpos($result['file'],': eval()\'d code')!==false) {
			return null;
		}

		return $result;
	}

	/**
	 * Email the error the the specified e-mail adress
	 *
	 * @param Cream_Exception $exception
	 */
	private function emailError($exception)
	{
		$message = new Cream_Net_Mail_Message();
		$message->addTo($this->getApplication()->getConfig()->system->exception->emailAddress);
		$message->setFrom('systeembeheer@mbwp.nl', 'MBWP Internetbureau Systeembeheer');
		$message->setBodyHtml($this->getException($exception));
		$message->setSubject($this->getApplication()->getConfig()->system->application->name .': '. get_class($exception));

		$mail = new Cream_Net_Mail();
		$mail->send($message);
	}
}