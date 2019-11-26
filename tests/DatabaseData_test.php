<?php
require_once("src/model/DBConnection.php");
class DatabaseData_test extends \PHPUnit\Framework\TestCase {

    public function test_Tag_NotEmptyOrOne() {
        $dbConnection = new DBConnection();
        $conn = $dbConnection->createConnection();

        $minCount = 2;
        $queryString = "SELECT COUNT(*) FROM tag;";
        $queryResult = $conn->query($queryString);
        $row = $queryResult->fetch();
        $actualCount = $row[0];
        $this->assertGreaterThan($minCount, $actualCount);
    }

    public function test_Tag_TooManyRows() {
        $dbConnection = new DBConnection();
        $conn = $dbConnection->createConnection();

        $maxCount = 200;
        $queryString = "SELECT COUNT(*) FROM tag;";
        $queryResult = $conn->query($queryString);
        $row = $queryResult->fetch();
        $actualCount = $row[0];
        $this->assertLessThan($maxCount, $actualCount);
    }

    public function test_Tag_NoneMapped() {
        $dbConnection = new DBConnection();
        $conn = $dbConnection->createConnection();

        $minMappedCount = 1;
        $queryString = "SELECT COUNT(*) FROM tag WHERE tag_map_id IS NOT NULL;";
        $queryResult = $conn->query($queryString);
        $row = $queryResult->fetch();
        $actualCount = $row[0];
        $this->assertGreaterThan($minMappedCount, $actualCount);
    }

    public function test_Tag_MissingNames() {
        $dbConnection = new DBConnection();
        $conn = $dbConnection->createConnection();

        $expectedUnmappedCount = 0;
        $queryString = "SELECT COUNT(*) FROM tag WHERE tag_name IS NULL OR tag_name = '';";
        $queryResult = $conn->query($queryString);
        $row = $queryResult->fetch();
        $actualCount = $row[0];
        $this->assertEquals($expectedUnmappedCount, $actualCount);
    }

    public function test_Tag_DuplicateNames() {
        $dbConnection = new DBConnection();
        $conn = $dbConnection->createConnection();

        $expectedCount = 0;
        $queryString = "SELECT COUNT(*) FROM (
    SELECT tag_name, COUNT(*)
    FROM tag
    GROUP BY tag_name
    HAVING COUNT(*) > 1
) s;";
        $queryResult = $conn->query($queryString);
        $row = $queryResult->fetch();
        $actualCount = $row[0];
        $this->assertEquals($expectedCount, $actualCount);
    }


    public function test_Subscriber_NotEmptyOrOne() {
        $dbConnection = new DBConnection();
        $conn = $dbConnection->createConnection();

        $minCount = 2;
        $queryString = "SELECT COUNT(*) FROM subscriber;";
        $queryResult = $conn->query($queryString);
        $row = $queryResult->fetch();
        $actualCount = $row[0];
        $this->assertGreaterThan($minCount, $actualCount);
    }

    public function test_Subscriber_TooManyRows() {
        $dbConnection = new DBConnection();
        $conn = $dbConnection->createConnection();

        $maxCount = 10000;
        $queryString = "SELECT COUNT(*) FROM subscriber;";
        $queryResult = $conn->query($queryString);
        $row = $queryResult->fetch();
        $actualCount = $row[0];
        $this->assertLessThan($maxCount, $actualCount);
    }

}