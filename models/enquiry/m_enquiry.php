<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_enquiry
 *
 * @author Anup kumar
 */
class m_enquiry extends CI_Model {

              //put your code here
              public function __construct() {
                            parent::__construct();
              }

              /**
                @name check_name_mobile_already_exits($enq_name,$Mob_No)
               * Check enquiry already exits or not !!
               * @param String $enq_name name of the enquirer
               * @param String $Mob_No Mobile of enquirer  
               * @return array return True if exists false if doesn't exits             /
               */
              function check_name_mobile_already_exits($BrancheIDs, $enq_name, $Mob_No) {
                            /*

                             * Mobile no check,
                             * Mobile no should be 10 digit in lenght
                             * Name should be in alphabates shouldn't have integer                       */
                            if (!is_array($BrancheIDs) || strlen($Mob_No) != 10) {
                                          log_message("error", "Branch ID is not arrray or Mobile no is not correct, Directory : " . $this->router->fetch_directory() . " Class " . $this->router->fetch_class() . " Function " . $this->router->fetch_method());
                                          return array("succ" => FALSE);
                            }

                            $enq_name = trim($enq_name);
                            $this->db->where_in("enq.BranchID", $BrancheIDs);
                            $this->db->select('E_Code', 'Mobile1')->from(DB_PREFIX . "e_tab enq");
                            $this->db->where(array("enq.StudentName" => $enq_name, "enq.Mobile1" => $Mob_No));
                            $query = $this->db->get();
                            $result = $query->result();
                            if (empty($result)) {
                                          return array("succ" => FALSE);
                            } else {
                                          return array("succ" => TRUE, "edata" => $result[0]);
                            }
              }

              function _gen_eformno($BranchID) {

                            $this->db->select('BranchID,EFormNo')->from(DB_PREFIX . 'e_tab')->where(array("BranchID" => $BranchID));
                            $this->db->order_by("EFormNo", "DESC");
                            $query = $this->db->get();
                            $result = $query->result();
                            if (empty($result))
                                          return 1;
                            else {
                                          return $result[0]->EFormNo + 1;
                            }
              }

              function addenq($FormData) {
                            if ($this->db->insert(DB_PREFIX . "e_tab", $FormData)) {
                                          return array("succ" => TRUE, "E_Code" => $this->db->insert_id());
                            } else {
                                          return array("succ" => FALSE);
                            }
              }

              function addsource($FormData) {

                            if ($this->db->insert(DB_PREFIX . "e_sources", $FormData)) {
                                          return array("succ" => TRUE, "ESID" => $this->db->insert_id());
                            } else {
                                          return array("succ" => FALSE);
                            }
              }

              function addecourses($FormData) {
                            $e_courses_data = array();
                            $this->load->model('adm/admission_model', "adm_model");
                           // $this->util_model->printr($FormData['CourseID']);
                            $FormData['CourseID'] = $this->adm_model->get_final_courses($FormData['CourseID']);
                            //die($this->util_model->printr($FormData['CourseID']));
                            foreach ($FormData['CourseID'] as $course_id) {
                                          $e_courses_data[] = array(
                                              "Visit" => $FormData['Visit'],
                                              "E_Code" => $FormData['E_Code'],
                                              "CourseID" => $course_id,
                                              "Add_User" => $FormData['Add_User'],
                                              "Add_DateTime" => $FormData['Add_DateTime']);
                            }
                            //   die($this->util_model->printr($e_courses_data));
                            if ($this->db->insert_batch(DB_PREFIX . 'e_courses', $e_courses_data)) {
                                          return array("succ" => TRUE, "ECID" => $this->db->insert_id());
                            } else {
                                          return array("succ" => FALSE);
                            }
              }

              function addptime($FormData) {
                            $e_ptime_data = array();
                            for ($i = 0; $i < count($FormData['Str_Time']); $i++) {
                                          $e_ptime_data[] = array(
                                              "Visit" => $FormData['Visit'],
                                              "E_Code" => $FormData['E_Code'],
                                              "Str_Time" => $FormData['Str_Time'][$i],
                                              "End_Time" => $FormData['End_Time'][$i]);
                            }
                            //   die($this->util_model->printr($e_courses_data));
                            if ($this->db->insert_batch(DB_PREFIX . 'e_ptime', $e_ptime_data)) {
                                          return array("succ" => TRUE, "EPID" => $this->db->insert_id());
                            } else {
                                          return array("succ" => FALSE);
                            }
              }

