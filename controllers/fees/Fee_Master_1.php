<?php

/*
  @auther Anup kumar
 * This class is a controller having following function
 * 1.Print_Fee($Receipt_Number),
 * 2.save_update_fee_plan() // taking data from $_POST to save fee plan
 * 3.Update_fee_plan($Fee_Plan_ID,$error = '', $show_error = 0)
 * 4.set_fee_plan($error = '', $show_error = 0, $EnrollNo = '', $Encoded_CourseCode = '') 
 *   // it will open the form of setup fee plan which will show all fee plan and form to add more
 * 5.Fee_Edit($error = '', $show_error = 0,$ID) // here $ID is receipt no.
 * 6.index($error = '', $show_error = 0, $EnrollNo = '', $CourseCode = '');
 * // fee collection form , you can get fee form using only EnrollNo.
 * 7.set_fee_form_data_for_help($EnrollNo, $CourseCode);
 * // this funciton helping to make array to insert fee and update fee for above function.
 * 8. all_fees_record($error = '', $show_error = 0);
 * 9. Get_Last_Fee_Record($EnrollNo, $CourseCode = '')
 * 10. Fee_collect_save_update() // taking data from $_POST
 * 11. Del_Fee_plan($ID, $EnrollNo, $CourseCode); 
 *     // If there will be any fee taken from  this fee plan it will not allow
 * 12. Del_Fee_record($ID, $EnrollNo); 
 * 
 * 12 and 5 is not working .. Under construction
 *  */
if (!defined('BASEPATH'))
              exit('No direct script access allowed');

class Fee_Master_1 extends CI_Controller {

              function __construct() {
                            parent::__construct();
                            $this->load->model('adm/admission_model');
                            $this->load->model('fee/fee_collect_model_1');
              }

              /*

               * set_course_fee_plan scfp();
               * it would need just courseid
               * it contain a form for a fixed fee plan */

//              function scfp($CourseID = '', $error = '', $_err_codes = '') {
//                            global $data;
//                            $data = $this->util_model->set_error($data, $error, $_err_codes);
//                            if ($CourseID == "") {
//                                          $CourseID = $this->input->post('CourseID');
//                            }
//                            // echo $this->input->post('CourseID'); 
//                            $this->load->model(array('courses/course'));
//                            $data['All_Course_List'] = $this->course->listConvert($this->course->Course_list_with_child($data['Session_Data']['IBMS_BRANCHID'], 0));
//                            $data['CourseCode'] = $this->util_model->get_a_column_value('CourseCode', DB_PREFIX . 'course_mst', array("CourseID" => $CourseID, "BranchID" => $data['Session_Data']['IBMS_BRANCHID']));
//                            $data['Package_List'] = $this->util_model->get_list("PackageID", "PackageCode", DB_PREFIX . 'fee_planpackages', $data['Session_Data']['IBMS_BRANCHID'], 'PackageCode');
//                            $data['FeeTypeID'] = $this->util_model->get_list("FeeTypeID", "FeeType_Code", DB_PREFIX . 'fee_type_mst', $data['Session_Data']['IBMS_BRANCHID'], 'Sort,FeeType_Code');
//                            // previouse fee plan fiters
//                            $filter_data = array();
//                            $filter_data['CourseID'] = array($CourseID);
//                            $filter_data['BranchID'] = array($data['Session_Data']['IBMS_BRANCHID']);
//                            $filter_data['orderby'] = "Sort,CourseID,PackageID";
//                            // end of filter
//                            // fetching previouse course fee plan
//                            $data['all_cfp'] = $this->all_cfp($filter_data);
//                            // end of fetching
//                            $data['CourseID'] = $CourseID;
//
//                            $this->load->view('templates/header.php', $data);
//                            $this->load->view('templates/common_window_pop_up.php', $data);
//                            $this->load->view('Fee_collect/cfp/v-set-cfp.php', $data);
//                            $this->load->view('templates/footer.php');
//              }

              /*

               * this function will return the all course fee plan view               */

//              function all_cfp($filter_data = array()) {
//                            global $data;
//                            if (empty($filter_data)) {
//                                          $filter_data['BranchID'] = array($data['Session_Data']['IBMS_BRANCHID']);
//                                          $filter_data['orderby'] = "Sort,CourseID,PackageID";
//                            }
//                            $data['cfp'] = $this->fee_collect_model_1->get_all_course_fee_plan($filter_data);
//                            return $this->load->view('Fee_collect/cfp/all-cfp.php', $data, true);
//              }
//              function cfp_validation($POST) {
//                            $err_codes = '';
//                            //die($this->util_model->printr($POST));
//                            if (!isset($POST['PackageID']) || empty($POST['PackageID'])) {
//                                          $err_codes.='cfp_PackageIDblank' . ERR_DELIMETER;
//                            }
//                            if (!isset($POST['CourseID']) || empty($POST['CourseID'])) {
//                                          $err_codes.='cfp_CourseIDblank' . ERR_DELIMETER;
//                            }
//                            if (!isset($POST['FeeTypeID']) || empty($POST['FeeTypeID'])) {
//                                          $err_codes.='cfp_FeeTypeIDblank' . ERR_DELIMETER;
//                            }
//
//
//                            $_err_flag = FALSE;
//                            foreach ($POST['Inst_amt'] as $t_inst) {
//                                          if ($t_inst == "") {
//                                                        $_err_flag = TRUE;
//                                          }
//                            }
//                            if ($_err_flag) {
//                                          $err_codes.='cfp_Inst_amtblank' . ERR_DELIMETER;
//                            }
//
//                            $_err_flag = FALSE;
//                            foreach ($POST['Total_Inst'] as $t_inst) {
//                                          if ($t_inst == "") {
//                                                        $_err_flag = TRUE;
//                                          }
//                            }
//                            if ($_err_flag) {
//                                          $err_codes.='cfp_Total_Instblank' . ERR_DELIMETER;
//                            }
//
//                            $valid = $err_codes == '' ? TRUE : FALSE;
//                            return array("_err" => $valid, "_err_codes" => $err_codes);
//              }

