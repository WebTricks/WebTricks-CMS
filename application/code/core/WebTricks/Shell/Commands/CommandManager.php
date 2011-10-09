<?php

class WebTricks_Shell_Commands_CommandManager extends Cream_ApplicationComponent
{
	const CONFIG_PATH_COMMANDS = 'shell/commands';
	
	public static function instance()
	{
		return Cream::instance(__CLASS__);
	}
	
	public function queryState($name, $item)
	{
		
	}
	
	public function getCommand($name)
	{
		$name = $this->_getNameWithoutArguments($name);
		$name = str_replace(':', '_', $name);
		
		$node = $this->getApplication()->getConfig()->getNode(self::CONFIG_PATH_COMMANDS);

		if ($node && $node->$name) {
			$className = (string) $node->$name;
			if (Cream::exists($className)) {
				return Cream::instance($className);
			}	
		}
	}
	
	public function getDispatchCommand($sender, $command)
	{
		return $this->_getMessageCommand($sender, $command, true);
	}
	
	public function sendMessage($sender, $command, $argumentsFromRequest = false)
	{
		$messageCommand = $this->_getMessageCommand($sender, $command, $argumentsFromRequest);
		
		$context = WebTricks_Shell_Commands_CommandContext::instance();
		$context->setMessage($messageCommand->getMessage());
		
		$messageCommand->execute($context);
	}
	
	protected function _getNameWithoutArguments($name) 
	{	
		if (strpos($name, '(')) {
			$name = substr($name, 0, strpos($name, '('));
		}
		
		return $name;
	}

	protected function _getArgumentsFromMessage($name, $delimiter = ',')
	{
		$parameters = array();
		$start = strpos($name, '(');
		$stop = strpos($name, ')');
		
		if ($start) {
			if (!$stop) {
				throw new Cream_Exceptions_Exception('Message with arguments should en with a ")"');
			}
			
			$arguments = explode($delimiter, substr($name, $start+1, $stop-$start-1));
			foreach($arguments as $argument) {
				list($argumentName, $argumentValue) = explode('=', $argument);
				
				$argumentName = trim($argumentName);
				$argumentValue = trim($argumentValue);
				
				$parameters[$argumentName] = $argumentValue;				
			}
		}
		
		return $parameters;
	}
	
	protected function _getArgumentsFromRequest()
	{
		$arguments = array();
		$params = Cream_Json::decode($this->getApplication()->getRequest()->getParam('params'));
		
		foreach($params as $key => $value)
		{
			if (substr($key, 0, 2) == '__') {
				$key = substr($key, 2);
				$arguments[$key] = $value;
			}
		}
		
		return $arguments;
	}
	
	protected function _getMessageCommand($sender, $message, $argumentsFromRequest = false)
	{
		$message = $this->_getMessage($sender, $message, $argumentsFromRequest);
		$messageCommand = WebTricks_Shell_Commands_MessageCommand::instance($message);
		return $messageCommand;
	}
	
	protected function _getMessage($sender, $message, $argumentsFromRequest = false)
	{
		if ($argumentsFromRequest) {
			$arguments = $this->_getArgumentsFromRequest();
		} else {
			$arguments = $this->_getArgumentsFromMessage($message);
		}
		
		$message = WebTricks_Shell_Commands_Message::instance($sender, $this->_getNameWithoutArguments($message));
		$message->addData($arguments);
		
		return $message;
	}
}