              function get_enquiry_via_e_code($BranchID, $E_Code) {
                            $query = $this->db->select("t7.Code as Nname,t6.Code as Qname,t5.BranchCode,enq.*,t3.Emp_Code as Add_User, t4.Emp_Code as Mode_User,(select count(*) from " . DB_PREFIX . "e_sources es where es.E_Code=enq.E_Code) as t_enq,(select count(*) from " . DB_PREFIX . "e_courses ec where ec.E_Code=enq.E_Code) as t_enqc,t8.Code CurrDoingCode")->from(DB_PREFIX . "e_tab enq");
                            $this->db->join(DB_PREFIX . "employee t3", "enq.Add_User=t3.Emp_ID", 'LEFT');
                            $this->db->join(DB_PREFIX . "employee t4", "enq.Mode_User=t4.Emp_ID", 'LEFT');
                            $this->db->join(DB_PREFIX . "branch_mst t5", "enq.BranchID=t5.BranchID", 'LEFT');
                            $this->db->join(DB_PREFIX . "qualification t6", "enq.Quali=t6.QID", 'LEFT');
                            $this->db->join(DB_PREFIX . "nationality t7", "enq.NID=t7.NID", 'LEFT');
                            $this->db->join(DB_PREFIX . "current_doing t8", "enq.CurrentDoing=t8.CDID", 'LEFT');
                            $this->db->where(array("enq.Status" => 1, "enq.E_Code" => $E_Code));
                            $result = $query->get()->result();
//                            echo $this->db->last_query();
//                            die();
                            if (!empty($result))
                                          return $result[0];
              }

              function get_Enq_visit_Details_via_e_code($E_Code) {
                            $query = $this->db->select("es.E_Code, es.Src_CatID, es.Src_ID, es.Visit, "
                                            . "es.DOE, es.Insentive, es.InsenivePaid, es.PRO, es.Status,es.Mode_DateTime,"
                                            . "t3.Emp_Code as Add_User,t4.Emp_Code as Mode_User,"
                                            . "t5.Emp_Code as PRO_CODE,,t6.Src_Name as Src_CatName,t7.Src_Name as Src_IDName")->from(DB_PREFIX . "e_sources es");
                            // $this->db->join(DB_PREFIX . "e_courses ec", "es.E_Code=ec.E_Code", 'LEFT');
                            $this->db->join(DB_PREFIX . "employee t3", "es.Add_User=t3.Emp_ID", 'LEFT');
                            $this->db->join(DB_PREFIX . "employee t4", "es.Mode_User=t4.Emp_ID", 'LEFT');
                            $this->db->join(DB_PREFIX . "employee t5", "es.PRO=t5.Emp_ID", 'LEFT');
                            $this->db->join(DB_PREFIX . "e_source_mst t6", "es.Src_CatID=t6.SrcId", 'LEFT');
                            $this->db->join(DB_PREFIX . "e_source_mst t7", "es.Src_ID=t7.SrcId", 'LEFT');
                            $this->db->where(array("es.Status" => 1, "es.E_Code" => $E_Code));
                            $this->db->order_by('es.E_Code,es.Visit');
                            $result = $query->get()->result();
                            return $result;
              }

              function get_e_details_vai_visit_and_ecode($E_Code, $visit) {
                            $query = $this->db->get_where(DB_PREFIX . 'e_sources', array("E_Code" => $E_Code, "Visit" => $visit));
                            $result = $query->result();
                            return $result[0];
              }

