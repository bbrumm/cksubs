<?php
require_once('src/controller/TagMatchUpdater.php');
require_once('src/model/ArrayTagDatabase.php');
require_once('src/model/DBTagDatabase.php');
require_once("src/model/TagRecord.php");

class TagMatchUpdaterTest extends \PHPUnit\Framework\TestCase {

    const MAP_ID_MATCHED = 1;
    const MAP_ID_IGNORED = 2;

    /*
     * Tests:
     * Update a set of one tag with Matched where it was Ignore (done)
     * Update a set of one tag with Ignore where it was Matched (done)
     * Update multiple tags where both are Matched but one was Ignore (done)
     * Update multiple tags where both are Matched but they are already Matched (done)
     * Update multiple tags where both are Ignore and one was already Matched (done)
     * Update multiple tags where both are Ignore but they are already Ignore (done)
     * Update a large number of tags with different combinations of match and ignore
     * Update when no tags are in the set
     *
     */

    public function test_UpdateSingleTagFromIgnoreToMatched() {
        $tagArrayFromPage = array(
            TagRecord::createTagRecord(1, 'some tag', self::MAP_ID_MATCHED)
        );

        $tagArrayFromDatabase = array(
            TagRecord::createTagRecord(1, 'some tag', self::MAP_ID_IGNORED)
        );

        $arrayTagDatabase = new ArrayTagDatabase();
        $arrayTagDatabase->setTestData($tagArrayFromDatabase);

        $tagMatchUpdater = new TagMatchUpdater();

        $tagMatchUpdater->updateTagMapping($tagArrayFromPage, $arrayTagDatabase);

        $tagArrayFromDatabaseAfterUpdate = $arrayTagDatabase->loadTagsFromDatabase();

        $expectedTagMapID = self::MAP_ID_MATCHED;
        $actualTagMapID = $tagArrayFromDatabaseAfterUpdate[0]->getTagMapID();
        $this->assertEquals($expectedTagMapID, $actualTagMapID);

    }

    public function test_UpdateSingleTagFromMatchedToIgnore() {
        $tagArrayFromPage = array(
            TagRecord::createTagRecord(1, 'some tag', self::MAP_ID_IGNORED)
        );

        $tagArrayFromDatabase = array(
            TagRecord::createTagRecord(1, 'some tag', self::MAP_ID_MATCHED)
        );

        $arrayTagDatabase = new ArrayTagDatabase();
        $arrayTagDatabase->setTestData($tagArrayFromDatabase);

        $tagMatchUpdater = new TagMatchUpdater();

        $tagMatchUpdater->updateTagMapping($tagArrayFromPage, $arrayTagDatabase);

        $tagArrayFromDatabaseAfterUpdate = $arrayTagDatabase->loadTagsFromDatabase();

        $expectedTagMapID = self::MAP_ID_IGNORED;
        $actualTagMapID = $tagArrayFromDatabaseAfterUpdate[0]->getTagMapID();
        $this->assertEquals($expectedTagMapID, $actualTagMapID);

    }

    public function test_UpdateMultipleTagsOneDifference() {
        $tagArrayFromPage = array(
            TagRecord::createTagRecord(1, 'some tag', self::MAP_ID_MATCHED),
            TagRecord::createTagRecord(2, 'some tag', self::MAP_ID_MATCHED)
        );

        $tagArrayFromDatabase = array(
            TagRecord::createTagRecord(1, 'some tag', self::MAP_ID_MATCHED),
            TagRecord::createTagRecord(2, 'some tag', self::MAP_ID_IGNORED)
        );

        $arrayTagDatabase = new ArrayTagDatabase();
        $arrayTagDatabase->setTestData($tagArrayFromDatabase);

        $tagMatchUpdater = new TagMatchUpdater();

        $tagMatchUpdater->updateTagMapping($tagArrayFromPage, $arrayTagDatabase);

        $tagArrayFromDatabaseAfterUpdate = $arrayTagDatabase->loadTagsFromDatabase();

        $expectedFirstTagMapID = self::MAP_ID_MATCHED;
        $actualFirstTagMapID = $tagArrayFromDatabaseAfterUpdate[0]->getTagMapID();
        $this->assertEquals($expectedFirstTagMapID, $actualFirstTagMapID);

        $expectedSecondTagMapID = self::MAP_ID_MATCHED;
        $actualSecondTagMapID = $tagArrayFromDatabaseAfterUpdate[1]->getTagMapID();
        $this->assertEquals($expectedSecondTagMapID, $actualSecondTagMapID);

    }

