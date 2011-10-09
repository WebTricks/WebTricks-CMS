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
 * Iterator class the loop truth an collection of items. This class is extended
 * by a collection class which can add several functions to alter the data of
 * the collection.
 *
 * @package		Cream_Collection
 * @author		Danny Verkade
 */
class Cream_Collection_Iterator implements Iterator, Countable
{
	/**
	 * Array with data
	 * 
	 * @var array
	 */
	protected $_data = array();

	/**
	 * Internal pointer
	 * 
	 * @var integer
	 */
	protected $_pointer = 0;
	
	/**
	 * Create a new instance of this class.
	 * 
	 * @param array $data
	 * @return Cream_Collection_Iterator
	 */
	public static function instance($data = null) 
	{
		return Cream::instance(__CLASS__, $data);		
	}

	/**
	 * Initialize function
	 * 
	 * @param array $data
	 * @return void
	 */
	public function __init($data = null)
	{
		if (!is_null($data)) {
			$this->_data = $data;
		}
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

	/**
	 * Get a specific item
	 *
	 * @param $columnNumber integer
	 * @return mixed
	 */
    public function get($columnNumber)
    {
    	return $this->_data[$columnNumber];
    }
}