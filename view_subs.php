<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('examples/layout/header.php');



$ck = new \ConvertKit\ConvertKit($apiKey, $apiSecretKey);

/*
$subscriber = $ck->subscriber();
$response = $subscriber->showall();

echo "<pre>";
print_r($response);
echo "</pre>";
*/

$tag = $ck->tag(429090)->listSubscriptions();
echo "<pre>";
print_r($tag);
echo "</pre>";

// footer for Bootstrap to make the example look pretty
require_once('examples/layout/footer.php');
