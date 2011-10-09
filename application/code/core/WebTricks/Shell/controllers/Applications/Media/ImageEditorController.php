<?php
/**
 * WebTricks - PHP Framework
 *
 * LICENSE
 *
 * For the full copyright and license information, please view the 
 * following URL: http://www.webtricksframework.com/license 
 *
 * @copyright Copyright (c) 2007-2010 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * 
 * @package		WebTricks_Shell
 * @author		Danny Verkade
 */
class WebTricks_Shell_Applications_Media_ImageEditorController extends WebTricks_Shell_Controller_Action
{
	/**
	 * 
	 * 
	 * @var Cream_Drawing_Image
	 */
	protected $image;
	
	/**
	 * Initialize function
	 * 
	 */
	public function __init()
	{
		$file = '';
		$itemId = '';
		
		if ($file) {
			$this->loadFromFile($file);
		} else {
			$this->loadFromItem($itemId);
		}
		
		parent::__init();
	}
	
	public function undoAction()
	{
		
	}
	
	public function redoAction()
	{
		
	}
	
	public function cropAction()
	{
		$this->image->crop();
		$this->update();
	}
	
	public function flipAction()
	{
		
	}
	
	public function rotateAction()
	{
		//$this->image->rotate($angle);
		$this->update();
	}
	
	public function resizeAction()
	{
		//$this->image->resize($width, $height);
		$this->update();
	}
	
	protected function update()
	{
		//$image = WebTricks_Shell_Web_UI_ExtControls_Media_Image::instance();
		//$image->setSrc();
		//$image->setHeight();
		//$image->setWidth();
		
		//$this->getResponse()->setBody(Cream_Json::encode($image));
	}
}