<?php
//Must be in this specific order
require_once("src/Connector.php");
require_once("src/ConvertKit.php");
require_once("src/Subscriber.php");
require_once("src/Tag.php");
require_once("src/Sequence.php");
require_once('src/config.php');

require_once('src/model/APISubscriberResponse.php');
require_once('src/model/APITagResponse.php');
require_once("src/model/DBConnection.php");
require __DIR__ . '/../../vendor/autoload.php';


class APIController {

    public function getAllSubscribers() {
        $dotenv = Dotenv\Dotenv::create(__DIR__. '/../..');
        $dotenv->load();

        $apiSubscriberResponse = new APISubscriberResponse();
        $this->loadSubscribers($apiSubscriberResponse);
    }

    public function getAllTags() {
        $dotenv = Dotenv\Dotenv::create(__DIR__. '/../..');
        $dotenv->load();
        $apiTagResponse = new APITagResponse();
        $this->loadTags($apiTagResponse);

    }



    public function loadSubscribers(ISubscriberResponse $subscriberResponse) {
        file_put_contents(
            'progress.json',
            json_encode(array('percentSubsComplete'=>0))
        );

        $dbConnection = new DBConnection();
        $conn = $dbConnection->createConnection();
        $dbConnection->resetSubscriberTable($conn);

        file_put_contents(
            'progress.json',
            json_encode(array('percentSubsComplete'=>0))
        );

        $this->insertAllSubscribersFromAPI($subscriberResponse, $conn);

        echo json_encode(array('message'=>"API done"));
    }

    private function insertAllSubscribersFromAPI(ISubscriberResponse $subscriberResponse, $conn) {
        $pageNumberCount = 1;
        for ($pageNumOfThisAPICall = 1; $pageNumOfThisAPICall <= $pageNumberCount; $pageNumOfThisAPICall++) {
            $response = $subscriberResponse->getPageOfSubscribers($pageNumOfThisAPICall);
            //print_r($response);
            $this->insertAllSubscribers($response, $conn);
            $pageNumberCount = $this->updateTotalPageNumberFromAPIResponse($response);
            $pctComplete = round($pageNumOfThisAPICall/$pageNumberCount,2);
            $this->updateJsonWithSubsProgress($pctComplete);

        }
    }

    public function loadTags(ITagResponse $tagResponse) {
        $this->updateJsonWithTagsProgress(0);

        $dbConnection = new DBConnection();
        $conn = $dbConnection->createConnection();

        $this->updateJsonWithTagsProgress(0.3);
        $this->insertAllTagsFromAPI($tagResponse, $conn);

        echo json_encode(array('message'=>"API done"));
    }

    private function insertAllTagsFromAPI(ITagResponse $tagResponse, $conn) {
        $response = $tagResponse->getPageOfTags();
        $newTagArray = $this->determineNewTags($response, $conn);
        if(count($newTagArray) > 0) {
            $this->insertNewTags($newTagArray, $conn);
        }
        $this->updateJsonWithTagsProgress(1);

    }

    //Write out the progress to a JSON file, which is used to update the index page.
    private function updateJsonWithSubsProgress($pctComplete) {
        file_put_contents(
            'progress.json',
            json_encode(array('percentSubsComplete'=>$pctComplete))
        );
    }

    private function updateJsonWithTagsProgress($pctComplete) {
        file_put_contents(
            'progress.json',
            //json_encode(array('percentComplete'=>$pageNumOfThisAPICall/$pageNumberCount))
            json_encode(array('percentTagsComplete'=>$pctComplete))
        );
    }

    private function updateTotalPageNumberFromAPIResponse($response) {
        return $response->total_pages;
    }


    private function insertAllSubscribers($response, $conn) {
        $insertSubscriberQuery = $this->convertSubscriberArrayToSQL($response->subscribers);
        $this->insertSubscribers($conn, $insertSubscriberQuery);
    }

    private function determineNewTags($response, $conn) {
        $tagsFromAPI = $response->tags;
        //echo "API TAGS:";
        //print_r($tagsFromAPI);
        $tagsFromDatabase = $this->loadExistingTagsFromDatabase($conn);
        return $this->findTagsFromAPINotInDatabase($tagsFromAPI, $tagsFromDatabase);
    }

