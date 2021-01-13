<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of followUps
 *
 * @author Anup kumar
 */
class followups extends CI_Controller {

    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->model('enquiry/m_enquiry');
    }

    public function follow_up_list() {
        global $data;

        $data['enq_limit'] = 50;
        $data['todays_follow_up'] = $this->m_enquiry->todays_follow_list(array($data['Session_Data']['IBMS_BRANCHID']));
        //$this->util_model->printr($data['todays_follow_up']);
        $data['latest_enquiry'] = $this->m_enquiry->fresh_enquiry($data['Session_Data']['IBMS_BRANCHID'], $data['enq_limit']);
        $data['last_followed_enquiry'] = $this->m_enquiry->get_lastn_followups(array($data['Session_Data']['IBMS_BRANCHID']));
        //$this->util_model->printr($data['last_followed_enquiry']);
        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/common_window_pop_up.php', $data);
        $this->load->view('Enquiry/followups/v-all-follow_ups.php', $data);
        $this->load->view('templates/footer.php');
    }

    public function index($E_Code = '', $error = '', $_err_codes = '') {
        //provide a view of followups form
        global $data;
        $this->load->helper('array');
        $this->load->model(array('enquiry/m_enquiry', 'super-admin/usertypes_model','branch/branch_model'));
        $data['title_window'] = "Follow Up";
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        $data['branch_setting'] = $this->branch_model->get_branch_setting($data['Session_Data']['IBMS_BRANCHID']);
        if ($E_Code != '') {
            $data['Enq_Details'] = $this->m_enquiry->get_enquiry_via_e_code($data['Session_Data']['IBMS_BRANCHID'], $E_Code);
            $data['Enq_Visit_Details'] = $this->m_enquiry->get_Enq_visit_Details_via_e_code($E_Code);
        }
        $data['ResponseList'] = $this->util_model->get_list('ResponseID', 'ResponseText', DB_PREFIX . 'e_response_mst', $data['Session_Data']['IBMS_BRANCHID'], 'Sort,ResponseText');
        $data['AllUsers'] = $this->usertypes_model->AllUsers($data['Session_Data']['IBMS_BRANCHID']);
        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/common_window_pop_up.php', $data);
        $this->load->view('Enquiry/followups/v-add-followup');
        $this->load->view('templates/footer.php');
    }

    function save_follow_ups() {
        $path = base_url() . "Enquiry/followups/index/";
        $this->load->helper('array');
        $FormData = $this->input->post();
        //die($this->util_model->printr($FormData));
        $E_Code = $FormData['E_Code'];
        $FormData = $this->util_model->add_common_fields($FormData);
        $FormData['NextNotifyDateTime'] = date(DB_DTF, strtotime($FormData['NextNotifyDateTime']));
        $FormData['CallDateTime'] = date(DB_DTF, strtotime($FormData['CallDateTime']));
        $FormData['nofity_next_flag'] = (isset($FormData['nofity_next_flag']));
        $FormData['need_mail_noti_flag'] = (isset($FormData['need_mail_noti_flag']));
        $FormData['need_sms_noti_flag'] = (isset($FormData['need_sms_noti_flag']));
        $follow_data_to_insert = elements(array('E_Code', 'need_mail_noti_flag', 'Visit', 'CallDateTime', 'ResponseID', 'Description', 'nofity_next_flag', 'NextNotifyDateTime', 'NotifyToEmp_ID', 'FollowerID', 'Add_User', 'Add_DateTime', 'Remarks'), $FormData);
        $inserted_follow_up = $this->m_enquiry->save_follow_up($FormData);
        if ($inserted_follow_up['succ']) {
            redirect($path . "$E_Code/0/EnqFollowAddSucc");
        } else {
            redirect($path . "$E_Code/1/EnqFollowAddErr");
        }
    }

    function set_view_notification($FollowID) {
        echo json_encode($this->m_enquiry->set_view_notification($FollowID));
    }

}