              // those enquiry havn't followed yet
              function fresh_enquiry($BranchID = 0, $limit = 0, $order_by = 'enq.Add_DateTime', $order = 'DESC', $like = '') {
                            $query = $this->db->query("SELECT e_tab.Mode_DateTime,e_tab.FatherName,e_tab.EFormNo,e_tab.E_Code,es.Visit as Visit, e_tab.StudentName,e_tab.Mobile1,(select Emp_Code from " . DB_PREFIX . "employee where Emp_ID=e_tab.Add_User) as Add_UserCode,(select Emp_Code from " . DB_PREFIX . "employee where Emp_ID=es.PRO) as PROCode, (select Src_Code from " . DB_PREFIX . "e_source_mst esm where esm.SrcId=es.Src_ID) as SrcCode, (select Src_Code from " . DB_PREFIX . "e_source_mst esm where esm.SrcId=es.Src_CatID) as SrcCatCode,es.DOE,es.Status FROM " . DB_PREFIX . "e_tab e_tab INNER JOIN " . DB_PREFIX . "e_sources es ON (e_tab.E_Code=es.E_Code) where (select count(*) from " . DB_PREFIX . "e_followup ef where ef.E_Code=es.E_Code and ef.Visit=es.Visit)=0");
                            return $query->result();
              }

              function all_enq_list($BranchID = 0, $limit = 0, $order_by = 'enq.Add_DateTime', $order = 'DESC', $like = '') {
                            if ($BranchID != 0) {
                                          $order_by = "enq.BranchID, " . $order_by;
                                          $this->db->where(array("enq.BranchID " => $BranchID));
                            }
                            $query = $this->db->select("enq.*,t3.Emp_Code as Add_User, t4.Emp_Code as Mode_User,(select count(*) from " . DB_PREFIX . "e_sources es where es.E_Code=enq.E_Code) as t_enq,(select count(*) from " . DB_PREFIX . "e_courses ec where ec.E_Code=enq.E_Code) as t_enqc")->from(DB_PREFIX . "e_tab enq");
                            $this->db->join(DB_PREFIX . "employee t3", "enq.Add_User=t3.Emp_ID", 'LEFT');
                            $this->db->join(DB_PREFIX . "employee t4", "enq.Mode_User=t4.Emp_ID", 'LEFT');
                            if ($limit)
                                          $this->db->limit($limit);
                            if ($like != '') {

                                          $this->db->like($like);
                            } else {
                                          $this->db->where(array("enq.Status" => 1));
                            }

                            $this->db->order_by($order_by, $order);
                            $result = $query->get()->result();
                            return $result;
              }

              /*

               * it will show all enquiry list from e_source_master 
               * $BranchID will be 2,1
               * $str_date = starting date of enquiry default  First Day of Month

               * $end_date = default current date 2015-05-10 23:59:59 

               *   not in use             */

              public function get_enq_list($BranchID, $str_date, $end_date) {
                            $sql = "SELECT 
                                          GROUP_CONCAT(cm.CourseCode SEPARATOR ', ') as Courses,
                                          GROUP_CONCAT(cm.CourseID SEPARATOR ', ') as Courses,
                                          et.StudentName, ec.E_Code ,et.BranchID,ec.Visit ,
                                          CONCAT(et.Mobile1,' /',et.Phone1) as Contact, 
                                          es.Src_CatID,
                                          es.Src_ID,
                                          es.DOE,
                                          es.PRO,
                                          esm1.Src_Code as SrcCatCode,
                                          esm2.Src_Code as SrcCode
                                          FROM " . DB_PREFIX . "e_courses ec 
                                          left join " . DB_PREFIX . "course_mst cm on (ec.CourseID=cm.CourseID) 
                                          left join " . DB_PREFIX . "e_tab et on (et.E_Code= ec.E_Code) 
                                          left join " . DB_PREFIX . "e_sources es on (es.E_Code=ec.E_Code and es.Visit=ec.Visit) 
                                          left join " . DB_PREFIX . "e_source_mst esm1 on (es.Src_CatID=esm1.SrcId) 
                                          left join " . DB_PREFIX . "e_source_mst esm2 on (es.Src_ID=esm2.SrcId) 
                                          where et.BranchID=2 and et.Status=1 and (es.DOE>='2015-05-01 00:00:00' and es.DOE<='2015-05-10 23:59:59')
                                          GROUP BY  ec.E_Code,ec.Visit 
                                          order by es.DOE DESC limit 0,50";
                            $query = $this->db->query($sql);
                            $result = $query->result();
                            return $result;
              }

