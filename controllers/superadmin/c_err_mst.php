<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class c_err_mst extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("super-admin/m_err_mst");
    }

    function index($error = '', $_err_codes = '') { //provide a view of error form
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        if (!file_exists(APPPATH . '/views/superadmin/err/v-add-err.php')) {
            show_404();
        }
        $this->load->view("templates/header", $data);
        $this->load->view("templates/common_window_pop_up");
        $this->load->view("superadmin/err/v-add-err.php", $data);
        $this->load->view("templates/footer.php");
    }

    // to get all err from the ddatabase
    function all_err_list() {
        global $data;
        $data['all_err_list'] = $this->m_err_mst->get_err_list();
//        echo '<pre>';
//        print_r($data['all_err_list']);
//        echo '</pre>';
//        die();
        $this->load->view("superadmin/err/v-all-err.php", $data);
    }

    // form validation
    function formvalidation($POST) {
        $err_codes = '';

        if (!isset($POST['ErrCode']) || $POST['ErrCode'] == "") {
            $err_codes.='Enq_ResBlank' . ERR_DELIMETER;
        }
        if (!isset($POST['ErrCodeDes']) || $POST['ErrCodeDes'] == "") {
            $err_codes.='Enq_ResBlank' . ERR_DELIMETER;
        }
        $valid = $err_codes == '' ? TRUE : FALSE;
        return array("_err" => $valid, "_err_codes" => $err_codes);
    }

    // to save the err
    function save_err() {
        $FormData = $this->input->post();
        $path = base_url() . "sp-admin/em/index/";
        $validates = $this->formvalidation($FormData); // validating the form
        // die($this->util_model->printr($validates));
        if (!$validates['_err']) {
            redirect($path . "1/{$validates['_err_codes']}");
        }
        $FormData['Status'] = isset($FormData['Status']);
        $FormData = $this->util_model->add_common_fields($FormData);
        $inserted_enq = $this->m_err_mst->insert_err($FormData);
        if (!$inserted_enq['succ']) {
            redirect($path . "1/EnqResAddErr" . ERR_DELIMETER);
        } else {
            redirect($path . "1/EnqResAddSucc");
        }
    }

    // to Edit view form for err
    function vedit_err($rid, $error = '', $_err_codes = '') { //provide a view of new course form
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);
//        if (!file_exists(APPPATH . 'superadmin/err/v-edit-err')) {
//            show_404();
//        }
        $data['err_data'] = $this->m_err_mst->get_errors($rid);
        $this->load->view("templates/header", $data);
        $this->load->view("superadmin/err/v-edit-err.php", $data);
        $this->load->view("templates/footer.php");
    }

    // update the err
    function update_err() {
        $FormData = $this->input->post();
        $path = base_url() . "superadmin/err/v-edit-err/";

        // setting flag for status
        $FormData['Status'] = isset($FormData['Status']);
        // for form validation
        $validates = $this->formvalidation($FormData); // validating the form
        // checking its reponse
        if (!$validates['_err']) {
            redirect($path . "1/{$validates['_err_codes']}");
        }
        // checking about hidden errid
        if (!isset($FormData['ERRID'])) {
            redirect(base_url());
        }
        // retreiving hidden errid
        $errid = $FormData['ERRID'];
        // doing unset to rid
        unset($FormData['ERRID']);
        // adding mode user
        $FormData = $this->util_model->add_mode_user($FormData);
        // calling to model function to update
        //die($this->util_model->printr($FormData));
        $inserted_enq = $this->m_err_mst->err_update($FormData, $errid);
        if (!$inserted_enq['succ']) {
             redirect($path . "1/EnqResUpSucc");
            
        } else {
           redirect($path . "0/EnqResUpErr" . ERR_DELIMETER);
        }
    }

}
