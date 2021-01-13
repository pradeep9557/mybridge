<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mailer
 * @Created on : Sep 16, 2015, 11:45:57 AM
 * @author Dee
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

        $config['send_multipart'] = FALSE;
        $config['protocol'] = 'mail';
        $config['useragent'] = "CodeIgniter";
        $config['charset'] = 'utf-8';
        $config['mailtype'] = 'html';
        $this->email->initialize($config);

        $this->email->set_newline("\r\n");
        $this->email->from("contact@nexibms.com", "NexIbms Team");
        $this->email->to($mailData['to']);
        if (isset($mailData['cc'])) {
            $this->email->cc($mailData['cc']);
        }
        if (isset($mailData['bcc'])) {
            $this->email->bcc($mailData['bcc']);
        }
        $this->email->subject($mailData['subject']);
        $this->email->message($mailData['message']);
        
        $from = isset($mailData['from']) ? $mailData['from'] : "";
        $headers = "From: " . strip_tags($from) . "\r\n";
        $headers .= "Reply-To: " . strip_tags($mailData['from']) . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        if ($this->email->send()) {
            return True;
        } else {
            return False;
        }
    }

    public function send_html($mailData) {
        $config['send_multipart'] = FALSE;
        $config['protocol'] = 'mail';
        $config['useragent'] = "CodeIgniter";
        $config['charset'] = 'utf-8';
        $config['mailtype'] = 'html';
        $config['dns'] = TRUE;
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->from($mailData['from'], isset($mailData['from_name'])?$mailData['from_name']:EMAIL_FROM);
        $this->email->reply_to($mailData['from'], isset($mailData['from_name'])?$mailData['from_name']:EMAIL_FROM);
        $this->email->to($mailData['to']);
        if (isset($mailData['cc'])) {
            $this->email->cc($mailData['cc']);
        }
        if (isset($mailData['bcc'])) {
            $this->email->bcc($mailData['bcc']);
        }
       
        $this->email->subject($mailData['subject']);
        $this->email->message($mailData['message']);

        if ($this->email->send()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function table_data($filter_data) {
        $this->load->library('table');
        $template = array(
            'table_open' => '<table style="width: 100%; max-width: 100%; margin-bottom: 20px; border: 1px solid black; border-spacing: 0; border-collapse: collapse; cellpadding="4"; cellspacing="0";">',
            'thead_open' => '<thead style="border: 1px solid black; font-weight:bold; text-align:center;">',
            'thead_close' => '</thead>',
            'heading_row_start' => '<tr style="border: 1px solid black">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th style="border: 1px solid black; text-align:center;">',
            'heading_cell_end' => '</th>',
            'tbody_open' => '<tbody style="border: 1px solid black">',
            'tbody_close' => '</tbody>',
            'row_start' => '<tr style="border: 1px solid black">',
            'row_end' => '</tr>',
            'cell_start' => '<td style="border: 1px solid black; text-align:center;">',
            'cell_end' => '</td>',
            'row_alt_start' => '<tr>',
            'row_alt_end' => '</tr>',
            'cell_alt_start' => '<td>',
            'cell_alt_end' => '</td>',
            'table_close' => '</table>'
        );

        $this->table->set_template($template);
        $this->table->set_heading($filter_data['heading']);
        $html = $this->table->generate($filter_data['table_data']);
        return $html;
    }

}
