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

class Cream_Market_Channel_Generator extends Cream_Xml_Generator
{
    protected $_file      = 'channel.xml';
    protected $_generator = null;

	/**
	 * Create a new instance of this class
	 * 
	 * @param string $file
	 * @return Cream_Market_Channel_Generator
	 */
	public static function instance($file = '')
	{
		return Cream::instance(__CLASS__, $file);
	}

	/**
	 * Initialze function
	 * 
	 * @param string $file
	 */
    public function __instance($file = '')
    {
        if ($file) {
            $this->_file = $file;
        }
        return $this;
    }

    public function getFile()
    {
        return $this->_file;
    }

    public function getGenerator()
    {
        if (is_null($this->_generator)) {
            $this->_generator = new Cream_Xml_Generator();
        }
        return $this->_generator;
    }

    /**
     * @param array $content
     */
    public function save($content)
    {
        $xmlContent = $this->getGenerator();
		$xmlContent->arrayToXml($content);
        $xmlContent->save($this->getFile());
    }
}