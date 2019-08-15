<?php
require_once("src/SubscriberCollection.php");

class SampleTest extends \PHPUnit\Framework\TestCase
{

    public function setUp() {

    }

    public function testSomething() {

        $this->assertEquals(1, 1);
    }

    public function testAdd() {
        $a = 1;
        $b = 2;
        $subscriberCollection = new SubscriberCollection();

        $expected = 3;
        $actual = $subscriberCollection->add($a, $b);

        $this->assertEquals($expected, $actual);

    }

}