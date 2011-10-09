<?php

class Cream_Content_Serialization_Tokenizer implements Iterator
{
	/**
	 * Array with the data.
	 * 
	 * @var array
	 */
	protected $_data = array();

	/**
	 * Internal pointer.
	 * 
	 * @var integer
	 */
	protected $_pointer = 0;

	/**
	 * The token which is used to explode and implode the data.
	 *  
	 * @var strimg
	 */
	protected $_token;
	
	/**
	 * Create a new instance of this class. 
	 * 
	 * @param string $data
	 * @param string $token
	 */
	public static function instance($data = null, $token = "\r\n")
	{
		return Cream::instance(__CLASS__, $data, $token);
	}
	
	/**
	 * Initialize function.
	 * 
	 * @param string $data
	 * @param string $token
	 */
	public function __init($data = null, $token = "\r\n")
	{
		$this->_token = $token;
		
		if ($data) {	
			$data = explode($token, $data);
			$this->_data = $data;
		}
	}
	
	public function getLine()
	{
		return $this->current();
	}
	
	public function nextLine()
	{
		$this->next();
	}
	
	public function addLine($text)
	{
		$this->add($text);
	}
	
	public function getToken()
	{
		return $this->_token;
	}
	
	/**
     * Rewind the Iterator to the first element.
     * Similar to the reset() function for arrays in PHP.
     * Required by interface Iterator.
     *
     * @return void
     */
    public function rewind()
    {
        $this->_pointer = 0;
    }

    /**
     * Return the current element.
     * Similar to the current() function for arrays in PHP
     * Required by interface Iterator.
     *
     * @return mixed
     */
    public function current()
    {
        if ($this->valid() === false) {
            return null;
        }

        // return the value
        return $this->_data[$this->_pointer];
    }

    /**
     * Return the identifying key of the current element.
     * Similar to the key() function for arrays in PHP.
     * Required by interface Iterator.
     *
     * @return int
     */
    public function key()
    {
        return $this->_pointer;
    }

    /**
     * Move forward to next element.
     * Similar to the next() function for arrays in PHP.
     * Required by interface Iterator.
     *
     * @return void
     */
    public function next()
    {
        ++$this->_pointer;
    }

    /**
     * Check if there is a current element after calls to rewind() or next().
     * Used to check if we've iterated to the end of the collection.
     * Required by interface Iterator.
     *
     * @return bool False if there's nothing more to iterate over
     */
    public function valid()
    {
        return $this->_pointer < $this->count();
    }

    /**
     * Returns the number of elements in the collection.
     *
     * Implements Countable::count()
     *
     * @return int
     */
    public function count()
    {
        return count($this->_data);
    }

    /**
     * Returns true if and only if count($this) > 0.
     *
     * @return bool
     */
    public function exists()
    {
        return count($this->_data) > 0;
    }

	/**
	 * Add an item to the collection
	 *
	 * @param $data mixed
	 */
    public function add($data)
    {
    	$this->_data[] = $data;
    }	
}