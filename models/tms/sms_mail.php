<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sms_mail
 *
 * @author anup
 */
class sms_mail extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function sendHtmlEmail($mail_data) {
//        $this->load->model("branch/m_settings");
//        $branchSettings = $this->m_settings->getBranchSettings($this->util_model->get_bid());
//        $this->util_model->printr($mail_data['attach_file']);
//        die();
        $this->load->library('email');

//        if (isset($branchSettings['smtp_host']) && $branchSettings['smtp_host'] != '') {
//            $config['smtp_host'] = $branchSettings['smtp_host'];
//        }
//
//        if (isset($branchSettings['smtp_username']) && $branchSettings['smtp_username'] != '') {
//            $config['smtp_user'] = $branchSettings['smtp_username'];
//        }
//
//        if (isset($branchSettings['smtp_pass']) && $branchSettings['smtp_pass'] != '') {
//            $config['smtp_pass'] = $branchSettings['smtp_pass'];
//        }
//
//        if (isset($branchSettings['smtp_port']) && $branchSettings['smtp_port'] != '') {
//            $config['smtp_port'] = $branchSettings['smtp_port'];
//        }
//        if (isset($config['smtp_host']) && $config['smtp_host'] != '') {
//            $config['protocol'] = 'sendmail';
//            $config['mailpath'] = '/usr/sbin/sendmail';
//        }
        $config['charset'] = 'UTF-8';
        $config['dsn'] = TRUE;
        $config['wordwrap'] = TRUE;
        $config['validate'] = TRUE;
        $config['mailtype'] = "html";
        $this->email->initialize($config);
        $this->email->from($mail_data['mail_from'], EMAIL_FROM);
        $this->email->to($mail_data['to']);
        if(isset($mail_data['cc']) && $mail_data['cc']!=''){
            $this->email->cc($mail_data['cc']);
        }
        if(isset($mail_data['attach_file']) && $mail_data['attach_file']!=''){
            foreach ($mail_data['attach_file'] as $key => $value) {
                  $this->email->attach(SITE_ROOT_PATH . "/$value");
            }
        }
        
        $this->email->subject($mail_data['subject']);
        $this->email->message($mail_data['message']);
        return $this->email->send();
    }

    function doSMS($filter,$log=0) {
        $msg = urlencode($filter['msg']);
        $sender_id = "BMYLYL";
        $msg_type = 1;
        $route = 3;
        $mobiles = $filter['mobiles'];
        //$mobiles, $msg, $sender_id = "BMLTMG", $msg_type = 1,$route=1
        $token = "008cd82ed71d52e4c56c5bdc2314485b";
        $http_url = "http://tgs4sms.bigtgs.in/httpapi/httpapi?token=$token&sender=$sender_id&number=$mobiles&route=$route&type=$msg_type&sms=$msg";
        $ch = curl_init($http_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $curl_scraped_page = curl_exec($ch);
        curl_close($ch);
        $msg_id = trim($curl_scraped_page);
        if (is_int($msg_id)) {
            $sql = "INSERT INTO `nexgen_sms_tracker`(`msg_id`, `msg`,`client_id`) VALUES ($msg_id,'" . urldecode($msg) . "',{$filter['client_id']})";
            $this->db->query($sql);
            log_message('info', '\n Message send on '.$mobiles);
        } else {
           $mail_data = array(
               'to'=>DEV_MAILS,
               'mail_from'=>NOTIFY_EMAIL,
               'subject'=>'SMS send error',
               'message'=>$msg_id
           );
           $this->sendHtmlEmail($mail_data);
           log_message('info', "\n error while sending message with mail data ".  print_r($mail_data,TRUE). "\n URL ".$http_url);
        }
        //$db = Zend_Db_Table_Abstract::getDefaultAdapter();
        //$db->query($sql);
        //echo $curl_scraped_page;
    }

}
