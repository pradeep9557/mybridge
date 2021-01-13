<?php

class messages {

    private $msg = array();

    public function __construct() {
        //dailyt task entry
        $this->msg["daily_task"] = array("msg" => "Sorry,there is no client.");

        //dailyt task entry
        //default Msg
        $this->msg['defalut'] = array("msg" => "Sorry cant Process.");
        //default Msg
    }

    public function getMessage($key) {

        if (isset($this->msg[$key]))
            return $this->msg[$key];
        return $this->msg['default'];
    }

}
