<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of batch_model
 *
 * @author anup
 */
class batch_model extends CI_Model {

              function __construct() {
                            parent::__construct();
              }

              // function to count all student for a batch from batch master
              public function batch_strenght($FacultyID, $BatchID) {
                            $this->db->select()->from(DB_PREFIX . "batch_master")->where(array("BatchID" => $BatchID, "FacultyID" => $FacultyID));
                            $result = $this->db->get()->result();
                            return $result[0]->Max_Std;
                            //return $this->db->count_all_results();
              }

              // function to count the no of student those a have passed facultycode and batch code.
              public function alloted_student_in_batch($FacultyID, $BatchID, $BatchStatusID = '') {
                            if ($BatchStatusID != '') {
                                          $this->db->where("BatchStatusID", $BatchStatusID);
                            }
                            $this->db->select()->from(DB_PREFIX . "stu_batches")->where(array("BatchID" => $BatchID, "FacultyID" => $FacultyID));
                            return $this->db->count_all_results();
              }

              // this function will tell space is availble or not
              public function space_in_batch($Needed_Space, $FacultyID, $BatchID, $BatchStatusID = '') {
                            $Total_Allowed = $this->batch_model->batch_strenght($FacultyID, $BatchID);
                            $Already_allocated_stu = $this->batch_model->alloted_student_in_batch($FacultyID, $BatchID, $BatchStatusID);

                            $Remained_Space = $Total_Allowed - $Already_allocated_stu;
                            // return array(FALSE,$Total_Allowed.$Already_allocated_stu.$Remained_Space);
                            if ($Remained_Space <= 0) {
                                          return array(FALSE, "Batch is Full Max Capacity of this batch is $Total_Allowed !!");
                            } else if ($Remained_Space < $Needed_Space) {
                                          return array(TRUE, "Only $Remained_Space Space is Remained !! You have selected $Needed_Space Students !!");
                            } else {
                                          return array(TRUE, "");
                            }
              }

              public function all_batch_list($Branch_IDs = array()) {
                            global $data;
                            /* this function is being used for two purpose
                             * 1. to show batch list to update student batch 
                             * 2. to show all batch list where it is being created
                             */
                            if (!empty($Branch_IDs)) {
                                          $this->db->where_in("bm.BranchID", $Branch_IDs);
                            }
                            $this->db->select("bm.BatchID,bm.BatchCode,bm.FacultyID,bm.Add_User,bm.Mode_User,bm.Start_Time,bm.End_Time,bm.Str_date,bm.Status,bm.Total_Class,bm.Max_Std, bm.Remarks,bm.Add_DateTime,bm.Mode_DateTime,"
                                    . "cm.CourseCode")->from(DB_PREFIX . "batch_master bm")->order_by('bm.Mode_DateTime', "DESC");
                            $this->db->join(DB_PREFIX . "course_mst cm", "bm.CourseID=cm.CourseID", 'LEFT');
                            //FacultyCode
                            $result = $this->db->get()->result();
                            $all_users = $this->util_model->get_list('Emp_ID', 'Emp_Code', DB_PREFIX . "employee", $data['Session_Data']['IBMS_BRANCHID'], 'Emp_ID');
                            $all_courses = array();
                            foreach ($result as $row) {
                                          $row->FacultyCode = isset($all_users[$row->FacultyID]) ? $all_users[$row->FacultyID] : '';
                                          $row->Add_UserCode = isset($all_users[$row->Add_User]) ? $all_users[$row->Add_User] : '';
                                          $row->Mode_UserCode = isset($all_users[$row->Mode_User]) ? $all_users[$row->Mode_User] : '';
                                          $all_courses[] = $row;
                            }
                            return $all_courses;
              }

