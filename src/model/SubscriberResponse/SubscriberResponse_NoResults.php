<?php
require_once 'ISubscriberResponse.php';
//require_once('config.php');

class SubscriberResponse_NoResults implements ISubscriberResponse {

    public function __construct() {

    }

    public function getPageOfSubscribers($pageNumber) {
        $response = new stdClass();
        $response->total_subscribers = 0;
        $response->total_pages = 1;
        $response->page = 1;

        $response->subscribers = array();

        return $response;
    }
}