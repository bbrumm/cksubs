<?php
//Must be in this specific order
require_once("src/Connector.php");
require_once("src/ConvertKit.php");
require_once("src/Subscriber.php");
require_once("src/Tag.php");
require_once("src/Sequence.php");

require_once('config.php');

class APIController {


    public function getAllSubscribers() {
        $apiKey = CONVERTKIT_PUBLIC_KEY;
        $apiSecretKey = CONVERTKIT_SECRET_KEY;

        $ck = new \ConvertKit\ConvertKit($apiKey, $apiSecretKey);
        $subscriber = $ck->subscriber();
        $response = $subscriber->showall();

        echo "<pre>";
        print_r($response);
        echo "</pre>";
    }


}