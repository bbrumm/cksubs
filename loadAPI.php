<?php
require_once('src/controller/APIController.php');
set_time_limit(0);
$apiController = new APIController();
$apiController->getAllSubscribers();
exit(0);

