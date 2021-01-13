<?php

if (!defined('BASEPATH'))
              exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of c_course_ajax
 *
 * @author NexGen Team
 */
class c_course_ajax extends CI_Controller {

              function __construct() {
                            parent::__construct();
              }

              public function getCourseByCourseCat($C_CID = 0, $multi_select = TRUE,$faculty_show_filter_function=FALSE) {
                            global $data;
                            $this->load->model('courses/course');
                            $data['selected'] = array();
                            $data['multi_select'] = $multi_select;
                            $data['faculty_show_filter'] = $faculty_show_filter_function;
                            $data['field_name'] = "CourseID";
                            $data['list'] = $this->course->listConvert($this->course->Course_list_with_child($data['Session_Data']['IBMS_BRANCHID'], 0, '', $C_CID));
                            $this->load->view('Ajax/v-multi-select-list', $data);
                           
              }
              
               
              
                   public function getFacultyByCourse($CourseID = 0, $multi_select = TRUE) {
                            global $data;
                            $this->load->model('courses/course');
                            $data['selected'] = "";
                            $data['multi_select'] = $multi_select;
                            $data['field_name'] = "FacultyID";
                            $data['faculty_show_filter'] = FALSE;
                            $filter_data = array("Status" => TRUE);
                            if ($CourseID) {
                                          $filter_data['CourseID'] = $CourseID;
                            }
                            $data['list'] = array("" => "Select") + $this->course->get_faculty_via_course($filter_data);
                            $this->load->view('Ajax/v-multi-select-list', $data);
              }

}
