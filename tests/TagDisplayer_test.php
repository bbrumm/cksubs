<?php
require_once('src/controller/TagDisplayer.php');

class TagDisplayerTest extends \PHPUnit\Framework\TestCase {
    public function test_OneTagDisplayed() {
        $tagArray = array(
            array(
                'tag_id'=>1,
                'tag_name'=>'single tag',
                'tag_map_id'=>'1'
            )
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
            array(
                'tag_id'=>1,
                'tag_name'=>'single tag',
                'tag_map_id'=>'1'
            ),
            array(
                'tag_id'=>12324536,
                'tag_name'=>'again',
                'tag_map_id'=>'0'
            ),
            array(
                'tag_id'=>634,
                'tag_name'=>'boomerang',
                'tag_map_id'=>'1'
            ),
            array(
                'tag_id'=>1,
                'tag_name'=>'sdfagi348bfkhb',
                'tag_map_id'=>'0'
            )
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
            array(
                'tag_id'=>1,
                'tag_name'=>'single tag',
                'tag_map_id'=>'1'
            ),
            array(
                'tag_id'=>12324536,
                'tag_name'=>'again',
                'tag_map_id'=>'0'
            )
        );

        $tagDisplayer = new TagDisplayer();

        $expectedTableHeader = "<tr><th scope='col'>Tag ID</th><th scope='col'>Tag Name</th><th scope='col'>Map</th>";
        $actualResult = $tagDisplayer->prepareTagsForDisplay($tagArray);
        $this->assertContains($expectedTableHeader, $actualResult);

    }

    public function test_TagWithMatchIsChecked() {
        $tagArray = array(
            array(
                'tag_id'=>1,
                'tag_name'=>'single tag',
                'tag_map_id'=>'1'
            ),
            array(
                'tag_id'=>12324536,
                'tag_name'=>'again',
                'tag_map_id'=>'0'
            )
        );

        $tagDisplayer = new TagDisplayer();

        $expectedTableRow = "<tr><td>1</td><td>single tag</td>".
            "<td><div class='form-check'>" .
            "<input class='form-check-input' type='checkbox' value='' id='defaultCheck1' checked>" .
            "</div></td></tr>";
        $actualResult = $tagDisplayer->prepareTagsForDisplay($tagArray);
        $this->assertContains($expectedTableRow, $actualResult);
    }

    public function test_TagWithIgnoreIsUnChecked() {
        $tagArray = array(
            array(
                'tag_id'=>1,
                'tag_name'=>'single tag',
                'tag_map_id'=>'1'
            ),
            array(
                'tag_id'=>12324536,
                'tag_name'=>'again',
                'tag_map_id'=>'0'
            )
        );

        $tagDisplayer = new TagDisplayer();

        $expectedTableRow = "<tr><td>12324536</td><td>again</td>".
            "<td><div class='form-check'>" .
            "<input class='form-check-input' type='checkbox' value='' id='defaultCheck1' >" .
            "</div></td></tr>";
        $actualResult = $tagDisplayer->prepareTagsForDisplay($tagArray);
        $this->assertContains($expectedTableRow, $actualResult);
    }

}