              /*

               * save_cfp() save course fee plan
               *                */

//              function save_cfp() {
//                            $FormData = $this->input->post();
//                            //die($this->util_model->printr($FormData));
//                            $CourseID = isset($FormData['CourseID']) ? $FormData['CourseID'][0] : 0; // CourseID to return on same form 
//                            $path = "fees/Fee_Master/scfp/" . $CourseID . "/";
//
//                            $validates = $this->cfp_validation($FormData); // validating the form
//                            // die($this->util_model->printr($validates));
//                            if (!$validates['_err']) {
//                                          redirect($path . "1/{$validates['_err_codes']}");
//                            }
//
//                            if ($FormData != NULL) {
//                                          if ($FormData["save_scfp"] == "Save") {
//                                                        $inserted = $this->fee_collect_model_1->insert_cpf($FormData);
//                                                        redirect(base_url() . $path . ($inserted['succ'] ? "0/" . $inserted['_err_codes'] : "1/" . $inserted['_err_codes']));
//                                          }
//                            }
//                            echo "Bad required ";
//              }

              /*
               * main Page to take fees
               *  */

              function index($Stu_ID = 0, $FeeTypeID = 0, $error = '', $_err_codes = '') {
                            global $data;
                            $data = $this->util_model->set_error($data, $error, $_err_codes);

                            $data['EnrollNo'] = "";
                            $data['Fee_Plan'] = array();
                            $data['due_day'] = 0;
                            $data['Stu_ID'] = $Stu_ID;
                            $data['FeeTypeID'] = $FeeTypeID;
                            $data['stu_Courses'] = array();

                            // if stu_id and course is coming from form
                            if ($Stu_ID == 0 && $FeeTypeID == 0) {
                                          //$this->util_model->printr($this->input->post());
                                          $data['Stu_ID'] = $this->input->post('Stu_ID');
                                          $data['FeeTypeID'] = $this->input->post('FeeTypeID');
                            }
                            $Stu_ID = $data['Stu_ID'];
                            $FeeTypeID = $data['FeeTypeID'];


                            $this->load->model(array('enquiry/locality', 'courses/course', 'super-admin/usertypes_model'));
                            /*

                             * Admission searching template */
                            $data['All_Course_List'] = $this->course->listConvert($this->course->Course_list_with_child($data['Session_Data']['IBMS_BRANCHID'], 0));
                            $data['locality_list'] = $this->locality->AllLocality(0, $data['Branch_obj']->Locality);

                            $data['AdmSearch_List'] = array(
                                "Mob1" => "Mobile",
                                "Name" => "StudentName",
                                "FName" => "FatherName",
                                "Email1" => "Email1",
                                "EnrollNo" => "EnrollNo",
                                "Stu_ID" => "Student ID");
                            $data['collapse'] = "collapse";
                            $data['adm_search_template'] = $this->load->view('Admission/search/v-search-adm.php', $data, true);
                            // end of searching template
                            /*

                             * end of admission searching template                             */




                            // to get fee plan has already set or not
                            if ($Stu_ID != 0 && $FeeTypeID != 0) {
                                          $data['EnrollNo'] = $this->util_model->get_a_column_value("EnrollNo", DB_PREFIX . "stu_mst", array("Stu_ID" => $Stu_ID));
                                          $filter = array(
                                              "search_via" => array("Stu_ID"),
                                              "adv_search" => "adv_search",
                                              "search_via_value" => array($Stu_ID)
                                          );
                                          //die($this->util_model->printr($filter));
                                          //$s_courses = $this->admission_model->msearch_adm($filter);
                                          //$this->util_model->printr($s_courses);
                                          // if user id and course doen't found !!
//                                          if (empty($s_courses))
//                                             redirect(base_url() . "fees/Fee_Master/index/0/0/1/RecNotFound" . ERR_DELIMETER);
                                          //$this->util_model->printr($s_courses);
//                                          $data['due_day'] = $s_courses[0]['due_day'];
                                          if (!$this->fee_collect_model_1->is_record_exits_in_fee_plan_table($Stu_ID)) {
                                                        redirect(base_url() . "fees/Fee_Master_1/sscfp/" . $Stu_ID . "/" . $FeeTypeID);
                                          }

                                          $this->load->model('adm/admission_model');
                                          $courses_result = $this->admission_model->get_student_courses($Stu_ID, 1);
                                          $final_course_list = array();
                                          if (!empty($courses_result)) {
                                                        foreach ($courses_result as $c_row) {
                                                                      $final_course_list[$c_row->CourseID] = $c_row->CourseCode;
                                                        }
                                          }
                                          // $this->util_model->printr($final_course_list);
                                          $data['stu_Courses'] = $final_course_list;
                                          $data['stu_fee_plan'] = $this->show_stu_fee_plan($Stu_ID);
                                          $fee_record_filter_data = array(
                                              "Stu_ID" => $Stu_ID,
                                              "Status" => TRUE,
                                              "BranchID" => $data['Session_Data']['IBMS_BRANCHID'],
                                              "orderby" => "fee_trn.Stu_ID,fee_trn.CourseID,fee_trn.FeeTypeID"
                                          );
                                          $data['last_fee_record'] = $this->show_fees_record($fee_record_filter_data);
                            }

                            // drop down list
                            //$data['due_days'] = $this->util_model->get_list("due_day", "due_day", DB_PREFIX . "fee_due_days", $data['Session_Data']['IBMS_BRANCHID'], $sort_col = 'due_day');
                            $data['fac_list'] = array("" => "Select Faculty Code") + $this->util_model->get_list("Emp_ID", "Emp_Code", DB_PREFIX . "employee", $data['Session_Data']['IBMS_BRANCHID'], $sort_col = 'Emp_Code', TRUE, 1, " UTID=" . $data['Branch_obj']->FacultyCode);
                            $data['fac_batch_list'] = array("" => "Select Batch Code") + $this->util_model->get_list("BatchID", "BatchCode", DB_PREFIX . "batch_master", $data['Session_Data']['IBMS_BRANCHID'], $sort_col = 'BatchCode', TRUE, 1);
                            $data['paid_mode'] = $this->util_model->get_list("Paid_ModeID", "Paid_ModeCode", DB_PREFIX . "fee_paidmode_mst", 0, $sort_col = 'Paid_ModeCode');
                            $data['FeeTypeID_list'] = $this->util_model->get_list("FeeTypeID", "FeeType_Code", DB_PREFIX . 'fee_type_mst', $data['Session_Data']['IBMS_BRANCHID'], 'Sort,FeeType_Code');
                            // month  drop down list
                            $month_result = $this->util_model->all_month_list();
                            $data['Month_list'] = $month_result[0];
                            $data['c_month'] = $month_result[1];

                            $data['FeeTypeID'];
                            $help_data = $this->set_fee_form_data_for_help($Stu_ID, $data['FeeTypeID']);
                            $data['Form_Field_Value'] = $help_data;
                            //$this->util_model->printr($data['Form_Field_Value']);
                            $data['Fully_Paid'] = FALSE;

                            if ($this->fee_collect_model_1->check_fully_paid($Stu_ID)) {
                                          $data['Fully_Paid'] = TRUE;
                            }


                            if (!file_exists(APPPATH . '/views/Fee_collect/Fee_Collect_1/Fees_Collect_Form.php')) {
                                          show_404();
                            }

                            $this->load->view('templates/header.php', $data);
                            $this->load->view('templates/common_window_pop_up.php', $data);
                            $this->load->view("Fee_collect/Fee_Collect_1/Fees_Collect_Form.php", $data);
                            $this->load->view("Fee_collect/Fee_Collect_1/fee_collect_js.php", $data);
                            $this->load->view('templates/footer.php');
                            // fee history option

                            $this->load->view("Fee_collect/scfp_1/fee_history_icon.php", $data);
              }