              public function del_enq($E_Code) {
                            if ($this->db->delete(DB_PREFIX . "e_tab", array("E_Code" => $E_Code)) &&
                                    $this->db->delete(DB_PREFIX . "e_sources", array("E_Code" => $E_Code)) &&
                                    $this->db->delete(DB_PREFIX . "e_courses", array("E_Code" => $E_Code)) &&
                                    $this->db->delete(DB_PREFIX . "e_ptime", array("E_Code" => $E_Code)) &&
                                    $this->db->delete(DB_PREFIX . "e_followup", array("E_Code" => $E_Code))
                            ) {
                                          return array(TRUE, "Deleted Successfully !!");
                            } else {
                                          return array(FALSE, "Error while Deleting Course Enquiry  !!");
                            }
              }

              public function follow_up_list_via_e_code($E_Code, $Visit) {
                            $query = $this->db->select("f.*,t3.Emp_Code as Add_User, t4.Emp_Code as Mode_User,t5.ResponseText as ResponseText,t6.Emp_Code as FollowerName,t7.Emp_Code as NextFollowerName,")->from(DB_PREFIX . "e_followup f");
                            $this->db->join(DB_PREFIX . "employee t3", "f.Add_User=t3.Emp_ID", 'LEFT');
                            $this->db->join(DB_PREFIX . "employee t4", "f.Mode_User=t4.Emp_ID", 'LEFT');
                            $this->db->join(DB_PREFIX . "employee t6", "f.FollowerID=t6.Emp_ID", 'LEFT');
                            $this->db->join(DB_PREFIX . "e_response_mst t5", "f.ResponseID=t5.ResponseID", 'LEFT');
                            $this->db->join(DB_PREFIX . "employee t7", "f.FollowerID=t7.Emp_ID", 'LEFT');
                            $this->db->where(array('f.Status' => TRUE, "f.E_Code" => $E_Code, "f.Visit" => $Visit));
                            $result = $query->get()->result();
                            return $result;
              }

              // to show last n no of follow up list
              public function get_lastn_followups($BranchIDs, $limit = 50) {
                            if ($BranchIDs != '') {
                                          $this->db->order_by('et.BranchID');
                                          $this->db->where_in('et.BranchID', $BranchIDs);
                            }
                            $query = $this->db->select("f.*,t3.Emp_Code as Add_User, t4.Emp_Code as Mode_User,t5.ResponseText as ResponseText,t6.Emp_Code as FollowerName,t7.Emp_Code as NextFollowerName,")->from(DB_PREFIX . "e_followup f");
                            $this->db->join(DB_PREFIX . "employee t3", "f.Add_User=t3.Emp_ID", 'LEFT');
                            $this->db->join(DB_PREFIX . "e_tab et", "f.E_Code=et.E_Code");
                            $this->db->join(DB_PREFIX . "employee t4", "f.Mode_User=t4.Emp_ID", 'LEFT');
                            $this->db->join(DB_PREFIX . "employee t6", "f.FollowerID=t6.Emp_ID", 'LEFT');
                            $this->db->join(DB_PREFIX . "e_response_mst t5", "f.ResponseID=t5.ResponseID", 'LEFT');
                            $this->db->join(DB_PREFIX . "employee t7", "f.FollowerID=t7.Emp_ID", 'LEFT');
                            $this->db->where(array('f.Status' => TRUE));
                            $this->db->limit($limit);
                            $result = $query->get()->result();
                            return $result;
              }

//              //get notification 
//              public function get_notification($BranchID, $EmpCode) {
//                            $this->db->select();
//                            $this->db->from(DB_PREFIX . 'e_followup');
//                            $this->db->where(array('stst'));
//              }

              public function save_follow_up($FormData) {
                            if ($this->db->insert(DB_PREFIX . "e_followup", $FormData)) {
                                          return array("succ" => TRUE);
                            } else {
                                          return array("succ" => FALSE);
                            }
              }