    private function loadExistingTagsFromDatabase(PDO $conn) {
        $queryString = "SELECT tag_id AS id, tag_name AS name FROM tag;";
        $queryResult = $conn->query($queryString);
        $resultArray = $queryResult->fetchAll(PDO::FETCH_ASSOC);

        //echo "RESULT: ";
        //print_r($resultArray);
        return $resultArray;
    }

    private function loadTagsFromDatabase(PDO $conn) {
        $queryString = "SELECT t.tag_id, t.tag_name, t.tag_map_id FROM tag t ORDER BY t.tag_map_id, t.tag_name;";
        $queryResult = $conn->query($queryString);
        $resultArray = $queryResult->fetchAll(PDO::FETCH_ASSOC);
        return $resultArray;
    }

    private function loadPossibleMapValues(PDO $conn) {
        $queryString = "SELECT tag_map_id, map_value FROM tag_map ORDER BY tag_map_id;";
        $queryResult = $conn->query($queryString);
        $resultArray = $queryResult->fetchAll(PDO::FETCH_ASSOC);
        return $resultArray;
    }

    private function findTagsFromAPINotInDatabase($tagsFromAPI, $tagsFromDatabase) {
        $missingTags = array();
        foreach($tagsFromAPI as $tagInArray) {
            $tagFoundInDatabase = false;
            foreach($tagsFromDatabase as $tagInDatabase) {
                if ($tagInArray->id == $tagInDatabase["id"]) {
                    $tagFoundInDatabase = true;
                }
            }
            if (!$tagFoundInDatabase) {
                $missingTags[] = $tagInArray;
            }
        }
        //Returns an array of Objects, as that is what the tagsFromAPI is
        return $missingTags;
    }


    private function insertNewTags($newTagArray, $conn) {
        $insertTagQuery = $this->convertTagArrayToSQL($newTagArray);
        $this->insertTags($conn, $insertTagQuery);
    }

    private function convertTagArrayToSQL($tagArray) {
        $insertTagQuery = "INSERT INTO tag (tag_id, tag_name) VALUES ";
        $insertTagQuery .= $this->appendTagsToSQLQueryString($tagArray);
        $insertTagQuery .= ";";
        return $insertTagQuery;
    }

    private function appendTagsToSQLQueryString($tagArray) {
        $queryString = "";
        $tagCount = count($tagArray);
        $currentTagNumber = 0;
        foreach ($tagArray as $key => $value) {
            $queryString .= "(". $value->id .", '". $value->name ."') ";
            $currentTagNumber++;
            if ($currentTagNumber < $tagCount) {
                $queryString.= ",";
            }
        }
        return $queryString;
    }


    private function convertSubscriberArrayToSQL($subscriberArray) {
        $insertQuery = "INSERT INTO subscriber (subscriber_id, first_name, email_address, subscriber_state, subscriber_created_at) VALUES ";
        $insertQuery .= $this->appendSubscribersToSQLQueryString($subscriberArray);
        $insertQuery .= ";";
        return $insertQuery;
    }

    private function appendSubscribersToSQLQueryString($subscriberArray) {
        $currentTagNumber = 0;
        $tagCount = count($subscriberArray);
        $queryString = "";
        foreach ($subscriberArray as $key => $value) {
            $queryString .= "(".
                $value->id .", '".
                $value->first_name ."', '".
                $value->email_address ."', '".
                $value->state ."', ".
                "STR_TO_DATE(SUBSTR('" . $value->created_at ."', 1, 10), '%Y-%m-%d')) ";
            $currentTagNumber++;
            if ($currentTagNumber < $tagCount) {
                $queryString.= ",";
            }
        }
        return $queryString;
    }

    private function insertSubscribers($conn, $insertQuery) {
        try {
            $conn->query($insertQuery);
            $conn->query("COMMIT;");
        } catch (Exception $e) {
            echo "Insert Subscribers query failed: " . $e->getMessage();
            echo "Query: <br />" . $insertQuery . "<br />";
        }

    }

    private function insertTags($dbConnection, $insertTagQuery) {
        try {
            $dbConnection->query($insertTagQuery);
            $dbConnection->query("COMMIT;");
        } catch (Exception $e) {
            echo "Insert Tags query failed: " . $e->getMessage() . "<br />";
            echo "Query: <br />" . $insertTagQuery . "<br /><br />";
        }

    }

}