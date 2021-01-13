<?php

class ajax_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function upload_pic($path, $Uploading_Pic_Name, $FILE) {
        $this->load->helper('file');
        //$this->load->helper('url');
        $this->load->model("upload/file_upload");
        $PIC = $FILE['name'];
        if ($PIC != "") {
            if (file_exists($path . $PIC)) {
                unlink($path . $PIC);
            }
            if (move_uploaded_file($FILE['tmp_name'], $path . $PIC)) {
                $this->file_upload->initial($path . $PIC);

                $this->file_upload->resizeImage(330, 426, 'auto');
                if (file_exists($path . $Uploading_Pic_Name)) {
                    unlink($path . $Uploading_Pic_Name);
                }
                $this->file_upload->saveImage($path . $Uploading_Pic_Name, 100);
                unlink($path . $PIC);
            }
        }
        return array(TRUE, $Uploading_Pic_Name);
    }

    public function Search_Student($Searching_Form_Data) {
        $query = "";

        if ($Searching_Form_Data['Searching_option'] === "EnrollNo") {
            $this->db->select(DB_PREFIX . 'scnb.EnrollNo,' . DB_PREFIX . 'stu_mst.DOR,' . DB_PREFIX . 'stu_mst.Stu_ID,' . DB_PREFIX . 'stu_mst.StudentName,' . DB_PREFIX . 'stu_mst.FatherName,' . DB_PREFIX . 'scnb.CourseCode,' . DB_PREFIX . 'stu_mst.Mobile1,' . DB_PREFIX . 'scnb.Add_User,' . DB_PREFIX . 'scnb.Mode_User');
            $this->db->from('' . DB_PREFIX . 'stu_mst');
            $this->db->join('' . DB_PREFIX . 'scnb', '' . DB_PREFIX . 'scnb.EnrollNo = ' . DB_PREFIX . 'stu_mst.EnrollNo', 'inner')->where(array('' . DB_PREFIX . 'stu_mst.EnrollNo' => $Searching_Form_Data['EnrollNo'], '' . DB_PREFIX . 'scnb.EnrollNo' => $Searching_Form_Data['EnrollNo']));
            $query = $this->db->get(); // It will return query..
            return $query->result();  //  It will return result..
        } else if ($Searching_Form_Data['Searching_option'] === "Receipt_Number") {
            $this->db->select('' . DB_PREFIX . 'stu_mst.EnrollNo,' . DB_PREFIX . 'stu_mst.StudentName,' . DB_PREFIX . 'stu_mst.FatherName,' . DB_PREFIX . 'fee_trn.CourseCode,' . DB_PREFIX . 'stu_mst.Mobile1,' . DB_PREFIX . 'stu_mst.Add_User,' . DB_PREFIX . 'stu_mst.Mode_User');
            $this->db->from('' . DB_PREFIX . 'stu_mst');
            $this->db->join('' . DB_PREFIX . 'fee_trn', '' . DB_PREFIX . 'fee_trn.EnrollNo = ' . DB_PREFIX . 'stu_mst.EnrollNo', 'inner')->where(array('' . DB_PREFIX . 'fee_trn.ID' => $Searching_Form_Data['EnrollNo']));
            $query = $this->db->get(); // It will return query..
            return $query->result();  //  It will return result..
        } else if ($Searching_Form_Data['Searching_option'] === "Between_Dates") {
            $dates = explode('-', $Searching_Form_Data['between_dates']);
            $d1 = date('Y-m-d', strtotime(trim($dates[0])));
            $d2 = date('Y-m-d', strtotime(trim($dates[1])));
            $query = $this->db->query("SELECT `" . DB_PREFIX . "scnb`.`EnrollNo`, `" . DB_PREFIX . "stu_mst`.`DOR`, `" . DB_PREFIX . "stu_mst`.`Stu_ID`, `" . DB_PREFIX . "stu_mst`.`StudentName`, `" . DB_PREFIX . "stu_mst`.`FatherName`, `" . DB_PREFIX . "scnb`.`CourseCode`, `" . DB_PREFIX . "stu_mst`.`Mobile1`, `" . DB_PREFIX . "scnb`.`Add_User`, `" . DB_PREFIX . "scnb`.`Mode_User`
            FROM (`" . DB_PREFIX . "stu_mst`) INNER JOIN `" . DB_PREFIX . "scnb` ON `" . DB_PREFIX . "scnb`.`EnrollNo` = `" . DB_PREFIX . "stu_mst`.`EnrollNo`
            WHERE `" . DB_PREFIX . "stu_mst`.`DOR`>= '{$d1}' AND `" . DB_PREFIX . "stu_mst`.`DOR`<= '{$d2}'");
            //   $query = $this->db->get(); // It will return query..
            return $query->result();  //  It will return result..
        } else if ($Searching_Form_Data['Searching_option'] === "Advance_Search") {
            $qry = "";
            $Stu_Name = $Searching_Form_Data['Stu_Name'];
            $FatherName = $Searching_Form_Data['Father_Name'];
            $BatchCode = $Searching_Form_Data['Batch_Code'];
            $FacultyCode = $Searching_Form_Data['Faculty_Code'];
            $qry .= $Stu_Name != "" ? $qry != "" ? " and " . DB_PREFIX . "stu_mst.StudentName like '%$Stu_Name%'" : " " . DB_PREFIX . "stu_mst.StudentName like '%$Stu_Name%'" : "";
            $qry .= $FatherName != "" ? $qry != "" ? " and " . DB_PREFIX . "stu_mst.FatherName like '%$FatherName%'" : " " . DB_PREFIX . "stu_mst.FatherName like '%$FatherName%'" : "";
            $qry .= $BatchCode != "" ? $qry != "" ? " and " . DB_PREFIX . "scnb.BatchCode='$BatchCode'" : " " . DB_PREFIX . "scnb.BatchCode='$BatchCode'" : "";
            $qry .= $FacultyCode != "" ? $qry != "" ? " and " . DB_PREFIX . "scnb.FacultyCode='$FacultyCode'" : " " . DB_PREFIX . "scnb.FacultyCode='$FacultyCode'" : "";
            $query = $this->db->query("SELECT `" . DB_PREFIX . "scnb`.`EnrollNo`, `" . DB_PREFIX . "stu_mst`.`DOR`, `" . DB_PREFIX . "stu_mst`.`Stu_ID`, `" . DB_PREFIX . "stu_mst`.`StudentName`, `" . DB_PREFIX . "stu_mst`.`FatherName`, `" . DB_PREFIX . "scnb`.`CourseCode`, `" . DB_PREFIX . "stu_mst`.`Mobile1`, `" . DB_PREFIX . "scnb`.`Add_User`, `" . DB_PREFIX . "scnb`.`Mode_User`
            FROM (`" . DB_PREFIX . "stu_mst`) INNER JOIN `" . DB_PREFIX . "scnb` ON `" . DB_PREFIX . "scnb`.`EnrollNo` = `" . DB_PREFIX . "stu_mst`.`EnrollNo`
            WHERE $qry");
            //   $query = $this->db->get(); // It will return query..
            return $query->result();  //  It will return result..
        }
        $query = $this->db->select('EnrollNo')->from(DB_PREFIX . "stu_mst")->order_by('Stu_ID', 'DESC')->limit(1);
        $result = $query->get()->result();
        if (!empty($result))
            return substr($result[0]->EnrollNo, 5) + 1;
        else
            return 1;
    }

    function late_payment($filter_data) {
        global $data;
        // $this->util_model->printr($filter_data);
        // print_r($result1);
        $this->load->model('fee/fee_type_model');

        $fee_type_filter_data = array("FeeTypeID" => $filter_data['FeeTypeID'],
            "BranchID" => $data['Session_Data']['IBMS_BRANCHID'],
            "Status" => 1);
        $fee_type_data = $this->fee_type_model->get_feetype_details($fee_type_filter_data);

        // if result not found
        if (empty($fee_type_data[0])) {
            return 0;
        }
        // if late payment fine is zero of per day
        if ($fee_type_data[0]->Late_Payment_Fee == 0) {
            return 0;
        }

        $this->load->model('fee/fee_collect_model');
        $last_fee_record = $this->fee_collect_model->last_fee_record($filter_data['Stu_ID'], $filter_data['CourseID'], $filter_data['FeeTypeID']);
        if (empty($last_fee_record[0]))
            return 0;
        //$stu_month_day = $result[0]->Due_Date;
        $next_due_day_was = $last_fee_record[0]->NextDueDate;
        //  $current_due_day = time();
        //echo date(DF,  strtotime($last_fee_record[0]->NextDueDate));
        $datediff = strtotime($filter_data['ReceiptDate']) - strtotime($last_fee_record[0]->NextDueDate);
        $days = floor($datediff / (60 * 60 * 24));
        //echo $days;
        if ($days > 0)
            return abs($days * $fee_type_data[0]->Late_Payment_Fee);
        else
            return 0;
        //  $month_day = $ReceiptDay;
        // max_day_limit here for .. if due date is 5 then fine will start after 5 or how many days after.
        // $stu_due_day = ($stu_month_day + ($result1[0]->Max_Day_Limit_After_Due_Date));
//        if ($stu_due_day < $month_day) {
//            return($result1[0]->Late_Payment_Fee * ($month_day - $stu_due_day));
//        } else {
//            return 0;
//        }
    }

    function delete($data_to_delete) {
        // die($this->util_model->printr($data_to_delete));
        global $data;
        if (empty($data_to_delete))
            return array(FALSE, "Sorry Unable to fetch data !!");
        $_key = isset($data_to_delete['_key']) ? $data_to_delete['_key'] : '';
        if ($_key == "")
            return array(FALSE, "Key is not defined !!");
        else {
//            $auth = $this->util_model->is_auth_for_this("ajax_delete_using_key", $_key);
//            if (!$auth['auth']) {
//                return array(FALSE, "Sorry you don't have access of this module");
//            }
            if ($_key == "add_del_update_batch") {
                $action = isset($data_to_delete['_action']) ? $data_to_delete['_action'] : '';
                if ($action == "Update") {
                    // $this->util_model->printr($data_to_delete);

                    if (empty($data_to_delete['has_to_update']))
                        return array(FALSE, "Please select at Least One students");
                    else {

                        $BatchID = $data_to_delete['BatchID'];
                        $FacultyID = $data_to_delete['FacultyID'];
                        $scnb_statusID = $data_to_delete['scnb_statusID'];
                        $Remarks = $data_to_delete['Remarks'];
                        if ($BatchID == "") {
                            return array(FALSE, $this->util_model->get_err_msg("BatchCodeBlank"));
                        }
                        if ($FacultyID == "") {
                            return array(FALSE, $this->util_model->get_err_msg("FacultyCodeBlank"));
                        }
                        if ($scnb_statusID == "") {
                            return array(FALSE, $this->util_model->get_err_msg("Bat_StaBlank"));
                        }
                        $Mode_UserID = $data['Session_Data']['IBMS_USER_ID'];


                        $set = " BatchID='$BatchID',FacultyID='$FacultyID',BatchStatusID='$scnb_statusID',Mode_User='$Mode_UserID',Remarks='$Remarks'  ";
                        $where = "";
                        $Student_to_allocate = 0;
                        foreach ($data_to_delete['has_to_update'] as $EnrollNo_____CourseCode) {

                            $Stu_details = explode("_____", $EnrollNo_____CourseCode); // joined using 5 underscore     
                            if ($Stu_details[2] != $FacultyID || $Stu_details[3] != $BatchID) {
                                $Student_to_allocate++;
                            }
                            //$this->util_model->printr($Stu_details);  
                            $where = $where . "  (Stu_ID='{$Stu_details[0]}' and CourseID='{$Stu_details[1]}' and " . ("BatchID " . ($Stu_details[3] == "" ? " is NULL " : "='{$Stu_details[3]}'")) . " and " . ("FacultyID " . ($Stu_details[2] == "" ? " is NULL " : "='{$Stu_details[2]}'")) . ") or";
                        }


                        //echo $where;
                        // $Student_to_allocate = count($data_to_delete['has_to_update']);
                        if ($Student_to_allocate) {
                            if ($FacultyID != "") {
                                $this->load->model('batch/batch_model');
                                $space_in_a_batch = $this->batch_model->space_in_batch($Student_to_allocate, $FacultyID, $BatchID);
                                if (!$space_in_a_batch[0]) {
                                    return array(FALSE, $space_in_a_batch[1]);
                                }
                            }
                        }


                        $where = substr($where, 0, -3);
                        $query = "Update " . DB_PREFIX . "stu_batches set " . $set . " where " . $where;
                        if ($this->db->query($query)) {
                            //echo $this->db->last_query();
                            $batch_status_updated = TRUE; //$this->db->query("update " . DB_PREFIX . "batch_master set `AllotedStd` = `AllotedStd`+$Student_to_allocate where BatchID='{$BatchID}' and FacultyID='{$FacultyID}'");
                            if ($batch_status_updated)
                                return array(TRUE, "Batch Updated Successfully !!");
                            else
                                return array(FALSE, "Error while Updating Batch Status !!");
                        } else {
                            return array(FALSE, "Error while running update_sring");
                        }
                    }
                } else if ($action == "Add") {
                    // add batch
                    // $this->util_model->printr($data_to_delete);
                    $BatchID = $data_to_delete['BatchID'];
                    $FacultyID = $data_to_delete['FacultyID'];
                    $scnb_statusID = $data_to_delete['scnb_statusID'];
                    $Remarks = $data_to_delete['Remarks'];
                    if ($BatchID == "") {
                        return array(FALSE, $this->util_model->get_err_msg("BatchCodeBlank"));
                    }
                    if ($FacultyID == "") {
                        return array(FALSE, $this->util_model->get_err_msg("FacultyCodeBlank"));
                    }
                    if ($scnb_statusID == "") {
                        return array(FALSE, $this->util_model->get_err_msg("Bat_StaBlank"));
                    }
                    $Student_to_allocate = count($data_to_delete['has_to_update']);
                    if ($FacultyID != "") {
                        $this->load->model('batch/batch_model');
                        $space_in_a_batch = $this->batch_model->space_in_batch($Student_to_allocate, $FacultyID, $BatchID);
                        if (!$space_in_a_batch[0]) {
                            return array(FALSE, $space_in_a_batch[1]);
                        }
                    }
                    $data_to_insert = array();
                    foreach ($data_to_delete['has_to_update'] as $EnrollNo_____CourseCode) {
                        $Stu_details = explode("_____", $EnrollNo_____CourseCode); // joined using 5 underscore     

                        if ($this->util_model->check_aready_exits(DB_PREFIX . "stu_batches", array("FacultyID" => $FacultyID, "BatchID" => $BatchID, "BatchStatusID" => $scnb_statusID)))
                            continue;

                        $row = array();
                        $row = array(
                            "Stu_ID" => $Stu_details[0],
                            "CourseID" => $Stu_details[1],
                            "FacultyID" => $FacultyID,
                            "BatchStatusID" => $scnb_statusID,
                            "BatchID" => $BatchID,
                            "Remarks" => $Remarks
                        );

                        $row = $this->util_model->add_common_fields($row);
                        $row = $this->util_model->add_mode_user($row);
                        $data_to_insert[] = $row;
                    }
                    if (!empty($data_to_insert)) {
                        if ($this->db->insert_batch(DB_PREFIX . "stu_batches", $data_to_insert))
                            return array(TRUE, "Batch Added Successfully !!");
                        else
                            return array(FALSE, "Error while Inserting batch");
                    }else {
                        return array(FALSE, "Student/s Already exits in that batch !!");
                    }
                }
            } elseif ($_key == "del_course") {
                $CourseID = $this->util_model->url_decode($data_to_delete['ID']);
                $this->db->select('*')->from('' . DB_PREFIX . 'stu_courses')->where(array("CourseID" => $CourseID));
                $course_taken_by_students = $this->db->count_all_results();
                if (!$course_taken_by_students) {
                    if ($this->db->delete('' . DB_PREFIX . 'course_mst', array('CourseID' => $CourseID))) {
                        return array(1, "");
                    } else {
                        return array(0, "Error While Deleting Course !!");
                    }
                } else {
                    return array(False, "Course has been allocated to $course_taken_by_students students, Can't be deleted !!");
                }
            } elseif ($_key == "del_Student") {
                $EnrollNo = trim($data_to_delete['EnrollNo']);
                $CourseCode = $this->util_model->url_decode($data_to_delete['CourseCode']); // not being used right now                 
                $this->load->model('adm/admission_model');
                return array($this->admission_model->Del_Admission_Course($EnrollNo), '');
            } elseif ($_key == "del_batch") {
                $BatchID = $data_to_delete['BatchID'];
                $this->load->model('batch/batch_model');
                $total_allocated_student_in_this_batch = $this->batch_model->no_of_student_in_a_batch($BatchID, 2);
                if ($total_allocated_student_in_this_batch > 1) {
                    return array(0, $total_allocated_student_in_this_batch . " Students are allocated in this, cant be delete !!");
                } else {
                    return array($this->batch_model->Del_Batch($BatchID));
                }
            } else if ($_key == "del_Fee_plan") {
                $Fee_Plan_ID = $data_to_delete['Fee_Plan_ID'];
                $this->load->model('fee/fee_collect_model');
                $succ = $this->fee_collect_model->Del_Fee_plan($Fee_Plan_ID);
                if (!$succ) {
                    $q = $this->db->get_where(DB_PREFIX . "fee_trn", array("Individual_fee_plan_id" => $Fee_Plan_ID));
                    $result = $q->result();
                    $Receipt_no_taken = "";
                    foreach ($result as $Fee_Plan_Row) {
                        $Receipt_no_taken .=$Fee_Plan_Row->ID . " ,";
                    }
                    $Receipt_no_taken = substr($Receipt_no_taken, 0, -1);
                    return array($succ, $succ ? "" : "Sorry fees has been taken from this Plan, Receipt no $Receipt_no_taken is/are taken from this fee plan !!");
                } else {
                    return array(TRUE, "");
                }
            } else if ($_key == "del_designation") {
                $Designation_ID = $data_to_delete['Designation_ID'];
                $this->db->select('*')->from('' . DB_PREFIX . 'employee')->where(array("DID" => $Designation_ID));
                $Designation_taken_by_Emp = $this->db->count_all_results();
                if (!$Designation_taken_by_Emp) {
                    if ($this->db->delete('' . DB_PREFIX . 'designation', array('DID' => $Designation_ID))) {
                        return array(1, "");
                    } else {
                        return array(0, "Error While Deleting Designation !!");
                    }
                } else {
                    return array(False, "Designation has been allocated to $Designation_taken_by_Emp Employees, Can't be deleted !!");
                }
            } else if ($_key == "del_FeeType_Code") {
                $del_FeeType_ID = $data_to_delete['FeeType_ID'];
                $this->db->select('*')->from('' . DB_PREFIX . 'fee_trn')->where(array("FeeTypeID" => $del_FeeType_ID));
                $Fee_taken_by_FeeType_Code = $this->db->count_all_results();
                if (!$Fee_taken_by_FeeType_Code) {
                    if ($this->db->delete('' . DB_PREFIX . 'fee_type_mst', array('FeeTypeID' => $del_FeeType_ID))) {
                        return array(1, "Fee Type Deleted Successfully !!");
                    } else {
                        return array(0, "Error While Deleting FeeType Code !!");
                    }
                } else {
                    return array(False, "Fees has been taken from $Fee_taken_by_FeeType_Code Fee type, Can't be deleted !!");
                }
            } else if ($_key == "del_qualification") {
                $quali_code = $data_to_delete['Qualification_Code'];
                $this->db->select('*')->from('' . DB_PREFIX . 'stu_mst')->where(array("Quali" => $quali_code));
                $Quali_taken_by_Quali_Code = $this->db->count_all_results();
                if (!$Quali_taken_by_Quali_Code) {
                    if ($this->db->delete('' . DB_PREFIX . 'qualification', array('Code' => $quali_code))) {
                        return array(1, "");
                    } else {
                        return array(0, "Error While Deleting FeeType Code !!");
                    }
                } else {
                    return array(False, "$quali_code Qualification has been taken by $Quali_taken_by_Quali_Code, Can't be deleted !!");
                }
            } else if ($_key == "del_Emp_Code") {
                $UserName = $data_to_delete['UserName'];
                $this->db->query("SET FOREIGN_KEY_CHECKS=0");
//                && $this->db->delete(DB_PREFIX . 'fee_faculty_share', array('FacultyID' => $emp_id))
                if ($this->db->delete(DB_PREFIX . 'employee', array('UserName' => $UserName))) {
                    $this->db->query("SET FOREIGN_KEY_CHECKS=1");
                    return array(1, "");
                } else {
                    $this->db->query("SET FOREIGN_KEY_CHECKS=1");
                    return array(0, "Error While Deleting Employee Code !!");
                }
            } else if ($_key == "due_day_update") {
                $due_day = $data_to_delete['due_day'];
                $Stu_ID = $data_to_delete['Stu_ID'];
                $CourseID = $data_to_delete['CourseID'];
                if ($this->db->update(DB_PREFIX . "stu_courses", array("due_day" => $due_day), array("Stu_ID" => $Stu_ID, "CourseID" => $CourseID))) {
                    return array(TRUE, "Due day updated SuccessFully");
                } else {
                    return array(FALSE, "Error while Updating !!");
                }
            } else if ($_key == "del_UID") {
                $table_name = array(DB_PREFIX . 'usertypes', DB_PREFIX . 'menu_access', DB_PREFIX . "branch_access");
                $del_UID = $data_to_delete['UTID'];
                // check is there any user with this user type
                if (!$this->util_model->get_column_value("status", DB_PREFIX . 'employee', array("UTID" => $del_UID))) {
                    $this->db->where('UTID', $del_UID);
                    $this->db->delete($table_name);
                    return array(TRUE, "Deleted All Successfully !!");
                } else {
                    return array(FALSE, "User already exists with this user type !!");
                }
            } else if ($_key == "del_menu") {
                $MID = $data_to_delete['MID'];
                if (!$this->db->delete(DB_PREFIX . 'menus', array("MID" => $MID))) {
                    return array(FALSE, "Error while Deleting Menu From Menu Master !!");
                } else {
                    if (!$this->db->delete(DB_PREFIX . 'menu_access', array("MID" => $MID))) {
                        return array(FALSE, "Error while Deleting Menu From Menu Access !!");
                    } else {
                        return array(TRUE, "Deleted Successfully !!");
                    }
                }
            } else if ($_key == "del_course_cat") {
                if (!isset($data_to_delete['C_CID'])) {
                    return array(FALSE, "Unable to get data to delete !!");
                }
                $this->load->model('courses/course');
                return $this->course->delete_course_cat($data_to_delete['C_CID']);
            } else if ($_key == "del_Enq") {
                if (!isset($data_to_delete['E_Code'])) {
                    return array(TRUE, "Unable to get data to delete !!");
                }
                $E_Code = $data_to_delete['E_Code'];
                $this->load->model('enquiry/m_enquiry');
                return $this->m_enquiry->del_enq($E_Code);
            } else if ($_key == "del_source") {
                if (!isset($data_to_delete['src_id'])) {
                    return array(FALSE, "Unable to get data to delete !!");
                }
                $src_id = $data_to_delete['src_id'];
                $this->load->model('enquiry/m_source');
                return $this->m_source->deleteSource($src_id);
            } else if ($_key == "del_response") {
                if (!isset($data_to_delete['UniqueKey'])) {
                    return array(FALSE, "Unable to get data to delete !!");
                }
                $rid = $data_to_delete['UniqueKey'];
                $this->load->model('enquiry/m_response');
                return $this->m_response->deleteResponse($rid);
            } else if ($_key == "del_country") {
                if (!isset($data_to_delete['ID'])) {
                    return array(FALSE, "Unable to get data to delete !!");
                }
                $id = $data_to_delete['ID'];
                $this->load->model('enquiry/m_country');
                return $this->m_country->deletecountry($id);
            } else if ($_key == "del_followup_record") {
                if (!isset($data_to_delete['ID'])) {
                    return array(FALSE, "Unable to get data to delete !!");
                }
                // print_r($data_to_delete);
                $this->load->model('enquiry/m_enquiry');
                $id = $data_to_delete['ID'];
                return $this->m_enquiry->delete_follow_up($id);
            } else if ($_key == "cancel_fee_receipt") {
                if (!isset($data_to_delete['ReceiptNo']) &&
                        !isset($data_to_delete['Stu_ID']) &&
                        !isset($data_to_delete['FeeTypeID']) &&
                        !isset($data_to_delete['CourseID'])) {
                    return array(FALSE, "Unable to get data to cancel fee receipt !!");
                }
                //$this->util_model->printr($data_to_delete);
                $this->load->model('fee/fee_collect_model_1');
                return $this->fee_collect_model_1->cancel_fee_receipt($data_to_delete);
            } else if ($_key == "del_state") {
                if (!isset($data_to_delete['ID'])) {
                    return array(FALSE, "Unable to get data to delete !!");
                }
                // print_r($data_to_delete);
                $this->load->model('enquiry/m_state');
                $id = $data_to_delete['ID'];
                return $this->m_state->deletestate($id);
            } else if ($_key == "del_city") {
                if (!isset($data_to_delete['ID'])) {
                    return array(FALSE, "Unable to get data to delete !!");
                }
                // print_r($data_to_delete);
                $this->load->model('enquiry/m_city');
                $id = $data_to_delete['ID'];
                return $this->m_city->deletecity($id);
            } elseif ($_key == "del_locality") {
                if (!isset($data_to_delete['ID'])) {
                    return array(FALSE, "Unable to get data to delete !!");
                }
                // print_r($data_to_delete);
                $this->load->model('enquiry/locality');
                $id = $data_to_delete['ID'];
                return $this->locality->deletelocality($id);
            } elseif ($_key == "del_cdoing") {
                if (!isset($data_to_delete['ID'])) {
                    return array(FALSE, "Unable to get data to delete !!");
                }
                // print_r($data_to_delete);
                $this->load->model('enquiry/m_cdoing');
                $id = $data_to_delete['ID'];
                return $this->m_cdoing->deletecdoing($id);
            } elseif ($_key == "del_batch_status") {
                if (!isset($data_to_delete['ID'])) {
                    return array(FALSE, "Unable to get data to delete !!");
                }
                // print_r($data_to_delete);
                $this->load->model("batch/m_bstatus");
                $id = $data_to_delete['ID'];
                return $this->m_bstatus->deletebatchstatus($id);
            } elseif ($_key == "del_cfp") {
                if (!isset($data_to_delete['CID']) || !isset($data_to_delete['PackageID']) || !isset($data_to_delete['BranchID'])) {
                    return array(FALSE, "Unable to get data to delete !!");
                }
                // print_r($data_to_delete);
                $this->load->model('fee/fee_collect_model');
                $filter_to_delete = array("CourseID" => $data_to_delete['CID'],
                    "PackageID" => $data_to_delete['PackageID'],
                    "BranchID" => $data_to_delete['BranchID']);
                return $this->fee_collect_model->del_cfp($filter_to_delete);
            } elseif ($_key == "del_scfp") {
                if (!isset($data_to_delete['ID'])) {
                    return array(FALSE, "Unable to get data to delete !!");
                }
                // print_r($data_to_delete);
                $this->load->model('fee/fee_collect_model');
                $filter_to_delete = array("scfpID" => $data_to_delete['ID']);
                return $this->fee_collect_model->del_scfp($filter_to_delete);
            } elseif ($_key == "del_faq_menu") {
                if (!isset($data_to_delete['menuid'])) {
                    return array(FALSE, "Unable to get data to delete !!");
                }
                // print_r($data_to_delete);
                $this->load->model('faq/m_faq');
                $filter_to_delete = array("menuid" => $data_to_delete['menuid']);
                return $this->m_faq->del_faq_menu($filter_to_delete);
            } elseif ($_key == "del_faq_ques") {
                if (!isset($data_to_delete['fqid'])) {
                    return array(FALSE, "Unable to get data to delete !!");
                }
                // print_r($data_to_delete);
                $this->load->model('faq/m_faq');
                $filter_to_delete = array("fqid" => $data_to_delete['fqid']);
                return $this->m_faq->del_faq_qus($filter_to_delete);
            } elseif ($_key == "del_room") {
                if (!isset($data_to_delete['rid'])) {
                    return array(FALSE, "Unable to get data to delete !!");
                }
                // print_r($data_to_delete);
                $this->load->model('rooms/room_model');
                $filter_to_delete = array("rid" => $data_to_delete['rid']);
                return $this->room_model->delete_room($filter_to_delete);
            } elseif ($_key == "del_tt_id") {
                $ttm_id = $data_to_delete['ID'];
                $this->db->query("SET FOREIGN_KEY_CHECKS=0");
                if (!$this->db->delete(DB_PREFIX . 'task_type_mst', array("ttm_id" => $ttm_id))) {
                    $this->db->query("SET FOREIGN_KEY_CHECKS=1");
                    return array(FALSE, "Error while Deleting Menu Task Type Category !!");
                } else {
                    $this->db->query("SET FOREIGN_KEY_CHECKS=1");
                    return array(TRUE, "Deleted Successfully !!");
                }
            } elseif ($_key == "del_attachment") {
                $path = str_replace(base_url(), "", $data_to_delete['link']);
//                if (file_exists(SITE_ROOT_PATH . "/".$path)) {
//                    echo "hi";
//                    echo SITE_ROOT_PATH . "/".$path;
//                }
//                die();
//                $this->util_model->printr($_SERVER);
                $doc_id = $data_to_delete['ID'];
                // $this->db->query("SET FOREIGN_KEY_CHECKS=0");
                if (!$this->db->delete(DB_PREFIX . 'task_attachments', array("attach_id" => $doc_id))) {
                        return array(FALSE, "Unable to get data to delete !!");
                }
                // print_r($data_to_delete);
                else {
                    $path = str_replace(base_url(), "", $data_to_delete['link']);
                    if (file_exists(SITE_ROOT_PATH . "/".$path)) {
                        if (unlink(SITE_ROOT_PATH ."/". $path)) {
                            return array(TRUE, "Deleted Successfully !!");
                        } else {
                            return array(FALSE, "Error in delting file from physical location");
                        }
                    }else{
                         return array(TRUE, "File Deleted Successfully");
                    }
                }
                 } elseif ($_key == "del_Daily_task") {
                //die($this->util_model->printr($data_to_delete));
                $comment_id = $data_to_delete['comment_id'];
                // $this->db->query("SET FOREIGN_KEY_CHECKS=0");
                if (!$this->db->delete(DB_PREFIX . 'task_sub_task_comments', array("comment_id" => $comment_id))) {
                    return array(FALSE, "Unable to get data to delete !!");
                }
                else{
                    return array(TRUE, "Deleted Successfully");
                }
            }
            elseif ($_key == "del_client_noti") {
                //die($this->util_model->printr($data_to_delete));
                $comment_id = $data_to_delete['noti_mst_id'];
                // $this->db->query("SET FOREIGN_KEY_CHECKS=0");
                if (!$this->db->delete(DB_PREFIX . 'client_notification_level', array("noti_mst_id" => $comment_id))) {
                    return array(FALSE, "Unable to get data to delete !!");
                }
                else{
                    return array(TRUE, "Deleted Successfully");
                }
            }
        }
    }

    /*
      this used to check already exits value in row .. in this you have to pass table, col_name then value in
     * indexive array
     *      */

    public function check_aready_exits($data_to_check) {
        /*
         * i m passing the value and id
         * id i will insert $table_Array  and i would get table_name and column name
         * using this method i will hide my table and column name */

        $table_array = array("1" => array(DB_PREFIX . "employee", "Emp_Code", TRUE),
            "2" => array(DB_PREFIX . "employee", "UserName", TRUE),
            "3" => array(DB_PREFIX . "course_mst", "CourseCode", TRUE),
            "4" => array(DB_PREFIX . "course_mst", "Course_Name", TRUE),
            "5" => array(DB_PREFIX . "course_cat_mst", "C_CatCode", TRUE),
            "6" => array(DB_PREFIX . "course_cat_mst", "C_CatName", TRUE),
            "7" => array(DB_PREFIX . "e_source_mst", "Src_Code", TRUE),
            "8" => array(DB_PREFIX . "e_source_mst", "Src_Name", TRUE),
            "9" => array(DB_PREFIX . "current_doing", "Code", TRUE),
            "10" => array(DB_PREFIX . "current_doing", "Name", TRUE),
            "11" => array(DB_PREFIX . "countries", "name", FALSE),
            "12" => array(DB_PREFIX . "task_type_mst", "ttm_code", FALSE),
            "13" => array(DB_PREFIX . "employee", "UserName", FALSE)
        );
        $whr = array($table_array[$data_to_check[0]][1] => $data_to_check[1]);
        // checking if branch check allowed then adding branch id from session
        if ($table_array[$data_to_check[0]][2]) {
            global $data;
            $whr["BranchID"] = $data['Session_Data']['IBMS_BRANCHID'];
        }
        $result = $this->db->get_where($table_array[$data_to_check[0]][0], $whr);
        return $result;
    }

}

?>