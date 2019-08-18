<?php
require_once 'ISubscriberResponse.php';
require_once('config.php');

class ArraySubscriberResponse implements ISubscriberResponse {

    public function __construct() {

    }

    public function getPageOfSubscribers($pageNumber) {
        $response = new stdClass();
        $response->total_subscribers = 2;
        $response->total_pages = 1;
        $response->page = 1;

        $subscriber1 = new stdClass();
        $subscriber1->id = 100;
        $subscriber1->first_name = null;
        $subscriber1->email_address = "first@databasestar.com";
        $subscriber1->state = "active";
        $subscriber1->created_at = "2015-11-24T06:49:38.000Z";
        $subscriber1->fields = new stdClass();

        $subscriber2 = new stdClass();
        $subscriber2->id = 101;
        $subscriber2->first_name = null;
        $subscriber2->email_address = "second@databasestar.com";
        $subscriber2->state = "active";
        $subscriber2->created_at = "2016-11-24T06:49:38.000Z";
        $subscriber2->fields = new stdClass();

        $response->subscribers = array($subscriber1, $subscriber2);

        return $response;
    }
}