    public function test_UpdateMultipleTagsAlreadyMatched() {
        $tagArrayFromPage = array(
            TagRecord::createTagRecord(1, 'some tag', self::MAP_ID_MATCHED),
            TagRecord::createTagRecord(2, 'some tag', self::MAP_ID_MATCHED)
        );

        $tagArrayFromDatabase = array(
            TagRecord::createTagRecord(1, 'some tag', self::MAP_ID_MATCHED),
            TagRecord::createTagRecord(2, 'some tag', self::MAP_ID_MATCHED)
        );

        $arrayTagDatabase = new ArrayTagDatabase();
        $arrayTagDatabase->setTestData($tagArrayFromDatabase);

        $tagMatchUpdater = new TagMatchUpdater();

        $tagMatchUpdater->updateTagMapping($tagArrayFromPage, $arrayTagDatabase);

        $tagArrayFromDatabaseAfterUpdate = $arrayTagDatabase->loadTagsFromDatabase();

        $expectedFirstTagMapID = self::MAP_ID_MATCHED;
        $actualFirstTagMapID = $tagArrayFromDatabaseAfterUpdate[0]->getTagMapID();
        $this->assertEquals($expectedFirstTagMapID, $actualFirstTagMapID);

        $expectedSecondTagMapID = self::MAP_ID_MATCHED;
        $actualSecondTagMapID = $tagArrayFromDatabaseAfterUpdate[1]->getTagMapID();
        $this->assertEquals($expectedSecondTagMapID, $actualSecondTagMapID);

    }

    public function test_UpdateMultipleTagsOneDifferenceMatched() {
        $tagArrayFromPage = array(
            TagRecord::createTagRecord(1, 'some tag', self::MAP_ID_IGNORED),
            TagRecord::createTagRecord(2, 'some tag', self::MAP_ID_IGNORED)
        );

        $tagArrayFromDatabase = array(
            TagRecord::createTagRecord(1, 'some tag', self::MAP_ID_MATCHED),
            TagRecord::createTagRecord(2, 'some tag', self::MAP_ID_IGNORED)
        );

        $arrayTagDatabase = new ArrayTagDatabase();
        $arrayTagDatabase->setTestData($tagArrayFromDatabase);

        $tagMatchUpdater = new TagMatchUpdater();

        $tagMatchUpdater->updateTagMapping($tagArrayFromPage, $arrayTagDatabase);

        $tagArrayFromDatabaseAfterUpdate = $arrayTagDatabase->loadTagsFromDatabase();

        $expectedFirstTagMapID = self::MAP_ID_IGNORED;
        $actualFirstTagMapID = $tagArrayFromDatabaseAfterUpdate[0]->getTagMapID();
        $this->assertEquals($expectedFirstTagMapID, $actualFirstTagMapID);

        $expectedSecondTagMapID = self::MAP_ID_IGNORED;
        $actualSecondTagMapID = $tagArrayFromDatabaseAfterUpdate[1]->getTagMapID();
        $this->assertEquals($expectedSecondTagMapID, $actualSecondTagMapID);

    }

    public function test_UpdateMultipleTagsAlreadyIgnored() {
        $tagArrayFromPage = array(
            TagRecord::createTagRecord(1, 'some tag', self::MAP_ID_IGNORED),
            TagRecord::createTagRecord(2, 'some tag', self::MAP_ID_IGNORED)
        );

        $tagArrayFromDatabase = array(
            TagRecord::createTagRecord(1, 'some tag', self::MAP_ID_IGNORED),
            TagRecord::createTagRecord(2, 'some tag', self::MAP_ID_IGNORED)
        );

        $arrayTagDatabase = new ArrayTagDatabase();
        $arrayTagDatabase->setTestData($tagArrayFromDatabase);

        $tagMatchUpdater = new TagMatchUpdater();

        $tagMatchUpdater->updateTagMapping($tagArrayFromPage, $arrayTagDatabase);

        $tagArrayFromDatabaseAfterUpdate = $arrayTagDatabase->loadTagsFromDatabase();

        $expectedFirstTagMapID = self::MAP_ID_IGNORED;
        $actualFirstTagMapID = $tagArrayFromDatabaseAfterUpdate[0]->getTagMapID();
        $this->assertEquals($expectedFirstTagMapID, $actualFirstTagMapID);

        $expectedSecondTagMapID = self::MAP_ID_IGNORED;
        $actualSecondTagMapID = $tagArrayFromDatabaseAfterUpdate[1]->getTagMapID();
        $this->assertEquals($expectedSecondTagMapID, $actualSecondTagMapID);

    }

