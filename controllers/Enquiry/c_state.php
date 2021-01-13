<?php

class c_state extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('enquiry/m_state');
    }

    function index($error = '', $_err_codes = '') { //provide a view of new state form
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        if (!file_exists(APPPATH . '/views/Enquiry/others/state/v-manage-state.php')) {
            show_404();
        }
        $this->load->model('enquiry/m_state');

        //$this->util_model->printr($data['state_list']);
        $data['country_list'] = $this->util_model->get_list('country_id', 'name', DB_PREFIX . "countries", 0, 'name');
        $this->load->view("templates/header", $data);
        $this->load->view("templates/common_window_pop_up");
        $this->load->view("Enquiry/others/state/v-manage-state", $data);
        $this->load->view("templates/footer.php");
    }

    //to get all states from the database
    function all_states_list() {
        global $data;
        $this->load->model('enquiry/m_state');
        $data['state_list'] = $this->m_state->get_states_list();
        $this->load->view("Enquiry/others/state/v-all-state", $data);
    }

    function formvalidation($POST) {
        $err_codes = '';
        if (!isset($POST['code']) || $POST['code'] == "") {
            $err_codes.='StateCodeBlank' . ERR_DELIMETER;
        }
        if (!isset($POST['name']) || $POST['name'] == "") {
            $err_codes.='StateNameBlank' . ERR_DELIMETER;
        }

        $valid = $err_codes == '' ? TRUE : FALSE;
        return array("_err" => $valid, "_err_codes" => $err_codes);
    }

// to save the state
    function save_state() {
        $FormData = $this->input->post(); // getting all data from form
        // die($this->util_model->printr($FormData));
        $path = base_url() . "Enquiry/c_state/index/";
        $validates = $this->formvalidation($FormData); // validating the form
        // die($this->util_model->printr($validates));
        if (!$validates['_err']) {
            redirect($path . "1/{$validates['_err_codes']}");
        }

        // checking that src_code or src_Name already exits or not
        $src_code_already_exits = $this->util_model->check_aready_exits(DB_PREFIX . "cstates", array("code" => $FormData['code']));
        if ($src_code_already_exits) {
            redirect($path . "1/cstatealreadyexists" . ERR_DELIMETER);
        }
        // end of already checking
        $FormData['Status'] = isset($FormData['Status']);
        $FormData = $this->util_model->add_common_fields($FormData);
        $this->load->model('enquiry/m_state');
        $inserted_enq = $this->m_state->insert_states($FormData);
        if (!$inserted_enq['succ']) {
            redirect($path . "1/EnqstateAddErr" . ERR_DELIMETER);
        } else {
            redirect($path . "0/EnqstateAddSucc");
        }
    }

// to Edit view form for state
    function vedit_state($id, $error = '', $_err_codes = '') { //provide a view of new course form
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        if (!file_exists(APPPATH . '/views/Enquiry/others/state/v-edit-state.php')) {
            show_404();
        }
        $data['sdata'] = $this->m_state->get_states_data($id);
        $data['country_list'] = $this->util_model->get_list('country_id', 'name', DB_PREFIX . "countries", 0, 'name');
        $this->load->view("templates/header", $data);
        $this->load->view("Enquiry/others/state/v-edit-state", $data);
        $this->load->view("templates/footer.php");
    }

// update the state
    function update_state() {
        $FormData = $this->input->post();
        $path = base_url() . "Enquiry/c_state/vedit_state/";

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
        $inserted_enq = $this->m_state->state_update($FormData, $id);
        redirect(base_url() . "Enquiry/c_state/vedit_state/$id/" . (($inserted_enq['succ'] == TRUE) ? "1/" . $inserted_enq['_err_codes'] : "0/" . $inserted_enq['_err_codes']));
    }

}
