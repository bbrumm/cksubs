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
        if (is_numeric($pValue)) {
            $this->tag_map_id = $pValue;
        } else {
            throw new InvalidArgumentException;
        }
    }

    public function setLastUpdated($pValue) {
        if ($this->validateDate($pValue)) {
            $this->tag_last_updated = $pValue;
        } else {
            throw new InvalidArgumentException;
        }
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

    public function getLastUpdated() {
        return $this->tag_last_updated;
    }

    private function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

}