              public function all_ecourses_visit_wise($E_Code, $Visit) {
                            $this->db->select('ec.*,t2.CourseCode as esCourseCode')->from(DB_PREFIX . "e_courses ec");
                            $this->db->join(DB_PREFIX . "course_mst t2", "ec.CourseID=t2.CourseID", 'LEFT');
                            $this->db->where(array("ec.E_Code" => $E_Code, "ec.Visit" => $Visit));
                            $query = $this->db->get();
                            $result = $query->result();
                            return $result;
              }

              // used to update the basic enquiry details
              public function update_basic_enquiry_details($FormData, $E_Code) {
                            $this->db->where(array("E_Code" => $E_Code));
                            $FormData['DOB'] = date(DB_DF, strtotime($FormData['DOB']));
                            if ($this->db->update(DB_PREFIX . 'e_tab', $FormData)) {
                                          return array("success" => TRUE, "_err_msg" => "", "E_Code" => $E_Code);
                            } else {
                                          return array("success" => FALSE, "_err_msg" => "Error while Updation in Basic enquiry Details", "E_Code" => $FormData['E_Code']);
                            }
              }

              // used to set view notification = 1 when user see notification and click to follow
              function set_view_notification($FollowID) {
                            $this->db->where(array("FollowID" => $FollowID));
                            $this->db->update(DB_PREFIX . "e_followup", array("ViewNotification" => 1));
                            if ($this->db->affected_rows() > 0) {
                                          return array("success" => TRUE, "_err_msg" => "");
                            } else {
                                          return array("success" => FALSE, "_err_msg" => "Error Occured in view notification !!");
                            }
              }

              function get_e_course($E_Code, $Visit, $CourseID) {
                            $whr = array("E_Code" => $E_Code, "Visit" => $Visit, "CourseID" => $CourseID);
                            $query = $this->db->get_where(DB_PREFIX . "e_courses", $whr);
                            return $query->result();
              }

              // used to update the source details on per enquiry visit
              public function update_e_source() {
                            $FormData = $this->input->post();
                            $FormData = $this->util_model->add_mode_user($FormData);
                            $E_Code = $FormData['E_Code'];
                            $Visit = $FormData['Visit'];
                            $FormData = $this->util_model->unset_array($FormData, array('E_Code', 'Visit'));
                            $whr = array("E_Code" => $E_Code, "Visit" => $Visit);
                            $this->db->where($whr);
                            if ($this->db->update(DB_PREFIX . "e_sources", $FormData)) {
                                          return array("success" => TRUE, "_err_msg" => "Enquiry Source has been updated successfully for Visit $Visit");
                            } else {
                                          return array("success" => FALSE, "_err_msg" => "Error while Updation in Eqnuiry Source");
                            }
              }

              public function update_e_course() {
                            $FormData = $this->input->post();
                            // $this->util_model->printr($FormData);

                            $FormData = $this->util_model->add_mode_user($FormData);
                            $E_Code = $FormData['E_Code'];
                            $Visit = $FormData['Visit'];
                            $CourseID = $FormData['CourseID'];
                            $OldCourseID = $FormData['OldCourseID'];
                            // return row if any entry does exists in db
                            $Course_already_exists = $this->get_e_course($E_Code, $Visit, $CourseID);
                            if (!empty($Course_already_exists)) {
                                          return array("success" => FALSE, "_err_msg" => "This Entry already exists !!");
                            }
                            $FormData = $this->util_model->unset_array($FormData, array('E_Code', 'Visit', 'OldCourseID'));
                            $whr = array("E_Code" => $E_Code, "Visit" => $Visit, "CourseID" => $OldCourseID);
                            $this->db->where($whr);
                            if ($this->db->update(DB_PREFIX . "e_courses", $FormData)) {
                                          return array("success" => TRUE, "_err_msg" => "Enquiry Courses has been updated successfully for Visit $Visit");
                            } else {
                                          return array("success" => FALSE, "_err_msg" => "Error while Updation in Eqnuiry Courses");
                            }
              }

