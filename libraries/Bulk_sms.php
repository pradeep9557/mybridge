<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Bulk_sms
 *
 * @author anup
 */
class Bulk_sms {

    //put your code here
    public function __construct() {
        
    }

    /*
     * config
     */

    function send_sms($mobiles, $msg, $temp, $user_id = "20046", $password = "rituraj", $sender_id = "LBSEDU", $msg_type = 0) {

        $msg = urlencode(sprintf($this->templates[$temp], $msg));
        $url = "http://bulksmsindia.mobi/sendurlcomma.aspx?user=$user_id&pwd=$password&senderid=$sender_id&mobileno=$mobiles&msgtext=$msg&smstype=$msg_type";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $curl_scraped_page = curl_exec($ch);
        curl_close($ch);
        //echo $curl_scraped_page;
    }

    function insert_sms_log($data) {
        if (isset($data['add_numbers'])) {
            $add_numbers = explode(",", $data['add_numbers']);
        }

        if ($data['sms'] == "" || $data['template'] == "") {
            return array("succ" => FALSE, "_err_msg" => "SMS is required, cannot be blank !!");
        }

        $sql = "insert into lbs_sms_mst (sms_message,send_by,remarks,temp_used) values('{$data['sms']}','{$_SESSION['User_ID']}','{$data['remarks']}','{$data['template']}')";
        if (!mysql_query($sql, $con)) {
            mysql_query("ROLLBACK", $con);
            return array("succ" => FALSE, "_err_msg" => "error while SMS log creation !!");
        }
        $sms_id = mysql_insert_id($con);
        $mobile_nos = array();
        $sql1 = "insert into lbs_sms_sending_records (sms_id,EnrollNo,MobileNo) values";
        if (isset($data['send'])) {
            foreach ($data['send'] as $EnrollNo => $MobileNo) {
                $sql1.=" ($sms_id,'$EnrollNo','$MobileNo'),";
                $mobile_nos[] = $MobileNo;
            }
        }

        if (!empty($add_numbers) && $add_numbers[0] != "") {
            foreach ($add_numbers as $index => $MobileNo) {
                $sql1.=" ($sms_id,NULL,'$MobileNo'),";
                $mobile_nos[] = $MobileNo;
            }
        }

        // to insert int sms recoreds
        $sql1 = substr($sql1, 0, -1);

        if (!mysql_query($sql1, $con)) {

            return array("succ" => FALSE, "_err_msg" => "error while SMS record creation creation !!");
        }


        $all_mobiles = implode(",", $mobile_nos);
        return array("succ" => TRUE, "_err_msg" => $this->send_sms($all_mobiles, $data['sms'], $data['template']));
    }

}
