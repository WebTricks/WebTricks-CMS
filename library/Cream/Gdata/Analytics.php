<?php

class Cream_Gdata_Analytics extends Zend_Gdata {

	const AUTH_SERVICE_NAME = 'analytics';
	const ANALYTICS_FEED_URI = 'http://www.google.com/analytics/feeds';
	const ANALYTICS_ACCOUNT_FEED_URI = 'http://www.google.com/analytics/feeds/accounts';

	public static $namespaces = array(
        array('ga', 'http://schemas.google.com/analytics/2009', 1, 0));

    /**
     * Create Cream_Gdata_Analytics object
     *
     * @param Zend_Http_Client $client (optional) The HTTP client to use when
     *          when communicating with the Google Apps servers.
     * @param string $applicationId The identity of the app in the form of Company-AppName-Version
     */
	public function __construct($client = null, $applicationId = 'MyCompany-MyApp-1.0')
    {
        $this->registerPackage('Zend_Gdata_Analyitcs');
        $this->registerPackage('Zend_Gdata_Analyitcs_Extension');
        parent::__construct($client, $applicationId);
        $this->_httpClient->setParameterPost('service', self::AUTH_SERVICE_NAME);
    }

    /**
     * Retrieve account feed object
     *
     * @return Cream_Gdata_Analytics_AccountFeed
     */
    public function getAccountFeed()
    {
        $uri = self::ANALYTICS_ACCOUNT_FEED_URI . '/default?prettyprint=true';
        return parent::getFeed($uri, 'Cream_Gdata_Analytics_AccountFeed');
    }

    /**
     * Retrieve data feed object
     * 
     * @param mixed $location
     * @return Cream_Gdata_Analytics_DataFeed
     */
    public function getDataFeed($location){
		if ($location == null) {
            $uri = self::ANALYTICS_FEED_URI;
        } else if ($location instanceof Zend_Gdata_Query) {
            $uri = $location->getQueryUrl();
        } else {
            $uri = $location;
        }
        return parent::getFeed($uri, 'Cream_Gdata_Analytics_DataFeed');
    }

    /**
     * Returns a new DataQuery object.
     * 
     * @return Cream_Gdata_Analytics_DataQuery
     */
    public function newDataQuery($profileId=null){
    	return new Cream_Gdata_Analytics_DataQuery($profileId);
    }
}
?>