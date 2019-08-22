<?php

class TagRecord {

    private $tag_id;
    private $tag_name;
    private $tag_map_id;

    public function __construct() {

    }

    public static function createTagRecord($tagID, $tagName, $tagMapID) {
        $tagRecord = new TagRecord();
        $tagRecord->setTagID($tagID);
        $tagRecord->setTagName($tagName);
        $tagRecord->setTagMapID($tagMapID);
        return $tagRecord;
    }

    public function setTagID($pValue) {
        $this->tag_id = $pValue;
    }

    public function setTagName($pValue) {
        $this->tag_name = $pValue;
    }

    public function setTagMapID($pValue) {
        $this->tag_map_id = $pValue;
    }

    public function getTagID() {
        return $this->tag_id;
    }

    public function getTagName() {
        return $this->tag_name;
    }

    public function getTagMapID() {
        return $this->tag_map_id;
    }

}