    public function test_UpdateManyTags() {
        $tagArrayFromPage = array(
            TagRecord::createTagRecord(1, 'some tag', self::MAP_ID_MATCHED),
            TagRecord::createTagRecord(2, 'dfvdvf', self::MAP_ID_IGNORED),
            TagRecord::createTagRecord(5, 'acs', self::MAP_ID_MATCHED),
            TagRecord::createTagRecord(9, '134', self::MAP_ID_IGNORED),
            TagRecord::createTagRecord(12, 'boo', self::MAP_ID_MATCHED),
            TagRecord::createTagRecord(92, 'qqq', self::MAP_ID_MATCHED),
            TagRecord::createTagRecord(109, 'wwwee', self::MAP_ID_IGNORED),
            TagRecord::createTagRecord(14, 'antler', self::MAP_ID_IGNORED)
        );

        $tagArrayFromDatabase = array(
            TagRecord::createTagRecord(1, 'some tag', self::MAP_ID_IGNORED),
            TagRecord::createTagRecord(2, 'dfvdvf', self::MAP_ID_IGNORED),
            TagRecord::createTagRecord(5, 'acs', self::MAP_ID_MATCHED),
            TagRecord::createTagRecord(9, '134', self::MAP_ID_MATCHED),
            TagRecord::createTagRecord(12, 'boo', self::MAP_ID_MATCHED),
            TagRecord::createTagRecord(92, 'qqq', self::MAP_ID_MATCHED),
            TagRecord::createTagRecord(109, 'wwwee', self::MAP_ID_IGNORED),
            TagRecord::createTagRecord(14, 'antler', self::MAP_ID_MATCHED)

        );

        $arrayTagDatabase = new ArrayTagDatabase();
        $arrayTagDatabase->setTestData($tagArrayFromDatabase);

        $tagMatchUpdater = new TagMatchUpdater();

        $tagMatchUpdater->updateTagMapping($tagArrayFromPage, $arrayTagDatabase);

        $tagArrayFromDatabaseAfterUpdate = $arrayTagDatabase->loadTagsFromDatabase();

        $expectedTagMapIDs = array(
            self::MAP_ID_MATCHED, self::MAP_ID_IGNORED, self::MAP_ID_MATCHED, self::MAP_ID_IGNORED,
            self::MAP_ID_MATCHED, self::MAP_ID_MATCHED, self::MAP_ID_IGNORED, self::MAP_ID_IGNORED
        );

        foreach($tagArrayFromDatabaseAfterUpdate as $tagFromDatabaseKey=>$tagFromDatabaseRow) {
            $actualTagMapID = $tagArrayFromDatabaseAfterUpdate[$tagFromDatabaseKey]->getTagMapID();
            $this->assertEquals($expectedTagMapIDs[$tagFromDatabaseKey], $actualTagMapID);
        }

    }

    public function test_UpdateTagsToDatabase_Ignored() {
        $tagArrayFromPage = array(
            TagRecord::createTagRecord(429090, 'Done Content 01', self::MAP_ID_MATCHED),
            TagRecord::createTagRecord(435103, 'DONESEQ Engagement DB Normalisation', self::MAP_ID_MATCHED),
            TagRecord::createTagRecord(514580, 'Start Content 06', self::MAP_ID_IGNORED)
        );

        $dbTagDatabase = new DBTagDatabase();
        $tagMatchUpdater = new TagMatchUpdater();
        $tagMatchUpdater->updateTagMapping($tagArrayFromPage, $dbTagDatabase);

        $tagArrayFromDatabaseAfterUpdate = $dbTagDatabase->loadTagsFromDatabase();

        $expectedFirstTagMapID = self::MAP_ID_MATCHED;
        $actualFirstTagMapID = $this->findTagMapID(429090, $tagArrayFromDatabaseAfterUpdate);
        $this->assertEquals($expectedFirstTagMapID, $actualFirstTagMapID);

        $expectedSecondTagMapID = self::MAP_ID_MATCHED;
        $actualSecondTagMapID = $this->findTagMapID(435103, $tagArrayFromDatabaseAfterUpdate);
        $this->assertEquals($expectedSecondTagMapID, $actualSecondTagMapID);

        $expectedThirdTagMapID = self::MAP_ID_IGNORED;
        $actualThirdTagMapID = $this->findTagMapID(514580, $tagArrayFromDatabaseAfterUpdate);
        $this->assertEquals($expectedThirdTagMapID, $actualThirdTagMapID);

        //Reset tag_map_id values
        $dbConnection = new DBConnection();
        $conn = $dbConnection->createConnection();
        $resetMatchedQueryString = "UPDATE tag SET tag_map_id = 1 WHERE tag_id IN (429090, 514580);";
        $conn->query($resetMatchedQueryString);
        $resetIgnoredQueryString = "UPDATE tag SET tag_map_id = 2 WHERE tag_id IN (435103);";
        $conn->query($resetIgnoredQueryString);


    }

    private function findTagMapID($tagID, $tagArray) {
        $tagKey = $this->findTagArrayKeyFromTagID($tagID, $tagArray);
        return $tagArray[$tagKey]->getTagMapID();
    }

    private function findTagArrayKeyFromTagID($tagID, $tagArray) {
        foreach($tagArray as $key=>$tagRow) {
            if ($tagRow->getTagID() == $tagID) {
                return $key;
            }
        }
    }


}