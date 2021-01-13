<?php

if (!defined('BASEPATH'))
              exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of source
 *
 * @author kuldeep
 */
class source extends CI_Controller {

              //put your code here
              public function __construct() {
                            parent::__construct();

                            $this->load->model('enquiry/m_source');
              }

              public function index($error = '', $_err_codes = '') { //provide a view of sourse form
                            global $data;
                            $data = $this->util_model->set_error($data, $error, $_err_codes);
                            $data['SourceList'] = $this->m_source->ShowSourceTable(array($data['Session_Data']['IBMS_BRANCHID']));
                            $data['Parent'] = $this->m_source->showParentList($data['Session_Data']['IBMS_BRANCHID']);
                            $this->load->view('templates/header.php', $data);
                            $this->load->view('templates/common_window_pop_up.php');
                            $this->load->view('Enquiry/source/v-add-source');
                            $this->load->view('templates/footer.php');
              }

              private function check_sourceform_validation($POST) {
                            $err_codes = '';
                            if (!isset($POST['Src_Name']) || $POST['Src_Name'] == '') {
                                          $err_codes.='Src_NameBlank' . ERR_DELIMETER;
                            }
                            if (!isset($POST['Src_Code']) || $POST['Src_Code'] == '') {
                                          $err_codes.='Src_CodeBlank' . ERR_DELIMETER;
                            }
                            $valid = $err_codes == '' ? TRUE : FALSE;
                            return array("_err" => $valid, "_err_codes" => $err_codes);
              }

              public function AddSource() {
                            global $data;
                            $path = base_url() . "Enquiry/source/index/";
                            $FormData = $this->input->post();
                            $validates = $this->check_sourceform_validation($FormData); // validating the form
                            // die($this->util_model->printr($validates));
                            if (!$validates['_err']) {
                                          redirect($path . "1/{$validates['_err_codes']}");
                            }
                            // checking that src_code or src_Name already exits or not
                            $src_code_already_exits = $this->util_model->check_aready_exits(DB_PREFIX . "e_source_mst", array("Src_Code" => $FormData['Src_Code'], "Parent" => $FormData['Parent'], "BranchID" => $data['Session_Data']['IBMS_BRANCHID']));
                            if ($src_code_already_exits) {
                                          redirect($path . "1/srcCodealreadyexist" . ERR_DELIMETER);
                            }
                            $src_Src_Name_already_exits = $this->util_model->check_aready_exits(DB_PREFIX . "e_source_mst", array("Src_Name" => $FormData['Src_Name'], "Parent" => $FormData['Parent'], "BranchID" => $data['Session_Data']['IBMS_BRANCHID']));
                            if ($src_Src_Name_already_exits) {
                                          redirect($path . "1/srcNamealreadyexist" . ERR_DELIMETER);
                            }
                            // end of already checking
                            if (isset($FormData['source_submit'])) {
                                          unset($FormData['source_submit']);
                                          if ($this->m_source->AddSource($FormData)) {
                                                        redirect($path . "0/SrcAddSucc");
                                          } else {
                                                        redirect($path . "1/SrcAddErr" . ERR_DELIMETER);
                                          }
                            }
                            $this->index();
              }

              public function showParentList($BranchID = 0, $Parent = 0, $field_name) {
                            $data['field_name'] = $field_name;
                            $data['Parent'] = $this->m_source->showParentList($BranchID, $Parent);
                            $this->load->view('Enquiry/source/parent_select', $data);
              }

              public function EditSource() {
                            $Src_id = '';
                            $path = base_url() . "Enquiry/source/getDataForUpdate/";
                            $FormData = $this->input->post();
                            $validates = $this->check_sourceform_validation($FormData); // validating the form
                            // die($this->util_model->printr($validates));
                            // end of already checking
                            if (isset($FormData['source_submit'])) {
                                          // print_r($FormData);
                                          unset($FormData['source_submit']);
                                          $Src_id = $FormData['Src_Id'];
                                          unset($FormData['Src_Id']);
                                          $FormData['Status'] = isset($FormData['Status']);
                                          if ($this->m_source->EditSource($FormData, $Src_id)) {
                                                        redirect($path . $Src_id . "/0/SrcUpSucc");
                                          } else {
                                                        redirect($path . $Src_id . "/1/SrcUpErr" . ERR_DELIMETER);
                                          }
                            }
              }

              public function deleteSource($SrcId) {
                            if ($this->m_source->deleteSource($SrcId)) {
                                          echo json_encode(array('success' => TRUE));
                            } else {
                                          echo json_encode(array('success' => FALSE));
                            }
              }

              public function getDataForUpdate($SrcId, $error = '', $_err_codes = '') {
                            global $data;
                            $data = $this->util_model->set_error($data, $error, $_err_codes);
                            $data['SourceList'] = $this->m_source->ShowSourceTable();



                            $data['Parent'] = $this->m_source->showParentList(1);
                            $data['SourceData'] = $this->m_source->SourceData($SrcId);
                            // to remove itself from the parent menu !!
                            if (isset($data['Parent'][$SrcId])) {
                                          unset($data['Parent'][$SrcId]);
                            }
                            $this->load->view('templates/header', $data);
                            $this->load->view('Enquiry/source/v-edit-source', $data);
                            $this->load->view('templates/footer');
              }

              public function ChangeParent() {
                            
              }

}
