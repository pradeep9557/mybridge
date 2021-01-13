<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of employee
 *
 * @author Mr. Anup
 */
class employee extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('emp/employee_model');
    }

    function add_employee($error = '', $_err_codes = '') { //provide a view of new Employee form
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        // to get all list 
//         $this->util_model->printr($data);
//         die();
        $data['all_qualification_list'] = $this->util_model->get_list("QID", "Code", DB_PREFIX . "qualification", $data['Session_Data']['IBMS_BRANCHID']);
        $data['user_types'] = $this->util_model->get_list("UTID", "UserTypeName", DB_PREFIX . "usertypes");

        unset($data['user_types'][10]);
        $data['Designation'] = $this->util_model->get_list("DID", "Code", DB_PREFIX . "designation");
        $data['nationality_list'] = $this->util_model->get_list("NID", "Code", DB_PREFIX . "nationality", $data['Session_Data']['IBMS_BRANCHID']);
        //To list all the nationality from the database 
        $data['all_branches'] = $this->util_model->branch_list_with_branch_Cat($data['Session_Data']);
        $data['days_list'] = $this->util_model->days_list();
        if (!file_exists(APPPATH . '/views/Employee/Add_Employee.php')) {
            show_404();
        }

        $this->load->library("time_mange/mange_time_lib");
        $data['element_type'] = "2";
        $data['selected'] = array(1, 2, 3, 4, 5, 6, 7, 8);
        $data['set_time_form'] = $this->mange_time_lib->get_set_time_form();

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/common_window_pop_up.php');
        $this->load->view('Employee/Add_Employee.php', $data);
        $this->load->view('templates/footer.php');
    }

    public function change_password($error = '', $_err_codes = '') { //provide a view of new Employee form
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);

        if (!file_exists(APPPATH . '/views/auth/change_password.php')) {
            show_404();
        }
        $data['title'] = ucfirst("Change Password | " . SITE_NAME); //capitalizing the first character of string for header.
        $this->load->view('templates/header.php', $data);
        $this->load->view('auth/change_password.php', $data);
        $this->load->view('templates/footer.php');
    }

    public function update_password_process() {
        global $data;
        $Emp_ID = $data['Session_Data']['IBMS_USER_ID'];
        $this->load->library('encrypt');
        $user_data = $this->input->post();
        $this->load->model("employee_model");
        $employee_data = $this->employee_model->get_emp_details_via_emp_id($Emp_ID);
        if (!$employee_data) {
            redirect("employee/add_employee/1/EmpNotFound");
        } else {
            $decoded_pass = $this->encrypt->decode($employee_data->Emp_Pass);
            if ($decoded_pass == $user_data['Old_Pass']) {
                $encrypted_pass = $this->encrypt->encode($user_data['confirm_Password']);
                $data_to_update["Emp_Pass"] = $encrypted_pass;
                if ($employee_data->P_Email_Verified == 0)
                    $data_to_update["P_Email_Verified"] = 1;
            }
            if ($this->employee_model->update_emp_via_id($employee_data->Emp_ID, $data_to_update)) {
                redirect(base_url() . 'employee/change_password/0/EmpPassChangedSucc');
            } else {
                redirect(base_url() . 'employee/change_password/1/EmpPassChangedErr');
            }
        }
//$encrpt_pass = $user_data['']
    }

    function All_module_list() {
        $module_list = $this->auth_model->module_list();
        $this->load->view('auth/auth_module_list');
    }

    function employee_save_update() {
        global $data;


        // will do save and update and redirect to Supported_Documents.php
        $employee_form_data = $this->input->post();
        $employee_form_data['DOB'] = date(DB_DF, strtotime($employee_form_data['DOB']));
        $employee_form_data['DOJ'] = date(DB_DF, strtotime($employee_form_data['DOJ']));
        //  die($this->util_model->printr($employee_form_data));
        if (isset($employee_form_data['Add_Employee']) && $employee_form_data['Add_Employee'] == "Save") {
            //$this->util_model->printr($this->input->post());
            $inserted = $this->employee_model->employee_save_update($employee_form_data);
            if ($inserted['succ']) {
                if (isset($employee_form_data['send_on_mail'])) {
                    $this->load->library('email');
                    $this->load->library('encrypt');
                    //$this->email->from($data['Branch_obj']->Email1, $data['Branch_obj']->BranchCode);
                    $this->email->from("account@nexibms.in");
                    $this->email->to("{$employee_form_data['P_Email']}");
                    $this->email->subject('IBMS User Password For User ' . $employee_form_data['Emp_Code']);
                    $pass_encrypt = $this->encrypt->encode($employee_form_data['Emp_Code'] . rand(0, 4000));
                    $pass_to_update = array("Emp_Pass" => $pass_encrypt);
                    $pass_plan_text = $this->encrypt->decode($pass_encrypt);
                    $this->employee_model->update_emp($employee_form_data['Emp_Code'], $pass_to_update);
                    $message = sprintf($data['Branch_obj']->emp_pass_template, $data['Branch_obj']->BranchCode, $employee_form_data['Emp_Code'], $pass_plan_text, $data['Branch_obj']->login_panel_url);
                    $this->email->message($message);
                    $this->email->send();
                } else {
                    $pass_to_update = array("Emp_Pass" => $this->util_model->encrypt_string($employee_form_data['Password']));
                    if ($this->employee_model->update_emp($employee_form_data['Emp_Code'], $pass_to_update)) {
                        redirect(base_url() . "employee/document_attach/{$employee_form_data['Emp_Code']}/0/Emp_AddSucc"); // passing error alert 0 means no error, 1 means Error
                    } else {
                        redirect(base_url() . "employee/add_employee/1/{$inserted['_err_codes']}"); // passing error alert 0 means no error, 1 means Error
                    }
                }
            } else {
                redirect(base_url() . "employee/add_employee/1/{$inserted['_err_codes']}"); // passing error alert 0 means no error, 1 means Error
            }
        } else if (isset($employee_form_data['Add_Employee']) && $employee_form_data['Add_Employee'] == "Update") {
            $query_result = $this->employee_model->employee_save_update($employee_form_data);
//                                          $this->util_model->printr($query_result);
//                                          $saved_or_updated = $query_result[0];
            if ($query_result['succ']) {
                redirect(base_url() . "employee/Emp_Edit/" . $query_result['Emp_Code']) . "/0/Emp_UpSucc";
            } else {
                redirect(base_url() . 'employee/add_employee/' . $query_result['Emp_Code'] . "/1/Emp_UpErr" . ERR_DELIMETER); //if someone try to open this script directory .. it will redirect him/her to new employee form
            }
        }
        //  $this->util_model->printr($query_result);
        redirect(base_url() . 'employee/add_employee/1/Emp_UpErr'); //if someone try to open this script directory .. it will redirect him/her to new employee form
    }

    function document_attach($Emp_Code, $error = '', $_err_codes = '') { //provide a view of new Employee form
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        // to get all list 
        $data['Emp_Code'] = strtoupper($Emp_Code);
        $data['employee_data'] = $this->employee_model->get_emp_details_from_database($Emp_Code);
        //print_r($data['employee_data']);
        if (!file_exists(APPPATH . '/views/Employee/Add_Employee.php')) {
            show_404();
        }
        $data['title'] = ucfirst("Attach Your Supported Documents | " . SITE_NAME);
        //capitalizing the first character of string for header.
        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/common_window_pop_up.php');
        $this->load->view('Employee/Supported_documents.php', $data);
        $this->load->view('templates/footer.php');
    }

    function upload_supported_document() {

        if ($_POST['upload_supported_documents'] == "Upload & Finish") {
            $data_to_update = array();
            $Emp_Code = strtoupper($_REQUEST['Emp_Code']);
            $Mode_User = $_REQUEST['Mode_User'];
            $this->load->model('upload/file_upload');
            $all_fields_name = array("Address_Proof", "ID_Proof", "Police_verification", "Resume");
            // if none selected to uploaded docx then it will back with error
            if ($_FILES['Address_Proof']['name'] == "" && $_FILES['ID_Proof']['name'] == "" && $_FILES['Police_verification']['name'] == "" && $_FILES['Resume']['name'] == "") {
                redirect(base_url() . "employee/document_attach/$Emp_Code/1/none_selected" . ERR_DELIMETER);
            }
            foreach ($all_fields_name as $field_name) {
                if ($_FILES[$field_name]["name"] != "") {
                    $saving_name = $Emp_Code . $field_name . ".pdf";
                    $data_to_update[$field_name] = $saving_name;
                    if ($this->file_upload->upload_file(450, 'pdf', $field_name, $saving_name, EMP_DOCUMENT_UPLOAD_PATH)) {
                        continue;
                    } else {
                        redirect(base_url() . "employee/document_attach/$Emp_Code/1/EmpDocUplErr" . ERR_DELIMETER);
                    }
                }
            }

            if (!empty($data_to_update)) {
                if ($this->employee_model->update_emp($Emp_Code, $data_to_update)) {
                    redirect(base_url() . "employee/document_attach/$Emp_Code/0/EmpDocUplSucc");
                } else {
                    redirect(base_url() . "employee/document_attach/$Emp_Code/1/EmpDocUpdateErr" . ERR_DELIMETER);
                }
            }
        } else {
            redirect(base_url() . "employee/document_attach/$Emp_Code/1/void_action" . ERR_DELIMETER);
        }
    }

    function All_Emp_List() {
        $data['Session_Data'] = $this->session->all_userdata();

        $data['all_emp_details'] = $this->employee_model->get_emp_details_from_database();
        if (!file_exists(APPPATH . '/views/Employee/Add_Employee.php')) {
            show_404();
        }
        $data['title'] = ucfirst("All Employee List | " . SITE_NAME); //capitalizing the first character of string for header.
        $this->load->view('Employee/All_Employee_List.php', $data);
    }

    function Emp_Edit($Emp_Code, $error = '', $_err_codes = '') { //provide a view of new Employee form
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        $data['all_qualification_list'] = $this->util_model->get_list("QID", "Code", DB_PREFIX . "qualification", $data['Session_Data']['IBMS_BRANCHID']);
        $data['user_types'] = $this->util_model->get_list("UTID", "UserTypeName", DB_PREFIX . "usertypes");
        unset($data['user_types'][10]);
        $data['Designation'] = $this->util_model->get_list("DID", "Code", DB_PREFIX . "designation", $data['Session_Data']['IBMS_BRANCHID']);
        $data['nationality_list'] = $this->util_model->get_list("NID", "Code", DB_PREFIX . "nationality", $data['Session_Data']['IBMS_BRANCHID']);
        //To list all the nationality from the database 
        $data['all_branches'] = $this->util_model->branch_list_with_branch_Cat($data['Session_Data']);
        $data['days_list'] = $this->util_model->days_list();
        $data['Emp_Code'] = strtoupper($Emp_Code);

        $data['employee_data'] = $this->employee_model->get_emp_details_from_database($Emp_Code);
        //$this->util_model->printr($data['employee_data']);

        $this->load->library("time_mange/mange_time_lib");
        $data['element_type'] = "2";
        $data['selected'] = array(1, 2, 3, 4, 5, 6, 7, 8);
        $data['update_time_form'] = $this->mange_time_lib->get_update_time_form($data['employee_data']->Emp_ID, 2);


        if (!file_exists(APPPATH . '/views/Employee/Add_Employee.php')) {
            show_404();
        }
        $data['title'] = ucfirst("Attach Your Supported Documents | " . SITE_NAME); //capitalizing the first character of string for header.
        $this->load->view('templates/header.php', $data);
        $this->load->view('Employee/Edit_Employee.php', $data);
        $this->load->view('templates/footer.php');
    }

    public function user_profile() {
        global $data;
        $Emp_ID = $data['Session_Data']['IBMS_USER_ID'];
        $data['employee_data'] = $this->employee_model->get_emp_details_via_emp_id($Emp_ID);
//        die($this->util_model->printr($data['employee_data']));
//        $data['employee_data'] = $this->employee_model->get_emp_details_from_database($data['employee_data']->Emp_Code);
        if (!file_exists(APPPATH . '/views/Employee/user_profile.php')) {
            show_404();
        }

        $data['title'] = ucfirst("{$data['Session_Data']['IBMS_USER_ID_NAME']} Profile | " . SITE_NAME); //capitalizing the first character of string for header.
        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/common_window_pop_up.php');
        $this->load->view('Employee/profile_page.php', $data);
        $this->load->view('templates/footer.php');
    }

    public function update_user_data() {
        $formdata = $this->input->post();
        $config['upload_path'] = "./img/Employee_Data/Employee_pic_and_sign/";
        $config['allowed_types'] = 'jpg|png|jpeg|gif';
        $config['max_size'] = '5120'; // 5MB allowed
        $this->load->library('upload', $config);
        $uploaded_data = array();
        if (!empty($_FILES)) {
            $file_name = str_replace(" ", "", $this->util_model->get_uname()) . "_" . $_FILES['Pro_Pic']['name'];
            $_FILES['Pro_Pic']['name'] = $file_name;
            if (!$this->upload->do_upload('Pro_Pic')) {
//                $this->util_model->printr($this->upload->display_errors());
                echo json_encode(array("succ" => FALSE, "_err_codes" => array("Error in uploading Files!")));
                die();
            }
            $uploaded_data['Pro_Pic'] = $file_name;
            if (!empty($uploaded_data['upload_errors'])) {
                echo json_encode(array("succ" => FALSE, "_err_codes" => array("Error in uploading Files!")));
                die();
            }else{
                $this->session->set_userdata('IBMS_USER_PRO_PIC',$file_name);
            }
        }

        $upload_data = array("Emp_Name" => $formdata['Emp_Name']);
        if (empty($uploaded_data['upload_errors']) && !empty($uploaded_data)) {
            $upload_data['Pro_Pic'] = $uploaded_data['Pro_Pic'];
        }
        echo json_encode($this->employee_model->update_user_data($this->util_model->add_mode_user($upload_data)));
    }

}
