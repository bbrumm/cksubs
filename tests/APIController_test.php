<?php
require_once("src/controller/APIController.php");
require_once("src/model/SubscriberResponse/ArraySubscriberResponse.php");
require_once("src/model/SubscriberResponse/SubscriberResponse_NoResults.php");
require_once("src/model/SubscriberResponse/SubscriberResponse_OneResult.php");
require_once("src/model/TagResponse/ArrayTagResponse.php");
require_once("src/model/TagResponse/TagResponse_NoResults.php");
require_once("src/model/TagResponse/TagResponse_OneResult.php");

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

        $this->copySubscribersToBackupTable($conn);

        //Run the method that's being tested
        $apiController->loadSubscribers($subscriberResponse);

        $expectedRowCount = 2;
        $queryString = "SELECT COUNT(*) FROM subscriber;";
        $queryResult = $conn->query($queryString);
        $row = $queryResult->fetch();
        $actualRowCount = $row[0];
        $this->assertEquals($expectedRowCount, $actualRowCount);

        $this->copySubscribersFromBackupToMainTable($conn);
    }

    public function test_APISubscriberResponseIntoDatabase() {
        $subscriberResponse = new APISubscriberResponse();
        $apiController = new APIController();
        $dbConnection = new DBConnection();
        $conn = $dbConnection->createConnection();

        $this->copySubscribersToBackupTable($conn);

        //Run the method that's being tested
        $apiController->loadSinglePageOfSubscribers($subscriberResponse);

        $expectedRowCount = 50;
        $queryString = "SELECT COUNT(*) FROM subscriber;";
        $queryResult = $conn->query($queryString);
        $row = $queryResult->fetch();
        $actualRowCount = $row[0];
        $this->assertEquals($expectedRowCount, $actualRowCount);

        //Copy subscribers from backup table to main table
        $this->copySubscribersFromBackupToMainTable($conn);
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

    public function test_APITagResponseIntoDatabase() {
        $tagResponse = new APITagResponse();
        $apiController = new APIController();
        $dbConnection = new DBConnection();
        $conn = $dbConnection->createConnection();

        $this->copyTagsToBackupTable($conn);

        $apiController->loadTags($tagResponse);

        $expectedMinRowCount = 1;
        $queryString = "SELECT COUNT(*) FROM tag;";
        $queryResult = $conn->query($queryString);
        $row = $queryResult->fetch();
        $actualRowCount = $row[0];
        $this->assertGreaterThan($expectedMinRowCount, $actualRowCount);

        $this->copyTagsFromBackupToMainTable($conn);
    }

    public function test_TagResponse_NoResults() {
        $this->expectException("Exception");
        $tagResponse = new TagResponse_NoResults();
        $apiController = new APIController();

        $apiController->loadTags($tagResponse);

    }

    public function test_TagResponse_OneResult() {
        $this->expectException("Exception");
        $tagResponse = new TagResponse_OneResult();
        $apiController = new APIController();

        $apiController->loadTags($tagResponse);
    }

    public function test_SubscriberResponse_NoResults() {
        $this->expectException("Exception");
        $subscriberResponse = new SubscriberResponse_NoResults();
        $apiController = new APIController();

        $apiController->loadSubscribers($subscriberResponse);
    }

    public function test_SubscriberResponse_OneResult() {
        $this->expectException("Exception");
        $subscriberResponse = new SubscriberResponse_OneResult();
        $apiController = new APIController();

        $apiController->loadSubscribers($subscriberResponse);
    }



    public function testRequiredTagsAreInTable() {
        $dbConnection = new DBConnection();
        $conn = $dbConnection->createConnection();

        $queryString = "SELECT tag_name FROM tag ORDER BY tag_name ASC;";
        $queryResult = $conn->query($queryString);
        $resultSet = $queryResult->fetchAll();

        $tagNamesFromDatabase = $this->transformResultIntoTagNames($resultSet);

        $expectedTagNames = $this->getExpectedTagNames();

        $matchingArray = array_intersect($expectedTagNames, $tagNamesFromDatabase);
        $this->assertEquals($expectedTagNames, $matchingArray);

    }

    /****** Private Functions ******/
    private function truncateTable($conn, $tableName) {
        $conn->query("TRUNCATE TABLE ". $tableName .";");
    }
    private function copySubscribersToBackupTable($conn) {
        $this->truncateTable($conn, "subscriber_bk");
        $backupQueryString = "INSERT INTO subscriber_bk (subscriber_id, first_name, email_address, subscriber_state, subscriber_created_at)
          SELECT subscriber_id, first_name, email_address, subscriber_state, subscriber_created_at FROM subscriber;";
        $conn->query($backupQueryString);
    }

    private function copySubscribersFromBackupToMainTable($conn) {
        $this->truncateTable($conn, "subscriber");
        $backupQueryString = "INSERT INTO subscriber (subscriber_id, first_name, email_address, subscriber_state, subscriber_created_at)
          SELECT subscriber_id, first_name, email_address, subscriber_state, subscriber_created_at FROM subscriber_bk;";
        $conn->query($backupQueryString);
    }

    private function copyTagsToBackupTable($conn) {
        $this->truncateTable($conn, "tag_bk");
        $backupQueryString = "INSERT INTO tag_bk (tag_id, tag_name, tag_map_id, last_updated)
          SELECT tag_id, tag_name, tag_map_id, last_updated FROM tag;";
        $conn->query($backupQueryString);
    }

    private function copyTagsFromBackupToMainTable($conn) {
        $this->truncateTable($conn, "tag");
        $backupQueryString = "INSERT INTO tag (tag_id, tag_name, tag_map_id, last_updated)
          SELECT tag_id, tag_name, tag_map_id, last_updated FROM tag_bk;";
        $conn->query($backupQueryString);
    }

    private function transformResultIntoTagNames($resultSet) {
        $tagNameArray = array();
        $resultRowCount = count($resultSet);
        for ($i=0; $i < $resultRowCount; $i++) {
            $tagNameArray[] = $resultSet[$i]['tag_name'];
        }
        return $tagNameArray;
    }

    private function getExpectedTagNames() {
        return array(
            'Start Content 01',
            'Start Content 02',
            'Start Content 03',
            'Start Content 04',
            'Start Content 05',
            'Start Content 06',
            'Start Content 07',
            'Start Content 08',
            'Start Content 09',
            'Start Content 10',
            'Start Content 11',
            'Done Content 01',
            'Done Content 02',
            'Done Content 03',
            'Done Content 04',
            'Done Content 05',
            'Done Content 06',
            'Done Content 07',
            'Done Content 08',
            'Done Content 09',
            'Done Content 10',
            'Done Content 11',
            'Start DSA Sales 01',
            'Start DSA Sales 02',
            'Done DSA Sales 01',
            'Done DSA Sales 02'
        );
    }


}