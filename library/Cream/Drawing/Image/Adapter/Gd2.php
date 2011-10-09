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
 * GD2 Adapter
 *
 * @package		System_Drawing_Image_Adapter
 * @author		Danny Verkade
 */
class System_Drawing_Image_Adapter_Gd2 extends System_Drawing_Image_Adapter_Abstract
{
	/**
	 * Array if required extenstions
	 *
	 * @var array
	 */
    protected $requiredExtensions = array("gd");

    /**
     * Callbacks, each image type has different create and outpout
     * functions.
     *
     * @var array
     */
	protected $callbacks = array(
        IMAGETYPE_GIF  => array('output' => 'imagegif',  'create' => 'imagecreatefromgif'),
        IMAGETYPE_JPEG => array('output' => 'imagejpeg', 'create' => 'imagecreatefromjpeg'),
        IMAGETYPE_PNG  => array('output' => 'imagepng',  'create' => 'imagecreatefrompng'),
        IMAGETYPE_XBM  => array('output' => 'imagexbm',  'create' => 'imagecreatefromxbm'),
        IMAGETYPE_WBMP => array('output' => 'imagewbmp', 'create' => 'imagecreatefromxbm'),
    );

    /**
     * Create a new instance of this class
     *
     * @return System_Drawing_Image_Adapter_Gd2
     */
    public static function instance()
    {
    	return Cream::instance(__CLASS__);
    }

    /**
     * Open a file
     *
     * @param string $filename
     */
    public function open($filename)
    {
        $this->fileName = $filename;
        $this->getMimeType();
        $this->getFileAttributes();
        $this->imageHandler = call_user_func($this->getCallback('create'), $this->fileName);
    }

    /**
     * Saves the image
     *
     * @param unknown_type $destination
     * @param unknown_type $newName
     */
    public function save($destination = null, $newName = null, $quality = null)
    {
        $fileName = (!isset($destination)) ? $this->fileName : $destination;

        if( isset($destination) && isset($newName) ) {
            $fileName = $destination . "/" . $fileName;
        } elseif( isset($destination) && !isset($newName) ) {
            $info = pathinfo($destination);
            $fileName = $destination;
            $destination = $info['dirname'];
        } elseif( !isset($destination) && isset($newName) ) {
            $fileName = $this->fileSrcPath . "/" . $newName;
        } else {
            $fileName = $this->fileSrcPath . $this->fileSrcName;
        }

        $destinationDir = ( isset($destination) ) ? $destination : $this->fileSrcPath;

        if(!is_writable($destinationDir) ) {
            try {
                $io = Cream_IO_File::instance();
                $io->mkdir($destination);
            } catch (Exception $e) {
                throw new System_Drawing_Image_Adapter_Exception("Unable to write file into directory '{$destinationDir}'. Access forbidden.");
            }
        }

        // keep alpha transparency
        $isAlpha     = false;
        $this->getTransparency($this->imageHandler, $this->fileType, $isAlpha);
        if ($isAlpha) {
            $this->fillBackgroundColor($this->imageHandler);
        }
        
        if ($quality !== null) {
        	call_user_func($this->getCallback('output'), $this->imageHandler, $fileName, $quality);
        } else {
        	call_user_func($this->getCallback('output'), $this->imageHandler, $fileName);
        }
    }

    /**
     * Displays the image
     *
     */
    public function display($quality = null)
    {
        header("Content-type: ". $this->getMimeType());
        
        if ($quality !== null) {
        	call_user_func($this->getCallback('output'), $this->imageHandler, null, $quality);
        } else {
        	call_user_func($this->getCallback('output'), $this->imageHandler);
        }
    }

    /**
     * Obtain function name, basing on image type and callback type
     *
     * @param string $callbackType
     * @param int $fileType
     * @return string
     * @throws System_Drawing_Image_Adapter_Exception
     */
    protected function getCallback($callbackType, $fileType = null, $unsupportedText = 'Unsupported image format.')
    {
        if (null === $fileType) {
            $fileType = $this->fileType;
        }

        if (empty($this->callbacks[$fileType])) {
            throw new System_Drawing_Image_Adapter_Exception($unsupportedText);
        }

        if (empty($this->callbacks[$fileType][$callbackType])) {
            throw new System_Drawing_Image_Adapter_Exception('Callback not found.');
        }

        return $this->callbacks[$fileType][$callbackType];
    }