              /*

               *   Fee_Edit($Receipt_no) 
               * Used to edit fees             */

              function Fee_Edit($ReceiptNo, $error = '', $_err_codes = '') {
                            //echo $ReceiptNo;
                            if (!isset($ReceiptNo)) {
                                          die($this->util_model->get_err_msg("receiptNoNotDefined"));
                            }
                            global $data;
                            $data = $this->util_model->set_error($data, $error, $_err_codes);
                            // where condition
                            $filter_data = array("ReceiptNo" => $ReceiptNo);
                            // fetching data
                            $data['receipt_data'] = $this->util_model->check_aready_exits(DB_PREFIX . "fee_trn", $filter_data, TRUE);
                            if (empty($data['receipt_data'][0])) {
                                          die($this->util_model->get_err_msg("receiptNoNotFound"));
                            }
                            // receipt cancelled checking
                            if (!$data['receipt_data'][0]->Status) {
                                          die($this->util_model->get_err_msg("receiptCancelled"));
                            }

                            //$this->util_model->printr($data['receipt_data']);
                            $data['Form_Field_Value'] = array();
                            $data['Stu_ID'] = $data['receipt_data'][0]->Stu_ID;
                            $data['CourseID'] = $data['receipt_data'][0]->CourseID;
                            $Stu_ID = $data['receipt_data'][0]->Stu_ID;
                            $CourseID = $data['receipt_data'][0]->CourseID;
                            $data['FeeTypeID'] = $data['receipt_data'][0]->FeeTypeID;
                            $data['Form_Field_Value']['Total_Paid_Amt'] = $this->fee_collect_model_1->total_installments_amount($Stu_ID);

                            $data['Form_Field_Value']['ReceiptNo'] = $ReceiptNo;
                            // to get fee plan has already set or not
                            if ($Stu_ID != 0) {

                                          $student_scnb_details = $this->admission_model->get_student_courses($Stu_ID);
                                          $student_mst_details = $this->admission_model->get_student_basic_details($Stu_ID, $data['Session_Data']['IBMS_BRANCHID']);
                                          if (!empty($student_mst_details[0]) && !empty($student_scnb_details[0])) {
                                                        $data['Form_Field_Value']['BranchCode'] = $student_mst_details[0]->BranchCode;
                                                        $data['Form_Field_Value']['EnrollNo'] = $student_mst_details[0]->EnrollNo;
                                                        $data['Form_Field_Value']['CourseID'] = $student_scnb_details[0]->CourseID;
                                                        $data['Form_Field_Value']['StudentName'] = $student_mst_details[0]->StudentName;
                                                        $data['Form_Field_Value']['FatherName'] = $student_mst_details[0]->FatherName;
                                                        $data['Form_Field_Value']['Gender'] = $student_mst_details[0]->Gender;
                                                        $data['Form_Field_Value']['DOB'] = $student_mst_details[0]->DOB;
                                                        $data['Form_Field_Value']['DOR'] = $student_scnb_details[0]->DOR;
                                                        $data['Form_Field_Value']['age'] = round((date(time()) - strtotime($data['Form_Field_Value']['DOB'])) / 31556926, 0) . " Years";
                                          } else {
                                                        echo "<div class='container text-center'><span class='box blink'>Student Not Found, or doesn't relate to this branch !!</span></div>";
                                          }
                                          $data['Form_Field_Value']['CourseCode'] = $this->util_model->get_a_column_value('CourseCode', DB_PREFIX . 'course_mst', array("CourseID" => $CourseID, "BranchID" => $data['Session_Data']['IBMS_BRANCHID']));

                                          $courses_result = $this->admission_model->get_student_courses($Stu_ID, 1);
                                          $final_course_list = array();
                                          if (!empty($courses_result)) {
                                                        foreach ($courses_result as $c_row) {
                                                                      $final_course_list[$c_row->CourseID] = $c_row->CourseCode;
                                                        }
                                          }
                                          // $this->util_model->printr($final_course_list);
                                          $data['stu_Courses'] = $final_course_list;
                            }

                            // cheque check exits
                            $data['Form_Field_Value']['BankName'] = "";
                            $data['Form_Field_Value']['BranchName'] = "";
                            $data['Form_Field_Value']['ChNumber'] = "";
                            $data['Form_Field_Value']['ChDate'] = "";
                            $data['Form_Field_Value']['ChAmount'] = "";
                            $data['Form_Field_Value']['Cleared'] = "";
                            $data['Form_Field_Value']['ChequeRemarks'] = "";
                            if ($data['receipt_data'][0]->Paid_ModeID != 1) {
                                          $cheque_fiter_data = array(
                                              "ReceiptNo" => $data['receipt_data'][0]->ReceiptNo,
                                              "Status" => TRUE);
                                          $data['cheque_details'] = $this->util_model->check_aready_exits(DB_PREFIX . "fee_cheque_details", $cheque_fiter_data, TRUE);
                                          if (!empty($data['cheque_details'][0])) {
                                                        $data['Form_Field_Value']['BankName'] = $data['cheque_details'][0]->BankName;
                                                        $data['Form_Field_Value']['BranchName'] = $data['cheque_details'][0]->BranchName;
                                                        $data['Form_Field_Value']['ChNumber'] = $data['cheque_details'][0]->ChNumber;
                                                        $data['Form_Field_Value']['ChDate'] = $data['cheque_details'][0]->ChDate;
                                                        $data['Form_Field_Value']['ChAmount'] = $data['cheque_details'][0]->ChAmount;
                                                        $data['Form_Field_Value']['Cleared'] = $data['cheque_details'][0]->Cleared;
                                                        $data['Form_Field_Value']['ChequeRemarks'] = $data['cheque_details'][0]->Remarks;
                                          }
                            }

                            // drop down list
                            $data['due_days'] = $this->util_model->get_list("due_day", "due_day", DB_PREFIX . "fee_due_days", $data['Session_Data']['IBMS_BRANCHID'], $sort_col = 'due_day');
                            $data['fac_list'] = array("" => "Select Faculty Code") + $this->util_model->get_list("Emp_ID", "Emp_Code", DB_PREFIX . "employee", $data['Session_Data']['IBMS_BRANCHID'], $sort_col = 'Emp_Code', TRUE, 1, " UTID=" . $data['Branch_obj']->FacultyCode);
                            $data['fac_batch_list'] = array("" => "Select Batch Code") + $this->util_model->get_list("BatchID", "BatchCode", DB_PREFIX . "batch_master", $data['Session_Data']['IBMS_BRANCHID'], $sort_col = 'BatchCode', TRUE, 1);
                            $data['paid_mode'] = $this->util_model->get_list("Paid_ModeID", "Paid_ModeCode", DB_PREFIX . "fee_paidmode_mst", 0, $sort_col = 'Paid_ModeCode');
                            $data['FeeTypeID_list'] = $this->util_model->get_list("FeeTypeID", "FeeType_Code", DB_PREFIX . 'fee_type_mst', $data['Session_Data']['IBMS_BRANCHID'], 'Sort,FeeType_Code');
                            // month  drop down list
                            $month_result = $this->util_model->all_month_list();
                            $data['Month_list'] = $month_result[0];
                            $data['c_month'] = $month_result[1];


                            foreach ($data['receipt_data'][0] as $key => $val) {
                                          $data['Form_Field_Value'][$key] = $val;
                            }
                            //$this->util_model->printr($data['Form_Field_Value']);

                            $this->load->view('templates/header.php', $data);
                            $this->load->view("Fee_collect/Fee_Collect_1/Fee_Edit.php", $data);
                            $this->load->view("Fee_collect/Fee_Collect_1/fee_collect_js.php", $data);
                            $this->load->view('templates/footer.php');
              }

