<?php

if (!defined('BASEPATH'))
              exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of batch_master
 *
 * @author anup
 */
class batch_master extends CI_Controller {

              function __construct() {
                            parent::__construct();
                            $this->load->model('batch/batch_model');
              }

              public function index($error = '', $show_error = 0) {
                            global $data;
                            if ($show_error == 1) {
                                          $data['_err_msg'] = $this->util_model->_get_decrypted_cookie('_err_msg');
                                          if ($error == 1)
                                                        $data['error'] = TRUE;
                                          else
                                                        $data['error'] = FALSE;
                            }

                            $this->load->model(array('courses/course'));
                            $data['All_Faculty_Code'] = $this->util_model->get_list("Emp_ID", "Emp_Code", DB_PREFIX . "employee", $data['Session_Data']['IBMS_BRANCHID'], $sort_col = 'Emp_Code', TRUE, 1, " UTID=" . $data['Branch_obj']->FacultyCode);
                            $data['course_cat_list'] = array("" => "Select") + $this->util_model->get_list('C_CID', 'C_CatCode', DB_PREFIX . "course_cat_mst", $data['Session_Data']['IBMS_BRANCHID'], 'C_CatCode');
                            $data['All_Course_Code'] = $this->course->listConvert($this->course->Course_list_with_child($data['Session_Data']['IBMS_BRANCHID'], 0));
                            //$this->util_model->printr($data['All_batch_list']);
                            $data['attributes'] = array('role' => 'form', 'class' => 'new_batch_form', 'id' => 'batch_validation_form'); // extra attributes for form


                            if (!file_exists(APPPATH . '/views/Batches/Add_New_batch.php')) {
                                          show_404();
                            }

                            $data['all_batches_list'] = $this->all_batches_list();

                            $this->load->library("time_mange/mange_b_time_lib");
                            $data['element_type'] = "1";
                            $data['selected'] = array(1, 2, 3, 4, 5, 6, 7, 8);
                            $data['set_b_time_form'] = $this->mange_b_time_lib->get_set_time_form();


                            $data['title'] = ucfirst("Add Batch |" . SITE_NAME); //capitalizing the first character of string for header.
                            $this->load->view('templates/header.php', $data);
                            $this->load->view('templates/common_window_pop_up.php');
                            $this->load->view("Batches/Add_New_batch.php", $data);
                            $this->load->view("Batches/batch_js.php", $data);
                            $this->load->view('templates/footer.php');
              }

              public function all_batches_list() {
                            global $data;
                            $data['All_batch_list'] = $this->batch_model->all_batch_list(array($data['Session_Data']['IBMS_BRANCHID']));
                            return $this->load->view("Batches/all_batches.php", $data, TRUE);
              }

              public function batch_save_update() {
                            $this->util_model->printr($this->input->post());
                            die();
                            $path = "";
                            $query_result = array();
                            if (isset($_REQUEST['Add_Batch']) && $_REQUEST['Add_Batch'] == "Save") {
                                          try {
                                                        $query_result = $this->batch_model->batch_master_save_update();
                                                        $saved_or_updated = $query_result[0];
                                                        $path = $saved_or_updated ? "batch/batch_master/index/0/1" : "batch/batch_master/index/1/1";
                                          } catch (Exception $ex) {
                                                        $saved_or_updated = $query_result[0];
                                                        $path = "batch/batch_master/index/1/1";
                                          }
                            } else if (isset($_REQUEST['Add_Batch']) && $_REQUEST['Add_Batch'] == "Update") {
                                          $query_result = $this->batch_model->batch_master_save_update();
                                          if ($query_result['succ']) {
                                                        $path = "batch/batch_master/edit_batches/" . $query_result['BatchID'] . "/0/B_Upp_Succ";
                                          } else {
                                                        $path = "batch/batch_master/edit_batches/" . $query_result['BatchID'] . "/1/B_Upp_Succ" . ERR_DELIMETER;
                                          }
                            } else {
                                          $path = "batch/batch_master/1/NeitherSaveOrUpdate" . ERR_DELIMETER;
                            }
                            redirect(base_url() . $path); // passing error alert 0 means no error, 1 means Error
              }

