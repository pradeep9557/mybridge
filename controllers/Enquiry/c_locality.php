<?php

class c_locality extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('enquiry/locality');
    }

    function index($data='',$error = '', $_err_codes = '') { //provide a view of new city form
        global $data;
       // die($this->util_model->printr($_err_codes));
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        if (!file_exists(APPPATH . '/views/Enquiry/others/locality/v-manage-locality.php')) {
            show_404();
        }
        $data['locality_list'] = $this->util_model->get_list('localityid', 'lcode', DB_PREFIX . "locality", 0, 'Sort,lcode');
        $data['city_list'] = $this->util_model->get_list('city_id', 'citycode', DB_PREFIX . "cities", 0, 'Sort,citycode');
        $this->load->view("templates/header", $data);
        $this->load->view("templates/common_window_pop_up", $data);
        $this->load->view("Enquiry/others/locality/v-manage-locality", $data);
        $this->load->view("templates/footer.php");
    }

    //to get all citys from the database
    function all_localites_list() {
        global $data;
        $this->load->model('enquiry/locality');
        $data['locality_list'] = $this->locality->all_locality_list();
        $this->load->view("Enquiry/others/locality/v-all-locality", $data);
    }

    function formvalidation($POST) {
        $err_codes = '';
        if (!isset($POST['lcode']) || $POST['lcode'] == "") {
            $err_codes.='lcodeeBlank' . ERR_DELIMETER;
        }
        if (!isset($POST['locality']) || $POST['locality'] == "") {
            $err_codes.='localitynameBlank' . ERR_DELIMETER;
        }
        $valid = $err_codes == '' ? TRUE : FALSE;
        return array("_err" => $valid, "_err_codes" => $err_codes);
    }

// to save the locality
    function save_locality() {
        $FormData = $this->input->post(); // getting all data from form
        // die($this->util_model->printr($FormData));
        $path = base_url() . "Enquiry/c_locality/index/";
        $validates = $this->formvalidation($FormData); // validating the form
        // die($this->util_model->printr($validates));
        if (!$validates['_err']) {
            redirect($path . "1/{$validates['_err_codes']}");
        }
        $FormData['Status'] = isset($FormData['Status']);
        $FormData = $this->util_model->add_common_fields($FormData);
        $this->load->model('enquiry/locality');
        $inserted_enq = $this->locality->insert_locality($FormData);
       // die($this->util_model->printr($inserted_enq));
        $id=$inserted_enq ['data'];
        if (!$inserted_enq['succ']) {
            redirect($path ."1/lAddErr" . ERR_DELIMETER);
        } else {
            redirect($path . $id . "/" ."0/lAddSucc");
        }
    }

// to Edit view form for city
    function vedit_locality($id, $error = '', $_err_codes = '') { //provide a view of new course form
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        if (!file_exists(APPPATH . '/views/Enquiry/others/locality/v-edit-locality.php')) {
            show_404();
        }
        $data['ldata'] = $this->locality->get_locality_data($id);
        $data['locality_list'] = $this->util_model->get_list('localityid', 'lcode', DB_PREFIX . "locality", 0, 'Sort,lcode');
        $data['city_list'] = $this->util_model->get_list('city_id', 'citycode', DB_PREFIX . "cities", 0, 'Sort,citycode');
        $this->load->view("templates/header", $data);
        $this->load->view("Enquiry/others/locality/v-edit-locality", $data);
        $this->load->view("templates/footer.php");
    }

// update the locality
    function update_locality() {
        $FormData = $this->input->post();
        $path = base_url() . "Enquiry/c_locality/vedit_locality/";

        // setting flag for status
        $FormData['Status'] = isset($FormData['Status']);
        // for form validation
        $validates = $this->formvalidation($FormData); // validating the form
        //// checking about hidden countryid
        if (!isset($FormData['id'])) {
            redirect(base_url());  //redirect to dashboard      
        }
        // retreiving hidden countryid
        $id = $FormData['id'];
        // checking its reponse
        if (!$validates['_err']) {
            redirect($path .   $id . "/". "1/{$validates['_err_codes']}");
        }
        
        // doing unset to rid
        unset($FormData['id']);
        // adding mode user
        $FormData = $this->util_model->add_mode_user($FormData);
        // calling to model function to update
        //die($this->util_model->printr($FormData));
        $inserted_enq = $this->locality->locality_update($FormData, $id);
        redirect(base_url() . "Enquiry/c_locality/index/" . $id . "/" . (($inserted_enq['succ'] == TRUE) ? "1/" . $inserted_enq['_err_codes'] : "0/" . $inserted_enq['_err_codes']));
    }

}
