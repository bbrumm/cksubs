<?php

class TagRecord {

    private $tag_id;
    private $tag_name;
    private $tag_map_id;
    private $tag_last_updated;

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
        if (is_numeric($pValue)) {
            $this->tag_id = $pValue;
        } else {
            throw new InvalidArgumentException;
        }
    }

    public function setTagName($pValue) {
        if(!is_null($pValue) && $pValue <> "") {
            $this->tag_name = $pValue;
        } else {
            throw new InvalidArgumentException;
        }
    }

    public function setTagMapID($pValue) {
        $this->tag_map_id = $pValue;
    }

    public function setLastUpdated($pValue) {
        $this->tag_last_updated = $pValue;
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

    public function getTagLastUpdated() {
        return $this->tag_last_updated;
    }

}