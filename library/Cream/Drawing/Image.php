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
 * Image class
 *
 * @package		Cream_Drawing
 * @author		WebTicks Core Team <core@webtricksframework.com>
 */
class Cream_Drawing_Image extends Cream_ApplicationComponent
{
	/**
	 * Image adapter
	 * 
	 * @var Cream_Drawing_Image_Adapter_Abstract
	 */
    protected $adapter;

    /**
     * The filename
     * 
     * @var string
     */
    protected $fileName;
    
    /**
     * Create a new instance of this class
     * 
     * @param string $fileName
     * @param Cream_Drawing_Image_Adapter $adapter. Default value is GD2
     * @return Cream_Drawing_Image
     */
    public static function instance($fileName = null, $adapter = Cream_Drawing_Image_Adapter::ADAPTER_GD2) 
    {
    	return Cream::instance(__CLASS__, $fileName, $adapter);
    }

    /**
     * Constructor
     *
     * @param string $fileName
     * @param Cream_Drawing_Image_Adapter $adapter. Default value is GD2
     * @return void
     */
    function __init($fileName = null, $adapter = Cream_Drawing_Image_Adapter::ADAPTER_GD2)
    {
        $this->getAdapter($adapter);
        $this->fileName = $fileName;
        if ($fileName !== null) {
            $this->open();
        }
    }

    /**
     * Opens an image and creates image handle
     *
     * @access public
     * @return void
     */
    public function open()
    {
        $this->getAdapter()->checkDependencies();

        if( !file_exists($this->fileName) ) {
            throw new Cream_Exceptions_Exception("File '{$this->fileName}' does not exists.");
        }

        $this->getAdapter()->open($this->fileName);
    }

    /**
     * Display handled image in your browser
     *
     * @param integer $quality. The quality of the image to display,
     * only for JPG images and quality can be a value between 0 en 100. 
     * @return void
     */
    public function display($quality = null)
    {
        $this->getAdapter()->display($quality);
    }

    /**
     * Save handled image into file
     *
     * @param string $destination. Default value is NULL
     * @param string $newFileName. Default value is NULL
     * @param string $quality. Quality of the file to save (only for JPG images)
     * @access public
     * @return void
     */
    public function save($destination = null, $newFileName = null, $quality = null)
    {
        $this->getAdapter()->save($destination, $newFileName, $quality);
    }

    /**
     * Rotate an image.
     *
     * @param int $angle
     * @access public
     * @return void
     */
    public function rotate($angle)
    {
        $this->getAdapter()->rotate($angle);
    }

    /**
     * Crop an image.
     *
     * @param int $top. Default value is 0
     * @param int $left. Default value is 0
     * @param int $right. Default value is 0
     * @param int $bottom. Default value is 0
     * @access public
     * @return void
     */
    public function crop($top = 0, $left = 0, $right = 0, $bottom = 0)
    {
        $this->getAdapter()->crop($left, $top, $right, $bottom);
    }

    /**
     * Resize an image
     *
     * @param integer $width
     * @param integer $height
     * @return void
     */
    public function resize($width, $height = null)
    {
        $this->getAdapter()->resize($width, $height);
    }

    /**
     * Set if the aspect ratio needs to be preserved when resizing an
     * image. When set to true, the aspect ratio will be preserved,
     * when set to false it won't.
     * 
     * @param bolean $value
     * @return void
     */
    public function keepAspectRatio($value)
    {
        return $this->getAdapter()->keepAspectRatio($value);
    }

    public function keepFrame($value)
    {
        return $this->getAdapter()->keepFrame($value);
    }

    public function keepTransparency($value)
    {
        return $this->getAdapter()->keepTransparency($value);
    }

    public function constrainOnly($value)
    {
        return $this->getAdapter()->constrainOnly($value);
    }

    public function backgroundColor($value)
    {
        return $this->getAdapter()->backgroundColor($value);
    }

    /**
     * Adds watermark to our image.
     *
     * @param string $watermarkImage. Absolute path to watermark image.
     * @param int $positionX. Watermark X position.
     * @param int $positionY. Watermark Y position.
     * @param int $watermarkImageOpacity. Watermark image opacity.
     * @param bool $repeat. Enable or disable watermark brick.
     * @return void
     */
    public function watermark($watermarkImage, $positionX = 0, $positionY = 0, $watermarkImageOpacity = 30, $repeat = false)
    {
        if( !file_exists($watermarkImage) ) {
            throw new Exception("Required file '{$watermarkImage}' does not exists.");
        }
        
        $this->_getAdapter()->watermark($watermarkImage, $positionX, $positionY, $watermarkImageOpacity, $repeat);
    }

    /**
     * Get mime type of handled image
     *
     * @access public
     * @return string
     */
    public function getMimeType()
    {
        return $this->getAdapter()->getMimeType();
    }

    /**
     * Set image background color
     *
     * @param int $color
     * @access public
     * @return void
     */
    public function setImageBackgroundColor($color)
    {
        $this->getAdapter()->imageBackgroundColor = intval($color);
    }

    public function setWatermarkPosition($position)
    {
        $this->getAdapter()->setWatermarkPosition($position);
    }

    public function setWatermarkWidth($width)
    {
        $this->getAdapter()->setWatermarkWidth($width);
    }

    public function setWatermarkHeigth($heigth)
    {
        $this->getAdapter()->setWatermarkHeigth($heigth);
    }

    /**
     * Retrieve image adapter object
     *
     * @param string $adapter
     * @return Cream_Drawing_Image_Adapter_Abstract
     */
    protected function getAdapter($adapter = null)
    {
        if(!$this->adapter) {
        	if (Cream::isInstanceOf($adapter, 'Cream_Drawing_Image_Adapter_Abstract')) {
        		$this->adapter = $adapter;
        	} else {
            	$this->adapter = Cream_Drawing_Image_Adapter::factory($adapter);
        	}
        }
        
        return $this->adapter;
    }

    /**
     * Retrieve original image width
     *
     * @return int|null
     */
    public function getOriginalWidth()
    {
        return $this->getAdapter()->getOriginalWidth();
    }

    /**
     * Retrieve original image height
     *
     * @return int|null
     */
    public function getOriginalHeight()
    {
        return $this->getAdapter()->getOriginalHeight();
    }
}