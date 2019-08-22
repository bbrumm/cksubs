<?php
require_once("src/model/DBConnection.php");
require __DIR__ . '/../../vendor/autoload.php';


class TagDisplayer {

    public function getTagsForDisplay() {
        $dbConnection = new DBConnection();
        $conn = $dbConnection->createConnection();

        $tagsInDatabase = $this->loadTagsFromDatabase($conn);
        return $this->prepareTagsForDisplay($tagsInDatabase);
    }

    private function loadTagsFromDatabase(PDO $conn) {
        $queryString = "SELECT t.tag_id, t.tag_name, t.tag_map_id FROM tag t ORDER BY t.tag_map_id, t.tag_name;";
        $queryResult = $conn->query($queryString);
        $resultArray = $queryResult->fetchAll(PDO::FETCH_ASSOC);
        return $resultArray;
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
        $outputData .= "</tr>";
        $outputData .= "</thead>";
        return $outputData;
    }

    private function populateTagTableBody($tagArray) {
        $outputData = "<tbody>";
        foreach ($tagArray as $tagInDatabase) {
            $outputData .= "<tr>";
            $outputData .= "<td>" . $tagInDatabase['tag_id'] . "</td>";
            $outputData .= "<td>" . $tagInDatabase['tag_name'] . "</td>";
            $outputData .= $this->appendCheckboxHTMLCell($tagInDatabase);
            $outputData .= "</tr>";
        }
        $outputData .= "</tbody>";
        $outputData .= "</table>";
        return $outputData;
    }

    private function appendCheckboxHTMLCell($tagInDatabase) {
        $checkedValue = $this->determineCheckboxCheckedValue($tagInDatabase);
        return "<td><div class='form-check'>" .
            "<input class='form-check-input' type='checkbox' value='' id='defaultCheck1' " . $checkedValue . ">" .
            "</div></td>";
    }

    private function determineCheckboxCheckedValue($tagArrayRow) {
        $checkedValue = "";
        if($this->isTagMappedForLookup($tagArrayRow)) {
            $checkedValue = "checked";
        }
        return $checkedValue;
    }



    private function isTagMappedForLookup($tagArrayRow) {
        return ($tagArrayRow['tag_map_id'] == 1);
    }


}