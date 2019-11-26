<?php
require_once("src/model/TagRecord.php");

class TagRecordTest extends \PHPUnit\Framework\TestCase {

    const INVALID_ARGUMENT_EXCEPTION = "InvalidArgumentException";

//    Test Tag ID
    public function test_TagID_ValidNumber() {
        $tagIDToUse = 4;
        $tagRecord = new TagRecord();
        $tagRecord->setTagID($tagIDToUse);

        $expectedValue = $tagRecord->getTagID();
        $this->assertEquals($expectedValue, $tagIDToUse);
    }

    public function test_TagID_InvalidText() {
        $this->expectException(self::INVALID_ARGUMENT_EXCEPTION);
        $tagIDToUse = "some words here";
        $tagRecord = new TagRecord();
        $tagRecord->setTagID($tagIDToUse);
    }

    public function test_TagID_Null() {
        $this->expectException(self::INVALID_ARGUMENT_EXCEPTION);
        $tagIDToUse = null;
        $tagRecord = new TagRecord();
        $tagRecord->setTagID($tagIDToUse);
    }

    public function test_TagID_EmptyString() {
        $this->expectException(self::INVALID_ARGUMENT_EXCEPTION);
        $tagIDToUse = "";
        $tagRecord = new TagRecord();
        $tagRecord->setTagID($tagIDToUse);
    }

//    Test Tag Name
    public function test_TagName_ValidText() {
        $tagNameToUse = "A new tag name";
        $tagRecord = new TagRecord();
        $tagRecord->setTagName($tagNameToUse);

        $expectedValue = $tagRecord->getTagName();
        $this->assertEquals($expectedValue, $tagNameToUse);
    }

    public function test_TagName_Number() {
        $tagNameToUse = 24534;
        $tagRecord = new TagRecord();
        $tagRecord->setTagName($tagNameToUse);

        $expectedValue = $tagRecord->getTagName();
        $this->assertEquals($expectedValue, $tagNameToUse);
    }

    public function test_TagName_LongText() {
        $tagNameToUse = "A new tag name that is very long and might be too long to store in the field but let's see";
        $tagRecord = new TagRecord();
        $tagRecord->setTagName($tagNameToUse);

        $expectedValue = $tagRecord->getTagName();
        $this->assertEquals($expectedValue, $tagNameToUse);
    }

    public function test_TagName_Null() {
        $this->expectException(self::INVALID_ARGUMENT_EXCEPTION);
        $tagNameToUse = null;
        $tagRecord = new TagRecord();
        $tagRecord->setTagName($tagNameToUse);
    }

    public function test_TagName_EmptyString() {
        $this->expectException(self::INVALID_ARGUMENT_EXCEPTION);
        $tagNameToUse = "";
        $tagRecord = new TagRecord();
        $tagRecord->setTagName($tagNameToUse);
    }

    //    Test Tag Map ID
    public function test_TagMapID_ValidNumber() {
        $tagMapIDToUse = 4;
        $tagRecord = new TagRecord();
        $tagRecord->setTagMapID($tagMapIDToUse);

        $expectedValue = $tagRecord->getTagMapID();
        $this->assertEquals($expectedValue, $tagMapIDToUse);
    }

    public function test_TagMapID_InvalidText() {
        $this->expectException(self::INVALID_ARGUMENT_EXCEPTION);
        $tagMapIDToUse = "some words here";
        $tagRecord = new TagRecord();
        $tagRecord->setTagMapID($tagMapIDToUse);
    }

    public function test_TagMapID_Null() {
        $this->expectException(self::INVALID_ARGUMENT_EXCEPTION);
        $tagMapIDToUse = null;
        $tagRecord = new TagRecord();
        $tagRecord->setTagMapID($tagMapIDToUse);
    }

    public function test_TagMapID_EmptyString() {
        $this->expectException(self::INVALID_ARGUMENT_EXCEPTION);
        $tagMapIDToUse = "";
        $tagRecord = new TagRecord();
        $tagRecord->setTagMapID($tagMapIDToUse);
    }

//    Test Last Updated Date
    public function test_TagLastUpdated_DateValid() {
        $this->expectException(self::INVALID_ARGUMENT_EXCEPTION);

        $tagLastUpdatedDateToUse = "2019-11-01";
        $tagRecord = new TagRecord();
        $tagRecord->setLastUpdated($tagLastUpdatedDateToUse);
    }

    public function test_TagLastUpdated_DateTime() {
        $tagLastUpdatedDateToUse = "2019-11-23 15:49:47";
        $tagRecord = new TagRecord();
        $tagRecord->setLastUpdated($tagLastUpdatedDateToUse);

        $expectedValue = $tagRecord->getLastUpdated();
        $this->assertEquals($expectedValue, $tagLastUpdatedDateToUse);
    }

    public function test_TagLastUpdated_DateInvalid() {
        $this->expectException(self::INVALID_ARGUMENT_EXCEPTION);

        $tagLastUpdatedDateToUse = "2019-11-41";
        $tagRecord = new TagRecord();
        $tagRecord->setLastUpdated($tagLastUpdatedDateToUse);
    }

    public function test_TagLastUpdated_Number() {
        $this->expectException(self::INVALID_ARGUMENT_EXCEPTION);
        $tagLastUpdatedDateToUse = 45;
        $tagRecord = new TagRecord();
        $tagRecord->setLastUpdated($tagLastUpdatedDateToUse);
    }

    public function test_TagLastUpdated_Text() {
        $this->expectException(self::INVALID_ARGUMENT_EXCEPTION);
        $tagLastUpdatedDateToUse = "something else";
        $tagRecord = new TagRecord();
        $tagRecord->setLastUpdated($tagLastUpdatedDateToUse);
    }

    public function test_TagLastUpdated_Null() {
        $this->expectException(self::INVALID_ARGUMENT_EXCEPTION);
        $tagLastUpdatedDateToUse = null;
        $tagRecord = new TagRecord();
        $tagRecord->setLastUpdated($tagLastUpdatedDateToUse);
    }

    public function test_TagLastUpdated_EmptyString() {
        $this->expectException(self::INVALID_ARGUMENT_EXCEPTION);
        $tagLastUpdatedDateToUse = "";
        $tagRecord = new TagRecord();
        $tagRecord->setLastUpdated($tagLastUpdatedDateToUse);
    }


}