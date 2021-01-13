<?php

class c_share extends CI_Controller {

              public function __construct() {
                            parent::__construct();
                            $this->load->model('fee_share/get_share');
                            $this->load->model('fee/fee_collect_model_1');
              }

              public function index($error = '', $_err_codes = '') {
                            global $data;

                            //$data = $this->util_model->set_error($data, $error, $_err_codes);
                            //$filter_data = array('BranchID' => $data['Session_Data']['IBMS_BRANCHID']);
                            //$data['share_data'] = $this->get_share->get_share_info($filter_data);
                            //$this->util_model->printr($data['share_data']);
                            $this->load->library("ajax/search");
                            $data['fee_search_template'] = $this->search->faculty_account_search();
                            $this->load->view('templates/header.php', $data);
                            $this->load->view('fee_share/all_faculty_share_record', $data);
                            $this->load->view('templates/footer.php');
              }

              // calcuate faculty share
              public function calculate_faculty_share() {
                            global $data;
                            $POST = $this->input->post();
                            $POST['orderby'] = "fee_trn.ReceiptDate";
                            $POST['order'] = "DESC";
                            $POST["BranchID"] = $data['Session_Data']['IBMS_BRANCHID'];
                            $POST['amount_shared'] = "not-calculated";
                            $POST['result_in'] = "array";
                            ///$this->util_model->printr($POST);
                            $data['fees_record'] = $this->fee_collect_model_1->get_fee_records($POST);
                            $final_result = array(
                                array("EnrollNo", "Student Name", "Mobile Number", "Fee Type", "ReceiptNo", "Previous Balance", "Total Amount", "Discount Amount", "Paid Amount", "Balance Amount", "Added By", "Succ", "Error Message")
                            );
                            foreach ($data['fees_record'] as $each_record) {
                                          $result = $this->enter_receipt_share($each_record);
                                          $each_record["success"] = $result['succ'] ? "Success" : "Error";
                                          $each_record["err_code"] = $result['_err_codes'];
                                          $each_record = $this->util_model->unset_array($each_record, array("FeeTypeID", "Stu_ID"));
                                          $final_result[] = $each_record;
                            }
                            $this->load->library("reports/csv");
                            $this->csv->export_csv(array("report_name" => "fee_report_share_report", "data" => $final_result));
                            //$this->util_model->printr($data['fees_record']);
              }

              /*

               * It would set faculty share of individual recipt
               * Need to pass receiptNo               */

              public function enter_receipt_share($FormData) {
                            //inserting data into nexgen_fee_faculty_account
                            $this->load->model('adm/admission_model', "adm_model");
                            /*
                             * get faculty share data from fee_course_indvidual_share */
                            $faculty_share_filter = array("Stu_ID" => $FormData['Stu_ID'], "Status" => TRUE);
                            $faculty_course_share = $this->adm_model->indi_faculty_share($faculty_share_filter);

                            $all_facutly_set = TRUE;
                            // checking if there is any facultyID which is null
                            //  .. means course code haven't setted yet
                            foreach ($faculty_course_share as $each_row) {
                                          if ($each_row->FacultyID == NULL) {
                                                        $all_facutly_set = FALSE;
                                          }
                            }
                            if ($all_facutly_set) {
                                          $this->db->trans_begin();
                                          $data_to_insert = array();
                                          foreach ($faculty_course_share as $each_row) {
                                                        $temp_row = array();
                                                        $temp_row["ReceiptNo"] = $FormData['ReceiptNo'];
                                                        $temp_row["FacultyID"] = $each_row->FacultyID;
                                                        $temp_row["CourseID"] = $each_row->CourseID;
                                                        $temp_row["FacultyShare"] = $each_row->FacultyShare;
                                                        $temp_row["Weightage"] = $each_row->Weightage;
                                                        $data_to_insert[] = $this->util_model->add_common_fields($temp_row);
                                          }

                                          if (!$this->util_model->insert_data(DB_PREFIX . "fee_faculty_account", $data_to_insert, TRUE)) {
                                                        $this->db->trans_rollback();
                                                        return array("succ" => FALSE, "_err_codes" => "ErrStuFacultyShareSavedErr");
                                          } else {
                                                        if (!$this->db->update(DB_PREFIX . "fee_trn", array("amount_shared" => TRUE), array("ReceiptNo" => $FormData['ReceiptNo']))) {
                                                                      $this->db->trans_rollback();
                                                                      return array("succ" => FALSE, "_err_codes" => "ErrStuFacultyShareSavedErr");
                                                        }
                                          }
                                          return array("succ" => TRUE, "_err_codes" => "AmountSharedSuccessfully");
                            } else {

                                          return array("succ" => FALSE, "_err_codes" => "FacultyShareNotSetted");
                            }
              }

              function search_share() {
                            global $data;
                            $POST = $this->input->post();
                            $POST['Status'] = TRUE;
                            $data['record'] = $this->get_share->get_faculty_share($POST);
                            //$this->util_model->printr($data['record']);              
                            $this->load->view("fee_share/share_history.php", $data);
              }

}