              /*

               * set student fee plan ssfp()              
               * 
               * this function will add individual fee plan !! */

              function sscfp($Stu_ID = 0, $FeeTypeID = 0, $error = '', $_err_codes = '') {
                            global $data;
                            $data = $this->util_model->set_error($data, $error, $_err_codes);
                            if ($Stu_ID == 0) {
                                          $Stu_ID = $this->input->post('Stu_ID');
                                          $FeeTypeID = $this->input->post('FeeTypeID');
                            }
                            $data['Stu_ID'] = $Stu_ID;
                            $data['FeeTypeID'] = $FeeTypeID;
                            // to get fee plan has already set or not
                            if ($Stu_ID == 0 && $FeeTypeID == 0) {
                                          redirect(base_url() . "fees/Fee_Master_1/index/0/0/1/RecNotFound" . ERR_DELIMETER);
                            }
                            //$data['CourseCode'] = $this->util_model->get_a_column_value('CourseCode', DB_PREFIX . 'course_mst', array("CourseID" => $CourseID, "BranchID" => $data['Session_Data']['IBMS_BRANCHID']));
                            $data['EnrollNo'] = $this->util_model->get_a_column_value('EnrollNo', DB_PREFIX . 'stu_mst', array("Stu_ID" => $Stu_ID, "BranchID" => $data['Session_Data']['IBMS_BRANCHID']));

                            $data['FeeTypeIDs'] = $this->util_model->get_list("FeeTypeID", "FeeType_Code", DB_PREFIX . 'fee_type_mst', $data['Session_Data']['IBMS_BRANCHID'], 'Sort,FeeType_Code');
                            // previouse fee plan fiters
                            //$filter_data = array();
                            //$filter_data['CourseID'] = array($CourseID);
                            //$filter_data['BranchID'] = array($data['Session_Data']['IBMS_BRANCHID']);
                            // $filter_data['orderby'] = "Sort,CourseID,PackageID";
                            // end of filter
                            // fetching previouse course fee plan
                            // $data['this_cfp'] = $this->fee_collect_model_1->get_all_course_fee_plan($filter_data);
                            //unset($filter_data);
                            // end of fetching
                            // exiting fee plan


                            $data['total_fees'] = $this->fee_collect_model_1->get_total_fees($Stu_ID);
                            if (!$data['total_fees']) {
                                          redirect(base_url() . "adm/cadm/edit_adm/$Stu_ID#sectionD");
                            } else {
                                          $data['already_setted_fee'] = $this->fee_collect_model_1->get_total_fee_plan_amt($Stu_ID);
                                          $data['total_fees'] = $data['total_fees'] - $data['already_setted_fee'];
                            }
                            $data['stu_fee_plan'] = $this->show_stu_fee_plan($Stu_ID);
                            //print_r($data['stu_exiting_fee_plan']);
                            // end of fetching
                            $this->load->view('templates/header.php', $data);
                            $this->load->view('templates/common_window_pop_up.php', $data);
                            $this->load->view("Fee_collect/scfp_1/scfp.php", $data);
                            $this->load->view('templates/footer.php');
              }

              /*

               * student fee plan               */