              public function batch_master_save_update() {
                            global $data;
                            $form_data = array();
                            try {
                                          $form_data = $this->input->post();
                                          //die($this->util_model->printr($form_data));
                                          if ($form_data["Add_Batch"] === "Save") {
                                                        $data_to_insert = $this->query_string($form_data);
                                                        $data_to_insert = $this->util_model->add_common_fields($data_to_insert);
                                                        if ($this->check_batch_already_exits($data_to_insert['BatchCode'], $data['Session_Data']['IBMS_BRANCHID'])) {
                                                                      $cookie_data = array(array(
                                                                              'cname' => '_err_msg',
                                                                              'cvalue' => "Batch Already Exits !! "
                                                                      ));
                                                                      $this->util_model->_set_encrypt_cookie($cookie_data);
                                                                      return array(FALSE);
                                                        }

                                                        $this->db->trans_begin();
                                                        // inserting batch details
                                                        $this->db->insert(DB_PREFIX . "batch_master", $data_to_insert);
                                                        $form_data['element_id'] = $this->db->insert_id();

                                                        // inserting timings
                                                        $this->load->model("time_manage/m_time_manage");
                                                        $this->m_time_manage->insert_batch_timing($form_data);

                                                        if ($this->db->trans_status() === TRUE) {
                                                                      $this->db->trans_commit();
                                                                      return array(TRUE);
                                                        } else {
                                                                      $this->db->trans_rollback();
                                                                      return array(FALSE);
                                                        }
                                          } else {
//                                                      die($this->util_model->printr($form_data));
                                                        $this->db->trans_begin();

                                                        // updating batch
                                                        $data_to_update = $this->query_string($form_data);
                                                        $this->db->where(array('BatchID' => $form_data['BatchID']));
                                                        $this->db->update(DB_PREFIX . "batch_master", $data_to_update);

                                                        // updating timings
                                                        $form_data['element_id'] = $form_data['BatchID'];
                                                        $this->load->model("time_manage/m_time_manage");
                                                        $this->m_time_manage->insert_batch_timing($form_data);


                                                        if ($this->db->trans_status() === TRUE) {
                                                                      $this->db->trans_commit();
                                                                      return array("succ" => TRUE, "BatchID" => $form_data["BatchID"]);
                                                        } else {
                                                                      $this->db->trans_rollback();
                                                                      return array("succ" => FALSE, "BatchID" => $form_data["BatchID"]);
                                                        }
                                          }
                            } catch (Exception $ex) {
                                          return array(FALSE);
                            }
              }

              function check_batch_already_exits($BatchCode, $BranchID) {

                            $q = $this->db->select('*')->from(DB_PREFIX . 'batch_master')->where(array('BatchCode' => $BatchCode, "BranchID" => $BranchID));
                            if ($this->db->count_all_results()) {
                                          return TRUE;
                            } else {
                                          return FALSE;
                            }
              }

              function no_of_student_in_a_batch($BatchID, $choice = 1) {
                            /*
                             *  this function used to count no of running students in this batch
                             *  or read student or both running and have had read.
                             *  1. for active 
                             *  0. deactive
                             *  2. both 
                             */

                            if (!$choice) {
                                          // for deactive
                            } elseif ($choice == 2) {
                                          // for both
                                          // called from ajax_model to check while deletion
                                          $this->db->get_where(DB_PREFIX . "stu_batches", array('BatchID' => $BatchID));
                                          return $this->db->count_all_results();
                            } else {
                                          // for active
                            }
              }

              public function query_string($form_data) {
                            global $data;
                            $data_to_insert_or_update = array(
                                "BatchCode" => $form_data['BatchCode'],
                                "BranchID" => isset($form_data['BranchID'])?$form_data['BranchID']:$data['Session_Data']['IBMS_BRANCHID'],
                                "FacultyID" => $form_data['FacultyID'],
                                "Str_date" => date(DB_DF, strtotime($form_data['Str_date'])),
                                "CourseID" => $form_data['CourseID'],
                                "Total_Class" => $form_data['Total_Class'],
                                "Max_Std" => $form_data['Max_Std'],
                                "Status" => $form_data['Status'],
                                "Remarks" => $form_data['Remarks']);
                            return $data_to_insert_or_update;
              }

