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
class search {

              // constructor
              private $super_object;

              public function __construct() {
                            // calling to parent constructor
                            $this->super_object = & get_instance();
              }

              // start you function from here
              public function fee_search() {
                            global $data;
                            $data['input_fields'] = array(
                                 "Name" => "StudentName",
                                "Mob1" => "Mobile",
                               
                                "FName" => "FatherName",
                                "Email1" => "Email1",
                                "EnrollNo" => "EnrollNo",
                                "Stu_ID" => "Student ID");
                            $data['collapse'] = "collapse";
                            $data['amount_share_options'] = array("calculated"=>"Calculated","not-calculated"=>"Not-calculated","both"=>"Both");
                           
                            return $this->super_object->load->view('Ajax/fees/search_form.php', $data, true);
              }

              
               // start you function from here
              /*

               * this function will fetch the data from faculty_account table               */
              public function faculty_account_search() {
                            global $data;                  
                            $this->super_object->load->model("courses/course");   
                            $data['input_fields'] = array(
                                 "Name" => "StudentName",
                                "ReceiptNo"=>"Receipt No",
                                "Mob1" => "Mobile",
                               
                                "FName" => "FatherName",
                                "Email1" => "Email1",
                                "EnrollNo" => "EnrollNo",
                                "Stu_ID" => "Student ID");
                            $data['share_options'] = array("0"=>"Not Given","1"=>"Given","2"=>"Both");
                            $data['course_cat_list'] = array("" => "Select") + $this->super_object->util_model->get_list('C_CID', 'C_CatCode', DB_PREFIX . "course_cat_mst", $data['Session_Data']['IBMS_BRANCHID'], 'C_CatCode');
                            $data['All_Course_List'] = $this->super_object->course->listConvert($this->super_object->course->Course_list_with_child($data['Session_Data']['IBMS_BRANCHID'], 0));
                            $data['fac_list'] = array("" => "Select Faculty Code") + $this->super_object->util_model->get_list("Emp_ID", "Emp_Code", DB_PREFIX . "employee", $data['Session_Data']['IBMS_BRANCHID'], $sort_col = 'Emp_Code', TRUE, 1, " UTID=" . $data['Branch_obj']->FacultyCode);
                            return $this->super_object->load->view('Ajax/faculty_share/search_form', $data, true);
              }
}
