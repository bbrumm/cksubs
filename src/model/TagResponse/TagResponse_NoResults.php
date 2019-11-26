<?php
require_once 'ITagResponse.php';

class TagResponse_NoResults implements ITagResponse {

    public function __construct() {

    }

    public function getPageOfTags() {
        $response = new stdClass();
        $response->tags = array();
        return $response;
    }
}