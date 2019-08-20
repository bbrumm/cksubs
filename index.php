<?php
require __DIR__ . '/vendor/autoload.php';
require_once('layout/header.php');
require_once('src/controller/APIController.php');
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

?>
<form method="POST" id="mainForm" action="">
    <p><button name="submitAction" type="submit" id="btnSubmit">Download Subscribers</button></p>
</form>

<form method="POST" id="testForm">
    <input type="submit" name="submitAction" value="Download Subscribers Submit" />
</form>
<span id="output"></span>

<?php
if(isset($_POST['submitAction'])) {
    if ($_POST['submitAction'] == 'Download Subscribers Submit') {
        $apiController = new APIController();
        //echo "Subscriber get";
        $apiController->getAllSubscribers();
    }
}
require_once('layout/footer.php');
?>
<script>
    $('#mainForm').on('submit',function(){
        window.pollingPeriod = 500;
        window.progressInterval;
        console.log("line 1");
        $.getJSON('loadAPI.php', function(data){
            console.log("line 2");
            clearInterval(window.progressInterval);
            $('#output').html('Woohoo, all done! Message from server: ' + data.message);
        }).fail(function(data){
            console.log("line 3 error: ");
            console.log(data);
            clearInterval(window.progressInterval);
            $('#output').html('Uh oh, something went wrong 1 ');
        });
        window.progressInterval = setInterval(updateProgress, window.pollingPeriod);
        function updateProgress(){
            $.getJSON('progress.json',function(data){
                console.log("line 4");
                $('#output').html(data.percentComplete*100 + ' complete');
            }).fail(function(data){
                console.log("line 5 error: ");
                console.log(data);
                clearInterval(window.progressInterval);
                $('#output').html('Uh oh, something went wrong 2 ');
            });
        }
        return false; //prevent the form for submitting or redirecting
    });
</script>
