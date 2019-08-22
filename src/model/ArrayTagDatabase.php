<?php
require_once 'ITagDatabase.php';

class ArrayTagDatabase implements ITagDatabase {

    private $tagArray;

    public function __construct() {

    }

    public function setTestData($sampleTagArray) {
        $this->tagArray = $sampleTagArray;
    }

    public function loadTagsFromDatabase() {
        return $this->tagArray;
    }

    public function updateTagMapIDs($tagDifferences) {
        foreach ($tagDifferences as $tagDifferenceRow) {
            foreach($this->tagArray as $existingTagRowKey => $existingTagRow) {
                if($tagDifferenceRow->getTagID() == $existingTagRow->getTagID()){
                        //Tag map ID is different. Update
                    $this->tagArray[$existingTagRowKey]->setTagMapID($tagDifferenceRow->getTagMapID());
                }
            }
        }
    }


}