    /**
     * Enter description here...
     *
     * @param unknown_type $imageResourceTo
     * @return unknown
     */
    private function fillBackgroundColor(&$imageResourceTo)
    {
        // try to keep transparency, if any
        if ($this->keepTransparency) {
            $isAlpha = false;
            $transparentIndex = $this->getTransparency($this->imageHandler, $this->fileType, $isAlpha);
            try {
                // fill truecolor png with alpha transparency
                if ($isAlpha) {
                    if (!imagealphablending($imageResourceTo, false)) {
                        throw new System_Drawing_Image_Adapter_Exception('Failed to set alpha blending for PNG image.');
                    }
                    $transparentAlphaColor = imagecolorallocatealpha($imageResourceTo, 0, 0, 0, 127);
                    if (false === $transparentAlphaColor) {
                        throw new System_Drawing_Image_Adapter_Exception('Failed to allocate alpha transparency for PNG image.');
                    }
                    if (!imagefill($imageResourceTo, 0, 0, $transparentAlphaColor)) {
                        throw new System_Drawing_Image_Adapter_Exception('Failed to fill PNG image with alpha transparency.');
                    }
                    if (!imagesavealpha($imageResourceTo, true)) {
                        throw new System_Drawing_Image_Adapter_Exception('Failed to save alpha transparency into PNG image.');
                    }
                    return $transparentAlphaColor;
                }
                // fill image with indexed non-alpha transparency
                elseif (false !== $transparentIndex) {
                    list($r, $g, $b)  = array_values(imagecolorsforindex($this->imageHandler, $transparentIndex));
                    $transparentColor = imagecolorallocate($imageResourceTo, $r, $g, $b);
                    if (false === $transparentColor) {
                        throw new System_Drawing_Image_Adapter_Exception('Failed to allocate transparent color for image.');
                    }
                    if (!imagefill($imageResourceTo, 0, 0, $transparentColor)) {
                        throw new System_Drawing_Image_Adapter_Exception('Failed to fill image with transparency.');
                    }
                    imagecolortransparent($imageResourceTo, $transparentColor);
                    return $transparentColor;
                }
            }
            catch (Exception $e) {
                // fallback to default background color
            }
        }
        list($r, $g, $b) = $this->backgroundColor;
        $color = imagecolorallocate($imageResourceTo, $r, $g, $b);
        if (!imagefill($imageResourceTo, 0, 0, $color)) {
            throw new System_Drawing_Image_Adapter_Exception("Failed to fill image background with color {$r} {$g} {$b}.");
        }
        return $color;
    }

    /**
     * Enter description here...
     *
     * @param unknown_type $imageResource
     * @param unknown_type $fileType
     * @param unknown_type $isAlpha
     * @param unknown_type $isTrueColor
     * @return unknown
     */
    private function getTransparency($imageResource, $fileType, &$isAlpha = false, &$isTrueColor = false)
    {
        $isAlpha     = false;
        $isTrueColor = false;
        // assume that transparency is supported by gif/png only
        if ((IMAGETYPE_GIF === $fileType) || (IMAGETYPE_PNG === $fileType)) {
            // check for specific transparent color
            $transparentIndex = imagecolortransparent($imageResource);
            if ($transparentIndex >= 0) {
                return $transparentIndex;
            }
            // assume that truecolor PNG has transparency
            elseif (IMAGETYPE_PNG === $fileType) {
                $isAlpha     = true;
                $isTrueColor = true;
                return $transparentIndex; // -1
            }
        }
        if (IMAGETYPE_JPEG === $fileType) {
            $isTrueColor = true;
        }
        return false;
    }