              function show_stu_fee_plan($Stu_ID = '', $CourseID = '') {
                            global $data;
                            // $this->util_model->printr($data['this_cfp']);
                            $sfp_data = array();
                            if ($CourseID != "") {
                                          $sfp_data['CourseID'] = array($CourseID);
                            }
                            $this->load->model('adm/admission_model');
                            $courses_result = $this->admission_model->get_student_courses($Stu_ID, 1);
                            $final_course_list = array();
                            if (!empty($courses_result)) {
                                          foreach ($courses_result as $c_row) {
                                                        $final_course_list[$c_row->CourseID] = $c_row->CourseCode;
                                          }
                            }
                            // $this->util_model->printr($final_course_list);
                            $data['stu_Courses'] = $final_course_list;
                            $sfp_data['Stu_ID'] = array($Stu_ID);
                            $data['EnrollNo'] = $this->util_model->get_a_column_value('EnrollNo', DB_PREFIX . 'stu_mst', array("Stu_ID" => $Stu_ID, "BranchID" => $data['Session_Data']['IBMS_BRANCHID']));
                            // to get the exiting fee plan
                            $data['stu_exiting_fee_plan'] = $this->fee_collect_model_1->get_stu_fee_plan($sfp_data);
                            unset($sfp_data);
                            return $this->load->view("Fee_collect/scfp_1/v_stu_fee_plan.php", $data, TRUE);
              }

              function stu_common_fee_history($Stu_ID = '', $CourseID = '') {
                            global $data;
                            $data['Stu_ID'] = $Stu_ID;
                            $data['CourseID'] = $CourseID;
                            $data['CourseCode'] = $this->util_model->get_a_column_value('CourseCode', DB_PREFIX . 'course_mst', array("CourseID" => $CourseID, "BranchID" => $data['Session_Data']['IBMS_BRANCHID']));
                            $data['EnrollNo'] = $this->util_model->get_a_column_value('EnrollNo', DB_PREFIX . 'stu_mst', array("Stu_ID" => $Stu_ID, "BranchID" => $data['Session_Data']['IBMS_BRANCHID']));
                            $data['stu_fee_plan'] = $this->show_stu_fee_plan($Stu_ID, $CourseID);


                            // last fees
                            $fee_record_filter_data = array(
                                "Stu_ID" => $Stu_ID,
                                "BranchID" => $data['Session_Data']['IBMS_BRANCHID'],
                                "orderby" => "fee_trn.Stu_ID,fee_trn.CourseID,fee_trn.FeeTypeID"
                            );
                            $data['last_fee_record'] = $this->show_fees_record($fee_record_filter_data);
                            $this->load->view("Fee_collect/Fee_Collect_1/common_fee_history_panel.php", $data);
              }

              /*

               * student course fee plan set form validatoin               */

              function sscfp_validation($POST) {
                            $err_codes = '';
                            //die($this->util_model->printr($POST));
//                            if (!isset($POST['CourseID']) || empty($POST['CourseID'])) {
//                                          $err_codes.='cfp_CourseIDblank' . ERR_DELIMETER;
//                            }
                            if (!isset($POST['FeeTypeID']) || empty($POST['FeeTypeID'])) {
                                          $err_codes.='cfp_FeeTypeIDblank' . ERR_DELIMETER;
                            }


                            $_err_flag = FALSE;
                            foreach ($POST['Inst_amt'] as $t_inst) {
                                          if ($t_inst == "") {
                                                        $_err_flag = TRUE;
                                          }
                            }
                            if ($_err_flag) {
                                          $err_codes.='cfp_Inst_amtblank' . ERR_DELIMETER;
                            }

                            $_err_flag = FALSE;
                            foreach ($POST['Total_Inst'] as $t_inst) {
                                          if ($t_inst == "") {
                                                        $_err_flag = TRUE;
                                          }
                            }
                            if ($_err_flag) {
                                          $err_codes.='cfp_Total_Instblank' . ERR_DELIMETER;
                            }

                            $valid = $err_codes == '' ? TRUE : FALSE;
                            return array("_err" => $valid, "_err_codes" => $err_codes);
              }

              /*

               * save_ssfp() save course fee studnet plan
               * set student course fee plan
               *                */

              function save_sscfp() {
                            $FormData = $this->input->post();
                            //die($this->util_model->printr($FormData));
                            $Stu_ID = isset($FormData['Stu_ID']) ? $FormData['Stu_ID'][0] : 0; // CourseID to return on same form 
                            $path = "fees/Fee_Master_1/sscfp/" . $Stu_ID . "/0/";

                            $validates = $this->sscfp_validation($FormData); // validating the form
                            // die($this->util_model->printr($validates));
                            if (!$validates['_err']) {
                                          redirect($path . "1/{$validates['_err_codes']}");
                            }

                            if ($FormData != NULL) {
                                          if ($FormData["save_scfp"] == "Save") {
                                                        $inserted = $this->fee_collect_model_1->insert_scpf($FormData);
                                                        redirect(base_url() . $path . ($inserted['succ'] ? "0/" . $inserted['_err_codes'] : "1/" . $inserted['_err_codes']));
                                          }
                            }
                            echo "Bad required ";
              }

              /*

               * fee_form_validation     
               * to validate the fee form          /
               */

              function fee_form_validation($POST) {
                            $err_codes = '';
                            //die($this->util_model->printr($POST));


                            if (!isset($POST['FeeTypeID'])) {
                                          $err_codes.='cfp_FeeTypeIDblank' . ERR_DELIMETER;
                            }
                            if (!isset($POST['TotalAmt'])) {
                                          $err_codes.='FeeTotalAmtNotSet' . ERR_DELIMETER;
                            }
                            if ($POST['TotalAmt'] == 0) {
                                          $err_codes.='FeeTotalAmtNotZero' . ERR_DELIMETER;
                            }
                            if ($POST['PaidAmt'] == 0) {
                                          $err_codes.='FeePaidAmtNotZero' . ERR_DELIMETER;
                            }


                            $valid = $err_codes == '' ? TRUE : FALSE;
                            return array("_err" => $valid, "_err_codes" => $err_codes);
              }

              /*

               *  fee_collect used to insert fee into db              */

