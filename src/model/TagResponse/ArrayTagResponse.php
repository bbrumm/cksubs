<?php
require_once 'ITagResponse.php';

class ArrayTagResponse implements ITagResponse {

    public function __construct() {

    }

    public function getPageOfTags() {
        $response = new stdClass();

        $tag1 = new stdClass();
        $tag1->id = 100;
        $tag1->name = "first tag";

        $tag2 = new stdClass();
        $tag2->id = 101;
        $tag2->name = "something else23423";

        $response->tags = array($tag1, $tag2);

        return $response;
    }
}