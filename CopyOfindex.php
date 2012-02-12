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
$application->init();


set_time_limit(3600);

replaceGuids('1bc2a8d1-0e14-489a-af4c-ad95c15a090b');

function replaceGuids($parent)
{
	print $parent;
	print '<hr>';
	global $application;
	
	//$guid = Cream_Guid::generateGuid();
	$guid = Cream_Guid::parseGuid('4d09ce1a-44b5-483a-a9b4-dc59e57dc54b');
	
	$update = Cream_Data_Statement_Update::instance();
	$update->from('content_item');
	$update->set('itemId', $guid);
	$update->where('itemId = ?', $parent);
	$application->getConnection('default_read')->query($update);
	
	$update = Cream_Data_Statement_Update::instance();
	$update->from('content_item');
	$update->set('parentId', $guid);
	$update->where('parentId = ?', $parent);
	$application->getConnection('default_read')->query($update);
	
	$update = Cream_Data_Statement_Update::instance();
	$update->from('content_item');
	$update->set('templateId', $guid);
	$update->where('templateId = ?', $parent);
	$application->getConnection('default_read')->query($update);

	$update = Cream_Data_Statement_Update::instance();
	$update->from('content_item_shared_field');
	$update->set('itemId', $guid);
	$update->where('itemId = ?', $parent);
	$application->getConnection('default_read')->query($update);

	$update = Cream_Data_Statement_Update::instance();
	$update->from('content_item_shared_field');
	$update->set('fieldId', $guid);
	$update->where('fieldId = ?', $parent);
	$application->getConnection('default_read')->query($update);

	$update = Cream_Data_Statement_Update::instance();
	$update->from('content_item_unversioned_field');
	$update->set('itemId', $guid);
	$update->where('itemId = ?', $parent);
	$application->getConnection('default_read')->query($update);

	$update = Cream_Data_Statement_Update::instance();
	$update->from('content_item_unversioned_field');
	$update->set('fieldId', $guid);
	$update->where('fieldId = ?', $parent);
	$application->getConnection('default_read')->query($update);
	
	$update = Cream_Data_Statement_Update::instance();
	$update->from('content_item_versioned_field');
	$update->set('itemId', $guid);
	$update->where('itemId = ?', $parent);
	$application->getConnection('default_read')->query($update);

	$update = Cream_Data_Statement_Update::instance();
	$update->from('content_item_versioned_field');
	$update->set('fieldId', $guid);
	$update->where('fieldId = ?', $parent);
	$application->getConnection('default_read')->query($update);
	
	$select = Cream_Data_Statement_Select::instance();
	$select->from('content_item');
	$select->where('parentId = ?', $guid);
	
	$result = $application->getConnection('default_read')->query($select);

	//print $select;
	
	//foreach ($result->getRows() as $row)
	//{
	//	replaceGuids($row->itemId);
	//}
	
}