              // add e_course 
              public function add_e_course() {
                            $FormData = $this->input->post();
                            // $this->util_model->printr($FormData);
                            $FormData = $this->util_model->add_common_fields($FormData);
                            $E_Code = $FormData['E_Code'];
                            $Visit = $FormData['Visit'];
                            $CourseID = $FormData['CourseID'];
                            // return row if any entry does exists in db
                            $Course_already_exists = $this->get_e_course($E_Code, $Visit, $CourseID);
                            if (!empty($Course_already_exists)) {
                                          return array("success" => FALSE, "_err_msg" => "This Entry already exists !!");
                            }
                            if ($this->db->insert(DB_PREFIX . "e_courses", $FormData)) {
                                          return array("success" => TRUE, "_err_msg" => "Enquiry Courses has been Added successfully for Visit $Visit");
                            } else {
                                          return array("success" => FALSE, "_err_msg" => "Error while Adding in Eqnuiry Courses");
                            }
              }

              /*

               * delete_e_course used to delete enquiry courses     */

              public function delete_e_course() {
                            $FormData = $this->input->post();
                            // $this->util_model->printr($FormData);
                            $E_Code = $FormData['E_Code'];
                            $Visit = $FormData['Visit'];
                            $CourseID = $FormData['CourseID'];
                            $whr = array("E_Code" => $E_Code, "Visit" => $Visit, "CourseID" => $CourseID);
                            if ($this->db->delete(DB_PREFIX . "e_courses", $whr)) {
                                          return array("success" => TRUE, "_err_msg" => "Enquiry Courses has been deleted successfully for Visit $Visit");
                            } else {
                                          return array("success" => FALSE, "_err_msg" => "Error while deleting  Eqnuiry Course");
                            }
              }

              public function todays_follow_list($BranchIDs = '', $limit = 0, $view_notification = 0, $nofity_next_flag = 1) {
                            if ($BranchIDs != '') {
                                          $this->db->order_by('et.BranchID');
                                          $this->db->where_in('et.BranchID', $BranchIDs);
                            }
                            $this->db->select("ef.*,et.Mobile1,et.StudentName,t3.Emp_Code as Add_UserCode,t5.ResponseText as ResponseText,t6.Emp_Code as FollowerName")->from(DB_PREFIX . "e_followup ef");
                            $this->db->join(DB_PREFIX . "e_tab et", "ef.E_Code=et.E_Code");
                            $this->db->join(DB_PREFIX . "employee t3", "ef.Add_User=t3.Emp_ID", 'LEFT');
                            $this->db->join(DB_PREFIX . "e_response_mst t5", "ef.ResponseID=t5.ResponseID", 'LEFT');
                            $this->db->join(DB_PREFIX . "employee t6", "ef.FollowerID=t6.Emp_ID", 'LEFT');
                            $this->db->where(array("nofity_next_flag" => $nofity_next_flag));
                            $this->db->where("DATE(nextNotifyDateTime) = DATE(NOW())", NULL, FALSE);
                            $this->db->order_by("ViewNotification");

                            $query = $this->db->get();
                            return $query->result();
              }

              function delete_follow_up($fid) {
                            $whr = array("FollowID" => $fid);
                            if ($this->db->delete(DB_PREFIX . "e_followup", $whr)) {
                                          return array(TRUE, "Enquiry Follow up has been deleted successfully.");
                            } else {
                                          return array(FALSE, "Error while deleting  Eqnuiry Follow Up.");
                            }
              }

