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
        //return ($_SERVER["HTTP_HOST"] == "localhost:8888");
        return (getenv("ENVIRONMENT") == "dev");
    }

    //TODO: Change this to use an environment variable because it's different in local vs travis
    public function createConnection() {
        $dbServername = "localhost";
        $dbUsername = "root";
        $dbPassword = "root";
        //TODO refactor this into a public method
        //if(!isset($_ENV["ENVIRONMENT"])) {
        //    $dbPassword = "root";
        //} elseif ($_ENV["ENVIRONMENT"] == "dev") {
        //echo "ENV: " . getenv("ENVIRONMENT");
        if (getenv("ENVIRONMENT") == "dev") {
            $dbPassword = "root";
        } elseif (getenv("ENVIRONMENT") == "travistest") {
            $dbPassword = "";
        }

        try {
            $conn = new PDO("mysql:host=$dbServername;dbname=ck_subscribers", $dbUsername, $dbPassword);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

    }

    //TODO: Refactor these functions to make the runQuery less confusing.
    public function resetSubscriberTable($dbConnection) {
        $truncateTable = "TRUNCATE TABLE subscriber;";
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
            echo "Query run: <br />" . $queryString . "<br />";
        } catch (Exception $e) {
            echo "Query failed: " . $e->getMessage();
            echo "Query: <br />" . $queryString . "<br />";
            throw $e;
        }
    }



}