<?php
//Must be in this specific order
require_once("src/Connector.php");
require_once("src/ConvertKit.php");
require_once("src/Subscriber.php");
require_once("src/Tag.php");
require_once("src/Sequence.php");
require_once('config.php');

require_once('src/model/APISubscriberResponse.php');
require_once("src/model/DBConnection.php");

class APIController {

    public function getAllSubscribers() {
        $apiSubscriberResponse = new APISubscriberResponse();
        $this->loadSubscribers($apiSubscriberResponse);
    }

    public function loadSubscribers(ISubscriberResponse $subscriberResponse) {
        $dbConnection = new DBConnection();
        $conn = $dbConnection->createConnection();
        $dbConnection->resetSubscriberTable($conn);

        $pageNumberCount = 1;
        for ($pageNumOfThisAPICall = 1; $pageNumOfThisAPICall <= $pageNumberCount; $pageNumOfThisAPICall++) {
            $response = $subscriberResponse->getPageOfSubscribers($pageNumOfThisAPICall);
            $this->insertAllSubscribers($response, $conn);

            $pageNumberCount = $this->updateTotalPageNumberFromAPIResponse($response);
            $this->log("Page ". $pageNumOfThisAPICall ." of ". $pageNumberCount ." completed");

        }
    }

    private function updateTotalPageNumberFromAPIResponse($response) {
        return $response->total_pages;
    }


    private function insertAllSubscribers($response, $conn) {
        $insertSubscriberQuery = $this->convertSubscriberArrayToSQL($response->subscribers);
        $this->insertSubscribers($conn, $insertSubscriberQuery);
    }

    private function convertSubscriberArrayToSQL($subscriberArray) {
        $insertQuery = "INSERT INTO subscriber (subscriber_id, first_name, email_address, subscriber_state, subscriber_created_at) VALUES ";
        $tagCount = count($subscriberArray);
        $currentTagNumber = 0;
        foreach ($subscriberArray as $key => $value) {
            $insertQuery .= "(".
                $value->id .", '".
                $value->first_name ."', '".
                $value->email_address ."', '".
                $value->state ."', ".
                "STR_TO_DATE(SUBSTR('" . $value->created_at ."', 1, 10), '%Y-%m-%d')) ";
            $currentTagNumber++;
            if ($currentTagNumber < $tagCount) {
                $insertQuery.= ",";
            }
        }
        $insertQuery .= ";";
        return $insertQuery;
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

    private function log($message) {
        $message = date("H:i:s") . " - $message - ".PHP_EOL . "<br />";
        print($message);
        flush();
        ob_flush();
    }


}