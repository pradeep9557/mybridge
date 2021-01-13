<?php 

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class c_response extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model("enquiry/m_response");
    }
     function index($error = '', $_err_codes = '') { //provide a view of new response form
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        if (!file_exists(APPPATH . '/views/Enquiry/others/response/v-manage-response.php')) {
            show_404();
        }
        $this->load->view("templates/header", $data);
        $this->load->view("templates/common_window_pop_up");
        $this->load->view("Enquiry/others/response/v-manage-response", $data);
        $this->load->view("templates/footer.php");
    }
    
    // to get all response from the ddatabase
    function all_response_list(){
              global $data;
              $data['all_response_list'] = $this->m_response->get_res_list(array($data['Session_Data']['IBMS_BRANCHID']));
              $this->load->view("Enquiry/others/response/v-all-response", $data);
    }
    
    // form validation
      function formvalidation($POST) {
              $err_codes = '';
              if (!isset($POST['BranchID']) || $POST['BranchID']=="") {
                            $err_codes.='BranchIDEmpty' . ERR_DELIMETER;
              }
              if (!isset($POST['ResponseText']) || $POST['ResponseText']=="") {
                            $err_codes.='Enq_ResBlank' . ERR_DELIMETER;
              }
              
              $valid = $err_codes == '' ? TRUE : FALSE;
              return array("_err" => $valid, "_err_codes" => $err_codes);
              }

    // to save the response
    function save_response(){
        global $data;
        $FormData = $this->input->post();
              $path = base_url()."Enquiry/c_response/index/";
              $validates = $this->formvalidation($FormData); // validating the form
              // die($this->util_model->printr($validates));
              if (!$validates['_err']) {
                   redirect($path . "1/{$validates['_err_codes']}");
              }
              // checking that src_code or src_Name already exits or not
        $src_code_already_exits = $this->util_model->check_aready_exits(DB_PREFIX."e_response_mst",array("ResponseText"=>$FormData['ResponseText'],"BranchID"=>$data['Session_Data']['IBMS_BRANCHID']));
        if ($src_code_already_exits) {
            redirect($path . "1/Rtextalreadyexist".ERR_DELIMETER);
        }
        // end of already checking
              $FormData['Status'] = isset($FormData['Status']);
              $FormData = $this->util_model->add_common_fields($FormData);
              $inserted_enq = $this->m_response->insert_response($FormData);
              if (!$inserted_enq['succ']) {
                   redirect($path . "1/EnqResAddErr" . ERR_DELIMETER);
              }else{
                    redirect($path . "1/EnqResAddSucc");         
              }
    }
    
    // to Edit view form for response
    function vedit_response($rid,$error = '', $_err_codes = '') { 
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        if (!file_exists(APPPATH . '/views/Enquiry/others/response/v-edit-response.php')) {
            show_404();
        }
        $data['res_data'] = $this->m_response->get_res_data($rid);
        $this->load->view("templates/header", $data);
        $this->load->view("templates/common_window_pop_up");
        $this->load->view("Enquiry/others/response/v-edit-response", $data);
        $this->load->view("templates/footer.php");
    }
    // update the response
    function update_response(){
              $FormData = $this->input->post();
              $path = base_url()."Enquiry/c_response/vedit_response/";
              
              // setting flag for status
              $FormData['Status'] = isset($FormData['Status']);
              // for form validation
              $validates = $this->formvalidation($FormData); // validating the form
              // checking its reponse
              if (!$validates['_err']) {
                   redirect($path . "1/{$validates['_err_codes']}");
              }
              // checking about hidden responseid
              if(!isset($FormData['rid'])){
                 redirect(base_url());        
              }
              // retreiving hidden responseid
              $rid = $FormData['rid'];
              // doing unset to rid
              unset($FormData['rid']);
              // adding mode user
              $FormData = $this->util_model->add_mode_user($FormData);
              // calling to model function to update
              //die($this->util_model->printr($FormData));
              $inserted_enq = $this->m_response->response_update($FormData,$rid);
              if (!$inserted_enq['succ']) {
                   redirect($path . "$rid/1/EnqResUpErr" . ERR_DELIMETER);
              }else{
                    redirect($path . "$rid/1/EnqResUpSucc");         
              } 
    }
    
}