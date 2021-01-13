<?php

class c_city extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('enquiry/m_city');
    }

    function index($error = '', $_err_codes = '') { //provide a view of new city form
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        if (!file_exists(APPPATH . '/views/Enquiry/others/city/v-manage-city.php')) {
            show_404();
        }
        $this->load->model('enquiry/m_city');
        $data['country_list'] = $this->util_model->get_list('country_id', 'name', DB_PREFIX . "countries", 0, 'name');
        $data['state_list'] = $this->util_model->get_list('state_id', 'name', DB_PREFIX . "cstates", 0, 'name');
        $this->load->view("templates/header", $data);
        $this->load->view("templates/common_window_pop_up", $data);
        $this->load->view("Enquiry/others/city/v-manage-city", $data);
        $this->load->view("templates/footer.php");
    }

    //to get all citys from the database
    function all_cities_list() {
        global $data;
        $this->load->model('enquiry/m_city');
        $data['city_list'] = $this->m_city->get_cities_list();
        $this->load->view("Enquiry/others/city/v-all-city", $data);
    }

    function formvalidation($POST) {
        $err_codes = '';
        if (!isset($POST['citycode']) || $POST['citycode'] == "") {
            $err_codes.='cityCodeBlank' . ERR_DELIMETER;
        }

        $valid = $err_codes == '' ? TRUE : FALSE;
        return array("_err" => $valid, "_err_codes" => $err_codes);
    }

// to save the city
    function save_city() {
        $FormData = $this->input->post(); // getting all data from form
        // die($this->util_model->printr($FormData));
        $path = base_url() . "Enquiry/c_city/index/";
        $validates = $this->formvalidation($FormData); // validating the form
        // die($this->util_model->printr($validates));
        if (!$validates['_err']) {
            redirect($path . "1/{$validates['_err_codes']}");
        }
        $FormData['Status'] = isset($FormData['Status']);
        $FormData = $this->util_model->add_common_fields($FormData);
        $FormData['state_id'] = $FormData['C_State'];
        // die($this->util_model->printr($FormData));
        unset($FormData['C_State']);
        $this->load->model('enquiry/m_city');
        $inserted_enq = $this->m_city->insert_city($FormData);
        if (!$inserted_enq['succ']) {
            redirect($path . "1/cityAddErr" . ERR_DELIMETER);
        } else {
            redirect($path . "0/cityAddSucc");
        }
    }

// to Edit view form for city
    function vedit_city($id, $error = '', $_err_codes = '') { //provide a view of new course form
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        if (!file_exists(APPPATH . '/views/Enquiry/others/city/v-edit-city.php')) {
            show_404();
        }
        $data['cdata'] = $this->m_city->get_city_data($id);
        $data['country_list'] = $this->util_model->get_list('country_id', 'name', DB_PREFIX . "countries", 0, 'name');
        $data['state_list'] = $this->util_model->get_list('state_id', 'name', DB_PREFIX . "cstates", 0, 'name');
        $this->load->view("templates/header", $data);
        $this->load->view("Enquiry/others/city/v-edit-city", $data);
        $this->load->view("templates/footer.php");
    }

// update the city
    function update_city() {
        $FormData = $this->input->post();
        $path = base_url() . "Enquiry/c_city/vedit_city/";

        // setting flag for status
        $FormData['Status'] = isset($FormData['Status']);
        // for form validation
        $validates = $this->formvalidation($FormData); // validating the form
        // checking its reponse
        if (!$validates['_err']) {
            redirect($path . "1/{$validates['_err_codes']}");
        }
        // checking about hidden countryid
        if (!isset($FormData['id'])) {
            redirect(base_url());  //redirect to dashboard      
        }
        // retreiving hidden countryid
        $id = $FormData['id'];
        // doing unset to rid
        unset($FormData['id']);
        // adding mode user
        $FormData = $this->util_model->add_mode_user($FormData);
        // calling to model function to update
        //die($this->util_model->printr($FormData));
        $inserted_enq = $this->m_city->city_update($FormData, $id);
        redirect(base_url() . "Enquiry/c_city/vedit_city/$id/" .(($inserted_enq['succ'] == TRUE) ? "1/" . $inserted_enq['_err_codes'] : "0/" . $inserted_enq['_err_codes']));
    }

}
