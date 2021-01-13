<?php

class c_cdoing extends CI_Controller {

              function __construct() {
                            parent::__construct();
                            $this->load->model('enquiry/m_cdoing');
              }

              function index($error = '', $_err_codes = '') { //provide a view of new city form
                            global $data;
                            $data = $this->util_model->set_error($data, $error, $_err_codes);
                            if (!file_exists(APPPATH . '/views/Enquiry/others/cdoing/v-manage-cdoing.php')) {
                                          show_404();
                            }
                            $this->load->model('enquiry/m_cdoing');
                            $this->load->view("templates/header", $data);
                            $this->load->view("templates/common_window_pop_up", $data);
                            $this->load->view("Enquiry/others/cdoing/v-manage-cdoing", $data);
                            $this->load->view("templates/footer.php");
              }

              //to get all cdoing from the database
              function all_cdoing_list() {
                            global $data;
                            $this->load->model('enquiry/m_cdoing');
                            $data['cdoing_list'] = $this->m_cdoing->get_cdoing_list();
                            $this->load->view("Enquiry/others/cdoing/v-all-cdoing", $data);
              }

              function formvalidation($POST) {
                            $err_codes = '';
                            if (!isset($POST['Code']) || $POST['Code'] == "") {
                                          $err_codes.='cdoingCodeBlank' . ERR_DELIMETER;
                            }

                            $valid = $err_codes == '' ? TRUE : FALSE;
                            return array("_err" => $valid, "_err_codes" => $err_codes);
              }

// to save the current doing
              function save_cdoing() {
                            global $data;
                            $FormData = $this->input->post(); // getting all data from form
                            // die($this->util_model->printr($FormData));
                            $path = base_url() . "Enquiry/c_cdoing/index/";
                            $validates = $this->formvalidation($FormData); // validating the form
                            // die($this->util_model->printr($validates));
                            if (!$validates['_err']) {
                                          redirect($path . "1/{$validates['_err_codes']}");
                            }

                            // checking that src_code or src_Name already exits or not
                            $src_code_already_exits = $this->util_model->check_aready_exits(DB_PREFIX . "current_doing", array("Code" => $FormData['Code'], "BranchID" => $data['Session_Data']['IBMS_BRANCHID']));
                            if ($src_code_already_exits) {
                                          redirect($path . "1/cdoingcodealreadyexist" . ERR_DELIMETER);
                            }
                            // end of already checking
                            $FormData['Status'] = isset($FormData['Status']);
                            $FormData = $this->util_model->add_common_fields($FormData);
                            $this->load->model('enquiry/m_cdoing');
                            $inserted_enq = $this->m_cdoing->insert_cdoing($FormData);
                            if (!$inserted_enq['succ']) {
                                          redirect($path . "1/cdAddErr" . ERR_DELIMETER);
                            } else {
                                          redirect($path . "0/cdAddSucc");
                            }
              }

// to Edit view form for current doing
              function vedit_cdoing($id, $error = '', $_err_codes = '') { //provide a view of new course form
                            global $data;
                            $data = $this->util_model->set_error($data, $error, $_err_codes);
                            if (!file_exists(APPPATH . '/views/Enquiry/others/cdoing/v-edit-cdoing.php')) {
                                          show_404();
                            }
                            $data['cdata'] = $this->m_cdoing->get_cdoing_data($id);
                            $this->load->view("templates/header", $data);
                            $this->load->view("Enquiry/others/cdoing/v-edit-cdoing", $data);
                            $this->load->view("templates/footer.php");
              }

// update the city
              function update_cdoing() {
                            $FormData = $this->input->post();
                            $path = base_url() . "Enquiry/c_cdoing/vedit_cdoing/";

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
                            $inserted_enq = $this->m_cdoing->cdoing_update($FormData, $id);
                            if (!$inserted_enq['succ']) {
                                          redirect($path . "$id/1/EnqConUpErr" . ERR_DELIMETER);
                            } else {
                                          redirect($path . "$id/0/EnqConUpSucc");
                            }
              }

}
