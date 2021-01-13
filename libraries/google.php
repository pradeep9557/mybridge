<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of google
 *
 * @author anup
 */
class google {

    private $GoogleClient;

    //put your code here
    public function __construct() {
        // initialise the reference to the codeigniter instance
        require_once APPPATH . 'libraries/vendor/autoload.php';
        $this->GoogleClient = new Google_Client();
        $this->GoogleClient->setApplicationName("My Project");
        $this->GoogleClient->setDeveloperKey("AIzaSyAkNOAz6crQY0NuuqYXS2gZejlimFdhdK4");

        //AIzaSyAkNOAz6crQY0NuuqYXS2gZejlimFdhdK4
    }

    public function getGmailObj() {
        // We only need permissions to compose and send emails
        $this->GoogleClient->addScope("https://www.googleapis.com/auth/gmail.compose");
        return new Google_Service_Gmail($this->GoogleClient);
    }

}
