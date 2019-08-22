<?php
require_once("src/model/TagRecord.php");
require_once("src/model/DBTagDatabase.php");

class TagMatchUpdater {

    public function updateTagMappingFromFormData($postedData) {
        //Load the form data from $_POST, convert it to an array, then call updateTagMapping
        $tagRecordArray = array();
        foreach($postedData as $key=>$value) {
            $tagRecord = TagRecord::createTagRecord($key, 'example', $value);
            $tagRecordArray[] = $tagRecord;
        }

        $dbTagDatabase = new DBTagDatabase();
        $this->updateTagMapping($tagRecordArray, $dbTagDatabase);

        echo "Tags updated.";
    }


    public function updateTagMapping($tagArrayFromPage, ITagDatabase $tagDatabase) {
        $tagArrayFromDatabase = $tagDatabase->loadTagsFromDatabase();
        $tagDifferences = $this->determineTagDifferences($tagArrayFromPage, $tagArrayFromDatabase);
        $tagDatabase->updateTagMapIDs($tagDifferences);
    }

    private function determineTagDifferences($tagArrayFromPage, $tagArrayFromDatabase) {
        $tagDifferences = array();
        foreach ($tagArrayFromPage as $tagFromPageRow) {
            foreach($tagArrayFromDatabase as $tagFromDatabaseKey => $tagFromDatabaseRow) {
                if($this->isTagIDMatchingButMapIDIsDifferent($tagFromPageRow, $tagFromDatabaseRow)){
                    $tagDifferences[] = $tagFromPageRow;
                }
            }
        }

        return $tagDifferences;
    }

    private function isTagIDMatchingButMapIDIsDifferent($tagRecord1, $tagRecord2) {
        if($tagRecord1->getTagID() == $tagRecord2->getTagID() &&
            $tagRecord1->getTagMapID() != $tagRecord2->getTagMapID()){
            return true;
        }
        return false;
    }


}