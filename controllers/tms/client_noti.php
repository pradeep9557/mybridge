<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of client_noti
 *
 * @author anup
 */
class client_noti extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('tms/m_client_noti', 'm_noti');
    }

    public function index() {
        global $data;

        $user_data = $this->input->post();
        $client_id = $this->input->get();

        if (!empty($user_data)) {



            $user_data['Add_DateTime'] = date(DB_DTF);
            $user_data['Add_User'] = $this->util_model->get_uid();

            // $datalist=array();

            $datalist = array(
                "noti_mst_id" => isset($user_data['noti_mst_id']) ? $user_data['noti_mst_id'] : '',
                "client_id" => $user_data['client_id'],
                "day" => $user_data['day'],
                "time" => $user_data['time'],
                "emails" => $user_data['emails'],
                "mobiles" => $user_data['mobiles'],
                "subject" => $user_data['subject'],
                "mailBody" => $user_data['mailBody'],
                "messageBody" => $user_data['messageBody'],
                "status" => $user_data['status'],
                "Add_DateTime" => $user_data['Add_DateTime'],
                "Add_User" => $user_data['Add_User'],
                'custom_months'=>  isset($user_data['custom_months'])?implode(",", $user_data['custom_months']):'',
                'monthly'=>   $user_data['monthly'],
                'state_id'=>$user_data['state_id']
            );
            
            if (isset($user_data['noti_mst_id']) && $user_data['noti_mst_id'] != '') {
                $this->m_noti->update_client_noti($datalist, $user_data['noti_mst_id']);
            } else {
                $this->m_noti->save_client_noti($datalist);
            }
        }
        $data['month_list'] = $this->m_noti->get_month_list();
        $this->load->model('tms/m_manage_users');
        if (isset($client_id['client_id']) && $client_id['client_id'] != '') {
            $data['client_states'] = $this->m_noti->get_client_state_list($client_id['client_id']);        
            $data['client_noti'] = $this->m_noti->get_client_noti($client_id);
        }
        if (isset($client_id['id']) && $client_id['id'] != '') {
            $data['client_noti_by_id'] = $this->m_noti->get_client_noti_by_id($client_id);
        }
         
        $data['client_list'] = $this->m_manage_users->get_all_clients();
       
        $data['day'] = $this->util_model->day();
        $data['time'] = $this->util_model->time();
        $this->load->view('templates/header.php', $data);
        $this->load->view("tms/client_noti/index", $data);
        $this->load->view('templates/footer.php', $data);
    }

    public function get_client_task() {
        global $data;
        $formdata = $this->input->post();
        $client_id = $this->input->get();
        if (!empty($formdata)) {
            $formdata['Add_DateTime'] = date(DB_DTF);
            $formdata['Add_User'] = $this->util_model->get_uid();
            $datalist = array();
            foreach ($formdata['ttm_id'] as $value) {
                $datalist[] = array(
                    "client_id" => $formdata['client_id'],
                    "ttm_id" => $value,
                    "status" => 1,
                );
            }
            $this->m_noti->save_client_task($datalist, $formdata['client_id']);
        }
        $this->load->model('tms/m_manage_users');
        $data['client_list'] = $this->m_manage_users->get_all_clients();
        if (isset($client_id['client_id']) && $client_id['client_id'] != '') {
            $data['task_list'] = $this->m_noti->get_task($client_id['client_id']);
        }

        $data['client_progress_status'] = $this->m_noti->get_client_progress_status();
        
        $this->load->view('templates/header.php', $data);
        $this->load->view("tms/client_noti/assign_task_type",$data);
        $this->load->view('templates/footer.php', $data);
    }
    public function get_client_state() {
        global $data;
        $formdata = $this->input->post();
        $client_id = $this->input->get();
        if (!empty($formdata)) {
            $formdata['Add_DateTime'] = date(DB_DTF);
            $formdata['Add_User'] = $this->util_model->get_uid();
            $datalist = array();
            foreach ($formdata['state_id'] as $value) {
                $datalist[] = array(
                    "client_id" => $formdata['client_id'],
                    "state_id" => $value,
                    "status" => 1,
                );
            }
            $this->m_noti->save_client_state($datalist, $formdata['client_id']);
        }
        $this->load->model('tms/m_manage_users');
        $data['client_list'] = $this->m_manage_users->get_all_clients();
        if (isset($client_id['client_id']) && $client_id['client_id'] != '') {
            $data['state_list'] = $this->m_noti->get_client_state($client_id['client_id']);
        }

        $data['client_progress_status'] = $this->m_noti->get_client_progress_status();
        
        $this->load->view('templates/header.php', $data);
        $this->load->view("tms/client_noti/get_client_state",$data);
        $this->load->view('templates/footer.php', $data);
    }

    public function intraction() {
        global $data;
        $user_data = $this->input->post();
        if (!empty($user_data)) {
            if (isset($user_data['_action']) && $user_data['_action'] == 'notify_action') {
                $this->notify_action();
            }
        }
        $this->load->model('tms/m_manage_users');
        $data['client_list'] = $this->m_manage_users->get_all_clients(array('min_one_task' => 1));
        $data['client_progress_status'] = $this->m_noti->get_client_progress_status();
//        $this->util_model->printr($data['client_progress_status']);
        $this->load->view('templates/header.php', $data);
        $this->load->view("tms/client_noti/manage_client_task",$data);
        $this->load->view('templates/footer.php', $data);
    }

    public function notify_action() {
        $form_data = $this->input->post();
        try {
            if(!isset($form_data['notify_to']) && $form_data['notify_to']!=''){
                throw new Exception('please select client id first');
            }
            if(!isset($form_data['p_id']) && $form_data['p_id']!='0'){
                throw new Exception('please select status of task');
            }
            if(!isset($form_data['tm_id'])  && $form_data['tm_id']!='' && $form_data['tm_id']!='0'){
                throw new Exception('No task has been selected !');
            }
            
            $this->m_noti->update_task_status($form_data['tm_id'],$form_data['p_id']);

            $this->load->model('tms/sms_mail');
            $client_noti_level = $this->m_noti->get_client_noti_by_id(array('id'=>$form_data['notify_to']));
//            $this->util_model->printr($form_data);
//            $this->util_model->printr($client_noti_level);
            if (1) {
//                echo "<br>Notification process started for {$client_noti_level['client_name']}";
                if (isset($form_data['notify_email']) && $client_noti_level['emails'] != '') {
                    $mail_data = array(
                        'to' => $client_noti_level['emails'],
                        'cc' => CC_MAILS,
                        'mail_from' => NOTIFY_EMAIL,
                        'subject' => $this->filter_variable($form_data['email_subject'], $client_noti_level),
                        'message' => $this->filter_variable($form_data['email_body'], $client_noti_level)
                    );
//                    $this->util_model->printr($mail_data);
                    $this->sms_mail->sendHtmlEmail($mail_data);
                } else {
                    log_message('info', 'No email found for client' . $client_noti_level['client_name']);
                }

                if (isset($form_data['notify_sms']) && $client_noti_level['mobiles'] != '') {
                    $mail_data = array(
                        'mobiles' => $client_noti_level['mobiles'],
                        'msg' => $this->filter_variable($form_data['sms_body'], $client_noti_level),
                        'client_id' => $client_noti_level['client_id']
                    );
//                    $this->util_model->printr($mail_data);
                    $this->sms_mail->doSMS($mail_data, 1);
                } else {
                    log_message('info', 'No Mobile found for client' . $client_noti_level['client_name']);
                }
            }
            echo json_encode(array('succ' => TRUE, '_err_codes' => 'Client notified successfully !'));
        } catch (Exception $ex) {
            echo json_encode(array('succ' => FALSE, '_err_codes' => $ex->getMessage()));
        }
        die();
    }

    
    
    public function filter_variable($string, $each_client) {
        $string = str_replace("VAR.MONTH", date('m'), $string);
        $string = str_replace("VAR.YEAR", date('m'), $string);
        $string = str_replace("VAR.CLIENT_NAME", $each_client['client_name'], $string);
        return $string;
    }
}
