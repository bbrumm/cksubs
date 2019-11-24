<?php

class DBConnection {

    const DB_USERNAME = "root";
    const DB_HOSTNAME = "localhost";
    const DB_NAME = "ck_subscribers";


    public function __construct() {
        if($this->isCurrentEnvironmentDev()) {
            $rootFolder = __DIR__ . "/../../";
            $dotenv = Dotenv\Dotenv::create($rootFolder);
            $dotenv->load();
        }
    }

    private function isCurrentEnvironmentDev() {
        //return (getenv("ENVIRONMENT") == "dev");
        return (getenv("HOME") == "/Users/BB");
    }

    private function isCurrentEnvironmentTravis() {
        return (getenv("ENVIRONMENT") == "travistest");
    }

    public function createConnection() {
        try {
            $conn = new PDO($this->buildConnectionString(), $this->getDBUsername(), $this->getDBPasswordForEnvironment());
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            throw $e;
        }
    }

    private function buildConnectionString() {
        return "mysql:host=". self::DB_HOSTNAME .";dbname=". self::DB_NAME;
    }

    private function getDBUsername() {
        return self::DB_USERNAME;
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

    public function resetSubscriberTable($dbConnection) {
        $this->truncateTable($dbConnection, "subscriber");
    }


    public function truncateTable($dbConnection, $tableName) {
        $truncateTableQuery = "TRUNCATE TABLE ". $tableName .";";
        $dbConnection->query($truncateTableQuery);
        $dbConnection->query("COMMIT;");
    }

    public function resetTagTableForSpecificTagID($dbConnection, $tagID) {
        $queryString = "DELETE FROM subscriber_tag WHERE tag_id = ". $tagID .";";
        $dbConnection->query($queryString);
    }



}