              public function fee_collect() {
                            $FormData = $this->input->post();
                            //die($this->util_model->printr($FormData));
                            $Stu_ID = isset($FormData['Stu_ID']) ? $FormData['Stu_ID'] : 0; // CourseID to return on same form 
                            $FeeTypeID = isset($FormData['FeeTypeID']) ? $FormData['FeeTypeID'] : 0; // CourseID to return on same form 
                            $path = "fees/Fee_Master_1/index/" . $Stu_ID . "/" . $FeeTypeID . "/";

//                            if($FormData['Individual_fee_plan_id']=="" || $FormData['Individual_fee_plan_id']==0){
//                                    redirect($path . "1/withoutFeePlan".ERR_DELIMETER);
//                            }

                            $validates = $this->fee_form_validation($FormData); // validating the form
                            // die($this->util_model->printr($validates));
                            if (!$validates['_err']) {
                                          redirect($path . "1/{$validates['_err_codes']}");
                            }

                            if ($FormData != NULL) {
                                          if ($FormData["Fee_Collect"] == "Save") {
                                                        $inserted = $this->fee_collect_model_1->fee_insert($FormData);
                                                        //die($this->util_model->printr($inserted));
                                                        if ($inserted['succ']) {
                                                                      redirect(base_url() . $path . "0/" . $inserted['_err_codes'] . "#last_fee_record");
                                                                      // passing error alert 0 means no error, 1 means Error
                                                        } else {
                                                                      redirect(base_url() . $path . "1/" . $inserted['_err_codes']);
                                                                      // passing error alert 0 means no error, 1 means Error    
                                                        }
                                          }
                            }
                            echo "Bad required ";
              }

              /*

               * fee_update
               * to update the fee details 
               * effecting tables are fee_trn, fee_bal, fee_cheque_details
               *                /
               */

              function fee_update() {
                            $FormData = $this->input->post();
                            //die($this->util_model->printr($FormData));
                            $Stu_ID = isset($FormData['Stu_ID']) ? $FormData['Stu_ID'] : 0; // CourseID to return on same form 
                            //$CourseID = isset($FormData['CourseID']) ? $FormData['CourseID'] : 0; // CourseID to return on same form 
                            $path = "fees/Fee_Master_1/Fee_Edit/" . $FormData['ReceiptNo'] . "/";

                            if (!isset($FormData['ReceiptNo'])) {
                                          redirect($path . "1/ReceiptNoNotDefined" . ERR_DELIMETER);
                            }

                            $validates = $this->fee_form_validation($FormData); // validating the form
                            // die($this->util_model->printr($validates));
                            if (!$validates['_err']) {
                                          redirect($path . "1/{$validates['_err_codes']}");
                            }


                            $inserted = $this->fee_collect_model_1->fee_update();
                            //die($this->util_model->printr($inserted));
                            if ($inserted['succ']) {
                                          redirect(base_url() . $path . "0/" . $inserted['_err_codes'] . "#last_fee_record");
                                          // passing error alert 0 means no error, 1 means Error
                            } else {
                                          redirect(base_url() . $path . "1/" . $inserted['_err_codes']);
                                          // passing error alert 0 means no error, 1 means Error    
                            }
              }

              function Print_Fee($ReceiptNo) {
                            global $data;


                            $this->load->model("branch/branch_model");
                            $this->db->query("update " . DB_PREFIX . "fee_trn set PrintCounter = PrintCounter+1 where ReceiptNo=$ReceiptNo");
                            $data['result'] = $this->fee_collect_model_1->data_to_print_fee($ReceiptNo);
                            $data['branch_settings'] = $this->branch_model->get_branch_setting($data['Session_Data']['IBMS_BRANCHID']);
                            $data['PROCODE'] = $this->util_model->get_a_column_value('Emp_Code', DB_PREFIX . 'employee', array("Emp_ID" => $data['Session_Data']['IBMS_USER_ID'], "BranchID" => $data['Session_Data']['IBMS_BRANCHID']));

                            $this->load->library('numbertowords');
                            $data['amount_in_words'] = $this->numbertowords->convert_number($data['result'][0]->PaidAmt) . " Only.";

                            //$this->util_model->printr($data['Branch_obj']);
                            if (!empty($data['result'][0]))
                                          $data['fee_record'] = $data['result'][0];
                            else {
                                          die("Sorry Record is Not Proper !!");
                            }
                            if (!file_exists(APPPATH . '/views/fpdf/receipt_printing.php')) {
                                          show_404();
                            }
                            $this->load->view('fpdf/receipt_printing.php', $data);
              }

//              function save_update_fee_plan() {
//                            $path = "";
//                            $data['Session_Data'] = $this->session->all_userdata();
//                            if (!$this->session->userdata('LOGIN_STATUS')) {
//                                          redirect('/auth/login/1/1');
//                            }
//                            $model_result = $this->fee_collect_model_1->save_update_fee_plan($_POST);
//                            if ($model_result) {
//                                          $path = "Fee_Master/set_fee_plan/0/1/{$_POST['EnrollNo1']}/" . $this->util_model->url_encode($_POST['CourseCode1']);
//                            } else {
//                                          $path = "Fee_Master/set_fee_plan/1/1/{$_POST['EnrollNo1']}/" . $this->util_model->url_encode($_POST['CourseCode1']);
//                            }
//                            redirect(base_url() . $path);
//              }
//              function Update_fee_plan($Fee_Plan_ID, $error = '', $show_error = 0) {
//                            $data['Session_Data'] = $this->session->all_userdata();
//                            if (!$this->session->userdata('LOGIN_STATUS')) {
//                                          redirect(base_url() . 'auth/login/1/1');
//                            }
//                            if ($show_error == 1) {
//                                          if ($error == 1)
//                                                        $data['error'] = TRUE;
//                                          else
//                                                        $data['error'] = FALSE;
//                            }
//                            $data['Fee_Plan_Detail$Fee_Plan_IDs'] = $this->fee_collect_model_1->Get_Fee_Plan_Details_via_ID($Fee_Plan_ID);
//                            $this->load->helper('form'); // Loading Form helper which helps to make form elements
//                            $attributes = array('role' => 'form', 'class' => 'Edit_Fee_plan_form', 'id' => 'Edit_Fee_Plan_validation_form'); // extra attributes for form
//                            $data['attributes'] = $attributes;
//
//                            if (!file_exists(APPPATH . '/views/Fee_collect/edit_fee_plan.php')) {
//                                          show_404();
//                            }
//                            $data['title'] = ucfirst("Edit Fee Plan |" . SITE_NAME); //capitalizing the first character of string for header.
//                            $this->load->view('templates/Common_Css_Js_Others_files.php', $data);
//
//                            $this->load->view("Fee_collect/edit_fee_plan.php", $data);
//                            $this->load->view('templates/footer.php');
//              }



