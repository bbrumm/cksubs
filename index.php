<?php
require_once('layout/header.php');
require_once('src/controller/APIController.php');
?>
<form method="POST">
   <input type="submit" name="submitAction" value="Download Subscribers" />
</form>


<?php

echo "ENV: <pre>";
print_r(getenv());
echo "</pre>";

if(isset($_POST['submitAction'])) {
    if ($_POST['submitAction'] == 'Download Subscribers') {
        $apiController = new APIController();
        //echo "Subscriber get";
        $apiController->getAllSubscribers();
    }
}



require_once('layout/footer.php');
