<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  Controller class for c_batch purpose
 *  It'll handle all batch status process, add, delete, update etc.
 *  */

class c_bstatus extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("batch/m_bstatus");
    }

    //provide a view of new batch form
    function index($error = '', $_err_codes = '') {
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        if (!file_exists(APPPATH . '/views/Batches/BatchStatus/v-add-bstatus.php')) {
            show_404();
        }
        $this->load->view("templates/header", $data);
        $this->load->view("templates/common_window_pop_up");
        $this->load->view("Batches/BatchStatus/v-add-bstatus.php", $data);
        $this->load->view("templates/footer.php");
    }

    // form validation
    function formvalidation($POST) {
        $err_codes = '';
        if (!isset($POST['BranchID']) || $POST['BranchID'] == "") {
            $err_codes.='BranchIDEmpty' . ERR_DELIMETER;
        }
        if (!isset($POST['BatchStatus']) || $POST['BatchStatus'] == "") {
            $err_codes.='Bat_StaBlank' . ERR_DELIMETER;
        }
       

        $valid = $err_codes == '' ? TRUE : FALSE;
        return array("_err" => $valid, "_err_codes" => $err_codes);
    }

    // to get all batch from the ddatabase
    function all_batchstatus_list() {
        global $data;
       
        $filter_data  = array("branch_ids"=>array($data['Session_Data']['IBMS_BRANCHID']));
        $data['all_batch_list'] = $this->m_bstatus->get_batchstatus_list($filter_data);
        $this->load->view("Batches/BatchStatus/v-all-bstatus.php", $data);
    }
    
    

    // to save the batch
    function save_batchstatus() {
        $FormData = $this->input->post();
        $path = base_url() . "batch/c_bstatus/index/";
        $validates = $this->formvalidation($FormData); // validating the form
        // die($this->util_model->printr($validates));
        if (!$validates['_err']) {
            redirect($path . "1/{$validates['_err_codes']}");
        }
        $FormData['Status'] = isset($FormData['Status']);
        $FormData = $this->util_model->add_common_fields($FormData);
        $inserted_enq = $this->m_bstatus->insert_batchstatus($FormData);
        if (!$inserted_enq['succ']) {
            redirect($path . "1/EnqResAddErr" . ERR_DELIMETER);
        } else {
            redirect($path . "0/EnqResAddSucc");
        }
    }

    function vedit_batchstatus($rid, $error = '', $_err_codes = '') { //provide a view of edit form
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);
//        if (!file_exists(APPPATH . 'Batches/BatchStatus/v-edit-bstatus')) {
//            show_404();
//        }
        $data['bth_data'] = $this->m_bstatus->get_batchstatus_data($rid);
        $this->load->view("templates/header", $data);
        $this->load->view("templates/common_window_pop_up");
        $this->load->view("Batches/BatchStatus/v-edit-bstatus", $data);
        $this->load->view("templates/footer.php");
    }

    // update the Batch 
    function update_batchstatus() {
        $FormData = $this->input->post();
        $path = base_url() . "batch/c_bstatus/vedit_batchstatus/";

        // setting flag for status
        $FormData['Status'] = isset($FormData['Status']);
        // for form validation
        $validates = $this->formvalidation($FormData); // validating the form
        // checking its reponse
        if (!$validates['_err']) {
            redirect($path . "1/{$validates['_err_codes']}");
        }
        // checking about hidden batchstatusid
        if (!isset($FormData['rid'])) {
            redirect(base_url());
        }
        // retreiving hidden batchstatusid
        $rid = $FormData['rid'];
        // doing unset to rid
        unset($FormData['rid']);
        // adding mode user
        $FormData = $this->util_model->add_mode_user($FormData);
        // calling to model function to update
        //die($this->util_model->printr($FormData));
        $inserted_enq = $this->m_bstatus->batchstatus_update($FormData, $rid);
        if (!$inserted_enq['succ']) {
            redirect($path . "$rid/1/EnqResUpErr" . ERR_DELIMETER);
        } else {
            redirect($path . "$rid/1/EnqResUpSucc");
        }
    }

}
