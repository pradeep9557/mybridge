<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of google_drive
 *
 * @author Nexgen
 */
class google_drive extends CI_Controller {
    //put your code here
    
    public function __construct() {
        parent::__construct();
    
        
        
        
        
    }
    
    public function index() {
       // echo "load";
//       $this->load->library("Curl");
//       $cont= $this;
//        $this->load->library("vendor/google/apiclient/examples/simplefileupload");
        $this->load->library("vendor/google/apiclient/examples/quickstart");
       // $this->load->library("vendor/google/apiclient/examples/service_auth");
        //$this->load->library("vendor/google/apiclient/examples/samplefileupload2");
    }
    
    
}
