<?php 

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class c_country extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('enquiry/m_country');
    }
    function index($error = '', $_err_codes = '') { //provide a view of new country form
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        if (!file_exists(APPPATH . '/views/Enquiry/others/country/v-manage-country.php')) {
            show_404();
        }
        $this->load->view("templates/header", $data);
        $this->load->view("templates/common_window_pop_up");
        $this->load->view("Enquiry/others/country/v-manage-country", $data);
        $this->load->view("templates/footer");
    }
    function all_country_list(){
        global $data;
        $data['country_list'] = $this->m_country->all_country_list();       
        $this->load->view("Enquiry/others/country/v-all-country", $data);
    }
     
    // form validation
      function formvalidation($POST) {
              $err_codes = '';
              if (!isset($POST['name']) || $POST['name']=="") {
                            $err_codes.='Enq_CouNameBlank' . ERR_DELIMETER;
              }
              
              $valid = $err_codes == '' ? TRUE : FALSE;
              return array("_err" => $valid, "_err_codes" => $err_codes);
              }

    // to save the country
    function save_country(){
              $FormData = $this->input->post(); // getting all data from form
              //die($this->util_model->printr($FormData));
              $path = base_url()."Enquiry/c_country/index/";
              $validates = $this->formvalidation($FormData); // validating the form
              // die($this->util_model->printr($validates));
              if (!$validates['_err']) {
                   redirect($path . "1/{$validates['_err_codes']}");
              }
              $FormData['Status'] = isset($FormData['Status']);
              $FormData = $this->util_model->add_common_fields($FormData);
              $inserted_enq = $this->m_country->insert_country($FormData);
              if (!$inserted_enq['succ']) {
                   redirect($path . "1/EnqConAddErr" . ERR_DELIMETER);
              }else{
                    redirect($path . "0/EnqConAddSucc");         
              }
    }
    
    // to Edit view form for country
    function vedit_country($id,$error = '', $_err_codes = '') { 
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        if (!file_exists(APPPATH . '/views/Enquiry/others/country/v-edit-country.php')) {
            show_404();
        }
        $data['cdata'] = $this->m_country->get_con_data($id);
        $this->load->view("templates/header", $data);
        $this->load->view("templates/common_window_pop_up");
        $this->load->view("Enquiry/others/country/v-edit-country", $data);
        $this->load->view("templates/footer.php");
    }
    // update the country
    function update_country(){
              $FormData = $this->input->post();
              $path = base_url()."Enquiry/c_country/vedit_country/";
              
              // setting flag for status
              $FormData['Status'] = isset($FormData['Status']);
              // for form validation
              $validates = $this->formvalidation($FormData); // validating the form
              // checking its reponse
              if (!$validates['_err']) {
                   redirect($path . "1/{$validates['_err_codes']}");
              }
              // checking about hidden countryid
              if(!isset($FormData['id'])){
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
              $inserted_enq = $this->m_country->country_update($FormData,$id);
//              if (!$inserted_enq['succ']) {
//                   redirect($path . "$id/1/EnqConUpErr" . ERR_DELIMETER);
//              }else{
//                    redirect($path . "$id/0/EnqConUpSucc");         
//              } 
               redirect(base_url() . "Enquiry/c_country/vedit_country/$id/" .(($inserted_enq['succ'] == TRUE) ? "1/" . $inserted_enq['_err_codes'] : "0/" . $inserted_enq['_err_codes']));
    }
    
    
}