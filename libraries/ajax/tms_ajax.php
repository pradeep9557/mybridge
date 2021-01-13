<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of search
 * @Created on : Sep 16, 2015, 4:22:49 PM
 * @author Anup kumar
 * @Team NexGen PHP Development Team
 * @copyright (c) year, NexGen Innovators IT Services Pvt. Ltd.
 * @website http://nexgeninnovators.com
 * @location
 * @uses 
 */
class tms_ajax {

    // constructor
    private $super_object;

    public function __construct() {
        // calling to parent constructor
        $this->super_object = & get_instance();
    }

    // start you function from here
    public function task_search($filter = array()) {
        global $data;
        $filter['does_repeat'] = isset($filter['does_repeat']) ? $filter['does_repeat'] : 2;
        $data['filters'] = $filter;
        if (isset($filter['collapse'])) {
            $data['collapse'] = 1; // it will close the search
        }
        
        if(isset($filter['task_period_id'])){
            $data['task_period_id'] = $filter['task_period_id'];
        }
        
        $data = array_merge($data,$_GET);
        
        $this->super_object->load->model("util_model");
        $this->super_object->load->model("tms/m_daily_task", 'daily_task');
        $this->super_object->load->model("tms/m_task_billing");
        $this->super_object->load->model("tms/m_task_manage", 'm_task');
        $data['list_month'] = $this->super_object->m_task->list_month();
        $data['list_year'] = $this->super_object->m_task->list_year();
        $data['list_state'] = $this->super_object->m_task->list_state();
        $data['no_of_subTask'] = $this->super_object->m_task->get_pending_task_no_list();
        $data['client_list'] = $this->super_object->m_task->get_client_list($filter);
        
        $data['billing_account_list'] = array("0" => "Select Billing From") + $this->super_object->m_task_billing->get_from_list();
        $data['users_list'] = array("0" => "Select User") + $this->super_object->m_task->get_lowest_level_users();

        $data['work_type_list'] = $this->super_object->daily_task->get_all_progress_status();
        $this->super_object->load->model("tms/m_manage_sub_task", 'm_sub_task');
        $data['task_type_list'] = array("0" => "Select Task Type") + $this->super_object->m_sub_task->get_ttm_list("ttm_id", "ttm_name", DB_PREFIX . "task_type_mst", 0, "ttm_name", TRUE, 1);
         $this->super_object->load->model('tms/m_client_noti', 'm_noti');
             $data['client_progress_status'] = $this->super_object->m_noti->get_client_progress_status();
//        $this->super_object->util_model->printr($data['task_type_list']);
        $this->super_object->load->model('tms/m_term');
        $data['period_list']  = $this->super_object->m_term->getTaskPeriod();     
        return $this->super_object->load->view('tms/common/get_task_ajax/search_form.php', $data, true);
    }

    public function sub_task_search() {
        global $data;
        $this->super_object->load->model("util_model");
        if (isset($data['active_tab']) && $data['active_tab'] == "pending_sub_task") {
            $data['formdata'] = array("progress_flag" => -1, "sort_by" => 4, "filter_by" => 1);
        } else if (isset($data['active_tab']) && $data['active_tab'] == "upcoming_sub_task") {
            $data['formdata'] = array("filter_by" => 2, "sort_by" => 4, "progress_flag" => -1);
        }
        
        $data['formdata']['progress_flag'] = $this->super_object->input->get('progress_flag');
        $data['formdata']['filter_by'] = $this->super_object->input->get('filter_by');
        
        //die($this->super_object->util_model->printr($data));
        $this->super_object->load->model("tms/m_task_manage", 'm_task');
        $this->super_object->load->model("tms/m_manage_sub_task", 'm_sub_task');
        $data['task_list'] = array("0" => "Select a Task") + $this->super_object->m_sub_task->task_name_of_sub_tasks();
        $data['client_list'] = $this->super_object->m_task->getClientByUserType();
        $data['locality'] = array("0" => "Select Locality") + $this->super_object->util_model->get_list("localityid", "locality", DB_PREFIX . "locality", 0, "locality", TRUE, 1);
        $data['incharge'] = array("0" => "Select Incharge") + $this->super_object->util_model->get_list("Emp_ID", "Emp_Name", DB_PREFIX . "employee", 0, "Emp_Name", TRUE, 1, " UTID not in(9,14)");
        $data['work_type_list'] = array("0" => "Select Progress Status", "2" => "In Progress", "3" => "Completed Approval Pending","4"=>"Completed Approved","-1"=>"Not Completed");
        $data['users_list'] = array("0" => "Select User") + $this->super_object->m_task->get_lowest_level_users();
        $data['sub_task_type_list'] = array("0" => "Select Sub Task Type") + $this->super_object->util_model->get_list("ttstm_id", "ttstm_name", DB_PREFIX . "task_type_sub_task_mst", 0, "ttstm_name", TRUE, 1);
        $data['ttm_list'] = array("0" => "Select Task Type") + $this->super_object->m_sub_task->get_ttm_list("ttm_id", "ttm_name", DB_PREFIX . "task_type_mst", 0, "ttm_name", TRUE, 1);
//        $this->super_object->util_model->printr($data['ttm_list']);
        return $this->super_object->load->view('tms/common/get_sub_task_ajax/search_form.php', $data, true);
    }

