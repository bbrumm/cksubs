<?php
require_once("src/controller/APIController.php");
require_once("src/model/ArraySubscriberResponse.php");
require_once("src/model/ArrayTagResponse.php");

class APIControllerTest extends \PHPUnit\Framework\TestCase
{
    const INVALID_ARGUMENT_EXCEPTION = "InvalidArgumentException";

    public function setUp() {

    }

    public function test_ArraySubscriberResponseIntoDatabase() {
        $subscriberResponse = new ArraySubscriberResponse();
        $apiController = new APIController();

        $apiController->loadSubscribers($subscriberResponse);

        $expectedRowCount = 2;

        $dbConnection = new DBConnection();
        $conn = $dbConnection->createConnection();
        $queryString = "SELECT COUNT(*) FROM subscriber;";
        $queryResult = $conn->query($queryString);
        $row = $queryResult->fetch();
        $actualRowCount = $row[0];
        $this->assertEquals($expectedRowCount, $actualRowCount);

    }

    public function test_ArrayTagResponseIntoDatabase() {
        $tagResponse = new ArrayTagResponse();
        $apiController = new APIController();

        $apiController->loadTags($tagResponse);

        $expectedRowCount = 2;

        $dbConnection = new DBConnection();
        $conn = $dbConnection->createConnection();
        $queryString = "SELECT COUNT(*) FROM tag;";
        $queryResult = $conn->query($queryString);
        $row = $queryResult->fetch();
        $actualRowCount = $row[0];
        $this->assertEquals($expectedRowCount, $actualRowCount);

    }




}