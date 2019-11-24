<?php
require_once('src/controller/TagDisplayer.php');

class TagDisplayerTest extends \PHPUnit\Framework\TestCase {

    const MAP_ID_MATCHED = 1;
    const MAP_ID_IGNORED = 2;

    public function test_OneTagDisplayed() {
        $tagArray = array(
            TagRecord::createTagRecord(1, 'single tag', self::MAP_ID_MATCHED)
        );
        $tagDisplayer = new TagDisplayer();

        $expectedTableHeader = "<table class='table'>";
        $actualResult = $tagDisplayer->prepareTagsForDisplay($tagArray);
        $this->assertContains($expectedTableHeader, $actualResult);

        $expectedTableRow = "<tr><td>1</td><td>single tag</td>";
        $this->assertContains($expectedTableRow, $actualResult);

        $expectedTableFooter = "</tbody></table>";
        $this->assertContains($expectedTableFooter, $actualResult);
    }

    public function test_ZeroTagsDisplayed() {
        $tagArray = array();
        $tagDisplayer = new TagDisplayer();

        $expectedMessage = "No tags found.";
        $actualResult = $tagDisplayer->prepareTagsForDisplay($tagArray);
        $this->assertEquals($expectedMessage, $actualResult);

    }

    public function test_MultipleTagsDisplayed() {
        $tagArray = array(
            TagRecord::createTagRecord(1, 'single tag', self::MAP_ID_MATCHED),
            TagRecord::createTagRecord(12324536, 'again', self::MAP_ID_IGNORED),
            TagRecord::createTagRecord(634, 'boomerang', self::MAP_ID_MATCHED),
            TagRecord::createTagRecord(1, 'sdfagi348bfkhb', self::MAP_ID_IGNORED)
        );
        $tagDisplayer = new TagDisplayer();

        $expectedTableHeader = "<table class='table'>";
        $actualResult = $tagDisplayer->prepareTagsForDisplay($tagArray);
        $this->assertContains($expectedTableHeader, $actualResult);

        $expectedTableRow = "<tr><td>1</td><td>single tag</td>";
        $this->assertContains($expectedTableRow, $actualResult);

        $expectedTableRow = "<tr><td>12324536</td><td>again</td>";
        $this->assertContains($expectedTableRow, $actualResult);

        $expectedTableRow = "<tr><td>634</td><td>boomerang</td>";
        $this->assertContains($expectedTableRow, $actualResult);

        $expectedTableRow = "<tr><td>1</td><td>sdfagi348bfkhb</td>";
        $this->assertContains($expectedTableRow, $actualResult);

    }

    public function test_CorrectColumnsAreShown() {
        $tagArray = array(
            TagRecord::createTagRecord(1, 'single tag', self::MAP_ID_MATCHED),
            TagRecord::createTagRecord(12324536, 'again', self::MAP_ID_IGNORED),
        );

        $tagDisplayer = new TagDisplayer();

        $expectedTableHeader = "<tr><th scope='col'>Tag ID</th><th scope='col'>Tag Name</th><th scope='col'>Map</th>";
        $actualResult = $tagDisplayer->prepareTagsForDisplay($tagArray);
        $this->assertContains($expectedTableHeader, $actualResult);

    }

    public function test_TagWithMatchIsChecked() {
        $tagArray = array(
            TagRecord::createTagRecord(1, 'single tag', self::MAP_ID_MATCHED),
            TagRecord::createTagRecord(12324536, 'again', self::MAP_ID_IGNORED),
        );

        $tagDisplayer = new TagDisplayer();

        $expectedTableRow = "<tr><td>1</td><td>single tag</td>".
            "<td><div class='form-check'>" .
            "<input id='1_hidden' type='hidden' value='2' name='1'>" .
            "<input class='form-check-input' type='checkbox' value='1' name='1' id='1' checked>" .
            "</div>";
        $actualResult = $tagDisplayer->prepareTagsForDisplay($tagArray);
        $this->assertContains($expectedTableRow, $actualResult);
    }

    public function test_TagWithIgnoreIsUnChecked() {
        $tagArray = array(
            TagRecord::createTagRecord(1, 'single tag', self::MAP_ID_MATCHED),
            TagRecord::createTagRecord(12324536, 'again', self::MAP_ID_IGNORED),
        );

        $tagDisplayer = new TagDisplayer();

        $expectedTableRow = "<tr><td>12324536</td><td>again</td>".
            "<td><div class='form-check'>" .
            "<input id='12324536_hidden' type='hidden' value='2' name='12324536'>" .
            "<input class='form-check-input' type='checkbox' value='1' name='12324536' id='12324536' >" .
            "</div>";
        $actualResult = $tagDisplayer->prepareTagsForDisplay($tagArray);
        $this->assertContains($expectedTableRow, $actualResult);
    }

    public function test_DisplayTagsFromDB() {
        $tagDisplayer = new TagDisplayer();

        $expectedTableHeader = "<table class='table'>";
        $actualResult = $tagDisplayer->getTagsForDisplay();
        $this->assertContains($expectedTableHeader, $actualResult);

        $expectedTableRow = "<tr><td>390939</td><td>Start Content 01</td>";
        $actualResult = $tagDisplayer->getTagsForDisplay();
        $this->assertContains($expectedTableRow, $actualResult);

    }

}