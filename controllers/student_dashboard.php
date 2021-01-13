<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class student_dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function view($path = 'Students_details', $page = 'student_dashboard') {
        global $data;
        if (!file_exists(APPPATH . '/views/' . $path . '/' . $page . '.php')) {
            show_404();
        }
        $this->load->helper('form'); // Loading Form helper which helps to make form elements
        $attributes = array('class' => 'new_addmission_form', 'id' => 'new_addmission_form'); // extra attributes for form
        $data['attributes'] = $attributes;
        //common class for all form element of bootstrap
        $this->load->model('adm/admission_model');
        $admi_data = $this->admission_model->get_details_from_database($data['Session_Data']['IBMS_USER_ID_Stu_ID']);
        $data['admission_data'] = $admi_data[0];
        $data['pass'] = $admi_data[1];
        $EnrollNo = $admi_data[0]->EnrollNo;
        $data['all_stu_scnb_details'] = $this->admission_model->get_details_from_scnb_table($EnrollNo);
        $this->load->model('fee/fee_collect_model');
        $data['fee_record'] = $this->fee_collect_model->all_fee_records($EnrollNo);
        $data['Fee_Plan'] = $this->fee_collect_model->All_fee_plan_of_student($EnrollNo, $data['all_stu_scnb_details'][0]->CourseCode);
        $data['title'] = ucfirst($page . " | " . SITE_NAME); //capitalizing the first character of string for header.
        $this->load->view('templates/Student_header.php', $data);
        $this->load->view('templates/common_window_pop_up.php');
        $this->load->view('Students_details/student_details.php', $data);
        $this->load->view('templates/footer.php');
    }

}
