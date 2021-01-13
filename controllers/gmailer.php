<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gmailer
 *
 * @author anup
 */
class gmailer extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->library('google');
        $this->util_model->printr($this->google); 
        $ser = $this->google->getGmailObj();
//        $message_object = new Google_Service_Gmail_Message();
        $encoded_message = rtrim(strtr(base64_encode("this is my message"), '+/', '-_'), '=');
        $ser->setRaw($encoded_message);
        try {
            $msg = $ser->createMessage("anup@nexgi.com");
            $ser->users_messages->send("me", $msg);
        } catch (Exception $e) {
            print 'An error occurred: ' . $e->getMessage();
        }
    }

}
