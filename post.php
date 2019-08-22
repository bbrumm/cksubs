<?php
require_once('src/controller/TagMatchUpdater.php');
$postedData = $_POST;
$tagMatchUpdater = new TagMatchUpdater();
$tagMatchUpdater->updateTagMappingFromFormData($postedData);
