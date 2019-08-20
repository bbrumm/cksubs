<?php
//Must be in this specific order
require_once("src/Connector.php");
require_once("src/ConvertKit.php");
require_once("src/Subscriber.php");
require_once("src/Tag.php");
require_once("src/Sequence.php");
require_once('src/config.php');

require_once('src/model/APISubscriberResponse.php');
require_once("src/model/DBConnection.php");
require __DIR__ . '/../../vendor/autoload.php';


class APIController {

    public function testLoop() {
        set_time_limit(0);

        $totalItems = 96;
        for($i = 0; $i <= $totalItems; $i++){
        // some long running code
        // sleep 1 second
            usleep(1000*2000);
        // write our output file
            file_put_contents(
                'progress.json',
                json_encode(array('percentComplete'=>$i/$totalItems))
            );
        }
        echo json_encode(array('message'=>"All done"));
    }

    public function getAllSubscribers() {
        $dotenv = Dotenv\Dotenv::create(__DIR__. '/../..');
        $dotenv->load();


        $apiSubscriberResponse = new APISubscriberResponse();
        $this->loadSubscribers($apiSubscriberResponse);
    }

    public function loadSubscribers(ISubscriberResponse $subscriberResponse) {
        file_put_contents(
            'progress.json',
            json_encode(array('percentComplete'=>0))
        );

        $dbConnection = new DBConnection();
        $conn = $dbConnection->createConnection();
        $dbConnection->resetSubscriberTable($conn);

        file_put_contents(
            'progress.json',
            //json_encode(array('percentComplete'=>$pageNumOfThisAPICall/$pageNumberCount))
            json_encode(array('percentComplete'=>0))
        );

        $pageNumberCount = 1;
        for ($pageNumOfThisAPICall = 1; $pageNumOfThisAPICall <= $pageNumberCount; $pageNumOfThisAPICall++) {
            $response = $subscriberResponse->getPageOfSubscribers($pageNumOfThisAPICall);
            print_r($response);

            $this->insertAllSubscribers($response, $conn);

            $pageNumberCount = $this->updateTotalPageNumberFromAPIResponse($response);



            //$pctComplete = round($pageNumOfThisAPICall/$pageNumberCount,2);
            $pctComplete = round($pageNumOfThisAPICall/$pageNumberCount,2);

            //$this->log("Page ". $pageNumOfThisAPICall ." of ". $pageNumberCount ." completed (". $pctComplete .")");

            //Write out the progress to a JSON file, which is used to update the index page.

/*
            file_put_contents(
                'progress.json',
                json_encode(array('percentComplete'=>$pctComplete))
            );
*/

            file_put_contents(
                'progress.json',
                json_encode(array('percentComplete'=>$pctComplete))
            );


        }
        //echo json_encode(array('message'=>"API done"));
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
        echo "tagCount: " . $tagCount . "<br/>";
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