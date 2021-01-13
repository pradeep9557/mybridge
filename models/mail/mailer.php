<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mailer
 * @Created on : Sep 16, 2015, 11:45:57 AM
 * @author Abhinav Chauhan
 * @Team NexGen PHP Development Team
 * @copyright (c) year, NexGen Innovators IT Services Pvt. Ltd.
 * @website http://nexgeninnovators.com
 * @location
 * @uses 
 */
class mailer extends CI_Model {

    // constructor
    public function __construct() {
        // calling to parent constructor
        parent::__construct();
        $this->load->library('email');
    }

    // send mail
    public function send_mail($mailData = array()) {

        $this->email->set_newline("\r\n");
        $this->email->from($mailData['from'], "Contact Message");
        $this->email->to($mailData['to']);
        if (isset($mailData['cc'])) {
            $this->email->cc($mailData['cc']);
        }
        if (isset($mailData['bcc'])) {
            $this->email->bcc($mailData['bcc']);
        }
        $this->email->subject($mailData['subject']);
        $this->email->message($mailData['message']);
        
        $headers = "From: " .strip_tags($mailData['from']) . "\r\n"; // sending server address
        $headers .= "Reply-To: " .strip_tags($mailData['from']) . "\r\n";
        $headers .= "Return-Path: ".strip_tags($mailData['from']). "\r\n";
        $headers .= "Organization: Clinical Records\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
        $headers .= "Content-Transfer-Encoding: binary";
        $headers .= "X-Priority: 3\r\n";
        $headers .= "X-Mailer: PHP". phpversion() ."\r\n";

        if ($this->email->send()) {
            return True;
        } else {
            return False;
        }
        
    }
    
    
}