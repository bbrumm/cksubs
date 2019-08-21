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
        $dbConnection = new DBConnection();
        $conn = $dbConnection->createConnection();

        //Copy subscribers to backup table
        $conn->query("TRUNCATE TABLE subscriber_bk;");
        $backupQueryString = "INSERT INTO subscriber_bk (subscriber_id, first_name, email_address, subscriber_state, subscriber_created_at)
          SELECT subscriber_id, first_name, email_address, subscriber_state, subscriber_created_at FROM subscriber;";
        $conn->query($backupQueryString);

        $apiController->loadSubscribers($subscriberResponse);

        $expectedRowCount = 2;

        $queryString = "SELECT COUNT(*) FROM subscriber;";
        $queryResult = $conn->query($queryString);
        $row = $queryResult->fetch();
        $actualRowCount = $row[0];
        $this->assertEquals($expectedRowCount, $actualRowCount);

        //Copy subscribers from backup table to main table
        $conn->query("TRUNCATE TABLE subscriber;");
        $backupQueryString = "INSERT INTO subscriber (subscriber_id, first_name, email_address, subscriber_state, subscriber_created_at)
          SELECT subscriber_id, first_name, email_address, subscriber_state, subscriber_created_at FROM subscriber_bk;";
        $conn->query($backupQueryString);

    }

    public function test_ArrayTagResponseIntoDatabase() {
        $tagResponse = new ArrayTagResponse();
        $apiController = new APIController();

        $apiController->loadTags($tagResponse);

        $expectedMinRowCount = 1;

        $dbConnection = new DBConnection();
        $conn = $dbConnection->createConnection();
        $queryString = "SELECT COUNT(*) FROM tag;";
        $queryResult = $conn->query($queryString);
        $row = $queryResult->fetch();
        $actualRowCount = $row[0];
        $this->assertGreaterThan($expectedMinRowCount, $actualRowCount);

        //Delete sample tags
        $queryString = "DELETE FROM tag WHERE tag_id IN (100, 101);";
        $conn->query($queryString);

    }




}