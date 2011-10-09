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
 * Abstract adapter class
 * 
 * @package		System_Drawing_Image_Adapter
 * @author 		Danny Verkade
 */
abstract class System_Drawing_Image_Adapter_Abstract
{
    const POSITION_TOP_LEFT = 'top-left';
    const POSITION_TOP_RIGHT = 'top-right';
    const POSITION_BOTTOM_LEFT = 'bottom-left';
    const POSITION_BOTTOM_RIGHT = 'bottom-right';
    const POSITION_STRETCH = 'stretch';
    const POSITION_TILE = 'tile';

    protected $fileName = null;
	protected $imageBackgroundColor = 0;

    protected $fileType = null;
    protected $fileMimeType = null;
    protected $fileSrcName = null;
    protected $fileSrcPath = null;
    protected $imageHandler = null;
    protected $imageSrcWidth = null;
    protected $imageSrcHeight = null;
    protected $requiredExtensions = null;
    protected $watermarkPosition = null;
    protected $watermarkWidth = null;
    protected $watermarkHeigth = null;

    protected $keepAspectRatio;
    protected $keepFrame;
    protected $keepTransparency;
    protected $backgroundColor;
    protected $constrainOnly;

    /**
     * Open a file
     *
     * @param string $fileName
     */
    abstract public function open($fileName);

    /**
     * Saves an image
     *
     * @param unknown_type $destination
     * @param unknown_type $newName
     */
    abstract public function save($destination = null, $newName = null);

    /**
     * Writes an image to the browser
     *
     */
    abstract public function display();

    /**
     * Resizes an image
     *
     * @param integer $width
     * @param integer $height
     */
    abstract public function resize($width = null, $height = null);

    /**
     * Rotates an image
     *
     * @param unknown_type $angle
     */
    abstract public function rotate($angle);

    /**
     * Crops an image
     *
     * @param unknown_type $top
     * @param unknown_type $left
     * @param unknown_type $right
     * @param unknown_type $bottom
     */
    abstract public function crop($top = 0, $left = 0, $right = 0, $bottom = 0);

    /**
     * Watermarks an image
     *
     * @param unknown_type $watermarkImage
     * @param unknown_type $positionX
     * @param unknown_type $positionY
     * @param unknown_type $watermarkImageOpacity
     * @param unknown_type $repeat
     */
    abstract public function watermark($watermarkImage, $positionX = 0, $positionY = 0, $watermarkImageOpacity = 30, $repeat = false);

    /**
     * Checks if all dependencies has been loaded, throws an
     * Exception when an extenstion cann't be found.
     *
     */
    abstract public function checkDependencies();

    /**
     * Returns the mime type of the specified image
     *
     * @return string
     */
    public function getMimeType()
    {
        if(!$this->fileType) {
            list($this->imageSrcWidth, $this->imageSrcHeight, $this->fileType) = getimagesize($this->fileName);
            $this->fileMimeType = image_type_to_mime_type($this->fileType);
        }

        return $this->fileType;
    }

    /**
     * Retrieve Original Image Width
     *
     * @return int|null
     */
    public function getOriginalWidth()
    {
        $this->getMimeType();
        return $this->imageSrcWidth;
    }

    /**
     * Retrieve Original Image Height
     *
     * @return int|null
     */
    public function getOriginalHeight()
    {
        $this->getMimeType();
        return $this->imageSrcHeight;
    }

    /**
     * Enter description here...
     *
     * @param unknown_type $position
     */
    public function setWatermarkPosition($position)
    {
        $this->watermarkPosition = $position;
    }

    /**
     * Enter description here...
     *
     * @return unknown
     */
    public function getWatermarkPosition()
    {
        return $this->watermarkPosition;
    }

    /**
     * Enter description here...
     *
     * @param unknown_type $width
     */
    public function setWatermarkWidth($width)
    {
        $this->watermarkWidth = $width;
    }

    /**
     * Enter description here...
     *
     * @return unknown
     */
    public function getWatermarkWidth()
    {
        return $this->_watermarkWidth;
    }

    /**
     * Enter description here...
     *
     * @param unknown_type $heigth
     */
    public function setWatermarkHeigth($heigth)
    {
        $this->watermarkHeigth = $heigth;
    }

    /**
     * Enter description here...
     *
     * @return unknown
     */
    public function getWatermarkHeigth()
    {
        return $this->watermarkHeigth;
    }

    /**
     * Get/set keepAspectRatio
     *
     * @param bool $value
     * @return bool
     */
    public function keepAspectRatio($value = null)
    {
        if (null !== $value) {
            $this->keepAspectRatio = (bool)$value;
        }
        return $this->keepAspectRatio;
    }

    /**
     * Get/set keepFrame
     *
     * @param bool $value
     * @return bool
     */
    public function keepFrame($value = null)
    {
        if (null !== $value) {
            $this->keepFrame = (bool)$value;
        }
        return $this->keepFrame;
    }

    /**
     * Get/set keepTransparency
     *
     * @param bool $value
     * @return bool
     */
    public function keepTransparency($value = null)
    {
        if (null !== $value) {
            $this->keepTransparency = (bool)$value;
        }
        return $this->keepTransparency;
    }

    /**
     * Get/set constrainOnly
     *
     * @param bool $value
     * @return bool
     */
    public function constrainOnly($value = null)
    {
        if (null !== $value) {
            $this->constrainOnly = (bool)$value;
        }
        return $this->constrainOnly;
    }

    /**
     * Get/set keepBackgroundColor
     *
     * @param array $value
     * @return array
     */
    public function backgroundColor($value = null)
    {
        if (null !== $value) {
            if ((!is_array($value)) || (3 !== count($value))) {
                return;
            }
            foreach ($value as $color) {
                if ((!is_integer($color)) || ($color < 0) || ($color > 255)) {
                    return;
                }
            }
        }
        $this->backgroundColor = $value;
        return $this->backgroundColor;
    }

    /**
     * Enter description here...
     *
     */
    protected function getFileAttributes()
    {
        $pathinfo = pathinfo($this->fileName);

        $this->fileSrcPath = $pathinfo['dirname'];
        $this->fileSrcName = $pathinfo['basename'];
    }
}