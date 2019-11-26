<?php
require_once("src/model/TagRecord.php");

class TagRecordTest extends \PHPUnit\Framework\TestCase {

    /*
     * Tests to write:
     * tag name number
     * tag name text - valid
     * tag name long text
     * tag name null
     * tag name empty string
     * tag map id number
     * tag map id text
     * tag map id null
     * tag map id empty string
     * last updated number
     * last updated text
     * last updated invalid date
     * last updated valid date
     * last updated null
     * last updated empty string
     */

//    Test Tag ID
    public function test_TagID_ValidNumber() {
        $tagIDToUse = 4;
        $tagRecord = new TagRecord();
        $tagRecord->setTagID($tagIDToUse);

        $expectedValue = $tagRecord->getTagID();
        $this->assertEquals($expectedValue, $tagIDToUse);
    }

    public function test_TagID_InvalidText() {
        $this->expectException("InvalidArgumentException");
        $tagIDToUse = "some words here";
        $tagRecord = new TagRecord();
        $tagRecord->setTagID($tagIDToUse);
    }

    public function test_TagID_Null() {
        $this->expectException("InvalidArgumentException");
        $tagIDToUse = null;
        $tagRecord = new TagRecord();
        $tagRecord->setTagID($tagIDToUse);
    }

    public function test_TagID_EmptyString() {
        $this->expectException("InvalidArgumentException");
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
        $this->expectException("InvalidArgumentException");
        $tagNameToUse = null;
        $tagRecord = new TagRecord();
        $tagRecord->setTagName($tagNameToUse);
    }

    public function test_TagName_EmptyString() {
        $this->expectException("InvalidArgumentException");
        $tagNameToUse = "";
        $tagRecord = new TagRecord();
        $tagRecord->setTagName($tagNameToUse);
    }


}