              public function Del_Batch($BatchCode = '') {
                            if ($this->batch_model->Del_Batch($BatchCode)) {
                                          redirect(base_url() . "batch/batch_master/index/0/1/1");
                                          // passing error alert 0 means no error, 1 means Error
                            } else {
                                          redirect(base_url() . "batch/batch_master/index/1/1/1");
                                          // passing error alert 0 means no error, 1 means Error
                            }
              }

              public function edit_batches($BatchID, $error = '', $_err_codes = '') {
                            global $data;
                            $data = $this->util_model->set_error($data, $error, $_err_codes);
                            echo $BatchID;
                            $this->load->model('courses/course');

                            $data['All_Faculty_Code'] = $this->util_model->get_list("Emp_ID", "Emp_Code", DB_PREFIX . "employee", $data['Session_Data']['IBMS_BRANCHID'], $sort_col = 'Emp_Code', TRUE, 1, " UTID=" . $data['Branch_obj']->FacultyCode);
                            $data['course_cat_list'] = array("" => "Select") + $this->util_model->get_list('C_CID', 'C_CatCode', DB_PREFIX . "course_cat_mst", $data['Session_Data']['IBMS_BRANCHID'], 'C_CatCode');
                            $data['All_Course_Code'] = $this->course->listConvert($this->course->Course_list_with_child($data['Session_Data']['IBMS_BRANCHID'], 0));

                            $data['attributes'] = array('role' => 'form', 'class' => 'new_batch_form', 'id' => 'batch_validation_form'); // extra attributes for form
                            $data['batch_details'] = $this->batch_model->m_batch_search(array("BatchID" => $BatchID));
                            $data['batch_details'] = $data['batch_details'][0];


                            $this->load->library("time_mange/mange_b_time_lib");
                            $data['element_type'] = "1";
                            $data['selected'] = array(1, 2, 3, 4, 5, 6, 7, 8);
                            $data['update_time_form'] = $this->mange_b_time_lib->get_update_time_form($BatchID, 1);


                            $this->load->view('templates/header.php',$data);
                            $this->load->view("Batches/batch_edit.php", $data);
                            $this->load->view("Batches/batch_js.php", $data);
                            $this->load->view('templates/footer.php');
              }

