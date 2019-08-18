<?php
require __DIR__ . '/vendor/autoload.php';
require_once('layout/header.php');
require_once('src/controller/APIController.php');

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

echo "<pre>";
print_r($_ENV);
echo "</pre>";

?>
<form method="POST">
   <input type="submit" name="submitAction" value="Download Subscribers" />
</form>

<?php

if(isset($_POST['submitAction'])) {
    if ($_POST['submitAction'] == 'Download Subscribers') {
        $apiController = new APIController();
        //echo "Subscriber get";
        $apiController->getAllSubscribers();
    }
}



require_once('layout/footer.php');
