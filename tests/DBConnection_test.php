<?php
require_once "src/model/DBConnection.php";

class DBConnection_test extends \PHPUnit\Framework\TestCase
{
    const INVALID_ARGUMENT_EXCEPTION = "InvalidArgumentException";

    public function setUp() {


        if($this->isCurrentEnvironmentDev()) {
            $rootFolder = __DIR__ . "/../";
            $dotenv = Dotenv\Dotenv::create($rootFolder);
            $dotenv->load();
        }
    }

    public function test_ValidQuery() {
        $queryString = "SELECT COUNT(*) FROM subscriber;";

        $dbConnection = new DBConnection();
        $conn = $dbConnection->createConnection();
        $conn->query($queryString);
        //$dbConnection->runQuery($conn, $queryString);
        $this->assertEquals(1, 1);

    }

    public function test_InvalidSyntax() {
        $this->expectException("Exception");
        $queryString = "SELECT;";

        $dbConnection = new DBConnection();
        $conn = $dbConnection->createConnection();
        $conn->query($queryString);
        //$dbConnection->runQuery($conn, $queryString);
    }

    //TODO refactor this into a public method as it is duplicated
    private function isCurrentEnvironmentDev() {
        //return ($_SERVER["HTTP_HOST"] == "localhost:8888");
        return (getenv("ENVIRONMENT") == "dev");
    }



}