              // providing view from where user can search student to update its batch
              public function b_update($error = '', $show_error = 0) {
                            global $data;
                            if ($show_error == 1) {
                                          if ($error == 1)
                                                        $data['error'] = TRUE;
                                          else
                                                        $data['error'] = FALSE;
                            }

                            $attributes = array('role' => 'form', 'class' => 'new_batch_form', 'id' => 'batch_validation_form'); // extra attributes for form
                            $data['attributes'] = $attributes;

                            if (!file_exists(APPPATH . '/views/Batches/Add_New_batch.php')) {
                                          show_404();
                            }
                            $data['title'] = ucfirst("Update Batch |" . SITE_NAME); //capitalizing the first character of string for header.
                            $this->load->model('emp/employee_model');
                            $this->load->model('batch/batch_model');

                            //admission wise searching 
                            $this->load->model(array('enquiry/locality', 'courses/course', 'super-admin/usertypes_model'));
                            $data['b_update_searching_option'] = array(
                                "Mob1" => "Mobile",
                                "Name" => "StudentName",
                                "FName" => "FatherName",
                                "Email1" => "Email1",
                                "EnrollNo" => "EnrollNo",
                                "Stu_ID" => "Student ID");
                            $data['collapse'] = "";
                            $data['fac_list'] = array("" => "Select Faculty Code") + $this->util_model->get_list("Emp_ID", "Emp_Code", DB_PREFIX . "employee", $data['Session_Data']['IBMS_BRANCHID'], $sort_col = 'Emp_Code', TRUE, 1, " UTID=" . $data['Branch_obj']->FacultyCode);
                            $data['All_Batch_Status'] = $this->util_model->get_list("BatchStatusID", "BatchStatus", DB_PREFIX . "batchstatus", $data['Session_Data']['IBMS_BRANCHID'], $sort_col = 'Sort,BatchStatus');
//                            // to get first faculty ID
//                            $FirstFacultyID = "";
//                            foreach ($data['fac_list'] as $FacultyID => $FacultyCode) {
//                                          $FirstFacultyID = $FacultyID;
//                                          break;
//                            }
                            // end of first faculty
                            $data['fac_batch_list'] = array("" => "Select Batch Code") + $this->util_model->get_list("BatchID", "BatchCode", DB_PREFIX . "batch_master", $data['Session_Data']['IBMS_BRANCHID'], $sort_col = 'BatchCode', TRUE, 1);
                            $data['All_Course_List'] = $this->course->listConvert($this->course->Course_list_with_child($data['Session_Data']['IBMS_BRANCHID'], 0));
                            $data['bupdate_search_template'] = $this->load->view('Batches/search/v-search-batch.php', $data, true);
                            // end of searching template


                            $this->load->view("templates/header.php", $data);
                            $this->load->view("templates/common_window_pop_up.php", $data);
                            $this->load->view("Batches/update_Stu_batch.php", $data);
                            $this->load->view("Batches/batch_js.php");
                            $this->load->view("templates/footer.php");
              }

              /*

               * search_enq()
               * calling from ajax
               * @param nothing
               * receiving POST data from search form
               * Processing and returning html data               */

              function search_batches() {
                            global $data;
                            $all_form_data = $this->input->post();
                            $this->load->model("courses/course");
//                            $this->util_model->printr($all_form_data);
                            $data['Query_Result'] = $this->batch_model->msearch_batches($all_form_data);
                            //$this->util_model->printr($data['Query_Result']);
                            $data['table_id'] = rand(0, 9999999);
                            $this->load->helper('form'); // Loading Form helper which helps to make form elements
                            $attributes = array('role' => 'form', 'class' => $data['table_id']); // Extra attributes for form
                            $data['attributes'] = $attributes;
                            $data['id_of_result'] = rand(0, 99999999);
                            $data['fac_list'] = array("" => "Select Faculty Code") + $this->util_model->get_list("Emp_ID", "Emp_Code", DB_PREFIX . "employee", $data['Session_Data']['IBMS_BRANCHID'], $sort_col = 'Emp_Code', TRUE, 1, " UTID=" . $data['Branch_obj']->FacultyCode);

//                            // to get first faculty ID
//                            $FirstFacultyID = "";
//                            foreach ($data['fac_list'] as $FacultyID => $FacultyCode) {
//                                          $FirstFacultyID = $FacultyID;
//                                          break;
//                            }
                            // end of first faculty
                            $data['course_cat_list'] = array("" => "Select") + $this->util_model->get_list('C_CID', 'C_CatCode', DB_PREFIX . "course_cat_mst", $data['Session_Data']['IBMS_BRANCHID'], 'C_CatCode');
                            $data['All_Course_List'] = $this->course->listConvert($this->course->Course_list_with_child($data['Session_Data']['IBMS_BRANCHID'], 0));
                            $data['fac_batch_list'] = array("" => "Select Batch Code") + $this->util_model->get_list("BatchID", "BatchCode", DB_PREFIX . "batch_master", $data['Session_Data']['IBMS_BRANCHID'], $sort_col = 'BatchCode', TRUE, 1);
                            $data['All_Batch_Status'] = $this->util_model->get_list("BatchStatusID", "BatchStatus", DB_PREFIX . "batchstatus", $data['Session_Data']['IBMS_BRANCHID'], $sort_col = 'Sort,BatchStatus');
                            $this->load->view('Batches/search/v-global_batch_search_result', $data);
              }