    /**
     * Change the image size
     *
     * @param int $frameWidth
     * @param int $frameHeight
     */
    public function resize($frameWidth = null, $frameHeight = null)
    {
        if (empty($frameWidth) && empty($frameHeight)) {
            throw new System_Drawing_Image_Adapter_Exception('Invalid image dimensions.');
        }

        // calculate lacking dimension
        if (!$this->keepFrame) {
            if (null === $frameWidth) {
                $frameWidth = round($frameHeight * ($this->imageSrcWidth / $this->imageSrcHeight));
            }
            elseif (null === $frameHeight) {
                $frameHeight = round($frameWidth * ($this->imageSrcHeight / $this->imageSrcWidth));
            }
        }
        else {
            if (null === $frameWidth) {
                $frameWidth = $frameHeight;
            }
            elseif (null === $frameHeight) {
                $frameHeight = $frameWidth;
            }
        }

        // define coordinates of image inside new frame
        $srcX = 0;
        $srcY = 0;
        $dstX = 0;
        $dstY = 0;
        $dstWidth  = $frameWidth;
        $dstHeight = $frameHeight;
        if ($this->keepAspectRatio) {
            // do not make picture bigger, than it is, if required
            if ($this->constrainOnly) {
                if (($frameWidth >= $this->imageSrcWidth) && ($frameHeight >= $this->imageSrcHeight)) {
                    $dstWidth  = $this->imageSrcWidth;
                    $dstHeight = $this->imageSrcHeight;
                }
            }
            // keep aspect ratio
            if ($this->imageSrcWidth / $this->imageSrcHeight >= $frameWidth / $frameHeight) {
                $dstHeight = round(($dstWidth / $this->imageSrcWidth) * $this->imageSrcHeight);
            } else {
                $dstWidth = round(($dstHeight / $this->imageSrcHeight) * $this->imageSrcWidth);
            }
        }
        // define position in center (TODO: add positions option)
        $dstY = round(($frameHeight - $dstHeight) / 2);
        $dstX = round(($frameWidth - $dstWidth) / 2);

        // get rid of frame (fallback to zero position coordinates)
        if (!$this->keepFrame) {
            $frameWidth  = $dstWidth;
            $frameHeight = $dstHeight;
            $dstY = 0;
            $dstX = 0;
        }

        // create new image
        $isAlpha     = false;
        $isTrueColor = false;
        $this->getTransparency($this->imageHandler, $this->fileType, $isAlpha, $isTrueColor);
        if ($isTrueColor) {
            $newImage = imagecreatetruecolor($frameWidth, $frameHeight);
        }
        else {
            $newImage = imagecreate($frameWidth, $frameHeight);
        }

        // fill new image with required color
        $this->fillBackgroundColor($newImage);

        // resample source image and copy it into new frame
        imagecopyresampled($newImage, $this->imageHandler, $dstX, $dstY, $srcX, $srcY, $dstWidth, $dstHeight, $this->imageSrcWidth, $this->imageSrcHeight);
        $this->imageHandler = $newImage;
        $this->refreshImageDimensions();
    }

    /**
     * Rotates an image
     *
     * @param string $angle
     */
    public function rotate($angle)
    {
        $this->imageHandler = imagerotate($this->imageHandler, $angle, $this->imageBackgroundColor);
        $this->refreshImageDimensions();
    }

