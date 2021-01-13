<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class courses extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('courses/course');
    }
    
   
    function add_course_cat($error = '', $_err_codes = '') { //provide a view of new course form
        global $data;
        $data['CourseCatList'] = $this->course->all_CourseCat_list();
        // $this->util_model->printr($data['CourseCatList']);
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        if (!file_exists(APPPATH . '/views/Courses/add_course_cat.php')) {
            show_404();
        }
        $this->load->view("templates/header.php", $data);
        $this->load->view("templates/common_window_pop_up.php");
        $this->load->view("Courses/add_course_cat.php", $data);
        $this->load->view("templates/footer.php");
    }
    function save_course_cat(){
        $FormData = $this->input->post();
        if ($FormData != NULL) {
            if ($FormData["Add_CourseCat"] == "Save") {
                $inserted = $this->course->save_course_cat($FormData);
                redirect(base_url() . "courses/add_course_cat/" . ($inserted['succ'] ? "0/" . $inserted['_err_codes'] : "1/" . $inserted['_err_codes']));
            }
        }
    }
    function Add_Course_form($error = '', $_err_codes = '') { //provide a view of new course form
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        $data['All_Course_List']= array("0"=>"Parent Select")+$this->course->listConvert($this->course->Course_list_with_child($data['Session_Data']['IBMS_BRANCHID'],0));
        
        //DIE($this->util_model->printr($data['All_Course_List']));
        $data['MonthDay_list'] = array('M' => "Month", 'D' => "Day", 'Y' => "Year");
        $data['CourseCategory'] = $this->util_model->get_list("C_CID", "C_CatCode", DB_PREFIX . 'course_cat_mst', $data['Session_Data']['IBMS_BRANCHID'], 'Sort,C_CatCode');
        $this->load->helper('form'); // Loading Form helper which helps to make form elements
        $attributes = array('role' => 'form', 'class' => 'new_course_form', 'id' => 'course_validation_form'); // extra attributes for form
        $data['attributes'] = $attributes;

        if (!file_exists(APPPATH . '/views/Courses/Add_New_course.php')) {
            show_404();
        }
        $data['title'] = ucfirst("Add New Course |" . SITE_NAME); //capitalizing the first character of string for header.
        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/common_window_pop_up.php');
        $this->load->view("Courses/Add_New_course.php", $data);
        $this->load->view('templates/footer.php');
    }

    public function all_Course_list() {
        global $data;
        $filter_data = array("BranchID"=>$data['Session_Data']['IBMS_BRANCHID']);
        $data['All_Course_List'] = $this->course->all_Course_list($filter_data);
        if (!file_exists(APPPATH . '/views/Courses/All_Course_List.php')) {
            show_404();
        }
        $this->load->view("Courses/All_Course_List.php", $data);
    }
    public function AllCourseListForEnquiry($BranchID,$E_Code,$Visit)
    {
        global $data;
        $data['E_Code'] = $E_Code;
        $data['Visit'] = $Visit;
        $data['All_Course_List'] = $this->course->listConvert($this->course->Course_list_with_child($BranchID, 0));
        $this->load->view('Courses/v-courselist',$data);
    }
    public function course_save() {
        $FormData = $this->input->post();
              $inserted = $this->course->insert_db($FormData);
              redirect(base_url() . "courses/Add_Course_form/" . ($inserted['succ'] ? "0/" . $inserted['_err_codes'] : "1/" . $inserted['_err_codes']));            
    }
    public function course_upd(){
              $FormData = $this->input->post();
              $inserted = $this->course->update_course($FormData);
              redirect(base_url() . "courses/Edit_Course/" .$inserted['CourseID']."/". ($inserted['succ'] ? "0/" . $inserted['_err_codes'] : "1/" . $inserted['_err_codes']));
                  
    } 
    public function Edit_Course($CourseID,$error = '', $_err_codes = '') { //provide a view of new course form
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        $data['MonthDay_list'] = array('M' => "Month", 'D' => "Day", 'Y' => "Year");
        $data['CourseCategory'] = $this->util_model->get_list("C_CID", "C_CatCode", DB_PREFIX . 'course_cat_mst', $data['Session_Data']['IBMS_BRANCHID'], 'Sort,C_CatCode');
        $data['Course_Data'] = $this->course->get_course_details($CourseID);
        $this->load->helper('form'); // Loading Form helper which helps to make form elements
        $attributes = array('role' => 'form', 'class' => 'new_course_form', 'id' => 'course_validation_form'); // extra attributes for form
        $data['attributes'] = $attributes;

        if (!file_exists(APPPATH . '/views/Courses/Add_New_course.php')) {
            show_404();
        }
        $data['All_Course_List']=  array("0"=>"Parent")+$this->course->listConvert($this->course->Course_list_with_child($data['Session_Data']['IBMS_BRANCHID'],0));
        $data['title'] = ucfirst("Add New Course |" . SITE_NAME); //capitalizing the first character of string for header.
        $this->load->view('templates/header.php', $data);
        $this->load->view("Courses/Edit_Course.php", $data);
        $this->load->view('templates/footer.php');
    }

    public function Del_Course($Encoded_CourseCode) {
        if ($this->course->Del_Course($this->util_model->url_decode($Encoded_CourseCode))) {
            redirect(base_url() . "courses/all_Course_list/0/1");
            // passing error alert 0 means no error, 1 means Error
        } else {
            redirect(base_url() . "courses/all_Course_list/1/1");
            // passing error alert 0 means no error, 1 means Error
        }
    }
    
    public function Edit_CourseCat($C_CID){
                  
    }

}
