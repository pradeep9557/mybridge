<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of manage_users
 * @Created on : 26 May, 2016, 10:39:52 AM
 * @author Deepak Singh
 * @Team NexGen PHP Development Team
 * @copyright (c) year, NexGen Innovators IT Services Pvt. Ltd.
 * @website http://nexgeninnovators.com
 * @location
 * @Use
 * 
 */
class manage_users extends CI_Controller {

    // constructor
    public function __construct() {
        // calling to parent constructorfr
        parent::__construct();
        $this->load->model('tms/m_manage_users', 'm_users');
    }

    // start you function from here
    public function index($error = '', $_err_codes = '',$type='') { //provide a view of new Employee form
         if(!isset($_POST['type'])){
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        // to get all list 
//         $this->util_model->printr($data);
//         die();
        $this->load->model("tms/m_task_manage", 'm_task');
        $data['user_types'] = $this->m_task->get_lowest_level_usertype(array("userGroup" => "(1)"));
        //$data['Designation'] = $this->util_model->get_list("DID", "Code", DB_PREFIX . "designation");
        //$data['nationality_list'] = $this->util_model->get_list("NID", "Code", DB_PREFIX . "nationality", $data['Session_Data']['IBMS_BRANCHID']);
        //To list all the nationality from the database 
        //$data['all_branches'] = $this->util_model->branch_list_with_branch_Cat($data['Session_Data']);
        //$data['days_list'] = $this->util_model->days_list();
        if (!file_exists(APPPATH . '/views/tms/manage_users/v_add_users.php')) {
            show_404();
        }
        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/common_window_pop_up.php');
        $this->load->view('tms/manage_users/v_add_users.php', $data);
        $this->load->view('templates/footer.php');
         }else if(isset($_POST['type']) && $_POST['type']=='ajax'){
        
            $form_data = $this->input->post();
      
//        die($this->util_model->printr($form_data));
        $form_data['page'] = $data['s_no'] = $form_data['page'] * $form_data['limit'];
//         $form_data['page'] = $data['s_no'];
        $data['all_emp_details'] = $this->m_users->getEmplist($form_data);
        $data['addr'] = "User_Edit";
        echo json_encode(array("succ" => TRUE, "html" => $this->load->view('tms/manage_users/v_ajax_user_list.php', $data, TRUE)));
        }
        else if(isset($_POST['type']) && $_POST['type']=='deactive'){
         if($this->m_users->deactiveuser($_POST)){
             echo json_encode(array("succ"=>TRUE));
         }else{
            echo json_encode(array("succ"=>FALSE)); 
         }
      
        }
    }

    public function add_clients($error = '', $_err_codes = '') { //provide a view of new Employee form
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);

