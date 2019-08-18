<?php
require_once "src/model/DBConnection.php";
require '../vendor/autoload.php';

class DBConnection_test extends \PHPUnit\Framework\TestCase
{
    const INVALID_ARGUMENT_EXCEPTION = "InvalidArgumentException";

    public function setUp() {
        $rootFolder = __DIR__ . "/../";
        $dotenv = Dotenv\Dotenv::create($rootFolder);
        $dotenv->load();
    }

    public function test_ValidQuery() {
        $queryString = "SELECT COUNT(*) FROM subscriber;";

        $dbConnection = new DBConnection();
        $conn = $dbConnection->createConnection();
        $dbConnection->runQuery($conn, $queryString);
        $this->assertEquals(1, 1);

    }

    public function test_InvalidSyntax() {
        $this->expectException("Exception");
        $queryString = "SELECT;";

        $dbConnection = new DBConnection();
        $conn = $dbConnection->createConnection();
        $dbConnection->runQuery($conn, $queryString);
    }

}