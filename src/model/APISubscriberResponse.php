<?php
require_once 'ISubscriberResponse.php';
//require_once('src/config.php');

class APISubscriberResponse implements ISubscriberResponse {

    public function __construct() {

    }

    public function getPageOfSubscribers($pageNumber) {
        $apiKey = $_ENV["CK_API_KEY"];
        $apiSecretKey = $_ENV["CK_API_SECRET"];
        $ck = new \ConvertKit\ConvertKit($apiKey, $apiSecretKey);
        $subscriber = $ck->subscriber();

        $response = $subscriber->showall($pageNumber);
        return $response;

    }
}