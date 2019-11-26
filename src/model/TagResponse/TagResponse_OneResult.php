<?php
require_once 'ITagResponse.php';

class TagResponse_OneResult implements ITagResponse {

    public function __construct() {

    }

    public function getPageOfTags() {
        $response = new stdClass();
        $tag1 = new stdClass();
        $tag1->id = 100;
        $tag1->name = "first tag";

        $response->tags = array($tag1);
        return $response;
    }
}