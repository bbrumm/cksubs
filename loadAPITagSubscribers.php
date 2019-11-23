<?php
require_once('src/controller/APIController.php');
set_time_limit(0);
//echo "Start loadAPITagSubscribers.php \n";
$apiController = new APIController();
$tagID = $_GET['tagID'];
//echo "Tag ID from GET: (". $tagID .") \n";
$apiController->getTagSubscribersForTag($tagID);
exit(0);

