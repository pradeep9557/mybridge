<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of course
 *
 * @author Mr. Anup
 */
class course extends CI_Model {

              function __construct() {
                            parent::__construct();
              }

              public function Course_list_with_Course_Cat() {
                            $query = $this->db->select()->from("nexgen_course_mst")->order_by('Course_Name');
                            $result = $query->get()->result();
                            $Course_list_with_Course_Cat = array();
                            foreach ($result as $value) {
                                          $Course_list_with_Course_Cat[$value->CourseCode] = $value->CourseCode;
                            }
                            return $Course_list_with_Course_Cat;
              }

              //new course list display 
              public function Course_list_with_child($BranchID, $parentID = 0, $parentName = '', $C_CID = 0) {
                            $clist = array();
                            $query = $this->db->select()->from(DB_PREFIX . "course_mst");
                            if ($C_CID)
                                          $this->db->where(array("C_CID" => $C_CID));
                            $this->db->where(array('parentID' => $parentID, 'Status' => 1, 'BranchID' => $BranchID));
                            $result = $query->get();
                            foreach ($result->result_array() as $row) {
                                          $clist[] = array('parent' => $row['CourseID'], 'name' => $parentName . "" . ($parentName == "" ? "" : " -> ") . $row['Course_Name'], 'child' => $this->Course_list_with_child($BranchID, $row['CourseID'], $parentName . "" . ($parentName == "" ? "" : " -> ") . $row['Course_Name'], $C_CID));
                            }

                            return $clist;
              }

              public function listConvert($List) {
                            $clist = array();

                            if ($List != null) {
                                          foreach ($List as $course) {

                                                        $clist[$course['parent']] = $course['name'];
                                                        $clist = $this->joinTwoarray($clist, $course['child']);
                                          }
                            }

                            return $clist;
              }

              public function joinTwoarray($array1, $array2) {
                            if ($array2 != NULL) {
                                          foreach ($array2 as $value) {

                                                        $array1[$value['parent']] = $value['name'];
                                                        $array1 = $this->joinTwoarray($array1, $value['child']);
                                          }
                            }

                            return $array1;
              }

//end of code course list displau
              public function all_Course_list($filter_data = array()) {
                            if (!empty($filter_data)) {
                                          if (isset($filter_data['BranchID'])) {
                                                        $this->db->where("cm.BranchID", $filter_data['BranchID']);
                                          }
                                          if (isset($filter_data['Status'])) {
                                                        $this->db->where("cm.Status", $filter_data['Status']);
                                          }
                                          if (isset($filter_data['OrderCol'])) {
                                                        $this->db->order_by($filter_data['OrderCol'], "ASC");
                                          } else {
                                                        $this->db->order_by("cm.Mode_DateTime", "DESC");
                                          }
                            }

                            $query = $this->db->select("`cm`.`CourseID`,cm.Remarks, `cm`.`CourseCode`, `cm`.`Course_Name`, `t2`.`C_CatName`, "
                                            . "`t2`.`C_CatCode`,cm.Duration,cm.MonthDay, `cm`.`Status`, `t3`.`Emp_Code` as Add_User,"
                                            . " `t4`.`Emp_Code` as Mode_User,cm.Add_DateTime,cm.Mode_DateTime,t5.CourseFee")->from("nexgen_course_mst cm");
                            $this->db->join(DB_PREFIX . "course_cat_mst t2", "cm.C_CID=t2.C_CID", 'LEFT');
                            $this->db->join(DB_PREFIX . "employee t3", "cm.Add_User=t3.Emp_ID", 'LEFT');
                            $this->db->join(DB_PREFIX . "employee t4", "cm.Mode_User=t4.Emp_ID", 'LEFT');
                            $this->db->join(DB_PREFIX . "course_fee t5", "cm.CourseID=t5.CourseID and t5.Status=1", 'LEFT');
                            $result = $query->get()->result();
                            return $result;
              }