              function update_indiviual_batch($Stu_ID) {
                            global $data;
                            $filter_data = array("search_via" => array("Stu_ID"),
                                "search_via_value" => array($Stu_ID),
                                "adv_search" => "Adv_search");
                            $data['Query_Result'] = $this->batch_model->msearch_batches($filter_data);
                            //$this->util_model->printr($data['Query_Result']);
                            $data['table_id'] = rand(0, 9999999);
                            $this->load->helper('form'); // Loading Form helper which helps to make form elements
                            $attributes = array('role' => 'form', 'class' => $data['table_id']); // Extra attributes for form
                            $data['attributes'] = $attributes;
                            $data['course_cat_list'] = array("" => "Select") + $this->util_model->get_list('C_CID', 'C_CatCode', DB_PREFIX . "course_cat_mst", $data['Session_Data']['IBMS_BRANCHID'], 'C_CatCode');
                            $data['id_of_result'] = rand(0, 99999999);
                            $data['fac_list'] = array("" => "Select Faculty Code") + $this->util_model->get_list("Emp_ID", "Emp_Code", DB_PREFIX . "employee", $data['Session_Data']['IBMS_BRANCHID'], $sort_col = 'Emp_Code', TRUE, 1, " UTID=" . $data['Branch_obj']->FacultyCode);

//                            // to get first faculty ID
//                            $FirstFacultyID = "";
//                            foreach ($data['fac_list'] as $FacultyID => $FacultyCode) {
//                                          $FirstFacultyID = $FacultyID;
//                                          break;
//                            }
                            // end of first faculty
                            $this->load->model("courses/course");
                            $data['All_Course_List'] = $this->course->listConvert($this->course->Course_list_with_child($data['Session_Data']['IBMS_BRANCHID'], 0));
                            $data['fac_batch_list'] = array("" => "Select Batch Code") + $this->util_model->get_list("BatchID", "BatchCode", DB_PREFIX . "batch_master", $data['Session_Data']['IBMS_BRANCHID'], $sort_col = 'BatchCode', TRUE, 1);
                            $data['All_Batch_Status'] = $this->util_model->get_list("BatchStatusID", "BatchStatus", DB_PREFIX . "batchstatus", $data['Session_Data']['IBMS_BRANCHID'], $sort_col = 'Sort,BatchStatus');
                            $this->load->view("templates/header.php", $data);
                            $data['wrap_it'] = TRUE;
                            $this->load->view('Batches/search/v-global_batch_search_result', $data);

                            $this->load->view("templates/footer.php", $data);
              }

              /*

               * this function will gernate the batch code
               *                

               * POST have
               * Array
                (
                [course_cat_codeid] => 13
                [faculty_codeid] => 38
                [str_batch_time] => 15:00
                [end_batch_time] => 16:00
                ) */

              public function gen_batchcode() {
                            global $data;
                            $filter_data = $this->input->post();
                            //$this->util_model->printr($filter_data);
                            $filter_data['BranchID'] = $data['Session_Data']['IBMS_BRANCHID'];
                            $filter_data['Course_Code_Cat_Code'] = $this->util_model->get_a_column_value("C_CatCode", DB_PREFIX . "course_cat_mst", array("C_CID" => $filter_data['course_cat_codeid']));
                            $filter_data['FacultyCode'] = $this->util_model->get_a_column_value("Emp_Code", DB_PREFIX . "employee", array("Emp_ID" => $filter_data['faculty_codeid']));
                            if ($this->batch_model->batch_gen_validation($filter_data)) {
                                          echo sprintf("%s%s%d", strtoupper($filter_data['Course_Code_Cat_Code']), strtoupper($filter_data['FacultyCode']), strtoupper($filter_data['str_batch_time']));
                            } else {
                                          echo "Error !!";
                            }
              }
              
              /*

               * check batch avaiablity               */
              function check_avail() {
                            $FormData = $this->input->post();
                            echo json_encode($FormData);
              }
}
