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
 * @copyright Copyright (c) 2007-2011 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * The jobstatus class. Holds constants about the status of the job. 
 *
 * @package		Cream_Jobs
 * @author		WebTricks Core Team <core@webtricksframework.com>
 */
class Cream_Jobs_JobStatus
{
    const PENDING = 'pending';
    const RUNNING = 'running';
    const SUCCESS = 'success';
    const MISSED = 'missed';
    const ERROR = 'error';	
}