              public function all_CourseCat_list($BranchID = 0, $orderby = 'ccm.Add_DateTime', $order = "DESC") {
                            global $data;
                            if ($BranchID != 0) {
                                          $orderby = " ccm.BranchID, " . $orderby;
                                          $this->db->where(array("ccm.BranchID " => $BranchID));
                            } else {
                                          $this->db->where(array("ccm.BranchID " => $data['Session_Data']['IBMS_BRANCHID']));
                            }
                            $query = $this->db->select("`ccm`.`C_CID`,`ccm`.`Sort`, `ccm`.`C_CatCode`, `ccm`.`C_CatName`,`ccm`.`Status`,`t3`.`Emp_Code` as Add_User, `t4`.`Emp_Code` as Mode_User,ccm.Add_DateTime,ccm.Mode_DateTime")->from(DB_PREFIX . "course_cat_mst ccm");
                            $this->db->join(DB_PREFIX . "employee t3", "ccm.Add_User=t3.Emp_ID", 'LEFT');
                            $this->db->join(DB_PREFIX . "employee t4", "ccm.Mode_User=t4.Emp_ID", 'LEFT');
                            $this->db->order_by($orderby, $order);
                            $result = $query->get()->result();
                            return $result;
              }

//    public function all_distinct_CourseCatagory_list() {
//        $query = $this->db->select('Category'); //->from("nexgen_course_mst");
//        $this->db->distinct();
//        $query = $this->db->get('nexgen_course_mst');
//        $result = $query->result();
//        $all_Course_Category_List = array();
//        // print_r($result);
//        foreach ($result as $value) {
//            $all_Course_Category_List["{$value->Category}"] = $value->Category;
//        }
//        return $all_Course_Category_List;
//    }
//    public function all_distinct_CourseCatagoryCode_list() {
//        $query = $this->db->select('CategoryCode'); //->from("nexgen_course_mst");
//        $this->db->distinct();
//        $query = $this->db->get('nexgen_course_mst');
//        $result = $query->result();
//        //print_r($result);
//        $all_Course_CategoryCode_List = array();
//        foreach ($result as $value) {
//            $all_Course_CategoryCode_List["{$value->CategoryCode}"] = $value->CategoryCode;
//        }
//        return $all_Course_CategoryCode_List;
//    }
              function form_validation($POST) {
                            $err_codes = '';
                            if (isset($POST['CourseCode']) && $POST['CourseCode'] == "") {
                                          $err_codes.='C_CodeBlank' . ERR_DELIMETER;
                            }
                            if (isset($POST['Course_Name']) && $POST['Course_Name'] == "") {
                                          $err_codes.='C_NameBlank' . ERR_DELIMETER;
                            }
                            if (isset($POST['Duration']) && $POST['Duration'] == "") {
                                          $err_codes.='C_DurationBlank' . ERR_DELIMETER;
                            }
                            $valid = $err_codes == '' ? TRUE : FALSE;
                            return array("_err" => $valid, "_err_codes" => $err_codes);
              }