              public function Del_Batch($BatchID) {
                            // calling from ajax_model while delete batch
                            $this->db->trans_begin();
                            $this->db->delete(DB_PREFIX . 'batch_master', array('BatchID' => $BatchID));
                            $this->db->delete(DB_PREFIX . 'batch_time_mst', array('element_id' => $BatchID, "element_type" => 1));
                            if ($this->db->trans_status() === TRUE) {
                                          $this->db->trans_commit();
                                          return TRUE;
                            } else {
                                          $this->db->trans_rollback();
                                          return FALSE;
                            }
              }

              public function get_batch_details($batch_code) {
                            $query = $this->db->get_where(DB_PREFIX . 'batch_master', array("BatchCode" => $batch_code));
                            return $query->first_row();
              }

              /*

               * used to get details of batches               */

              public function m_batch_search($filter_data) {

                            $this->db->select("bm.*")->from(DB_PREFIX . 'batch_master bm');
                            if (isset($filter_data['BatchID']) && $filter_data['BatchID'] != "") {
                                          $this->db->where("BatchID", $filter_data['BatchID']);
                            }
                            return $this->db->get()->result_array();
              }

              public function Get_Batches_of_Faculty($FacultyID) {
                            $query = $this->db->select('BatchID,BatchCode')->from(DB_PREFIX . "batch_master")->where(array("FacultyID" => $FacultyID))->order_by('BatchCode');
                            $result = $query->get()->result();
                            return $result;
              }

              public function All_Student_List($FacultyCode, $BatchCode) {
                            $query = $this->db->select()->from("nexgen_batch_master")->order_by('FacultyCode,BatchCode');
                            $result = $query->get()->result();
                            return $result;
              }

