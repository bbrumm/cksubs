<?php
require_once 'ITagDatabase.php';
require_once 'DBConnection.php';
require_once("src/model/TagRecord.php");

class DBTagDatabase implements ITagDatabase {

    const MAP_ID_MATCHED = 1;
    const MAP_ID_IGNORED = 2;

    private $conn;

    public function loadTagsFromDatabase() {
        $dbConnection = new DBConnection();
        $this->conn = $dbConnection->createConnection();

        //TODO refactor this into a call in a utilities class or DBConnection model
        $queryString = "SELECT t.tag_id, t.tag_name, t.tag_map_id FROM tag t ORDER BY t.tag_map_id, t.tag_name;";
        $preparedStatement = $this->conn->prepare($queryString);
        $preparedStatement->execute();

        $resultArray = $preparedStatement->fetchAll(PDO::FETCH_ASSOC);
        return $this->convertDatabaseResultIntoObjectArray($resultArray);

    }

    private function convertDatabaseResultIntoObjectArray($databaseResultArray) {
        $tagRecordArray = array();

        foreach($databaseResultArray as $key=>$resultArrayRow) {
            $tagRecord = new TagRecord();
            $tagRecord->setTagID($resultArrayRow['tag_id']);
            $tagRecord->setTagName($resultArrayRow['tag_name']);
            $tagRecord->setTagMapID($resultArrayRow['tag_map_id']);
            $tagRecordArray[] = $tagRecord;
        }

        return $tagRecordArray;
    }

    public function updateTagMapIDs($tagDifferences) {
        $dbConnection = new DBConnection();
        $this->conn = $dbConnection->createConnection();

        $this->updateMapIDsToMatched($tagDifferences);
        $this->updateMapIDsToIgnored($tagDifferences);
        $this->commitChanges();
    }

    private function updateMapIDsToMatched($tagDifferences) {
        $idList = $this->getIDsToSetAMapID($tagDifferences, self::MAP_ID_MATCHED);
        $queryString = "UPDATE tag SET tag_map_id = ". self::MAP_ID_MATCHED .
            " WHERE tag_id IN (". $idList .");";
        $this->runQuery($queryString);
    }

    private function updateMapIDsToIgnored($tagDifferences) {
        $idList = $this->getIDsToSetAMapID($tagDifferences, self::MAP_ID_IGNORED);
        $queryString = "UPDATE tag SET tag_map_id = ". self::MAP_ID_IGNORED .
            " WHERE tag_id IN (". $idList .");";
        $this->runQuery($queryString);
    }

    private function commitChanges() {
        $this->runQuery("COMMIT;");
    }

    private function getIDsToSetAMapID($tagDifferences, $tagMapID) {
        $idList = "0"; //Dummy ID so that a comma can be added below with minimal logic
        foreach($tagDifferences as $tagRow) {
            if($tagRow->getTagMapID() == $tagMapID) {
                $idList .= ", " . $tagRow->getTagID();
            }
        }
        return $idList;
    }

    private function runQuery($queryString) {
        $this->conn->query($queryString);
    }


}