<?php
require_once 'ITagResponse.php';
//require_once('src/config.php');

class APITagResponse implements ITagResponse {

    public function __construct() {

    }

    public function getPageOfTags() {
        $apiKey = getenv("CK_API_KEY");
        $apiSecretKey = getenv("CK_API_SECRET");
        $ck = new \ConvertKit\ConvertKit($apiKey, $apiSecretKey);
        $tag = $ck->tag();

        $response = $tag->showall();
        return $response;
    }
}