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

if (version_compare(phpversion(), '5.2.0', '<')===true) {
    echo  '<div style="font:12px/1.35em arial, helvetica, sans-serif;"><div style="margin:0 0 25px 0; border-bottom:1px solid #ccc;"><h3 style="margin:0; font-size:1.7em; font-weight:normal; text-transform:none; text-align:left; color:#2f2f2f;">Whoops, it looks like you have an invalid PHP version.</h3></div></div>';
    exit;
}

/**
 * Error reporting
 */
error_reporting(E_ALL | E_STRICT);

require_once('library/Cream/Autoload.php');

umask(0);

define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);
define('BP', dirname(__FILE__));

$paths = array();
$paths[] = BP . DS . 'app' . DS . 'code' . DS . 'local';
$paths[] = BP . DS . 'app' . DS . 'code' . DS . 'community';
$paths[] = BP . DS . 'app' . DS . 'code' . DS . 'core';
$paths[] = BP . DS . 'library';

$appPath = implode(PS, $paths);
set_include_path($appPath . PS . get_include_path());

Cream_Autoload::register();
Cream::initErrorHandlers();

$application = new Cream_Application();
$application->run();

//$itemId = $application->getRepository('core')->getDataManager()->resolvePath('WebTricks/content/Applications/Content Editor/Ribbons/Ribbons/Default');
//$item = $application->getRepository('core')->getItem($itemId);

//$ribbon = WebTricks_Shell_Toolbar_Ribbon::instance();
//print $ribbon->getExtControl($item);