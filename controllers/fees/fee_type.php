<?php

if (!defined('BASEPATH'))
              exit('No direct script access allowed');

class fee_type extends CI_Controller {

              function __construct() {
                            parent::__construct();
                            $this->load->model('fee/fee_type_model');
              }

              function index($error = '', $show_error = 0) {
                            global $data;
                            if ($show_error == 1) {
                                          if ($error == 1)
                                                        $data['error'] = TRUE;
                                          else
                                                        $data['error'] = FALSE;
                            }
                            $data['active_deactive'] = $this->util_model->active_deactive();
                            /*
                             * conditions to fetch array */
                            $filter_Data = array("BranchID"=>$data['Session_Data']['IBMS_BRANCHID']);
                            $data['All_Fee_Type_List'] = $this->fee_type_model->all_Fee_Type_list($filter_Data);
                            $data['title'] = ucfirst("Add New Fee |" . SITE_NAME); //capitalizing the first character of string for header.
                            $this->load->view('templates/header.php', $data);
                            $this->load->view('templates/common_window_pop_up.php');
                            $this->load->view("Fee_Type/Add_New_Fee_Type.php", $data);
                            $this->load->view('templates/footer.php');
              }

              public function all_Fee_Type_list($error = '', $show_error = 0) {
                            global $data;
                            if ($show_error == 1) {
                                          if ($error == 1)
                                                        $data['error'] = TRUE;
                                          else
                                                        $data['error'] = FALSE;
                            }
                            
                            /*
                             * conditions to fetch array */
                            $filter_Data = array("BranchID"=>$data['Session_Data']['IBMS_BRANCHID']);
                            
                            $data['title'] = ucfirst("All Fee Type List |" . SITE_NAME);
                            $data['All_Fee_Type_List'] = $this->fee_type_model->all_Fee_Type_list($filter_Data);
                            if (!file_exists(APPPATH . '/views/Fee_Type/All_Fee_Type_List.php')) {
                                          show_404();
                            }
                            // $data['title'] = ucfirst(Add_New_Fee_Type); //capitalizing the first character of string for header.
//        $this->load->view('templates/header.php', $data);
//        $this->load->view('templates/common_window_pop_up.php');
                            $this->load->view("Fee_Type/All_Fee_Type_List.php", $data);
//        $this->load->view('templates/footer.php');
              }

              public function Fee_Type_save_update() {
                            $path = "";
                            $query_result = array();
                            if (isset($_REQUEST['Add_Fee_Type']) && $_REQUEST['Add_Fee_Type'] == "Save") {
                                          $query_result = $this->fee_type_model->Fee_Types_save_update();
                                          $saved_or_updated = $query_result[0];
                                          $path = $saved_or_updated ? "fees/fee_type/index/0/1" : "fees/fee_type/index/1/1";
                            } else if (isset($_REQUEST['Add_Fee_Type']) && $_REQUEST['Add_Fee_Type'] == "Update") {
                                          $query_result = $this->fee_type_model->Fee_Types_save_update();
                                          $saved_or_updated = $query_result[0];
                                          $path = $saved_or_updated ? "fees/fee_type/Edit_FeeType/$query_result[1]/0/1" : "fees/fee_type/Edit_FeeType/$query_result[1]/1/1";
                            } else {
                                          $path = "fees/fee_type/index/1/1";
                            }
                            redirect(base_url() . $path); // passing error alert 0 means no error, 1 means Error
              }

              public function Edit_FeeType($FeeTypeID,$error = '', $show_error = 0) {
                            global  $data;
                            $data['active_deactive'] = $this->util_model->active_deactive();
                            // conditions
                            $filter_data = array("FeeTypeID"=>$FeeTypeID,"BranchID"=>$data['Session_Data']['IBMS_BRANCHID']);
                            $result = $this->fee_type_model->get_feetype_details($filter_data);
                            if($result){
                                     $data['FeeType_Data'] = $result[0];     
                            }
                            $data['FeeTypeID'] = $FeeTypeID;
                            //capitalizing the first character of string for header.
                            $this->load->view('templates/Common_Css_Js_Others_files.php', $data);
                            $this->load->view("Fee_Type/Edit_Fee_Type.php", $data);
                            $this->load->view('templates/footer.php');
              }

//    public function Del_FeeType($Encoded_FeeTypeCode) {
//        if ($this->fee_type_model->Del_FeeType($this->util_model->url_decode($Encoded_FeeTypeCode))) {
//            redirect(base_url() . "fee_type/all_Fee_Type_list/0/1");
//            // passing error alert 0 means no error, 1 means Error
//        } else {
//            redirect(base_url() . "fee_type/all_Fee_Type_list/1/1");
//            // passing error alert 0 means no error, 1 means Error
//        }
//    }
}