    /**
     * Enter description here...
     *
     * @param unknown_type $watermarkImage
     * @param unknown_type $positionX
     * @param unknown_type $positionY
     * @param unknown_type $watermarkImageOpacity
     * @param unknown_type $repeat
     */
    public function watermark($watermarkImage, $positionX = 0, $positionY = 0, $watermarkImageOpacity = 30, $repeat = false)
    {
        list($watermarkSrcWidth, $watermarkSrcHeight, $watermarkFileType, ) = getimagesize($watermarkImage);
        $this->_getFileAttributes();
        $watermark = call_user_func($this->_getCallback('create', $watermarkFileType, 'Unsupported watermark image format.'), $watermarkImage);

        $merged = false;

        if( $this->getWatermarkWidth() && $this->getWatermarkHeigth() && ($this->getWatermarkPosition() != self::POSITION_STRETCH) ) {
            $newWatermark = imagecreatetruecolor($this->getWatermarkWidth(), $this->getWatermarkHeigth());
            imagealphablending($newWatermark, false);
            $col = imagecolorallocate($newWatermark, 255, 255, 255);
            imagecolortransparent($newWatermark, $col);
            imagefilledrectangle($newWatermark, 0, 0, $this->getWatermarkWidth(), $this->getWatermarkHeigth(), $col);
            imagealphablending($newWatermark, true);

            imagecopyresampled($newWatermark, $watermark, 0, 0, 0, 0, $this->getWatermarkWidth(), $this->getWatermarkHeigth(), imagesx($watermark), imagesy($watermark));
            $watermark = $newWatermark;
        }

        if( $this->getWatermarkPosition() == self::POSITION_TILE ) {
            $repeat = true;
        } elseif( $this->getWatermarkPosition() == self::POSITION_STRETCH ) {
            $newWatermark = imagecreatetruecolor($this->_imageSrcWidth, $this->_imageSrcHeight);
            imagealphablending($newWatermark, false);
            $col = imagecolorallocate($newWatermark, 255, 255, 255);
            imagecolortransparent($newWatermark, $col);
            imagefilledrectangle($newWatermark, 0, 0, $this->_imageSrcWidth, $this->_imageSrcHeight, $col);
            imagealphablending($newWatermark, true);
            imagecopyresampled($newWatermark, $watermark, 0, 0, 0, 0, $this->_imageSrcWidth, $this->_imageSrcHeight, imagesx($watermark), imagesy($watermark));
            $watermark = $newWatermark;
        } elseif( $this->getWatermarkPosition() == self::POSITION_TOP_RIGHT ) {
            $positionX = ($this->_imageSrcWidth - imagesx($watermark));
            imagecopy($this->_imageHandler, $watermark, $positionX, $positionY, 0, 0, imagesx($watermark), imagesy($watermark));
            $merged = true;
        } elseif( $this->getWatermarkPosition() == self::POSITION_TOP_LEFT  ) {
            imagecopy($this->_imageHandler, $watermark, $positionX, $positionY, 0, 0, imagesx($watermark), imagesy($watermark));
            $merged = true;
        } elseif( $this->getWatermarkPosition() == self::POSITION_BOTTOM_RIGHT ) {
            $positionX = ($this->_imageSrcWidth - imagesx($watermark));
            $positionY = ($this->_imageSrcHeight - imagesy($watermark));
            imagecopy($this->_imageHandler, $watermark, $positionX, $positionY, 0, 0, imagesx($watermark), imagesy($watermark));
            $merged = true;
        } elseif( $this->getWatermarkPosition() == self::POSITION_BOTTOM_LEFT ) {
            $positionY = ($this->_imageSrcHeight - imagesy($watermark));
            imagecopy($this->_imageHandler, $watermark, $positionX, $positionY, 0, 0, imagesx($watermark), imagesy($watermark));
            $merged = true;
        }

        if( $repeat === false && $merged === false ) {
            imagecopymerge($this->_imageHandler, $watermark, $positionX, $positionY, 0, 0, imagesx($watermark), imagesy($watermark), $watermarkImageOpacity);
        } else {
            $offsetX = $positionX;
            $offsetY = $positionY;
            while( $offsetY <= ($this->_imageSrcHeight+imagesy($watermark)) ) {
                while( $offsetX <= ($this->_imageSrcWidth+imagesx($watermark)) ) {
                    imagecopy($this->_imageHandler, $watermark, $offsetX, $offsetY, 0, 0, imagesx($watermark), imagesy($watermark));
                    $offsetX += imagesx($watermark);
                }
                $offsetX = $positionX;
                $offsetY += imagesy($watermark);
            }
        }
        imagedestroy($watermark);
        $this->refreshImageDimensions();
    }

    /**
     * Enter description here...
     *
     * @param unknown_type $top
     * @param unknown_type $bottom
     * @param unknown_type $right
     * @param unknown_type $left
     */
    public function crop($top = 0, $bottom = 0, $right = 0, $left = 0)
    {
        if( $left == 0 && $top == 0 && $right == 0 && $bottom == 0 ) {
            return;
        }

        $newWidth = $this->imageSrcWidth - $left - $right;
        $newHeight = $this->imageSrcHeight - $top - $bottom;

        $canvas = imagecreatetruecolor($newWidth, $newHeight);

        if ($this->fileType == IMAGETYPE_PNG) {
            $this->saveAlpha($canvas);
        }

        imagecopyresampled($canvas, $this->imageHandler, $top, $bottom, $right, $left, $this->imageSrcWidth, $this->imageSrcHeight, $newWidth, $newHeight);

        $this->imageHandler = $canvas;
        $this->refreshImageDimensions();
    }

    /**
     * Checks the dependencies, throws an error if an extension is
     * not found.
     *
     */
    public function checkDependencies()
    {
        foreach($this->requiredExtensions as $value) {
            if(!extension_loaded($value)) {
                throw new System_Drawing_Image_Adapter_Exception("Required PHP extension '{$value}' was not loaded.");
            }
        }
    }

    /**
     * Refreshes the image dimensions 
     *
     * @return void
     */
    protected function refreshImageDimensions()
    {
        $this->imageSrcWidth = imagesx($this->imageHandler);
        $this->imageSrcHeight = imagesy($this->imageHandler);
    }

    /**
     * Destruction method
     *
     */
    public function __destruct()
    {
    	try {
        	imagedestroy($this->imageHandler);
    	} catch (Exception $e) {
    		// Do nothing with exception, object is being destroyed.		
    	}
    }

    /*
     * Fixes saving PNG alpha channel
     */
    protected function saveAlpha($imageHandler)
    {
        $background = imagecolorallocate($imageHandler, 0, 0, 0);
        ImageColorTransparent($imageHandler, $background);
        imagealphablending($imageHandler, false);
        imagesavealpha($imageHandler, true);
    }
}