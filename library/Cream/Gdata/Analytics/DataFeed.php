<?php

class Cream_Gdata_Analytics_DataFeed extends Zend_Gdata_Feed
{

    /**
     * The classname for individual feed elements.
     *
     * @var string
     */
    protected $_entryClassName = 'Cream_Gdata_Analytics_DataEntry';
    /**
     * The classname for the feed.
     *
     * @var string
     */
    protected $_feedClassName = 'Cream_Gdata_Analytics_DataFeed';

    public function __construct($element = null)
    {
        $this->registerAllNamespaces(Cream_Gdata_Analytics::$namespaces);
        parent::__construct($element);
    }
}