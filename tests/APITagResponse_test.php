<?php
require_once("src/model/APITagResponse.php");

class APITagResponse_test extends \PHPUnit\Framework\TestCase
{
    const INVALID_ARGUMENT_EXCEPTION = "InvalidArgumentException";

    public function setUp() {

    }

    public function test_GetSinglePageOfTags() {
        $tagResponse = new APITagResponse();
        $response = $tagResponse->getPageOfTags();

        $expectedCountGreaterThan = 1;
        $actualCount = count($response->tags);
        $this->assertGreaterThan($expectedCountGreaterThan, $actualCount);

    }




}