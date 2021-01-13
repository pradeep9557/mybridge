<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of branch_master
 *
 * @author Anup kumar
 * It would create branches
 */
class branch_master extends CI_Controller {

    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->model('branch/branch_model');
    }

    public function index($error = '', $_err_codes = '') { //provide a view of new Employee form
        global $data;
        $data['branch_list'] = $this->branch_model->get_all_branch();
         $data['branch_list_view'] =  $this->load->view('superadmin/bm/v_all_branch', $data,true);
       
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        $this->load->model(array('enquiry/locality'));
        $data['user_types'] = $this->util_model->get_list("UTID", "UserTypeName", DB_PREFIX . "usertypes");
        $data['country_list'] = $this->util_model->get_list('country_id', 'name', DB_PREFIX . "countries", 0, 'name');
        $data['state_list'] = $this->locality->all_states($data['Branch_obj']->Country);
        //$data['locality_list'] = $this->locality->AllLocality(0, 2);
        
        $data['City_list'] = $this->util_model->get_list('city_id', 'citycode', DB_PREFIX . "cities", 0, 'Sort,citycode');
        $branch_list = $this->branch_model->branch_list_with_branch_Cat(1);
//                            echo 'hiii';
//                            die();
        $this->load->view('templates/header.php', $data);
        $this->load->view('superadmin/bm/v-add-branch');
        $this->load->view('templates/footer.php');
    }

    function formvalidation($POST) {
        $err_codes = '';

        if (!isset($POST['BranchCode']) || $POST['BranchCode'] == "") {
            $err_codes.='bcodeBlank' . ERR_DELIMETER;
        }
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $POST['BranchCode'])) {
            $err_codes.='bcodeptrn' . ERR_DELIMETER;
        }
        if (!isset($POST['Bname']) || $POST['Bname'] == "") {
            $err_codes.='bcodeBlank' . ERR_DELIMETER;
        }
        if (!preg_match('/^[a-zA-Z0-9\s]+$/', $POST['Bname'])) {
            $err_codes.='Bnameptrn' . ERR_DELIMETER;
        }
//        if (!preg_match(' /^[0-9]+$/', $POST['Max_Std_In_Batch'])) {
//            $err_codes.='Maxstudptrn' . ERR_DELIMETER;
//        }
//        if (!preg_match('/^[0-9]+$/', $POST['Min_Emp_Age'])) {
//            $err_codes.='Minempageptrn' . ERR_DELIMETER;
//        }
//        if (!preg_match('/^[0-9]+$/', $POST['Min_Std_Age'])) {
//            $err_codes.='Minstuageptrn' . ERR_DELIMETER;
//        }
//                            if (!preg_match('/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i', $POST['Bsite'])) {
//                                          $err_codes.='Urlptrn' . ERR_DELIMETER;
//                            }
        if (!(filter_var($POST['Email1'], FILTER_VALIDATE_EMAIL))) {
            $err_codes.='Mailptrn' . ERR_DELIMETER;
        }

        if ($POST['Email2'] != "") {
            if (!filter_var($POST['Email2'], FILTER_VALIDATE_EMAIL)) {
                $err_codes.='Mailptrn' . ERR_DELIMETER;
            }
        }
        if ($POST['Mob2'] != "") {
            if ((strlen($POST['Mob2']) > 10) || (strlen($POST['Mob2']) < 10)) {
                $err_codes.='MobnumBlank' . ERR_DELIMETER;
            }
        }
        if (!isset($POST['Mob1']) || $POST['Mob1'] == "") {
            $err_codes.='MobnumBlank' . ERR_DELIMETER;
        }
        if ((strlen($POST['Mob1']) > 10) || (strlen($POST['Mob1']) < 10)) {
            $err_codes.='Mobnumlen' . ERR_DELIMETER;
        }
        if ($POST['Phone1'] != "") {
            if (!preg_match('/^[0-9\,]+$/', $POST['Phone1']) || !preg_match('/^[0-9\,]+$/', $POST['Phone1'])) {
                $err_codes.='Phonumptrn' . ERR_DELIMETER;
            }
        }
        if ($POST['Pincode'] != "") {
            if (!preg_match('/^(\d{6})+$/', $POST['Pincode'])) {
                $err_codes.='Pinptrn' . ERR_DELIMETER;
            }
        }
//                            if ($POST['login_panel_url'] != "") {
//                                          if (!preg_match('uri', $POST['login_panel_url'])) {
//                                                        $err_codes.='Urlptrn' . ERR_DELIMETER;
//                                          }
//                            }
        $valid = $err_codes == '' ? TRUE : FALSE;
        return array("_err" => $valid, "_err_codes" => $err_codes);
    }

