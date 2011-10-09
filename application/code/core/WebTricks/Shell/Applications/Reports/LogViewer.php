<?php

class WebTricks_Shell_Applications_Reports_LogViewer extends WebTricks_Shell_Applications_Abstract
{
	public function getConfig()
	{
		return array(
			'id' => (string) $this->getApplicationItem()->getItemId(),		
			'windowConfig' => $this->_getWindowConfig(),
			'workspace' => $this->_getViewer()
		);
	}		
	
	protected function _getViewer()
	{
		$panel = Cream_Web_UI_ExtControls_Panel::instance();
		$panel->setHtml($this->_getLog());
		$panel->setAutoScroll(true);
		$panel->setLayout('fit');
		
		return $panel;
	}
	
	protected function _getLog()
	{
		$file = BP . DS . 'var'. DS .'log'. DS .'system.log';
		$fh = fopen($file, 'r'); 
		$data = fread($fh, filesize($file)); 
		fclose($fh); 		
		
		return nl2br($data);
	}
}