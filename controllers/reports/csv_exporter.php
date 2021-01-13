<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of csv
 * @Created on : Sep 16, 2015, 6:34:34 PM
 * @author Anup kumar
 * @Team NexGen PHP Development Team
 * @copyright (c) year, NexGen Innovators IT Services Pvt. Ltd.
 * @website http://nexgeninnovators.com
 * @location
 * @uses 
 */
class csv_exporter extends CI_Controller {

              // constructor
              public function __construct() {
                            // calling to parent constructor
                            parent::__construct();
                            $this->load->helper("array");
              }

              public function export_all_fee_records() {

                            $this->load->model('fee/fee_collect_model_1');
                            global $data;
                            $POST = $this->input->post();
                            $POST['orderby'] = "fee_trn.ReceiptDate";
                            $POST['order'] = "DESC";
                            $POST["BranchID"] = $data['Session_Data']['IBMS_BRANCHID'];
                            $POST['result_in'] = "array";
                            //$this->util_model->printr($POST);
                            $final_result = array(
                                array("EnrollNo", "Student Name", "Mobile Number", "Fee Type", "Receipt Date", "ReceiptNo", "Previous Balance", "Total Amount", "Discount Amount", "Paid Amount", "Balance Amount", "Added By")
                            );
                            $data['fees_record'] = $this->fee_collect_model_1->get_fee_records($POST);
                            foreach ($data['fees_record'] as $each_record) {
                                          $each_record = $this->util_model->unset_array($each_record, array("FeeTypeID", "Stu_ID"));
                                          $final_result[] = $each_record;
                            }

                            $this->load->library("reports/csv");
                            $this->csv->export_csv(array("report_name" => "Fee_report", "data" => $final_result));
              }

              public function export_search_enq() {
                            global $data;
                            $this->load->model('enquiry/m_enquiry');
                            $POST = $this->input->post();
                            $data['enq_record'] = $this->m_enquiry->search_enq($POST);

                            $final_result = array(
                                array("Enq Code", "Visit", "Enq Form No.", "total_followups", "DOE", "Enquired Course", "EnrollNo", "DOR", "AdmCourse", "SName", "FName", "Mobile", "SourceCat", "Source", "PRO")
                            );

                            foreach ($data['enq_record'] as $each_record) {

                                          $each_record['DOE'] = date(DF, strtotime($each_record['DOE']));
                                          $each_record['DOR'] = date(DF, strtotime($each_record['DOR']));
                                          $final_result[] = elements(array('E_Code', 'Visit', 'EFormNo', 'total_followups', 'DOE', 'enqCourseCode', 'EnrollNo', 'DOR', 'admCourseCode', 'StudentName', 'FatherName', 'Mobile1', 'Src_CatCode', 'Src_Code', 'PRO'), $each_record);
                            }
                            //die($this->util_model->printr($final_result));
                            $this->load->library("reports/csv");
                            $this->csv->export_csv(array("report_name" => "Enquiry_report", "data" => $final_result));
              }

              // start you function from here

              public function export_search_share() {
                            $this->load->model('fee_share/get_share');
                            global $data;
                            $POST = $this->input->post();
                            $data['record'] = $this->get_share->get_faculty_share($POST);

                            //$this->util_model->printr($data['fees_record']);

                            $final_result = array(
                                array("Receipt No", "Receipt Date", "Paid Amount", "Faculty Share", "Weightage", "Faculty Share Amount", "EnrollNo", "Student Name", "Subject", "FacultyCode", "Batch Code", "Mobile Number", "Fee Type", "Added By")
                            );

                            foreach ($data['record'] as $each_record) {
                                          $each_record = $this->util_model->unset_array($each_record, array("ffaID"));
                                          $final_result[] = $each_record;
                            }

                            $this->load->library("reports/csv");
                            $this->csv->export_csv(array("report_name" => "faculty_share_amount", "data" => $final_result));
              }

              public function export_search_adm() {
                            $this->load->model('adm/admission_model', "adm_model");
                            global $data;
                            $POST = $this->input->post();
                            $data['record'] = $this->adm_model->msearch_adm($POST);
                           
                            $final_result = array(
                                array("EnrollNo", "DOR", "admCourseCode", "StudentName", "FatherName", "Mobile Number")
                            );

                            foreach ($data['record'] as $each_record) {
                                          //$each_record['DOR'] = date(DF, strtotime($each_record['DOR']));
                                          $each_record = elements(array("EnrollNo", "DOR", "admCourseCode", "StudentName", "FatherName", "Mobile1"), $each_record);
                                          $final_result[] = $each_record;
                            }
                            //$this->util_mode->printr($data['record']);

                            $this->load->library("reports/csv");
                            $this->csv->export_csv(array("report_name" => "Admission_report", "data" => $final_result));
              }

}
