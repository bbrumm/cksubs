<?php
require __DIR__ . '/vendor/autoload.php';
require_once('layout/header.php');
require_once('src/controller/APIController.php');
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

?>
<form method="POST" id="mainForm" action="">
    <p>
        <button type="submit" class="btn btn-primary" id="btnDownloadSubs" name="download" value="subs">Download Subscribers</button>
        <button type="submit" class="btn btn-primary" id="btnDownloadTags" name="download" value="tags">Download Tags</button>
    </p>
</form>
<!--
<form method="POST" id="testForm" action="loadAPI.php?type=tags">
    <p>
        <button type="submit" class="btn btn-primary">Download Tags Submit</button>
    </p>
</form>
-->
<span>Subscriber Download Progress:</span>
<span id="outputSubs"></span>
<br/>
<span>Tag Download Progress:</span>
<span id="outputTags"></span>
<br/><br/>
<h2>Tags</h2>

<form method="POST" id="tagUpdateForm" action="">
<button type="submit" class="btn btn-primary" id="btnUpdateTags">Update Tags</button>
</form>
<?php
$apiController = new APIController();

echo $apiController->getTagsForDisplay();

require_once('layout/footer.php');
?>
<script>
    //$('#mainForm').on('submit',function(){

    $('#btnDownloadSubs').click(function() {
        window.pollingPeriod = 500;
        window.progressInterval;
        console.log("line 1");
        $.getJSON('loadAPI.php?type=' + $(this).val(), function(data){
            console.log("line 2");
            clearInterval(window.progressInterval);
            $('#outputSubs').html('Completed');
        }).fail(function(data){
            console.log("line 3 error: ");
            console.log(data);
            console.log(data.responseText);
            clearInterval(window.progressInterval);
            $('#outputSubs').html('Uh oh, something went wrong 1 ');
        });
        window.progressInterval = setInterval(updateSubProgress, window.pollingPeriod);
        function updateSubProgress(){
            $.getJSON('progress.json',function(data){
                console.log("line 4");
                console.log(data);
                $('#outputSubs').html(data.percentSubsComplete * 100 + '% complete');
            }).fail(function(data){
                console.log("line 5 error: ");
                console.log(data);
                console.log(data.responseText);
                clearInterval(window.progressInterval);
                $('#outputSubs').html('Uh oh, something went wrong 2 ');
            });
        }
        return false; //prevent the form for submitting or redirecting
    });


    $('#btnDownloadTags').click(function() {
        window.pollingPeriod = 500;
        window.progressInterval;
        console.log("T line 1");
        $.getJSON('loadAPITags.php', function(data){
            console.log("T line 2");
            clearInterval(window.progressInterval);
            $('#outputTags').html('Completed');
        }).fail(function(data){
            console.log("T line 3 error: ");
            console.log(data);
            console.log(data.responseText);
            clearInterval(window.progressInterval);
            $('#outputTags').html('Uh oh, something went wrong 1');
        });
        window.progressInterval = setInterval(updateTagProgress, window.pollingPeriod);
        function updateTagProgress(){
            $.getJSON('progress.json',function(data){
                console.log("T line 4");
                //console.log(data);
                $('#outputTags').html(data.percentTagsComplete * 100 + '% complete');
            }).fail(function(data){
                console.log("T line 5 error: ");
                console.log(data);
                console.log(data.responseText);
                clearInterval(window.progressInterval);
                $('#outputTags').html('Uh oh, something went wrong 2');
            });
        }
        return false; //prevent the form for submitting or redirecting
    });

    $('#btnUpdateTags').click(function() {
       alert("TODO add Ajax call here to update data");
    });
</script>