    public function client_search() {
        global $data;

        $data['ASC'] = "DESC";
        //$this->super_object->load->model("util_model");
//        $data['client_list'] = array("0" => "Select Client") +  $this->super_object->util_model->get_list("Emp_ID", "Emp_Name", DB_PREFIX . "employee", "", $sort_col = 'Emp_Name', $for_selection = TRUE, $status = 1, $whr = " UTID in(9,14)");
        $this->super_object->load->model("tms/m_manage_users", 'm_task');
        $data['user_types'] = $this->super_object->util_model->get_list("UTID", "UserTypeName", DB_PREFIX . "usertypes", 0, "UserTypeName", TRUE, 1, " UserTypeGroup=2");
//        $data['usertype_list'] = $this->super_object->m_users->get_usertype();
        return $this->super_object->load->view('tms/common/get_client_ajax/search_form.php', $data, true);
    }

    public function bill_search() {
        global $data;
        $this->super_object->load->model("util_model");
        $this->super_object->load->model("tms/m_task_manage", 'm_task');
        $this->super_object->load->model("tms/m_task_billing", 'm_bill');
        $data['account_list'] = $this->super_object->m_bill->getAccount(); 
        $data['client_list'] = $this->super_object->m_task->get_client_list(array("progress_flag" => COMPLETED_APPROVAL));
    
        $data['btypelist'] = $this->super_object->m_bill->getbilltype();
        return $this->super_object->load->view('tms/common/get_bill_ajax/search_form.php', $data, true);
    }

    public function get_ser_list() {
        $query = $this->super_object->db->select()->from(DB_PREFIX . "biling_services_mst")->order_by("serCatCode");
        $this->super_object->db->where("status", 1);
        $this->super_object->db->group_by("serCatCode");
        $result = $query->get()->result();
//        $this->super_object->util_model->printr($result);
        $return_list = array();
        foreach ($result as $value) {
            $return_list[$value->serCatCode] = $value->serCatName;
        }
        return $return_list;
    }

    public function daily_task_search() {
        global $data; 
        $data['ASC'] = "DESC";
        if(!isset($data['selUser']))
        $data['selUser'] = $this->super_object->util_model->get_uid();
        $this->super_object->load->model("tms/m_daily_task", 'daily_task');
        $data['approved_flags']  = $this->super_object->daily_task->get_progress_flag();
        $this->super_object->load->model("tms/m_manage_sub_task", 'm_sub_task');
        $data['sub_task_type_list'] = array("0" => "Sub Task list") + $this->super_object->m_sub_task->getSubTaskListForSelect("ttstm_id", "ttstm_name", DB_PREFIX . "task_type_sub_task_mst", 0, "ttstm_name", TRUE, 1);
        $data['task_search_for'] = "Daily Task Entry";
        $this->super_object->load->model("tms/m_task_manage", 'm_task');
        $data['users_list'] = array("0" => "Select Users") + $this->super_object->util_model->get_list("Emp_ID", "Emp_Name", DB_PREFIX . "employee", 0, "Emp_Name", TRUE, 1, " UTID not in(9,14)");
        
//        $data['client_list'] = $this->super_object->m_task->get_client_list();
        $data['incharge'] = array("0" => "Select Incharge") + $this->super_object->util_model->get_list("Emp_ID", "Emp_Name", DB_PREFIX . "employee", 0, "Emp_Name", TRUE, 1, " UTID not in(9,14)");
        return $this->super_object->load->view('tms/common/daily_task_ajax/search_form.php', $data, true);
    }

}
