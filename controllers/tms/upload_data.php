<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of upload_data
 *
 * @author anup
 */
class upload_data extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    /*
     * day
     * month
     * year
     * 
     */

    public function track() {
        $filter = array(
            'month' => date('m'),
            'month_in_words' => strtoupper(date('M')),
            'year' => date('Y'),
            'day' => date('d'));
        if (!isset($_REQUEST['hour'])) {
            $filter['time'] = date('H');
        } else {
            $filter['time'] = $_REQUEST['hour'];
        }

        $this->load->model('upload_data/m_upload_data');
        $clients = $this->m_upload_data->getClientNotUploadedData($filter);
//        echo $this->db->last_query();
//        $this->util_model->printr($filter);
//        $this->util_model->printr($clients);
//         die();
        log_message('info', " Mail Process started : " . date(DB_DTF) . " : " . count($clients) . " client records found \n");
//        $this->util_model->printr($clients);
        $this->load->model('tms/sms_mail');
        foreach ($clients as $eachClient) {
            echo "<br>Notification process started for {$eachClient['client_name']}";
            if ($eachClient['emails'] != '') {
                $mail_data = array(
                    'to' => $eachClient['emails'],
                    'cc' => CC_MAILS,
                    'mail_from' => NOTIFY_EMAIL,
                    'subject' => $this->filter_variable($eachClient['subject'], $eachClient),
                    'message' => $this->filter_variable($eachClient['mailBody'], $eachClient)
                );
                $this->sms_mail->sendHtmlEmail($mail_data);
                echo "<br>Mailed sent to {$eachClient['client_name']} at {$eachClient['emails']}";
            } else {
                log_message('info', 'No email found for client' . $eachClient['client_name']);
            }

            if ($eachClient['mobiles'] != '') {
                $mail_data = array(
                    'mobiles' => $eachClient['mobiles'],
                    'msg' => $this->filter_variable($eachClient['messageBody'], $eachClient),
                    'client_id' => $eachClient['client_id']
                );
                $this->sms_mail->doSMS($mail_data, 1);
            } else {
                log_message('info', 'No Mobile found for client' . $eachClient['client_name']);
            }
        }
    }

    public function filter_variable($string, $each_client) {
        $string = str_replace("{{MONTH}}", date('m'), $string);
        $string = str_replace("{{YEAR}}", date('m'), $string);
        $string = str_replace("{{CLIENT_NAME}}", $each_client['client_name'], $string);
        return $string;
    }

}
