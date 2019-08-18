<?php
require_once 'ISubscriberResponse.php';
require_once('src/config.php');

class APISubscriberResponse implements ISubscriberResponse {

    public function __construct() {

    }

    public function getPageOfSubscribers($pageNumber) {
        $apiKey = CONVERTKIT_PUBLIC_KEY;
        $apiSecretKey = CONVERTKIT_SECRET_KEY;
        $ck = new \ConvertKit\ConvertKit($apiKey, $apiSecretKey);
        $subscriber = $ck->subscriber();

        $response = $subscriber->showall($pageNumber);
        return $response;

    }
}