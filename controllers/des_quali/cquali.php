<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class cquali extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('qualification');
    }

    public function add_qualification($error = '', $show_error = 0) {

        if ($show_error == 1) {
            if ($error == 1)
                $data['error'] = TRUE;
            else
                $data['error'] = FALSE;
        }
        $data['Session_Data'] = $this->session->all_userdata();
        if (!$this->session->userdata('LOGIN_STATUS')) {
            redirect(base_url() . 'auth/login/1/1');
        }
        $data['active_deactive'] = active_deactive();
        $this->load->helper('form'); // Loading Form helper which helps to make form elements
        $attributes = array('class' => 'new_qualification_form', 'id' => 'new_qualification_form'); // extra attributes for form
        $data['attributes'] = $attributes;

        if (!file_exists(APPPATH . '/views/qualification/Add_New_qualification.php')) {
            show_404();
        }
        $data['All_qualification_List'] = $this->qualification->all_qualification_list_from_db();
        $data['title'] = ucfirst("Add New qualification | " . SITE_NAME); //capitalizing the first character of string for header.
        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/common_window_pop_up.php');

        $this->load->view("qualification/Add_New_qualification.php", $data);
        $this->load->view('templates/footer.php');
    }

    public function All_qualification_List($error = '', $show_error = 0) {

        if ($show_error == 1) {
            if ($error == 1)
                $data['error'] = TRUE;
            else
                $data['error'] = FALSE;
        }
        $data['Session_Data'] = $this->session->all_userdata();
        if (!$this->session->userdata('LOGIN_STATUS')) {
            redirect(base_url() . 'auth/login/1/1');
        }
        $data['title'] = ucfirst("All qualification List |" . SITE_NAME);
        $data['All_qualification_List'] = $this->qualification->all_qualification_list_from_db();
        if (!file_exists(APPPATH . '/views/qualification/All_qualification_List.php')) {
            show_404();
        }
        // $data['title'] = ucfirst(Add_New_qualification); //capitalizing the first character of string for header.
        // $this->load->view('templates/header.php',$data);
//                     $this->load->view('templates/common_window_pop_up.php');
        $this->load->view("qualification/All_qualification_List.php", $data);
        //  $this->load->view('templates/footer.php');
    }

    public function qualification_save_update() {
        $path = "";
        $query_result = array();
        if (isset($_REQUEST['Add_qualification']) && $_REQUEST['Add_qualification'] == "Save") {
            $query_result = $this->qualification->qualification_save_update();
            $saved_or_updated = $query_result[0];
            $path = $saved_or_updated ? "cquali/add_qualification/0/1" : "cquali/add_qualification/1/1";
        } else if (isset($_REQUEST['Add_qualification']) && $_REQUEST['Add_qualification'] == "Update") {
            $query_result = $this->qualification->qualification_save_update();
            $saved_or_updated = $query_result[0];
            $path = $saved_or_updated ? "cquali/Edit_qualification/0/1/$query_result[1]" : "cquali/Edit_qualification/1/1/$query_result[1]";
        } else {
            $path = "cquali/add_qualification/1/1";
        }
        redirect(base_url() . $path); // passing error alert 0 means no error, 1 means Error
    }

    public function Edit_qualification($error = '', $show_error = 0, $Encoded_qualificationCode) {

        if ($show_error == 1) {
            if ($error == 1)
                $data['error'] = TRUE;
            else
                $data['error'] = FALSE;
        }
        $data['Session_Data'] = $this->session->all_userdata();
        if (!$this->session->userdata('LOGIN_STATUS')) {
            redirect(base_url() . 'auth/login/1/1');
        }
        $data['active_deactive'] = active_deactive();
        $data['qualification_Data'] = $this->qualification->get_details_from_database($this->util_model->url_decode($Encoded_qualificationCode));
        $this->load->helper('form'); // Loading Form helper which helps to make form elements
        $attributes = array('role' => 'form', 'class' => 'new_qualification_form', 'id' => 'qualification_validation_form'); // extra attributes for form
        $data['attributes'] = $attributes;

        if (!file_exists(APPPATH . '/views/qualification/Edit_qualification.php')) {
            show_404();
        }
        $data['title'] = ucfirst("Edit qualification |" . SITE_NAME);
        //capitalizing the first character of string for header.
        $this->load->view('templates/Common_Css_Js_Others_files.php', $data);

        $this->load->view("qualification/Edit_qualification.php", $data);
        $this->load->view('templates/footer.php');
    }

    public function Del_qualification($Encoded_qualificationCode) {
        if ($this->qualification->Del_qualification($this->util_model->url_decode($Encoded_qualificationCode))) {
            redirect(base_url() . "cquali/All_qualification_List/0/1");
            // passing error alert 0 means no error, 1 means Error
        } else {
            redirect(base_url() . "cquali/All_qualification_List/1/1");
            // passing error alert 0 means no error, 1 means Error
        }
    }

}