//    public function create_branch($error = '') {
//        if (error == 1) {
//            $data['_err_msg'] = $this->util_model->_get_decrypted_cookie('_err_msg');
//        }
//    }

    public function bra_noti_setting($BranchID="") { // notification_setting
        global $data;
        if ($BranchID == "") {
            $BranchID = $data['Session_Data']['IBMS_BRANCHID'];
        }
        $data['branch_settings'] = $this->branch_model->get_branch_setting($BranchID);
        $this->load->view('templates/header.php', $data);
        $this->load->view('superadmin/bm/notifi_setting');
        $this->load->view('templates/footer.php');
    }

// to save the new branch in Database(By Prabhu)
    function save_branch() {
        $FormData = $this->input->post(); // getting all data from form
//                             die($this->util_model->printr($FormData));
        $path = base_url() . "superadmin/branch_master/index/";
        $validates = $this->formvalidation($FormData); // validating the form
        // die($this->util_model->printr($validates));
        if (!$validates['_err']) {
            redirect($path . "1/{$validates['_err_codes']}");
        }
        $FormData['Status'] = isset($FormData['Status']);
        $FormData = $this->util_model->add_common_fields($FormData);
        unset($FormData['sbt_btn']);
        $this->load->model('branch/branch_model');
        if($this->branch_model->insert_branch($FormData)){
            redirect($path . "0/lAddSucc");
        } else {
            redirect($path . "1/lAddErr" . ERR_DELIMETER);
        }
    }

    public function vedit_branch($BranchID = '', $error = '', $_err_codes = '') { // notification_setting
        global $data;
        if ($BranchID == "") {
            $BranchID = $data['Session_Data']['IBMS_BRANCHID'];
        }
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        $this->load->model(array('enquiry/locality'));
        $data['user_types'] = $this->util_model->get_list("UTID", "UserTypeName", DB_PREFIX . "usertypes");
        $data['country_list'] = $this->util_model->get_list('country_id', 'name', DB_PREFIX . "countries", 0, 'name');
        $data['state_list'] = $this->locality->all_states($data['Branch_obj']->Country);
        $data['locality_list'] = $this->locality->AllLocality(0, 2);
        $data['City_list'] = $this->util_model->get_list('city_id', 'citycode', DB_PREFIX . "cities", 0, 'Sort,citycode');

        $data['branch_details'] = $this->util_model->get_branch_details($BranchID);
        $this->load->view('templates/header.php', $data);
        $this->load->view('superadmin/bm/update_branch_details', $data);
        $this->load->view('templates/footer.php');
    }

    // update the locality
    function update_branch() {
        $FormData = $this->input->post();
        $path = base_url() . "superadmin/branch_master/vedit_branch/";
        // checking about hidden BranchID
        if (!isset($FormData['id'])) {
            redirect(base_url());  //redirect to dashboard      
        }
        // retreiving hidden BranchID
        $BranchID = $FormData['id'];
        $path.="$BranchID/"; // to redirect with branch ID
        // doing unset to rid
        unset($FormData['id']);
        // setting flag for status
        $FormData['Status'] = isset($FormData['Status']);
        // for form validation
        $validates = $this->formvalidation($FormData); // validating the form
        // checking its reponse
        if (!$validates['_err']) {
            redirect($path . "1/{$validates['_err_codes']}");
        }


        // adding mode user
        $FormData = $this->util_model->add_mode_user($FormData);
        // calling to model function to update
        //die($this->util_model->printr($FormData));
        $inserted_enq = $this->branch_model->branch_update($FormData, $BranchID);
        if (!$inserted_enq['succ']) {
            redirect($path . "1/Buperr" . ERR_DELIMETER);
        } else {
            redirect(base_url(). "sp-admin/bm/index/0/Busucc");
        }
    }

//    function get_all_branch() {
//        global $data;
//        $data['branch_list'] = $this->branch_model->get_all_branch();
//        $this->load->view('templates/header.php', $data);
//        $this->load->view('superadmin/bm/v_all_branch');
//        $this->load->view('templates/footer.php');
//    }
    
    function save_notify_setting(){
        $FormData = $this->input->post();
//        $this->util_model->printr($FormData);
//        die();
        $path = base_url() . "superadmin/branch_master/bra_noti_setting/".$FormData['BranchID'];

        unset($FormData['save_adm']);
        if($this->branch_model->save_notify_setting($FormData)){
           redirect($path . "/0/Busucc");
        } else {
            redirect($path . "/1/Buperr" . ERR_DELIMETER);
        }
        
    }

}