              function insert_db() {
                            $FormData = $this->input->post(); // getting all form data
                            $validates = $this->form_validation($FormData); // validating the form
                            // die($this->util_model->printr($validates));
                            if (!$validates['_err']) {
                                          return array("succ" => false, "_err_codes" => $validates['_err_codes']);
                            }

                            $this->db->trans_begin();
                            /* if clicked on new category */
                            if ($FormData['New_Category'] != "") {
                                          $data_to_insert = array("BranchID" => $FormData['BranchID'],
                                              "C_CatCode" => $FormData['New_Category'],
                                              "C_CatName" => $FormData['New_Category'],
                                              "Status" => TRUE);
                                          $data_to_insert = $this->util_model->add_common_fields($data_to_insert);
                                          if (!$this->db->insert(DB_PREFIX . "course_cat_mst", $data_to_insert)) {
                                                        $this->db->trans_rollback();
                                                        return array("succ" => FALSE, "_err_codes" => "C_CatAddErr");
                                          } else {
                                                        $FormData['C_CID'] = $this->db->insert_id();
                                          }
                            }

                            $FormData = $this->util_model->add_common_fields($FormData);

                            // fees data
                            $Course_fees_data = array("CourseFee" => $FormData['CourseFee'],
                                "Add_User" => $FormData['Add_User'],
                                "BranchID" => $FormData['BranchID']);


                            $FormData = $this->util_model->unset_array($FormData, array('CourseFee', 'Add_Course', 'New_Category'));
                            // DIE($this->util_model->printr($FormData));
                            $this->db->insert("nexgen_course_mst", $FormData);
                            $Course_fees_data["CourseID"] = $this->db->insert_id();

                            $this->onCourseAmtUpdate($Course_fees_data);

                            if ($this->db->trans_status() === TRUE) {
                                          $this->db->trans_commit();
                                          return array("succ" => TRUE, "_err_codes" => "C_AddSucc");
                            } else {
                                          $this->db->trans_rollback();
                                          return array("succ" => FALSE, "_err_codes" => "C_AddErr");
                            }
              }

              function update_course() {
                             $FormData = $this->input->post(); // getting all form data
                            $FormData = $this->util_model->add_mode_user($FormData);

                            $validates = $this->form_validation($FormData); // validating the form
                            // die($this->util_model->printr($validates));
                            if (!$validates['_err']) {
                                          return array("succ" => false, "_err_codes" => $validates['_err_codes']);
                            }

                            $this->db->trans_begin();
                            $CourseID = $FormData['courseid'];
                            /* check if there is any update in amount then re-insert */
                            if (isset($FormData['update_fee'])) {
                                          // fees data
                                          $Course_fees_data = array("CourseFee" => $FormData['CourseFee'],
                                              "Add_User" => $FormData['Mode_User'],
                                              "BranchID" => $FormData['BranchID'],
                                              "CourseID" => $CourseID);

                                          $this->onCourseAmtUpdate($Course_fees_data);
                            }
                            $FormData['Status'] = isset($FormData['Status']);
                            $this->db->where('CourseID', $FormData['courseid']);
                            $FormData = $this->util_model->unset_array($FormData, array('New_Category', 'courseid', 'Add_Course', "update_fee", "CourseFee"));
                            $this->db->update(DB_PREFIX . "course_mst", $FormData);
                            if ($this->db->trans_status() === TRUE) {
                                          $this->db->trans_commit();
                                          return array("succ" => TRUE, "_err_codes" => "C_UpSucc", "CourseID" => $CourseID);
                            } else {
                                          $this->db->trans_rollback();
                                          return array("succ" => TRUE, "_err_codes" => "C_ErrUpSucc", "CourseID" => $CourseID);
                            }
              }

              /*

               * check fee amount update .. reinsert in nexgen_course_fee                */

              function onCourseAmtUpdate($Form_Data) {
                            // deactive if there is any existing course fees    
                            $this->db->update(DB_PREFIX . "course_fee", array("Status" => FALSE), array("CourseID" => $Form_Data['CourseID'], "BranchID" => $Form_Data['BranchID']));
                            // insert new one
                            $this->db->insert(DB_PREFIX . "course_fee", $Form_Data);
              }

              function cat_form_validation($POST) {
                            $err_codes = '';
                            if (isset($POST['C_CatCode']) && $POST['C_CatCode'] == "") {
                                          $err_codes.='C_CatCodeBlank' . ERR_DELIMETER;
                            }
                            if (isset($POST['C_CatName']) && $POST['C_CatName'] == "") {
                                          $err_codes.='C_CatNameBlank' . ERR_DELIMETER;
                            }
                            $valid = $err_codes == '' ? TRUE : FALSE;
                            return array("_err" => $valid, "_err_codes" => $err_codes);
              }

