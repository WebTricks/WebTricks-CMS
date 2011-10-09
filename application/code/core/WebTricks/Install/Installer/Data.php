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
 * Installer data model
 *
 * @package		WebTricks_Install
 * @author		WebTricks Core Team <core@webtricksframework.com>
 */
class WebTricks_Install_Installer_Data extends Cream_Object
{

    /**
     * Errors array
     *
     * @var array
     */
    protected $_errors = array();

    /**
     * Add error
     *
     * @param string $error
     * @return void
     */
    public function addError($error)
    {
        $this->_errors[] = $error;
    }

    /**
     * Get all errors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->_errors;
    }

}
