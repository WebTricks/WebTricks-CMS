<?php

class WebTricks_Shell_Web_UI_ExtControls_Desktop_Background extends Cream_Web_UI_ExtControl
{
	/**
	 * Create a new instance of this class
	 * 
	 * @return WebTricks_Shell_Web_UI_ExtControls_Desktop_Background
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
		
	public function setColor($color)
	{
		$this->setAttribute('color', $color);
	}
	
	public function setWallpaperPosition($wallpaperPosition)
	{
		$this->setAttribute('wallpaperPosition', $wallpaperPosition);
	}

	public function setWallpaper($wallpaper)
	{
		$this->setAttribute('wallpaper', $wallpaper);
	}
}