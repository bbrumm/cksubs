<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


require_once('examples/layout/header.php');

//Must be in this specific order
require_once("src/Connector.php");
require_once("src/ConvertKit.php");
require_once("src/Subscriber.php");
require_once("src/Tag.php");
require_once("src/Sequence.php");

require_once('examples/config.php');

$ck = new \ConvertKit\ConvertKit($apiKey, $apiSecretKey);


$subscriberArray = array(
    array('email' => 'address_here')
);

$arrayCount = count($subscriberArray);

for ($i = 0; $i < $arrayCount; $i++) {
    $tag = $ck->tag(452865)->addToSubscriber($subscriberArray[$i]);

}
echo "<pre>";
print_r($tag);
echo "</pre>";

/*
 * LIST TAG SUBSCRIPTIONS
*/
/*
$tag = $ck->tag(429090)->listSubscriptions();
echo "<pre>";
print_r($tag);
echo "</pre>";
*/
// footer for Bootstrap to make the example look pretty
require_once('examples/layout/footer.php');