              public function set_fee_form_data_for_help($Stu_ID, $FeeTypeID = '') {
                            global $data;
                            $form_fields = array("BranchCode", "StudentName", "EnrollNo", "CourseCode", "FatherName",
                                "DOR", "DOB", "age", "Gender", "RegFeeAmt",
                                "MonthlyChargeAmt", "LatePaymentAmt", "StudyMaterialCostAmt",
                                "ExamFeeAmt", "ProspectusCostAmt", "OtherAmt", "TotalAmt", "DisAmt", "NetPayableAmt",
                                "PaidAmt", "BalanceAmt", "BalDueDate", "BalanceDetails", "NextInstAmt", "AfterNextInstAmt",
                                "NoOfInstallment", "FacultyID", "BatchID", "service_tax", "PreBalAmt", "NextDueDate", "AfterNextDueDate", "Remarks", "Add_User", "Mode_User", "Total_Paid_Amt", "Individual_fee_plan_id", "BranchCode");
                            $form_fields_value = array();
                            foreach ($form_fields as $field_Name) { // to solve if there is no any privous record of student
                                          $form_fields_value[$field_Name] = "";
                            }
                            //$Stu_ID = "";
                            if ($Stu_ID == "") {
                                          return $form_fields_value;
                            }

                            $student_scnb_details = $this->admission_model->get_student_courses($Stu_ID);
                            $student_mst_details = $this->admission_model->get_student_basic_details($Stu_ID, $data['Session_Data']['IBMS_BRANCHID']);
                            //$this->util_model->printr($student_mst_details);
                            if (!empty($student_mst_details[0]) && !empty($student_scnb_details[0])) {
                                          $form_fields_value['BranchCode'] = $student_mst_details[0]->BranchCode;
                                          $form_fields_value['EnrollNo'] = $student_mst_details[0]->EnrollNo;
                                          $form_fields_value['CourseID'] = $student_scnb_details[0]->CourseID;
                                          $form_fields_value['StudentName'] = $student_mst_details[0]->StudentName;
                                          $form_fields_value['FatherName'] = $student_mst_details[0]->FatherName;
                                          $form_fields_value['Gender'] = $student_mst_details[0]->Gender;
                                          $form_fields_value['DOB'] = $student_mst_details[0]->DOB;
                                          $form_fields_value['DOR'] = $student_scnb_details[0]->DOR;
                                          $form_fields_value['age'] = round((date(time()) - strtotime($form_fields_value['DOB'])) / 31556926, 0) . " Years";
                            } else {
                                          echo "<div class='container text-center'><span class='box blink'>Student Not Found, or doesn't relate to this branch !!</span></div>";
                            }
//                            $form_fields_value['CourseCode'] = $this->util_model->get_a_column_value('CourseCode', DB_PREFIX . 'course_mst', array("CourseID" => $CourseID, "BranchID" => $data['Session_Data']['IBMS_BRANCHID']));
                            $form_fields_value['Total_Paid_Amt'] = $this->fee_collect_model_1->total_installments_amount($Stu_ID);

                            // call to get batchid and faculty id

                            $form_fields_value['BatchID'] = "";
                            $form_fields_value['FacultyID'] = "";

                            // end of call for batchid and faculty id

                            $form_fields_value['NextDueDate'] = date('Y-m-' . $student_scnb_details[0]->due_day, strtotime('+1 month'));
                            $form_fields_value['AfterNextDueDate'] = date('Y-m-' . $student_scnb_details[0]->due_day, strtotime('+2 month'));
                            //$form_fields_value['BalanceAmt'] = $student_scnb_details[0]->Total_Bal;
                            $sfp_data = array();

                            $sfp_data['Stu_ID'] = array($Stu_ID);
                            $sfp_data['FeeTypeID'] = array($FeeTypeID);
                            // to get the exiting fee plan
                            $all_fee_plan = $this->fee_collect_model_1->get_stu_fee_plan($sfp_data);
                            unset($sfp_data);

                            //$all_fee_plan = $this->fee_collect_model_1->All_fee_plan_of_student($student_scnb_details[0]->EnrollNo, $student_scnb_details[0]->CourseCode);
                            $form_fields_value['NextInstAmt'] = 0;
                            $form_fields_value['AfterNextInstAmt'] = 0;
                            $count = 1;
                            foreach ($all_fee_plan as $row) {
                                          $total_installment = $row->Total_Inst;
                                          for ($i = $row->Total_paid; $i < $total_installment; $i++) {
                                                        if ($total_installment != $row->Total_paid) {
                                                                      if ($count == 1) {
                                                                                    $form_fields_value['FeeTypeID'] = $row->FeeTypeID;
                                                                                    $form_fields_value['MonthlyChargeAmt'] = $row->Inst_amt;
                                                                                    $form_fields_value['Individual_fee_plan_id'] = $row->ID;
                                                                                    $count++;
                                                                      } else if ($count == 2) {
                                                                                    $form_fields_value['NextInstAmt'] = $row->Inst_amt;
                                                                                    $count++;
                                                                      } else if ($count == 3) {
                                                                                    $form_fields_value['AfterNextInstAmt'] = $row->Inst_amt;
                                                                                    $count++;
                                                                      }
                                                                      if ($count == 4)
                                                                                    break;
                                                        }
                                          }
                            }
                            $last_record = $this->get_last_fee_record($Stu_ID, $FeeTypeID);
                            $Fees_field = array("RegFeeAmt", "LatePaymentAmt", "StudyMaterialCostAmt", "ProspectusCostAmt", "OtherAmt", "DisAmt", "NoOfInstallment");
                            $form_fields_value['BalanceDetails'] = "";
                            $form_fields_value['BalDueDate'] = "";
                            $form_fields_value['BalanceAmt'] = 0;
                            $form_fields_value['PreBalAmt'] = 0;
                            $form_fields_value['NetPayableAmt'] = 0;

                            // balance and remarks from last records
                            $filter_data = array("Stu_ID" => $Stu_ID);
                            $bal_details = $this->fee_collect_model_1->get_balance_details($filter_data);
                            //$this->util_model->printr($bal_details);
                            if (empty($bal_details)) {
                                          
                            } else {
                                          $form_fields_value['BalanceDetails'] = $bal_details[0]->BalanceDetails;
                                          $form_fields_value['PreBalAmt'] = $bal_details[0]->BalanceAmt;
                            }


                            if ($last_record) {
                                          $form_fields_value['Remarks'] = $last_record[0]->Remarks;
                            } else {
                                          foreach ($Fees_field as $field) {
                                                        $form_fields_value[$field] = 0;
                                          }
                            }
                            // late payment
                            //  remained
                            // end of late payment
                            // discount calculate
                            // remained
                            // end of discount
                            // Services Tax
                            // checking tax_enabled for passed feetype
                            $this->load->model('fee/fee_type_model');
                            $filter_data = array("FeeTypeID" => $FeeTypeID, "BranchID" => $data['Session_Data']['IBMS_BRANCHID'], "Status" => 1);
                            $fee_type_data = $this->fee_type_model->get_feetype_details($filter_data);
                            $form_fields_value['service_tax'] = 0;
                            // if enabled then how much tax
                            if (isset($fee_type_data[0]) && $fee_type_data[0]->tax_enabled) {
                                          $this->load->model('branch/branch_model');
                                          $branch_settings = $this->branch_model->get_branch_setting($data['Session_Data']['IBMS_BRANCHID']);
                                          if ($branch_settings->Service_tax_flag) {
                                                        $form_fields_value['service_tax'] = $branch_settings->Service_tax;
                                          }
                                          // End of services Tax
                            }
                            $form_fields_value['NoOfInstallment'] = $this->fee_collect_model_1->get_no_of_installment($Stu_ID, $FeeTypeID);
                            return $form_fields_value;
              }

