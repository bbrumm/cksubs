<?php
require_once("src/model/SubscriberPerson.php");

class SubscriberPersonTest extends \PHPUnit\Framework\TestCase
{
    const INVALID_ARGUMENT_EXCEPTION = "InvalidArgumentException";

    public function setUp() {

    }

    public function test_SubscriberID_Valid() {
        $subscriberID = 1000;
        $subscriberPerson = new SubscriberPerson();

        $subscriberPerson->setSubscriberID($subscriberID);
        $expected = 1000;
        $actual = $subscriberPerson->getSubscriberID();

        $this->assertEquals($expected, $actual);
    }

    public function test_SubscriberID_InValid() {
        $this->expectException(self::INVALID_ARGUMENT_EXCEPTION);
        $subscriberID = "xyz some text";
        $subscriberPerson = new SubscriberPerson();

        $subscriberPerson->setSubscriberID($subscriberID);
    }

    public function test_EmailAddress_Provided() {
        $emailAddress = "ben@test.com";
        $subscriberPerson = new SubscriberPerson();

        $subscriberPerson->setEmailAddress($emailAddress);
        $expected = "ben@test.com";
        $actual = $subscriberPerson->getEmailAddress();

        $this->assertEquals($expected, $actual);
    }

    public function test_EmailAddress_Missing() {
        $this->expectException(self::INVALID_ARGUMENT_EXCEPTION);
        $subscriberID = "";
        $subscriberPerson = new SubscriberPerson();

        $subscriberPerson->setEmailAddress($subscriberID);
    }

    public function test_EmailAddress_Null() {
        $this->expectException(self::INVALID_ARGUMENT_EXCEPTION);
        $subscriberID = null;
        $subscriberPerson = new SubscriberPerson();

        $subscriberPerson->setEmailAddress($subscriberID);
    }


}