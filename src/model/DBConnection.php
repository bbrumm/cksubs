<?php
/**
 * Created by PhpStorm.
 * User: BB
 * Date: 17/6/19
 * Time: 5:00 AM
 */

class DBConnection {

    public function __construct() {

    }

    public function createConnection() {
        $dbServername = "localhost";
        $dbUsername = "root";
        $dbPassword = "root";

        try {
            $conn = new PDO("mysql:host=$dbServername;dbname=ck_subscribers", $dbUsername, $dbPassword);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

    }

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
        }
    }



}