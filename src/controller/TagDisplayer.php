<?php
require_once("src/model/DBConnection.php");
require_once("src/model/DBTagDatabase.php");
require_once("src/model/TagRecord.php");
require __DIR__ . '/../../vendor/autoload.php';


class TagDisplayer {

    const MAP_ID_MATCHED = 1;
    const MAP_ID_IGNORED = 2;

    public function getTagsForDisplay() {
        $dbTagDatabase = new DBTagDatabase();
        $tagsInDatabase = $dbTagDatabase->loadTagsFromDatabase();
        return $this->prepareTagsForDisplay($tagsInDatabase);
    }

    public function prepareTagsForDisplay($tagArray) {
        if(count($tagArray) > 0) {
            $outputData = $this->populateTagTableHeader();
            $outputData .= $this->populateTagTableBody($tagArray);
            return $outputData;
        } else {
            return "No tags found.";
        }
    }

    private function populateTagTableHeader() {
        $outputData = "<table class='table'>";
        $outputData .= "<thead class='thead-dark'>";
        $outputData .= "<tr>";
        $outputData .= "<th scope='col'>Tag ID</th>";
        $outputData .= "<th scope='col'>Tag Name</th>";
        $outputData .= "<th scope='col'>Map</th>";
        $outputData .= "<th scope='col'>Update</th>";
        $outputData .= "<th scope='col'>Last Updated</th>";
        $outputData .= "</tr>";
        $outputData .= "</thead>";
        return $outputData;
    }

    private function populateTagTableBody($tagArray) {
        $outputData = "<tbody>";
        foreach ($tagArray as $tagInDatabase) {
            $outputData .= "<tr>";
            $outputData .= "<td>" . $tagInDatabase->getTagID() . "</td>";
            $outputData .= "<td>" . $tagInDatabase->getTagName() . "</td>";
            $outputData .= $this->appendCheckboxHTMLCell($tagInDatabase);
            $outputData .= $this->appendTagSubscriberDownloadButton($tagInDatabase);
            $outputData .= "<td>" . $tagInDatabase->getTagLastUpdated() . "</td>";
            $outputData .= "</tr>";
        }
        $outputData .= "</tbody>";
        $outputData .= "</table>";
        return $outputData;
    }

    private function appendCheckboxHTMLCell($tagInDatabase) {
        $checkedValue = $this->determineCheckboxCheckedValue($tagInDatabase);
        return "<td><div class='form-check'>" .
            "<input id='". $tagInDatabase->getTagID() ."_hidden' type='hidden' value='". self::MAP_ID_IGNORED ."' name='". $tagInDatabase->getTagID() ."'>" .
            "<input class='form-check-input' type='checkbox' value='". self::MAP_ID_MATCHED ."' name='". $tagInDatabase->getTagID() ."' id='". $tagInDatabase->getTagID() ."' " . $checkedValue . ">" .
            "</div></td>";
    }

    private function determineCheckboxCheckedValue($tagArrayRow) {
        $checkedValue = "";
        if($this->isTagMappedForLookup($tagArrayRow)) {
            $checkedValue = "checked";
        }
        return $checkedValue;
    }

    private function appendTagSubscriberDownloadButton($tagInDatabase) {
        return "<td><button type='button' class='btn btn-primary' onClick='btnUpdateTagSubscribersClick(". $tagInDatabase->getTagID() .")' id='btnUpdateTagSubscribers'>Update Subscribers ". $tagInDatabase->getTagID() ." </button></td>";

    }



    private function isTagMappedForLookup($tagArrayRow) {
        return ($tagArrayRow->getTagMapID() == self::MAP_ID_MATCHED);
    }


}