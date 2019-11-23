<?php
require_once 'ITagSubscriberResponse.php';
//require_once('src/config.php');

class APITagSubscriberResponse implements ITagSubscriberResponse {

    public function __construct() {

    }

    public function getPageOfTagSubscribers($pageNumber, $tagID) {
        $apiKey = getenv("CK_API_KEY");
        $apiSecretKey = getenv("CK_API_SECRET");
        $ck = new \ConvertKit\ConvertKit($apiKey, $apiSecretKey);
        $tag = $ck->tag();

        $response = $tag->getPageOfSubscriptions($pageNumber, $tagID);
        return $response;
    }
}