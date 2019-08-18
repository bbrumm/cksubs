<?php
require_once("src/model/APISubscriberResponse.php");

class APISubscriberResponse_test extends \PHPUnit\Framework\TestCase
{
    const INVALID_ARGUMENT_EXCEPTION = "InvalidArgumentException";

    public function setUp() {

    }

    public function test_GetSinglePageOfSubscribers() {
        $subscriberResponse = new APISubscriberResponse();
        $pageNumber = 1;
        $response = $subscriberResponse->getPageOfSubscribers($pageNumber);

        $expectedPage = 1;
        $actualPage = $response->page;
        $this->assertEquals($expectedPage, $actualPage);

    }




}