              //put your code here
              /*

               * using in batch upate search form               */
              function msearch_batches($POST) {
                            global $data;
                            // $this->util_model->printr($POST);
                            $this->load->model('branch/branch_model');
                            $branch_settings = $this->branch_model->get_branch_setting($data['Session_Data']['IBMS_BRANCHID']);
                            if (isset($POST['adv_search'])) {
                                          $condi_given = FALSE;
                                          // advance search started !!          
                                          // starting of search date of enquiry or date of registration wise
                                          if (isset($POST['DOE_DOR']) && $POST['DOE_DOR'] != "") {


                                                        $from = date(DB_DTF, strtotime($POST['From']));
                                                        $to = date(DB_DTF, strtotime($POST['To']));
                                                        if (isset($POST['todays_enq'])) {
                                                                      // login for todays enquiry, if today checkbox is checked
                                                                      $from = date(DB_DTF, strtotime(Year . "-" . Month . "-" . date('d') . "00:00:00"));
                                                                      $to = date(DB_DTF, strtotime(Year . "-" . Month . "-" . date('d') . "23:59:59"));
                                                        }
                                                        if ($POST['DOE_DOR'] == "DOE") {

                                                                      $this->db->where("es.DOE>=", "'$from'", FALSE);
                                                                      $this->db->where("es.DOE<=", "'$to'", FALSE);

                                                                      $condi_given = TRUE; // it is for getting, yes any one condition is given
                                                        } else if ($POST['DOE_DOR'] == "DOR") {
                                                                      $from = date(DB_DF, strtotime($POST['From']));
                                                                      $to = date(DB_DF, strtotime($POST['To']));
                                                                      $this->db->where("sc.DOR>=", "'$from'", FALSE);
                                                                      $this->db->where("sc.DOR<=", "'$to'", FALSE);

                                                                      $condi_given = TRUE; // it is for getting, yes any one condition is given
                                                        }
                                          }


                                          //end of Src Wise
                                          // coursewise
                                          if (isset($POST['CourseList'])) {
                                                        $this->db->where_in("sb.CourseID", $POST['CourseList']);
                                          }
                                          // end of coursewise
                                          // locality list
                                          if (isset($POST['LocalityList'])) {
                                                        $this->db->where_in("stu_mst.C_Locality", $POST['LocalityList']);
                                          }
                                          // end of locality list
                            }
                            // $this->util_model->printr($POST);
                            // basic search via make for multi search only !!  
                            if(isset($POST['adv_search'])){
                            foreach ($POST['search_via_value'] as $index => $search_value) {
                                          if ($search_value != "") {
                                                        //return array("succ"=>FALSE,"_err_code"=>"UnSuccDataToSearchEnq");
                                                        $column_list = array(
                                                            "Mob1" => "stu_mst.Mobile1",
                                                            "Name" => "stu_mst.StudentName",
                                                            "Fname" => "stu_mst.FatherName",
                                                            "Email1" => "stu_mst.Email1",
                                                            "EnrollNo" => "stu_mst.EnrollNo",
                                                            "Stu_ID" => "stu_mst.Stu_ID");
                                                        $col = isset($column_list[$POST['search_via'][$index]]) ? $column_list[$POST['search_via'][$index]] : '';
                                                        // $value = $POST['search_via_value1'];
                                                        if ($col != "") {
                                                                      $this->db->where($col, $search_value);
                                                                      $condi_given = TRUE; // it is for getting, yes any one condition is given
                                                        }
                                          }
                            }}
                            if (isset($POST['via_fac_batch'])) {
                                          if ($POST['fac_id'] != "")
                                                        $this->db->where("sb.FacultyID", $POST['fac_id']);
                                          else
                                                        $this->db->where("sb.FacultyID is NULL", NULL, FALSE);

                                          if ($POST['batchid'] != "")
                                                        $this->db->where("sb.BatchID", $POST['batchid']);
                                          else
                                                        $this->db->where("sb.BatchID is NULL", NULL, FALSE);
                            }
                            $this->db->select("sb.BatchID,"
                                    . "sb.Stu_ID,"
                                    . "sb.CourseID as admCourseID,"
                                    . "sb.FacultyID,"
                                    . "sb.BatchStatusID,"
                                    . "sb.Add_User,"
                                    . "sb.Mode_User,"
                                    . "sb.Mode_DateTime,"
                                    . "sb.Remarks,"
                                    . "sc.DOR,sc.due_day,sb.Remarks,"
                                    . "stu_mst.EnrollNo,"
                                    . "stu_mst.StudentName,"
                                    . "stu_mst.FatherName,"
                                    . "stu_mst.C_Locality,"
                                    . "stu_mst.Mobile1,"
                                    . "stu_mst.Email1,"
                                    . "bm.BatchCode,"
                                    . "bsm.BatchStatus,"
                                    . "faculty.Emp_Code as FacultyCode,"
                                    . "mode_user_tbl.Emp_Code as last_modifier,"
                                    . "course_tbl.CourseCode as admCourseCode")->from(DB_PREFIX . "stu_batches sb");
                            $this->db->join(DB_PREFIX . "stu_courses sc", "sb.Stu_ID = sc.Stu_ID and sb.CourseID = sc.CourseID", "left");
                            $this->db->join(DB_PREFIX . "stu_mst stu_mst", "sb.Stu_ID = stu_mst.Stu_ID", "left");
                            $this->db->join(DB_PREFIX . "batch_master bm", "sb.BatchID = bm.BatchID", "left");
                            $this->db->join(DB_PREFIX . "course_mst course_tbl", "sb.CourseID = course_tbl.CourseID", "left");
                            $this->db->join(DB_PREFIX . "employee faculty", "sb.FacultyID = faculty.Emp_ID", "left");
                            $this->db->join(DB_PREFIX . "employee mode_user_tbl", "sb.Mode_User = mode_user_tbl.Emp_ID", "left");
                            $this->db->join(DB_PREFIX . "batchstatus bsm", "sb.BatchStatusID = bsm.BatchStatusID", "left");
                            $this->db->where(array("sc.Status" => TRUE, "stu_mst.Status" => TRUE));
                            if (isset($POST['BatchStatusID'])) {
                                          $this->db->where_in("sb.BatchStatusID", $POST['BatchStatusID']);
                            } else {
                                          $this->db->where_in("sb.BatchStatusID", explode(",", $branch_settings->stu_batch_statusIDs));
                            }

                            $query = $this->db->get();
                            $result = $query->result_array();
//                            echo $this->db->last_query();
//                            die();
                            $locality_list = $this->util_model->get_list('localityid', 'locality', DB_PREFIX . "locality", 0, 'localityid');
                            $final_enquiry_list = array();
                            foreach ($result as $row) {
                                          $row['lcode'] = isset($locality_list[$row['C_Locality']]) ? $locality_list[$row['C_Locality']] : 'NA';
                                          $final_enquiry_list[] = $row;
                            }
                            return $final_enquiry_list;
                            //$this->util_model->printr($final_enquiry_list);
              }

