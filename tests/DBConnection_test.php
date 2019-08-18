<?php
require_once "src/model/DBConnection.php";
class DBConnection_test extends \PHPUnit\Framework\TestCase
{
    const INVALID_ARGUMENT_EXCEPTION = "InvalidArgumentException";

    public function setUp() {

    }

    public function test_ValidQuery() {
        $queryString = "SELECT COUNT(*) FROM subscriber;";

        $dbConnection = new DBConnection();
        $conn = $dbConnection->createConnection();
        $dbConnection->runQuery($conn, $queryString);
        $this->assertEquals(1, 1);

    }

    public function test_InvalidSyntax() {
        $this->expectException(Exception::class);
        $queryString = "SELECT;";

        $dbConnection = new DBConnection();
        $conn = $dbConnection->createConnection();
        $dbConnection->runQuery($conn, $queryString);
    }

}