              public function save_course_cat($FormData) {
                            $validates = $this->cat_form_validation($FormData); // validating the form
                            if (!$validates['_err']) {
                                          return array("succ" => false, "_err_codes" => $validates['_err_codes']);
                            }
                            if ($FormData["Add_CourseCat"] === "Save") {
                                          $FormData = $this->util_model->add_common_fields($FormData);
                                          unset($FormData['Add_CourseCat']);
                                          if ($this->db->insert(DB_PREFIX . "course_cat_mst", $FormData)) {
                                                        return array("succ" => TRUE, "_err_codes" => "C_CatAddSucc");
                                          } else {
                                                        return array("succ" => FALSE, "_err_codes" => "C_CatAddErr");
                                          }
                            }
              }

              public function delete_course_cat($C_CID) {
                            $result = $this->db->get_where(DB_PREFIX . "course_mst", array("C_CID" => $C_CID));
                            if ($result->num_rows == 0) {
                                          if ($this->db->delete(DB_PREFIX . "course_cat_mst", array("C_CID" => $C_CID))) {
                                                        return array(TRUE, "Deleted Successfully !!");
                                          } else {
                                                        return array(FALSE, "Error while Deleting Course Category  !!");
                                          }
                            } else {
                                          return array(FALSE, "This Course Category is already allocated to your $result->num_rows Courses, First Delete Them !!");
                            }
              }

              public function get_course_details($CourseID) {
                            $this->db->where("cm.CourseID", $CourseID);
                            $this->db->select('cm.*,cfm.CourseFee')->from(DB_PREFIX . 'course_mst cm');
                            $this->db->join(DB_PREFIX . "course_fee cfm", "cm.CourseID=cfm.CourseID  and cfm.Status=1", "left");

                            $query = $this->db->get();
                            if ($this->db->count_all_results() > 0) {
                                          $course_details = $query->first_row();
                                          return $course_details;
                            } else {
                                          return FALSE;
                            }
              }

              public function get_details_from_database($CourseCode = '', $only_duration = 0) {
                            $query = $this->db->get_where(DB_PREFIX . 'course_mst', array("CourseCode" => $CourseCode));
                            if ($this->db->count_all_results() > 0) {
                                          $course_details = $query->first_row();
                                          if ($only_duration)
                                                        return $course_details->Duration . " " . $course_details->MonthDay;
                                          return $course_details; //sending first row
                            }else {
                                          return FALSE;
                            }
              }
              
              /*

               * public funciton get_course_fee
               * param1 courseid int 
               * return float fees                */
              public function get_course_fee($CourseID) {
                            global $data;
                             $result = $this->db->get_where(DB_PREFIX."course_fee",array("CourseID"=>$CourseID,"Status"=>TRUE,"BranchID"=>$data['Session_Data']['IBMS_BRANCHID']      )); 
                             //die($this->util_model->printr($result));
                             if ($result->num_rows) {
                                           $course_fee_details =  $result->first_row();     
                                           //die($this->util_model->printr($course_fee_details));
                                           return !empty($course_fee_details)?$course_fee_details->CourseFee:0;
                             }
                             return 0;
              }
              
              
               public function get_faculty_via_course($filter_data= array()) {
                  if(!empty($filter_data)){
                                if(isset($filter_data['CourseID'])){
                                              $this->db->where("bm.CourseID",$filter_data['CourseID']);
                                }
                                if(isset($filter_data['Status'])){
                                              $this->db->where("bm.Status",$filter_data['Status']);
                                }
                  }
                  $this->db->select("bm.FacultyID,emp.Emp_Code")->from(DB_PREFIX."batch_master bm");
                  $this->db->join(DB_PREFIX."employee emp","bm.FacultyID=emp.Emp_ID","left");
                  $this->db->order_by("emp.Emp_Code");
                  $result = $this->db->get()->result_array();
                  $final_result = array();
                  //$this->util_model->printr($result);
                  foreach ($result as $each_row) {
                             $final_result[$each_row['FacultyID']] = $each_row['Emp_Code'];   
                  }
                  return $final_result;
                  
    } 

}
