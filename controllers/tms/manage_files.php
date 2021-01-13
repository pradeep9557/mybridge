<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mange_files
 *
 * @author anup
 */
class manage_files extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('tms/m_files');
        $this->load->model('tms/m_client_noti', 'm_noti');
    }

    public function index() {
        global $data;

        $form_data = $this->input->get();
        if (isset($form_data['action'])) {
//            print_r($form_data);
            if (isset($form_data['action']) && $form_data['action'] == 'get_pending_task') {
                $this->db->select('tm.tm_id, tm.tm_name,ttm.ttm_name')->from(DB_PREFIX . "task_mst tm");
                $this->db->join(DB_PREFIX . "task_type_mst ttm", 'ttm.ttm_id = tm.ttm_id', 'left');
                $this->db->where('client_id', $form_data['client_id']);
                $this->db->where('progress_flag<>' . COMPLETED_APPROVAL, NULL, FALSE);
                echo json_encode(array('succ' => TRUE, 'task_list' => $this->db->get()->result_array()));
                die();
            }

            if (isset($form_data['action']) && $form_data['action'] == 'attach_file_with_task') {
                try {
                    $this->m_files->attach_files_with_task($form_data['tm_id'], $form_data['file_id'], $form_data);
                    $this->m_files->markAsApproved($form_data['file_id']);
                } catch (Exception $ex) {
                    echo json_encode(array('succ' => TRUE, "_err_codes" => $ex->getMessage()));
                } 
                echo json_encode(array('succ' => TRUE, '_err_codes' => 'Files attach successfully !'));

                die();
            } elseif (isset($form_data['show_email']) && $form_data['action'] == 'attach_file_with_notify_task') {
                $this->m_files->attach_files_with_task($form_data['tm_id'], $form_data['file_id']);
                $this->notify_action();
            } elseif ($form_data['action'] == 'notify_task') {
                $this->notify_action();
            }
        }
        $data['status'] = isset($form_data['status']) ? $form_data['status'] : 0;
        $data['sel_month'] = isset($form_data['month']) ? $form_data['month'] : '';
        $data['sel_year'] = isset($form_data['year']) ? $form_data['year'] : '';
        if (count($this->input->post())>0) {
            $form_data = $this->input->post();
            $this->db->select('cf.*,ttm.parent_ttmid,'
                    . 'addedby.Emp_Name as uploaded_by, '
                    . 'client.Emp_Name as client_name,'
                    . 'status_mst.p_name as status_name,'
                    . '(select count(*) from '.DB_PREFIX.'task_mst tm where tm.status=1 and tm.progress_flag<>'.COMPLETED_APPROVAL.' and tm.state_id=cf.state and tm.year=cf.year and tm.month=cf.month and tm.ttm_id = cf.ttm_id and tm.client_id=cf.client_id) as totalTaskMatched,'
                    . 'cs.name as state_name,'
                    . 'ttm.ttm_name')->from(DB_PREFIX . "client_files cf");
            $this->db->join(DB_PREFIX . "cstates cs", 'cs.state_id=cf.state', 'left');
            $this->db->join(DB_PREFIX . "task_type_mst ttm", 'ttm.ttm_id=cf.ttm_id', 'left');

            $this->db->join(DB_PREFIX . "progress_list_mst status_mst", 'status_mst.p_id = cf.status', 'left');
            $this->db->join(DB_PREFIX . "employee client", 'client.Emp_ID = cf.client_id', 'left');
            $this->db->join(DB_PREFIX . "employee addedby", 'addedby.Emp_ID = cf.Add_User', 'left');
            if (isset($form_data['year']) && !empty($form_data['year'])) {
                $this->db->where_in('cf.year', $form_data['year']);
            }
            if (isset($form_data['month']) && !empty($form_data['month'])) {
                $this->db->where_in('cf.month', $form_data['month']);
            }
            if (isset($form_data['ttm_id']) && !empty($form_data['ttm_id'])) {
                $this->db->where_in('ttm_id', $form_data['ttm_id']);
            }
            if (isset($form_data['client_id']) && !empty($form_data['client_id'])) {
                $this->db->where_in('cf.client_id', $form_data['client_id']);
            }
            if (isset($form_data['state_id']) && !empty($form_data['state_id'])) {
                $this->db->where_in('cf.state_id', $form_data['state_id']);
            }

            if (isset($form_data['status']) && !empty($form_data['status'])) {
                $this->db->where_in('cf.status', $form_data['status']);
            }

            $this->db->order_by('Mode_DateTime', 'DESC');
            $data['upload_data'] = $this->db->get()->result();
            $data['client_progress_status'] = $this->m_noti->get_client_progress_status();
            $data['status_list'] = $this->m_noti->get_status_list();
            echo json_encode(array('succ', 'html' => $this->load->view('tms/manage_files/ajax_result', $data, TRUE)));
            die();
        }
        $data['month'] = $this->m_noti->list_month();
        $data['year'] = $this->m_noti->list_year();
        $data['ttm_list'] = $this->m_noti->get_ttm_list();
        $data['state_list'] = $this->m_noti->get_state_list();
        $data['status_list'] = $this->m_noti->get_status_list();
        $this->load->model('tms/m_manage_users');
        $data['client_list'] = $this->m_manage_users->get_all_clients();
        $this->load->view('templates/header.php', $data);
        $this->load->view("tms/manage_files/search_form");
        $this->load->view('templates/footer.php', $data);
    }

    public function notify_action() {
        $form_data = $this->input->get();
        try {
            if (!isset($form_data['notify_to']) && $form_data['notify_to'] != '') {
                throw new Exception('please select client id first');
            }
            if (!isset($form_data['p_id']) && $form_data['p_id'] != '0') {
                throw new Exception('please select status of task');
            }
            if ($form_data['action'] != 'notify_task') {
                if (!isset($form_data['tm_id']) && $form_data['tm_id'] != '' && $form_data['tm_id'] != '0') {
                    throw new Exception('No task has been selected !');
                }

                $this->m_noti->update_task_status($form_data['tm_id'], $form_data['p_id']);
            }



            if (isset($form_data['notify_email'])) {
                if ((isset($form_data['extra_email_to']) && $form_data['extra_email_to'] != '') ||
                        (isset($form_data['extra_email_cc']) && $form_data['extra_email_cc'] != '')) {
                    
                } else {
                    if (!isset($form_data['notify_to'])) {
                        throw new Exception('please select client id first');
                    } else if ($form_data['notify_to'] == '') {
                        throw new Exception('please select client id first');
                    }
                    if (!isset($form_data['p_id']) && $form_data['p_id'] != '0') {
                        throw new Exception('please select status of task');
                    }
                }

                $this->load->model('tms/sms_mail');
                $toEmails = "";
                $taskData = array();
                if (isset($form_data['notify_to'])) {
                    $client_noti_level = $this->m_noti->get_client_noti_by_id(array('id' => $form_data['notify_to']));
                    $toEmails = $client_noti_level['emails'];
                    $taskData['client_name'] = $client_noti_level['client_name'];
                } else if (isset($form_data['task_id']) && $form_data['task_id'] != '') {
                    $client_noti_level = $this->m_noti->get_client_by_task_id($form_data['task_id']);
//                    $this->util_model->printr($client_noti_level);
                    $taskData['client_name'] = $client_noti_level['client_name'];
                }

                if ((isset($form_data['extra_email_to']) && $form_data['extra_email_to'] != '')) {
                    $toEmails = $toEmails == "" ? $form_data['extra_email_to'] : $toEmails . "," . $form_data['extra_email_to'];
                }
                $ccEmails = "";
                if ((isset($form_data['extra_email_cc']) && $form_data['extra_email_cc'] != '')) {
                    $ccEmails = $form_data['extra_email_cc'];
                }

                $mail_data = array(
                    'to' => $toEmails,
                    'cc' => CC_MAILS . ", " . $ccEmails,
                    'mail_from' => NOTIFY_EMAIL,
                    'subject' => $this->filter_variable($form_data['email_subject'], $taskData),
                    'message' => $this->filter_variable($form_data['email_body'], $taskData)
                );
                if (isset($form_data['attach_file'])) {
                    $mail_data['attach_file'] = $form_data['attach_file'];
                }
//                    $this->util_model->printr($mail_data);
                $this->sms_mail->sendHtmlEmail($mail_data);
            }

            if (isset($form_data['notify_sms']) && $client_noti_level['mobiles'] != '') {
                $mail_data = array(
                    'mobiles' => $client_noti_level['mobiles'],
                    'msg' => $this->filter_variable($form_data['sms_body'], $client_noti_level),
                    'client_id' => $client_noti_level['client_id']
                );
//                    $this->util_model->printr($mail_data);
                $this->sms_mail->doSMS($mail_data, 1);
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
