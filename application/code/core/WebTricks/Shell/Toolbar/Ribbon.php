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
 * @copyright Copyright (c) 2007-2010 Cream (http://www.cream.nl)
 * @license   http://www.webtricksframework.com/license
 */

/**
 * Toolbar class to generate and ExtJS ribbon toolbar based on a
 * content item.
 * 
 * @package		WebTricks_Shell
 * @author		Danny Verkade
 */
class WebTricks_Shell_Toolbar_Ribbon
{
	const LARGE_BUTTON = 'a09e3022-3242-4e5e-9940-7fe0d0ecaeae';
	
	const LARGE_GALLERY_BUTTON = '07bdc8a6-e068-479a-b49a-c3cf55654e20';
	
	const SMALL_BUTTON = 'e7b6da37-0009-43eb-81d1-80632f448be1';
	
	const SMALL_TOGGLE_BUTTON = 'cb79217f-c051-482e-b0ec-7068df7804b0';
	
	const SMALL_MENU_COMBO_BUTTON = '52e27a46-dab2-42ee-881c-7f3b9433b27a';
	
	const PANEL = 'f6bea742-4707-419f-8b8f-a577a622f8fe';
	
	/**
	 * Context of the command.
	 * 
	 * @var WebTricks_Shell_Commands_CommandContext
	 */
	protected $_commandContext;
	
	/**
	 * Create a new instance of this class
	 * 
	 * @return WebTricks_Shell_Toolbar_Ribbon
	 */
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	/**
	 * Returns the context for the ribbon rendering.
	 * 
	 * @return WebTricks_Shell_Commands_CommandContext
	 */
	public function getCommandContext()
	{
		return $this->_commandContext;
	}
	
	/**
	 * Sets the context for the ribbon rendering.
	 * 
	 * @param WebTricks_Shell_Commands_CommandContext $context
	 */
	public function setCommandContext(WebTricks_Shell_Commands_CommandContext $context)
	{
		$this->_commandContext = $context;
	}
	
	/**
	 * Creates a ribbon toolbar based on the given content item.
	 * 
	 * @param Cream_Content_Item $item
	 * @return WebTricks_Shell_Web_UI_ExtControls_Toolbar_Ribbon
	 */
	public function getExtControl(Cream_Content_Item $item)
	{
		$control = WebTricks_Shell_Web_UI_ExtControls_Toolbar_Ribbon::instance();
		$control->setActiveTab(0);
		
		if ((string) $item->get('Sticky Chunk')) {
			$itemId = Cream_Guid::parseGuid((string) $item->get('Sticky Chunk'));
			$stickyChunkItem = $item->getRepository()->getItem($itemId);

			$control->setItems($this->_getStrips($item, $stickyChunkItem));
			
		} else {
			$control->setItems($this->_getStrips($item));
		}
		
		return $control;
	}
	
	/**
	 * Returns an array with the strips for the ribbon. The strips will be
	 * retrieved bases on the given conten item. If a sticky chunk is given,
	 * it will be displayed as the first chunk of every strip.
	 * 
	 * @param Cream_Content_Item $ribbon
	 * @param Cream_Content_Item $stickyChunkItem
	 * @return array
	 */
	protected function _getStrips(Cream_Content_Item $ribbon, $stickyChunkItem = null)
	{
		$strips = array();
		
		foreach($ribbon->getChildren() as $strip) {
			if ($strip->getTemplateId() == Cream_Application_TemplateIds::getReferenceId()) {
				$referenceId = Cream_Guid::parseGuid($strip->get('Reference'));
				$strip = $strip->getRepository()->getItem($referenceId);
			}
			
			$strips[] = $this->_getStrip($strip, $stickyChunkItem);
			
		}
		
		return $strips;
	}
	
	/**
	 * Returns an ExtJS control of the strip.
	 * 
	 * @param Cream_Content_Item $strip
	 * @param Cream_Content_Item $stickyChunkItem
	 * @return WebTricks_Shell_Web_UI_ExtControls_Toolbar_Strip
	 */
	protected function _getStrip(Cream_Content_Item $strip, $stickyChunkItem = null)
	{
		$stripControl = WebTricks_Shell_Web_UI_ExtControls_Toolbar_Strip::instance();
		$stripControl->setTitle((string) $strip->get('Header'));
		$stripControl->setChunks($this->_getChunks($strip, $stickyChunkItem));		
		
		return $stripControl;
	}
	
	/**
	 * Returns an array of chunk items to display in a strip.
	 *  
	 * @param Cream_Content_Item $strip
	 * @param Cream_Content_Item $stickyChunkItem
	 * @return array
	 */
	protected function _getChunks(Cream_Content_Item $strip, $stickyChunkItem = null)
	{
		$chunks = array();
		
		if ($stickyChunkItem) {
			$chunks[] = $this->_getChunk($stickyChunkItem);
		}
		
		foreach($strip->getChildren() as $chunkItem) {
			if ($chunkItem->getTemplateId() == Cream_Application_TemplateIds::getReferenceId()) {
				$referenceId = Cream_Guid::parseGuid($chunkItem->get('Reference'));
				$chunkItem = $chunkItem->getRepository()->getItem($referenceId);
			}
			
			$chunk = $this->_getChunk($chunkItem);
			
			if ($chunk) {
				$chunks[] = $chunk;
			}
		}
		
		return $chunks;
	}
	
	/**
	 * Returns an ExtJS control of the chunk.
	 * 
	 * @param Cream_Content_Item $chunk
	 * @return WebTricks_Shell_Web_UI_ExtControls_Toolbar_Chunk
	 */
	protected function _getChunk(Cream_Content_Item $chunk)
	{
		$columns = 0;
		$enabled = WebTricks_Shell_Commands_CommandState::ENABLED;
		$click = (string) $chunk->get('Click');
		$buttons = $this->_getButtons($chunk, $columns);
		
		if (count($buttons)) {
			if ($click) {
				$command = WebTricks_Shell_Commands_CommandProvider::getCommand($click);
				
				if ($command) {
					$click = $command->getClick($click);
					$enabled = $command->queryState();
				}
			}
	
			$chunkControl = WebTricks_Shell_Web_UI_ExtControls_Toolbar_Chunk::instance();
			$chunkControl->setTitle((string) $chunk->get('Header'));
			$chunkControl->associate('cfg', array('columns' => ceil($columns)));
			$chunkControl->setItems($buttons);
			
			if ($click && $enabled == WebTricks_Shell_Commands_CommandState::ENABLED) {
				$chunkControl->setOnTitleClick(Cream_Expression::instance('function() { alert(this.application.getModule(\'16192c38-8337-4895-9364-4d29e78b7b40\').invokeCommand(\''. $click .'\')); }'));
				$chunkControl->associate('scope', Cream_Expression::instance('this'));
			}
			
			return $chunkControl;
		}
	}
	
	/**
	 * Returns an array of buttons to display in a chunk.
	 * 
	 * @param Cream_Content_Item $chunk
	 * @param integer $columns
	 * @return array
	 */
	protected function _getButtons(Cream_Content_Item $chunk, &$columns)
	{
		$buttons = array();
		
		foreach($chunk->getChildren() as $button) {
			if ($button->getTemplateId() == Cream_Application_TemplateIds::getReferenceId()) {
				$referenceId = Cream_Guid::parseGuid($button->get('Reference'));
				$button = $chunk->getRepository()->getItem($referenceId);
			}
			
			$control = $this->_getButton($button, $columns);
			
			if ($control) {
				$buttons[] = $control;
			}
		}
		
		return $buttons;
	}
	
	/**
	 * Returns an ExtJS control to display in a chunk.
	 * 
	 * @param Cream_Content_Item $button
	 * @param integer $columns
	 * @return Cream_Web_UI_ExtControls_Component
	 */
	protected function _getButton(Cream_Content_Item $button, &$columns)
	{
		switch($button->getTemplateId()) {
			case self::PANEL:
				$control = $this->_getPanel($button);
				if ($control) {
					$columns++;
				}
				break;
			case self::LARGE_BUTTON:
				$control = $this->_getLargeButton($button);
				if ($control) {
					$columns++;
				}
				break;
			case self::LARGE_GALLERY_BUTTON:
				$control = $this->_getLargeGalleryButton($button);
				if ($control) {
					$columns++;
				}
				break;				
			case self::SMALL_BUTTON:
				$control = $this->_getSmallButton($button);
				if ($control) {
					$columns = $columns + 0.5;
				}
				break;
			case self::SMALL_TOGGLE_BUTTON:
				$control = $this->_getSmallToggleButton($button);
				if ($control) {
					$columns = $columns + 0.5;
				}
				break;
			case self::SMALL_MENU_COMBO_BUTTON:
				$control = $this->_getSmallMenuComboButton($button);
				if ($control) {
					$columns = $columns + 0.5;
				}
				break;
			default:
				$control = $this->_getLargeButton($button);
				if ($control) {
					$columns++;
				}
				break;
		}
		
		return $control;
	}
	
	/**
	 * Create an ExtJS control for a large button.
	 * 
	 * @param Cream_Content_Item $button
	 * @return Cream_Web_UI_ExtControls_Button
	 */
	protected function _getLargeButton(Cream_Content_Item $button)
	{
		$enabled = WebTricks_Shell_Commands_CommandState::ENABLED;
		$click = (string) $button->get('Click');
		$icon = (string) $button->get('Icon');
		$header = (string) $button->get('Header');
		
		$command = WebTricks_Shell_Commands_CommandProvider::getCommand($click);
		
		if ($command) {
			$enabled = $command->queryState($this->_commandContext);
		}
		
		if ($enabled != WebTricks_Shell_Commands_CommandState::HIDDEN) {
		
			$buttonControl = Cream_Web_UI_ExtControls_Button::instance();
			$buttonControl->setScale('large');
			$buttonControl->setText((string) $button->get('Header'));
			$buttonControl->setTooltip((string) $button->get('Tooltip'));
			$buttonControl->setIconCls('icon-large-'. $button->get('Icon'));
			$buttonControl->setIconAlign('top');
			$buttonControl->setHandler(Cream_Expression::instance('function() { alert(this.application.getModule(\'16192c38-8337-4895-9364-4d29e78b7b40\').invokeCommand(\''. $click .'\')); }'));
			//$buttonControl->setHandler(Cream_Expression::instance('function() { alert(this.invokeCommand(\''. $click .'\')); }'));
			$buttonControl->setScope(Cream_Expression::instance('this'));
			$buttonControl->associate('rowspan', 2);
			
			if ($enabled == WebTricks_Shell_Commands_CommandState::DISABLED) {
				$buttonControl->setDisabled(true);
			}
			
			if ($enabled == WebTricks_Shell_Commands_CommandState::DOWN) {
				$buttonControl->setPressed(true);
			}
		
			return $buttonControl;
		}
	}
	
	/**
	 * Create an ExtJS control for a large gallery button.
	 * 
	 * @param Cream_Content_Item $button
	 * @return Cream_Web_UI_ExtControls_Button
	 */
	protected function _getLargeGalleryButton(Cream_Content_Item $button)
	{
		$enabled = WebTricks_Shell_Commands_CommandState::ENABLED;
		$click = (string) $button->get('Command');
		$icon = (string) $button->get('Icon');
		$header = (string) $button->get('Header');
		
		$command = WebTricks_Shell_Commands_CommandProvider::getCommand($click);
		
		if ($command) {
			$enabled = $command->queryState($this->_commandContext);
		}
		
		if ($enabled != WebTricks_Shell_Commands_CommandState::HIDDEN) {
		
			$buttonControl = Cream_Web_UI_ExtControls_Button::instance();
			$buttonControl->setScale('large');
			$buttonControl->setText((string) $button->get('Header'));
			$buttonControl->setTooltip((string) $button->get('Tooltip'));
			$buttonControl->setIconCls('icon-large-'. $button->get('Icon'));
			$buttonControl->setIconAlign('top');
			$buttonControl->setHandler(Cream_Expression::instance('function() { alert(this.application.getModule(\'16192c38-8337-4895-9364-4d29e78b7b40\').invokeCommand(\''. $click .'\')); }'));
			$buttonControl->setScope(Cream_Expression::instance('this'));
			$buttonControl->associate('rowspan', 2);
			
			if ($enabled == WebTricks_Shell_Commands_CommandState::DISABLED) {
				$buttonControl->setDisabled(true);
			}
			
			if ($enabled == WebTricks_Shell_Commands_CommandState::DOWN) {
				$buttonControl->setPressed(true);
			}
		
			return $buttonControl;
		}
	}
	
	/**
	 * Create an ExtJS control for a small button.
	 * 
	 * @param Cream_Content_Item $button
	 * @return Cream_Web_UI_ExtControls_Button
	 */	
	protected function _getSmallButton(Cream_Content_Item $button)
	{
		$enabled = WebTricks_Shell_Commands_CommandState::ENABLED;
		$click = (string) $button->get('Click');
		$icon = (string) $button->get('Icon');
		$header = (string) $button->get('Header');
				
		$command = WebTricks_Shell_Commands_CommandProvider::getCommand($click);
		
		if ($command) {
			$enabled = $command->queryState($this->_commandContext);
			$header = $command->getHeader($this->getCommandContext(), $header);
		}
		
		if ($enabled != WebTricks_Shell_Commands_CommandState::HIDDEN) {
		
			$buttonControl = Cream_Web_UI_ExtControls_Button::instance();
			$buttonControl->setScale('small');
			$buttonControl->setText((string) $header);
			$buttonControl->setTooltip((string) $button->get('Tooltip'));
			$buttonControl->setIconCls('icon-'. $button->get('Icon'));
			$buttonControl->setIconAlign('left');
			$buttonControl->setHandler(Cream_Expression::instance('function() { alert(this.application.getModule(\'16192c38-8337-4895-9364-4d29e78b7b40\').invokeCommand(\''. $click .'\')); }'));
			//$buttonControl->setHandler(Cream_Expression::instance('function() { alert(this.invokeCommand(\''. $click .'\')); }'));
			$buttonControl->setScope(Cream_Expression::instance('this'));
			$buttonControl->setHeight(28);
		
			if ($enabled == WebTricks_Shell_Commands_CommandState::DISABLED) {
				$buttonControl->setDisabled(true);
			}
			
			if ($enabled == WebTricks_Shell_Commands_CommandState::DOWN) {
				$buttonControl->setPressed(true);
			}
		
			return $buttonControl;
		}		
	}
	
	/**
	 * Create an ExtJS control for a small menu combo button.
	 * 
	 * @param Cream_Content_Item $button
	 * @return Cream_Web_UI_ExtControls_Button
	 */	
	protected function _getSmallMenuComboButton(Cream_Content_Item $button)
	{
		$enabled = WebTricks_Shell_Commands_CommandState::ENABLED;
		$click = (string) $button->get('Command');
		$icon = (string) $button->get('Icon');
		$header = (string) $button->get('Header');
				
		$command = WebTricks_Shell_Commands_CommandProvider::getCommand($click);
		
		if ($command) {
			$enabled = $command->queryState($this->_commandContext);
		}
		
		if ($enabled != WebTricks_Shell_Commands_CommandState::HIDDEN) {
		
			$buttonControl = Cream_Web_UI_ExtControls_Button::instance();
			$buttonControl->setScale('small');
			$buttonControl->setText((string) $button->get('Header'));
			$buttonControl->setTooltip((string) $button->get('Tooltip'));
			$buttonControl->setIconCls('icon-'. $button->get('Icon'));
			$buttonControl->setIconAlign('left');
			$buttonControl->setHandler(Cream_Expression::instance('this.save'));
			$buttonControl->setHeight(28);
		
			if ($enabled == WebTricks_Shell_Commands_CommandState::DISABLED) {
				$buttonControl->setDisabled(true);
			}
			
			if ($enabled == WebTricks_Shell_Commands_CommandState::DOWN) {
				$buttonControl->setPressed(true);
			}
		
			return $buttonControl;
		}		
	}	
	
	/**
	 * Create an ExtJS control for a small toggle button.
	 * 
	 * @param Cream_Content_Item $button
	 * @return Cream_Web_UI_ExtControls_Button
	 */	
	protected function _getSmallToggleButton(Cream_Content_Item $button)
	{
		$buttonControl = Cream_Web_UI_ExtControls_Button::instance();
		$buttonControl->setEnableToggle(true);
		$buttonControl->setScale('small');
		$buttonControl->setText((string) $button->get('Header'));
		$buttonControl->setTooltip((string) $button->get('Tooltip'));
		$buttonControl->setIconCls('icon-'. $button->get('Icon'));
		$buttonControl->setIconAlign('left');
		$buttonControl->setHandler(Cream_Expression::instance('this.save'));
		$buttonControl->setHeight(28);
				
		return $buttonControl;		
	}
	
	protected function _getPanel(Cream_Content_Item $button)
	{
		$type = $button->get('Type');
		
		if ((string) $type) {
			$panel = Cream::instance((string) $type);
			return $panel->getExtControl($button, $this->getCommandContext());
		}
	}
}