              // Search Enquiry calling form ajax .. return associative array with following fields
              /*

               * [E_Code] => 1
                [Visit] => 1
                [CourseID] => 78
                [enquired_course] => 1
                [Src_CatID] => 36
                [Src_ID] => 60
                [DOE] => 2015-05-10 10:40:00
                [PRO] => 36
                [Status] => 1
                [Remarks] => Remarks !!
                [EFormNo] => 1
                [StudentName] => Anup kumar
                [FatherName] => FatherName
                [Mobile1] => 7835851114
                [C_Locality] => 2449
                [total_followups] => 2
                [admCourseID] => 78
                [Stu_Id] => 1
                [DOR] => 2015-05-12
                [enqCourseCode] => FOAA
                [admCourseCode] => FOAA
                [Src_CatCode] => ONLINEMODE
                [Src_Code] => NA
                [PROCode] => VAN
                [EnrollNo] => VIPS140001
                [lcode] => Adarsh Nagar
               *  */
              function search_enq($POST) {
                            global $data;

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

                                                                      $this->db->where("sc.DOR>=", "'$from'", FALSE);
                                                                      $this->db->where("sc.DOR<=", "'$to'", FALSE);

                                                                      $condi_given = TRUE; // it is for getting, yes any one condition is given
                                                        }
                                          }
                                          // end of DOE_DOR   
                                          // end of advance search
                                          //PRO wise
                                          if (isset($POST['PROList'])) {
                                                        $this->db->where_in("es.PRO", $POST['PROList']);
                                          }
                                          //end of PRO wise
                                          //Src Wise
                                          if (isset($POST['SrcList'])) {
                                                        $this->db->where_in("es.Src_ID", $POST['SrcList']);
                                          }
                                          //end of Src Wise
                                          // coursewise
                                          if (isset($POST['CourseList'])) {
                                                        $this->db->where_in("ec.CourseID", $POST['CourseList']);
                                          }
                                          // end of coursewise
                                          // locality list
                                          if (isset($POST['LocalityList'])) {
                                                        $this->db->where_in("et.C_Locality", $POST['LocalityList']);
                                          }
                                          // end of locality list
                            }
                            // $this->util_model->printr($POST);
                            // basic search via make for multi search only !!  
                            foreach ($POST['search_via_value'] as $index => $search_value) {
                                          if ($search_value != "") {
                                                        //return array("succ"=>FALSE,"_err_code"=>"UnSuccDataToSearchEnq");
                                                        $column_list = array(
                                                            "Mob1" => "et.Mobile1",
                                                            "Name" => "et.StudentName",
                                                            "Fname" => "et.FatherName",
                                                            "EFNo" => "et.EFormNo",
                                                            "ECode" => "et.E_code",
                                                            "Email1" => "et.Email1");
                                                        $col = isset($column_list[$POST['search_via'][$index]]) ? $column_list[$POST['search_via'][$index]] : '';
                                                        // $value = $POST['search_via_value1'];
                                                        if ($col != "") {
                                                                      $this->db->where($col, $search_value);
                                                                      $condi_given = TRUE; // it is for getting, yes any one condition is given
                                                        }
                                          }
                            }

                            //$this->util_model->printr($POST);
                            $this->db->select('ec.E_Code,
                                ec.Visit,
                                et.EFormNo,
                                (select count(*) as t from ' . DB_PREFIX . 'e_followup f where  f.E_Code = ec.E_Code and f.Visit = ec.Visit) as total_followups,
                                es.DOE,
                                ec.enquired_course,
                                sc.Stu_Id,
                                sc.DOR,
                                GROUP_CONCAT(sc.CourseID SEPARATOR ", ") as admCourseID,
                                et.StudentName,
                                et.FatherName,
                                et.Mobile1,
                                es.Src_CatID,
                                es.Src_ID,
                                es.PRO,
                                es.Status,
                                es.Remarks,
                                et.Email1,
                                GROUP_CONCAT(ec.CourseID SEPARATOR ", ") as CourseID,
                                et.C_Locality',FALSE)->from(DB_PREFIX . "e_courses ec");
                            $this->db->join(DB_PREFIX . "e_sources es", "ec.E_Code = es.E_Code and ec.Visit= es.Visit", "left");
                            $this->db->join(DB_PREFIX . "e_tab et", "ec.E_Code = et.E_code", "left");
                            $this->db->join(DB_PREFIX . "stu_courses sc", "sc.E_Code = ec.E_Code and sc.Visit= ec.Visit and sc.CourseID = ec.CourseID", "left");
                            $this->db->where(array("et.BranchID" => $data['Session_Data']['IBMS_BRANCHID']));
                            $this->db->group_by("ec.E_Code");
                            $query = $this->db->get();
                            $result = $query->result_array();
                            $all_courses = $this->util_model->get_list('CourseID', 'CourseCode', DB_PREFIX . "course_mst", $data['Session_Data']['IBMS_BRANCHID'], 'CourseID');
                            $all_users = $this->util_model->get_list('Emp_ID', 'Emp_Code', DB_PREFIX . "employee", $data['Session_Data']['IBMS_BRANCHID'], 'Emp_ID');
                            $all_sources = $this->util_model->get_list('SrcId', 'Src_Code', DB_PREFIX . "e_source_mst", $data['Session_Data']['IBMS_BRANCHID'], 'SrcId');
                            $all_enroll = $this->util_model->get_list('Stu_ID', 'EnrollNo', DB_PREFIX . "stu_mst", $data['Session_Data']['IBMS_BRANCHID'], 'Stu_ID');
                            $locality_list = $this->util_model->get_list('localityid', 'locality', DB_PREFIX . "locality", 0, 'localityid');
                            $final_enquiry_list = array();
                            foreach ($result as $row) {
                                          //$this->util_model->printr($row);
                                          $e_courses = explode(", ", $row['CourseID']);
                                          $row['enqCourseCode'] = array();
                                          foreach ($e_courses as $CourseID) {
                                             $row['enqCourseCode'][] = isset($all_courses[$CourseID]) ? $all_courses[$CourseID] : 'NA';              
                                          }
                                          $row['enqCourseCode'] = implode(", ", $row['enqCourseCode']);
                                          $adm_courses = explode(",", $row['admCourseID']);
                                          $row['admCourseCode'] = array();
                                          foreach ($adm_courses as $CourseID) {
                                             $row['admCourseCode'][] = isset($all_courses[$CourseID]) ? $all_courses[$CourseID] : 'NA';              
                                          }
                                          $row['admCourseCode'] = implode(",", $row['admCourseCode']);
                                          $row['Src_CatCode'] = isset($all_sources[$row['Src_CatID']]) ? $all_sources[$row['Src_CatID']] : 'NA';
                                          $row['Src_Code'] = isset($all_sources[$row['Src_ID']]) ? $all_sources[$row['Src_ID']] : 'NA';
                                          $row['PROCode'] = isset($all_users[$row['PRO']]) ? $all_users[$row['PRO']] : 'NA';
                                          $row['EnrollNo'] = isset($all_enroll[$row['Stu_Id']]) ? $all_enroll[$row['Stu_Id']] : 'NA';
                                          $row['lcode'] = isset($locality_list[$row['C_Locality']]) ? $locality_list[$row['C_Locality']] : 'NA';
                                          $final_enquiry_list[] = $row;
                            }
                            return $final_enquiry_list;
                            //$this->util_model->printr($final_enquiry_list);
              }

              /*

               * get_e_details($E_Code,$Visit)
               * @param1 $E_Code Int
               * @param2 $visit Int
               * return it is mainly to give all enquiry details for admission
               * it is calling to other three function
               *       1. all_ecourses_visit_wise($E_Code, $Visit)  for getting course
               *       2. get_e_details_vai_visit_and_ecode($E_Code, $visit): for getting sources         
               *       3. get_enquiry_via_e_code($BranchID, $E_Code) : basic details       */

              public function get_e_details($E_Code, $Visit) {
                            global $data;
                            $enq_details = array();
                            $enq_details['e_basic_details'] = $this->get_enquiry_via_e_code($data['Session_Data']['IBMS_BRANCHID'], $E_Code);
                            $enq_details['e_courses'] = $this->all_ecourses_visit_wise($E_Code, $Visit);
                            $enq_details['e_sources'] = $this->get_e_details_vai_visit_and_ecode($E_Code, $Visit);
                            return $enq_details;
              }

              public function get_search_col_list() {
                            return array(
                                "Mob1" => "Mobile",
                                "Name" => "Student Name",
                                "FName" => "Father Name",
                                "EFNo" => "Enq Form No",
                                "ECode" => "Enq Code",
                                "Email1" => "Email");
              }

}
