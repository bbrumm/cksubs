<?php

class SubscriberPerson {

    private $subscriberID;
    private $emailAddress;

    public function setSubscriberID($pValue) {
        if(is_numeric($pValue)) {
            $this->subscriberID = $pValue;
        } else {
            throw new InvalidArgumentException();
        }
    }

    public function getSubscriberID() {
        return $this->subscriberID;
    }

    public function setEmailAddress($pValue) {
        if(isset($pValue) && $pValue != "") {
            $this->emailAddress = $pValue;
        } else {
            throw new InvalidArgumentException();
        }
    }

    public function getEmailAddress() {
        return $this->emailAddress;
    }

}