        $this->load->library("ajax/tms_ajax.php");
        $data['search_for'] = "Clients";
        $data['client_search_view'] = $this->tms_ajax->client_search();
//         $this->util_model->printr($data);
//         die();
        $data['user_types'] = $this->util_model->get_list("UTID", "UserTypeName", DB_PREFIX . "usertypes", 0, "UserTypeName", TRUE, 1, " UserTypeGroup=2");
//        unset($data['user_types'][1]);
//        $data['nationality_list'] = $this->util_model->get_list("NID", "Code", DB_PREFIX . "nationality", $data['Session_Data']['IBMS_BRANCHID']);
//      To list all the nationality from the database 
//        $data['all_branches'] = $this->util_model->branch_list_with_branch_Cat($data['Session_Data']);
//      $data['days_list'] = $this->util_model->days_list();
        if (!file_exists(APPPATH . '/views/tms/manage_users/v_add_clients.php')) {
            show_404();
        }
        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/common_window_pop_up.php');
        $this->load->view('tms/manage_users/v_add_clients.php', $data);
        $this->load->view('templates/footer.php');
    }

    function All_users_List($caller = "") {
    
        global $data;
        if ($caller != "" && $caller != USER) {
            $data['all_emp_details'] = $this->m_users->get_emp_details_from_database('', '', '', " ut.UserTypeGroup = 2");
            $data['addr'] = "Client_Edit";
        } else {
            $data['all_emp_details'] = $this->m_users->get_emp_details_from_database('', '', '', " ut.UserTypeGroup = 1");
            $data['addr'] = "User_Edit";
        }
        if (!file_exists(APPPATH . '/views/tms/manage_users/v_add_users.php')) {
            show_404();
        }
        $data['title'] = ucfirst("All Employee List | " . SITE_NAME); //capitalizing the first character of string for header.
        $data['caller'] = $caller;
        $this->load->view('tms/manage_users/v_all_user.php', $data);
       
    }

    function User_Edit($UserID, $error = '', $_err_codes = '') { //provide a view of new Employee form
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        $data['user_types'] = $this->util_model->get_list("UTID", "UserTypeName", DB_PREFIX . "usertypes");
        unset($data['user_types'][10]);
        $data['Designation'] = $this->util_model->get_list("DID", "Code", DB_PREFIX . "designation");
        $data['nationality_list'] = $this->util_model->get_list("NID", "Code", DB_PREFIX . "nationality", $data['Session_Data']['IBMS_BRANCHID']);
        //To list all the nationality from the database 
        $data['all_branches'] = $this->util_model->branch_list_with_branch_Cat($data['Session_Data']);
        $data['days_list'] = $this->util_model->days_list();
//        $data['Emp_Code'] = strtoupper($Emp_Code);
//die($this->util_model->printr($UserName));
        $data['employee_data'] = $this->m_users->get_emp_details_from_database($UserID);
//        $this->util_model->printr($data['employee_data']);
        $data['Emp_ID'] = $UserID;
        // die($this->util_model->printr($data['Emp_ID']));
        if (!file_exists(APPPATH . '/views/tms/manage_users/v_edit_users.php')) {
            show_404();
        }
        $data['title'] = ucfirst("Edit User | " . SITE_NAME); //capitalizing the first character of string for header.
        $this->load->view('templates/header.php', $data);
        $this->load->view('tms/manage_users/v_edit_users.php', $data);
        $this->load->view('templates/footer.php');
    }

    function Client_Edit($Emp_ID, $error = '', $_err_codes = '') { //provide a view of new Employee form
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        $data['user_types'] = $this->util_model->get_list("UTID", "UserTypeName", DB_PREFIX . "usertypes");
        unset($data['user_types'][10]);
        $data['nationality_list'] = $this->util_model->get_list("NID", "Code", DB_PREFIX . "nationality", $data['Session_Data']['IBMS_BRANCHID']);
        //To list all the nationality from the database 
        $data['all_branches'] = $this->util_model->branch_list_with_branch_Cat($data['Session_Data']);
        $data['days_list'] = $this->util_model->days_list();
//        $data['Emp_Code'] = strtoupper($Emp_Code);

        $data['employee_data'] = $this->m_users->get_emp_details_from_database($Emp_ID);

        if (!file_exists(APPPATH . '/views/tms/manage_users/v_edit_clients.php')) {
            show_404();
        }
        $data['title'] = ucfirst("Edit Client | " . SITE_NAME); //capitalizing the first character of string for header.
        $this->load->view('templates/header.php', $data);
        $this->load->view('tms/manage_users/v_edit_clients.php', $data);
        $this->load->view('templates/footer.php');
    }

    function users_save_update() {
        $this->load->library('encrypt');
        global $data;
        $user_data = $this->input->post();
//        print_r($user_data);
//                die();
//        $user_data['DOB'] = date(DB_DF, strtotime($user_data['DOB']));
        $user_data['DOJ'] = date(DB_DF, time());
        $user_data['BranchID'] = $data['Session_Data']['IBMS_BRANCHID'];
//          die($this->util_model->printr($user_data));
        if (isset($user_data['Add_Employee']) && $user_data['Add_Employee'] == "Create") {


//            $this->util_model->printr($this->input->post());
//            die();
            $user_data['UserName'] = preg_replace('/\s+/', '', $user_data['UserName']);
            $inserted = $this->m_users->user_save_update($user_data);
            if ($inserted['succ'] && !isset($user_data['client_entry'])) {
                if (isset($user_data['send_on_mail']) && $user_data['send_on_mail']) {
                    $pass_encrypt = $this->encrypt->encode($user_data['UserName'] . uniqid());
                    $pass_to_update = array("Emp_Pass" => $pass_encrypt);
                    $pass_plan_text = $this->encrypt->decode($pass_encrypt);
                    $this->m_users->update_emp($user_data['UserName'], $pass_to_update);
                    $this->m_users->pass_on_mail($user_data, $pass_plan_text);
                    redirect(base_url() . "tms/manage_users/index/0/user_CreateSucc");
                } else {
                    $pass_to_update = array("Emp_Pass" => $this->util_model->encrypt_string($user_data['Password']));
                    if ($this->m_users->update_emp($user_data['UserName'], $pass_to_update)) {
                        redirect(base_url() . "tms/manage_users/index/0/user_CreateSucc"); // passing error alert 0 means no error, 1 means Error
                    } else {
                        redirect(base_url() . "tms/manage_users/index/1/{$inserted['_err_codes']}"); // passing error alert 0 means no error, 1 means Error
                    }
                }
            } else {
                if (!isset($user_data['client_entry'])) {
                    redirect(base_url() . "tms/manage_users/index/1/{$inserted['_err_codes']}"); // passing error alert 0 means no error, 1 means Error
                } elseif ($user_data['client_entry']) {

                    redirect(base_url() . "tms/manage_users/add_clients/0/Client_AddSucc"); // passing error alert 0 means no error, 1 means Error
                } else {
                    redirect(base_url() . "tms/manage_users/add_clients/0/Client_AddSucc"); // passing error alert 0 means no error, 1 means Error
                }
            }
        } else if (isset($user_data['Add_Employee']) && $user_data['Add_Employee'] == "Update") {


            $query_result = $this->m_users->user_save_update($user_data);

            //  die($this->util_model->printr($user_data));
            if ($query_result['succ']) {
                //  die($this->util_model->printr($user_data));
                if (!isset($user_data['client_entry'])) {
                    redirect(base_url() . "tms/manage_users/index/0/user_updateSucc"); // passing error alert 0 means no error, 1 means Error
                } else {
                    redirect(base_url() . "tms/manage_users/add_clients/0/Client_UpSucc"); // passing error alert 0 means no error, 1 means Error
                }
//                redirect(base_url() . "tms/manage_users/" . $addr . "/" . $query_result['UserName'] . "/0/Emp_UpSucc");
            } else {
                if (!isset($user_data['client_entry'])) {
                    redirect(base_url() . "tms/manage_users/index/" . $query_result['UserName'] . "/1/Emp_UpErr" . ERR_DELIMETER); // passing error alert 0 means no error, 1 means Error
                } else {
                    redirect(base_url() . "tms/manage_users/add_clients/" . $query_result['UserName'] . "/1/Emp_UpSucc" . ERR_DELIMETER); // passing error alert 0 means no error, 1 means Error
                }
//                redirect(base_url() . "tms/manage_users/" . $addr . "/" . $query_result['UserName'] . "/1/Emp_UpErr" . ERR_DELIMETER); //if someone try to open this script directory .. it will redirect him/her to new employee form
            }
        }
        //  $this->util_model->printr($query_result);
        redirect(base_url() . 'tms/manage_users/index/1/Emp_UpErr' . ERR_DELIMETER); //if someone try to open this script directory .. it will redirect him/her to new employee form
    }

    public function get_client_result($form_data = array()) {
        if (empty($form_data)) {
            $form_data = $this->input->post();
        }

        if (!isset($form_data['usertype'])) {
            echo json_encode(array("succ" => TRUE, "html" => "<span style='color:red'>Please Select Client Type.</span>"));

            return;
        }

        // die($this->util_model->printr($form_data));
//        $data['all_emp_details'] = $this->m_users->get_emp_details_from_database('', '', '', " ut.UserTypeGroup = 2");
//        $data['addr'] = "Client_Edit";
        $data['client_list'] = $this->m_users->getUsers($form_data);
        $data['addr'] = "Client_Edit";
        //   die($this->util_model->printr($data['client_list'] ));
        echo json_encode(array("succ" => TRUE, "html" => $this->load->view('tms/common/get_client_ajax/ajax_result.php', $data, TRUE)));
    }

    public function free_users($error = '', $_err_codes = '') { //provide a view of new Employee form
//            $this->OverDueTask();
//            die();
//        $this->DailyTaskEntryByTeam();
//        die();
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        $this->load->model("tms/m_task_manage");

        $request = $this->input->get("per_page");

        $filter['limit'] = $request;
        // for re-assign
        
        
        
//        $this->util_model->printr($data['SubTaskList']);
        $req = $this->input->post();
        if ($req && isset($req['ajaxcall'])) {
            $filter = array();
            $filter['date'] = $req['date'];
            $data['free_users'] = $this->m_task_manage->free_hours($filter);
            echo json_encode($data['free_users']);
            return;
        }

        $getReq = $this->input->get();

        $startDate = date("Y-m-d", time());
        $endDate = date("Y-m-d", strtotime("+7 day", strtotime($startDate)));

        if ($getReq) {
            $startDate = date("Y-m-d", strtotime($getReq['startDate']));
            $endDate = date("Y-m-d", strtotime($getReq['endDate']));
        }

        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;

        $data['free_users'] = $this->m_task_manage->free_hours($filter);




        $data['dates'] = $this->getDatesFromRange($startDate, $endDate);

//        $config['base_url'] = base_url() . "all_admission?" . http_build_query($queryString);
//
//        $config['total_rows'] = 2000;
//        $config['per_page'] = 20;
//        $config['page_query_string'] = TRUE;
//        $config['full_tag_open'] = "<ul class='pagination'>";
//        $config['full_tag_close'] = "</ul>";
//        $config['num_tag_open'] = '<li>';
//        $config['num_tag_close'] = '</li>';
//        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
//        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
//        $config['next_tag_open'] = "<li>";
//        $config['next_tagl_close'] = "</li>";
//        $config['prev_tag_open'] = "<li>";
//        $config['prev_tagl_close'] = "</li>";
//        $config['first_tag_open'] = "<li>";
//        $config['first_tagl_close'] = "</li>";
//        $config['last_tag_open'] = "<li>";
//        $config['last_tagl_close'] = "</li>";
//
//
//        $this->pagination->initialize($config);
//
//
//        $data['pageination'] = $this->pagination->create_links();
//        $this->util_model->printr($data['free_users']);
//        die();
        $this->load->model("tms/m_task_manage", 'm_task');
        $this->load->view('templates/header.php', $data);
        $this->load->view('tms/manage_users/v_free_users.php', $data);
        $this->load->view('templates/footer.php');
    }

    function getDatesFromRange($start, $end) {
        $dates = array($start);
        while (end($dates) < $end) {
            $dates[] = date('Y-m-d', strtotime(end($dates) . ' +1 day'));
        }
        return $dates;
    }

}
