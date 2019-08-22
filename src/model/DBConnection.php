<?php

class DBConnection {

    public function __construct() {
        if($this->isCurrentEnvironmentDev()) {
            $rootFolder = __DIR__ . "/../../";
            $dotenv = Dotenv\Dotenv::create($rootFolder);
            $dotenv->load();
        }
    }

    private function isCurrentEnvironmentDev() {
        return (getenv("ENVIRONMENT") == "dev");
    }

    private function isCurrentEnvironmentTravis() {
        return (getenv("ENVIRONMENT") == "travistest");
    }

    public function createConnection() {
        $dbServername = "localhost";
        $dbUsername = "root";
        $dbPassword = $this->getDBPasswordForEnvironment();

        try {
            $conn = new PDO("mysql:host=$dbServername;dbname=ck_subscribers", $dbUsername, $dbPassword);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            throw $e;
        }
    }

    private function getDBPasswordForEnvironment() {
        $dbPassword = "root";
        if ($this->isCurrentEnvironmentDev()) {
            $dbPassword = "root";
        } elseif ($this->isCurrentEnvironmentTravis()) {
            $dbPassword = "";
        }
        return $dbPassword;
    }

    //TODO: Refactor these functions to make the runQuery less confusing.
    public function resetSubscriberTable($dbConnection) {
        $truncateTable = "TRUNCATE TABLE subscriber;";
        $this->runQuery($dbConnection, $truncateTable);
        $this->runQuery($dbConnection, "COMMIT;");
    }

    public function resetTagTable($dbConnection) {
        $truncateTable = "TRUNCATE TABLE tag;";
        $this->runQuery($dbConnection, $truncateTable);
        $this->runQuery($dbConnection, "COMMIT;");
    }

    public function resetTagTableForSpecificTagID($dbConnection, $tagID) {
        $query = "DELETE FROM subscriber_tag WHERE tag_id = ". $tagID .";";
        $this->runQuery($dbConnection, $query);
    }

    public function runQuery($dbConnection, $queryString) {
        try {
            $dbConnection->query($queryString);
            //echo "Query run: <br />" . $queryString . "<br />";
        } catch (Exception $e) {
            //echo "Query failed: " . $e->getMessage();
            //echo "Query: <br />" . $queryString . "<br />";
            throw $e;
        }
    }



}