<?php

class Cream_Gdata_Analytics_AccountFeed extends Zend_Gdata_Feed
{
    /**
     * The classname for individual feed elements.
     *
     * @var string
     */
    protected $_entryClassName = 'Cream_Gdata_Analytics_AccountEntry';

    /**
     * The classname for the feed.
     *
     * @var string
     */
    protected $_feedClassName = 'Cream_Gdata_Analytics_AccountFeed';

    public function __construct($element = null)
    {
        $this->registerAllNamespaces(Cream_Gdata_Analytics::$namespaces);
        parent::__construct($element);
    }
}