              /*

               * $FeeTypeID  
               * get_last_fee_record()
               * to get last receipt accouding to course and fee type wise
               *           
               *  */

              public function get_last_fee_record($Stu_ID, $FeeTypeID = "") {
                            return $this->fee_collect_model_1->last_fee_record($Stu_ID, $FeeTypeID);
              }

              public function Fee_collect_save_update() {
                            $path = "";
                            $query_result = array();
                            $Stu_ID = $this->input->post('Stu_ID');
                            $CourseID = $this->input->post('CourseID');
                            if (isset($_REQUEST['Fee_Collect']) && $_REQUEST['Fee_Collect'] == "Save") {
                                          $saved_or_updated = $this->fee_collect_model_1->fee_insert();
                                          $path = "fees/Fee_Master_1/index/";
                                          if ($saved_or_updated['succ'])
                                                        redirect(base_url() . $path . "0/" . $saved_or_updated['_err_codes'] . "/" . $Stu_ID . "/" . $CourseID . "#last_fee_record"); // passing error alert 0 means no error, 1 means Error
                                          else {
                                                        redirect(base_url() . $path . "1/" . $saved_or_updated['_err_codes'] . "/" . $Stu_ID . "/" . $CourseID); // passing error alert 0 means no error, 1 means Error    
                                          }
                            } else if (isset($_REQUEST['Fee_Collect']) && $_REQUEST['Fee_Collect'] == "Update") {
                                          // print_r($_POST);
                                          $saved_or_updated[0] = $this->fee_collect_model_1->Fee_collect_save_update($_POST);
                                          $path = $saved_or_updated[0] ? "Fee_Master_1/Fee_Edit/0/1" : "Fee_Master/Fee_Edit/1/1";
                                          redirect(base_url() . $path . "/" . $_REQUEST['ID']);
                            } else {
                                          $path = "Fee_Master_1/index/1/1/" . $_REQUEST['ID'];
                            }
                            redirect(base_url() . $path . "/" . $EnrollNo . "/" . $CourseCode . "#last_fee_record"); // passing error alert 0 means no error, 1 means Error
              }

              public function Del_Fee_plan($ID, $EnrollNo, $CourseCode) {
                            $path = "";
                            if ($this->fee_collect_model_1->Del_Fee_plan($ID)) {
                                          $path = "Fee_Master_1/set_fee_plan/0/1/$EnrollNo/" . $this->util_model->url_encode($CourseCode);
                                          // passing error alert 0 means no error, 1 means Error
                            } else {
                                          $path = "Fee_Master_1/set_fee_plan/1/1/$EnrollNo/" . $this->util_model->url_encode($CourseCode);
                                          // passing error alert 0 means no error, 1 means Error
                            }
                            redirect(base_url() . $path);
              }

              public function Del_Fee_record($ID, $EnrollNo) {
                            $path = "";
                            if ($this->fee_collect_model_1->Del_Fee_record($ID)) {
                                          $path = "Fee_Master_1/index/0/1/$EnrollNo";
                                          // passing error alert 0 means no error, 1 means Error
                            } else {
                                          $path = "Fee_Master_1/index/1/1/$EnrollNo";
                                          // passing error alert 0 means no error, 1 means Error
                            }
                            redirect(base_url() . $path . "#last_fee_record");
              }

              function all_fee_records() {
                            // last fees
                            global $data;

                            $this->load->library("ajax/search");
                            $data['fee_search_template'] = $this->search->fee_search();
                            $data['collapse'] = "collapse in";
                            $fee_record_filter_data = array(
                                "BranchID" => $data['Session_Data']['IBMS_BRANCHID'],
                                "orderby" => "fee_trn.Stu_ID,fee_trn.CourseID,fee_trn.FeeTypeID"
                            );
                            $data['last_fee_record'] = $this->show_fees_record($fee_record_filter_data);
                            $this->load->view('templates/header.php', $data);
                            $this->load->view('templates/common_window_pop_up.php', $data);
                            $this->load->view("Fee_collect/Fee_Collect_1/all_fee_record.php", $data);
                            $this->load->view('templates/footer.php');
                            // fee history option
              }

              /*

               * called via ajax               */

              function search_fee_recoreds() {
                            global $data;
                            $POST = $this->input->post();
                            $POST['orderby'] = "fee_trn.ReceiptDate";
                            $POST['order'] = "DESC";
                            $POST["BranchID"] = $data['Session_Data']['IBMS_BRANCHID'];
                            echo $this->show_fees_record($POST);
              }

              public function show_fees_record($filter_data) {
                            global $data;
                            $data['fees_record'] = $this->fee_collect_model_1->get_fee_records($filter_data);
                            // $data['title'] = ucfirst(Fees_Collect_Form); //capitalizing the first character of string for header.
                            //$this->load->view('templates/header.php', $data);
                            //$this->load->view('templates/common_window_pop_up.php');
                            return $this->load->view("Fee_collect/Fee_Collect_1/fee_record.php", $data, TRUE);
                            // $this->load->view('templates/footer.php');
              }

}
