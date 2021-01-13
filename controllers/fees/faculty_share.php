<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of faculty_share
 *
 * 
 */
class faculty_share extends CI_Controller {

              //put your code here
              function __construct() {
                            parent::__construct();
                            $this->load->model('fee/faculty_s_model');
              }

              function index($error = '', $_err_codes = '') {
                            global $data;
                            $data = $this->util_model->set_error($data, $error, $_err_codes);
                            
                            $this->load->model('courses/course'); 
                            $data['All_Faculty_Code'] = $this->util_model->get_list("Emp_ID", "Emp_Code", DB_PREFIX . "employee", $data['Session_Data']['IBMS_BRANCHID'], $sort_col = 'Emp_Code', TRUE, 1, " UTID=" . $data['Branch_obj']->FacultyCode);
                            $data['course_cat_list'] = array("" => "Select") + $this->util_model->get_list('C_CID', 'C_CatCode', DB_PREFIX . "course_cat_mst", $data['Session_Data']['IBMS_BRANCHID'], 'C_CatCode');
                            $data['All_Course_Code'] = $this->course->listConvert($this->course->Course_list_with_child($data['Session_Data']['IBMS_BRANCHID'], 0));
                            
                            $this->load->view('templates/header.php', $data);
                            $this->load->view('Fee_collect/faculty_share/v-manage-faculty-share.php', $data);
                            $this->load->view('templates/footer.php');
              }

              public function insert_data() {
                            global $data;
                            $FormData = $this->input->post();
                            $path = base_url() . "fees/faculty_share/index/";
                            $FormData['BranchID'] = $data['Session_Data']['IBMS_BRANCHID'];
                            unset($FormData['course_cat_list']);
                            $FormData = $this->util_model->add_common_fields($FormData);
                            if ($this->faculty_s_model->set_data($FormData)) {
                                          redirect($path . "0/FacAddSucc");
                            } else {
                                          redirect($path . "1/FacAddErr");
                            }
              }

              function faculty_list() {
                            global $data;
                            $filter_data = array(
                                "BranchID" => $data['Session_Data']['IBMS_BRANCHID']
                                    );
                            $data['faculty_list'] = $this->faculty_s_model->list_all_faculty($filter_data);
                           // $this->util_model->printr($data['faculty_list']);
                            $this->load->view("Fee_collect/faculty_share/v-all-faculty-share", $data);
              }

              public function update($id = "", $error = '', $_err_codes = '') {
                            global $data;
                            $data = $this->util_model->set_error($data, $error, $_err_codes);
                            $data['value'] = $this->faculty_s_model->get_faculty_data($id);
                            $this->load->model('courses/course'); 
                            $data['All_Faculty_Code'] = $this->util_model->get_list("Emp_ID", "Emp_Code", DB_PREFIX . "employee", $data['Session_Data']['IBMS_BRANCHID'], $sort_col = 'Emp_Code', TRUE, 1, " UTID=" . $data['Branch_obj']->FacultyCode);
                            $data['course_cat_list'] = array("" => "Select") + $this->util_model->get_list('C_CID', 'C_CatCode', DB_PREFIX . "course_cat_mst", $data['Session_Data']['IBMS_BRANCHID'], 'C_CatCode');
                            $data['All_Course_Code'] = $this->course->listConvert($this->course->Course_list_with_child($data['Session_Data']['IBMS_BRANCHID'], 0));
                            $this->load->view('templates/header.php', $data);
                            $this->load->view('Fee_collect/faculty_share/v-edit-faculty-share.php', $data);
                            $this->load->view('templates/footer.php');
              }

              public function update_data() {
                            global $data;
                            $path = base_url() . "fees/faculty_share/index/";
                            $formdata = $this->input->post();
                            unset($formdata['course_cat_list']);
                            $formdata = $this->util_model->add_mode_user($formdata);
                            $fac_id = $formdata['faculty_share_id'];
                            unset($formdata['Update']);
                            if ($this->faculty_s_model->update_faculty($formdata, $fac_id)) {
                                          redirect($path . "0/FacUpdateSucc");
                            } else {
                                          redirect($path . "1/FacUpdateErr" . ERR_DELIMETER);
                            }
              }

              public function delete_row($fac_id) {
                            $path = base_url() . "fees/faculty_share/index/";
                            if ($this->faculty_s_model->delete_faculty($fac_id)) {
                                          redirect($path . "0/FacDeleteSucc");
                            } else {
                                          redirect($path . "1/FacDeleteErr" . ERR_DELIMETER);
                            }
              }

              /*

               * it will show all the faculty share               */
              function share_account_list() {
                           $filter_data = array();
                           $data['result']=$this->faculty_s_model->get_faculty_accounts_details($filter_data);
                           $this->load->view('templates/header.php', $data);
                            $this->load->view('Fee_collect/faculty_share/faculty_share_details.php', $data);
                            $this->load->view('templates/footer.php');
              }
}
