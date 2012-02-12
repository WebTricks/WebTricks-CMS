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
 * @copyright Copyright (c) 2007-2012 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

    $commands = array(
        'list-installed' => array(
            'summary' => 'List Installed Packages In The Default Channel',
            'function' => 'doList',
            'shortcut' => 'l',
            'options' => array(
                'channel' => array(
                    'shortopt' => 'c',
                    'doc' => 'list installed packages from this channel',
                    'arg' => 'CHAN',
                    ),
                'allchannels' => array(
                    'shortopt' => 'a',
                    'doc' => 'list installed packages from all channels',
                    ),
                ),
            'doc' => '<package>
If invoked without parameters, this command lists the PEAR packages
installed in your php_dir ({config php_dir}).  With a parameter, it
lists the files in a package.
',
            ),
        'list-files' => array(
            'summary' => 'List Files In Installed Package',
            'function' => 'doFileList',
            'shortcut' => 'fl',
            'options' => array(),
            'doc' => '<package>
List the files in an installed package.
'
            ),
        'info' => array(
            'summary'  => 'Display information about a package',
            'function' => 'doInfo',
            'shortcut' => 'in',
            'options'  => array(),
            'doc'      => '<package>
Displays information about a package. The package argument may be a
local package file, an URL to a package file, or the name of an
installed package.'
            )
        ); 