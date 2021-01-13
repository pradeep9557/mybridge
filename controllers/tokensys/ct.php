<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ct
 *
 * @author NexGen Development Team
 */
class ct extends CI_Controller {

              //put your code here
              function __construct() {
                            parent::__construct();
                            $this->load->model('tokensys/mtoken');
              }

              function index($error = '', $_err_codes = '') {
                            global $data;
                            $data = $this->util_model->set_error($data, $error, $_err_codes);
                            $data['emp_list'] = $this->util_model->get_list('Emp_ID', 'Emp_Code', DB_PREFIX . "employee", $data['Session_Data']['IBMS_BRANCHID'], 'Emp_Name');
                            $this->load->view('templates/header.php', $data);
                            $this->load->view('tokensys/v-manage-token.php', $data);
                            $this->load->view('templates/footer.php');
              }

              function formvalidation($POST) {
                            $err_codes = '';
                            if (!isset($POST['token_msg']) || $POST['token_msg'] == "") {
                                          $err_codes.='tokenMsgBlank' . ERR_DELIMETER;
                            }
                            if (!isset($POST['nuserid']) || empty($POST['nuserid'])) {
                                          $err_codes.='tokenUserIdblank' . ERR_DELIMETER;
                            }

                            $valid = $err_codes == '' ? TRUE : FALSE;
                            return array("_err" => $valid, "_err_codes" => $err_codes);
              }

              function save_token() {
                            global $data;
                            $path = base_url() . "tokensys/ct/index/";
                            $FormData = $this->input->post();
                            $this->load->helper('array');
                            $validates = $this->formvalidation($FormData); // validating the form
                            // die($this->util_model->printr($validates));
                            if (!$validates['_err']) {
                                          redirect($path . "1/{$validates['_err_codes']}");
                            }
                            // transaction started !!
                            $this->db->trans_begin();
                            $FormData['BranchID'] = $data['Session_Data']['IBMS_BRANCHID'];
                            $FormData = $this->util_model->add_common_fields($FormData);
                            $data_to_insert = elements(array('BranchID','token_msg','Add_User','Add_DateTime','Remarks'), $FormData);
                            //die($this->util_model->printr($data_to_insert));
                            $inserted = $this->mtoken->insert_token($data_to_insert);
                            if($inserted['succ']){
                                  $FormData['token_id'] = $inserted['token_id'];
                                  $inserted_notify_users = $this->mtoken->insert_notify_users($FormData);
                            }
                            
                            if ($this->db->trans_status() === TRUE) {
                                          $this->db->trans_commit();
                                          redirect($path . "0/TokAddSucc");
                            } else {
                                           $this->db->trans_rollback();
                                           log_message("error", "Class " . $this->router->fetch_class() . " Function " . $this->router->fetch_class() . " " . get_err_msg("TokAddErr"));
                                           redirect($path . "1/TokAddErr" . ERR_DELIMETER);
                            }
              }
              
               /*

               * function all_token_list()
               * to diaplay all the dr_type menu list               */
              function token_list() {
                            global $data;
                            $filter_data = array(
                                "BRANCH_ID"=>$data['Session_Data']['IBMS_BRANCHID'],
                                "Add_User"=>array($data['Session_Data']['IBMS_USER_ID'])
                            );
                            $data['token_list'] = $this->mtoken->get_token_list($filter_data);
                            //$this->util_model->printr($data['token_list']);
                            $this->load->view("tokensys/v-all-token.php", $data);
              }

}