              function get_student_batches($Stu_ID) {
                            global $data;
                            $query = $this->db->get_where(DB_PREFIX . "stu_batches", array("Stu_ID" => $Stu_ID));
                            $all_stu_batches = $query->result_array();
                            $all_courses = $this->util_model->get_list('CourseID', 'CourseCode', DB_PREFIX . "course_mst", $data['Session_Data']['IBMS_BRANCHID'], 'CourseID');
                            $all_users = $this->util_model->get_list('Emp_ID', 'Emp_Code', DB_PREFIX . "employee", $data['Session_Data']['IBMS_BRANCHID'], 'Emp_ID');
                            $All_Batch_Status = $this->util_model->get_list("BatchStatusID", "BatchStatus", DB_PREFIX . "batchstatus", $data['Session_Data']['IBMS_BRANCHID'], $sort_col = 'Sort,BatchStatus');
                            $all_batch_list = $this->util_model->get_list("BatchID", "BatchCode", DB_PREFIX . "batch_master", $data['Session_Data']['IBMS_BRANCHID'], $sort_col = 'BatchCode', TRUE, 1);
                            $final_batch_list = array();
                            foreach ($all_stu_batches as $row) {
                                          $row['CourseCode'] = isset($all_courses[$row['CourseID']]) ? $all_courses[$row['CourseID']] : 'NA';
                                          $row['FacultyCode'] = isset($all_users[$row['FacultyID']]) ? $all_users[$row['FacultyID']] : 'NA';
                                          $row['BatchStatus'] = isset($All_Batch_Status[$row['BatchStatusID']]) ? $All_Batch_Status[$row['BatchStatusID']] : 'NA';
                                          $row['BatchCode'] = isset($all_batch_list[$row['BatchID']]) ? $all_batch_list[$row['BatchID']] : 'NA';
                                          $final_batch_list[] = $row;
                            }
                            return $final_batch_list;
              }

              /*

               * this funciton will check validation .. whether to allow or not to make new batch
               * after checking free time of faculty and room
               *  
                $filter_data
               * [course_cat_codeid] => 12
                [course_id] => 74
                [faculty_codeid] => 38
                [str_batch_time] => 15:00
                [end_batch_time] => 16:00
                [BranchID] => 2
                [Course_Code_Cat_Code] => CS
                [FacultyCode] => RAV
               *                 */

              function batch_gen_validation($filter_data) {
//                            $this->util_model->printr($filter_data);
//                            if (isset($filter_data['BranchID'])) {
//                                          $this->db->where("BranchID", $filter_data['BranchID']);
//                            }
//                            if (isset($filter_data['faculty_codeid'])) {
//                                          $this->db->where("FacultyID", $filter_data['faculty_codeid']);
//                            }
//                            if (isset($filter_data['course_id'])) {
//                                          $this->db->where("CourseID", $filter_data['course_id']);
//                            }
//                            
//                            if (isset($filter_data['str_batch_time'])) {
//                                          $this->db->where("Start_Time<", $filter_data['str_batch_time'],NULL,FALSE);
//                                          $this->db->where("End_Time>", $filter_data['str_batch_time'],NULL,FALSE);
//                            }
//                            
//                            if (isset($filter_data['end_batch_time'])) {
//                                          $this->db->where("Start_Time<", $filter_data['end_batch_time'],NULL,FALSE);
//                                          $this->db->where("End_Time<", $filter_data['end_batch_time'],NULL,FALSE);
//                            }
//                            $this->db->select(" t1.*")->from(DB_PREFIX . "_batch_master");
//                            $this->db->where("Status",TRUE);
//                            $this->db->get();
//                             echo $this->db->last_query();
                            return TRUE;
              }

}
