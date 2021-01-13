<?php

class admission_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

//              public function this_month_admission() {
//                            $start_date = date("Y", time()) . "-" . date("m", time()) . "-01";
//                            $today = date("Y-m-d", time());
//                            $this->db->select('*')->from('nexgen_student_mst');
//                            $this->db->where("DOR<= '$today' AND DOR>= '$start_date'", NULL, FALSE);
//                            return($this->db->count_all_results());
//              }
//              
    public function get_due_date($DOR) {
        $Due_Date = 0;
        $Day = date('d', strtotime($DOR));
        if ($Day <= 10) {
            $Due_Date = 5;
        } else if ($Day <= 20) {
            $Due_Date = 15;
        } else {
            $Due_Date = 25;
        }
        return $Due_Date;
    }

//              public function get_details_from_database($stu_id) {
//                            $query = $this->db->get_where(DB_PREFIX."stu_mst", array("Stu_ID" => $stu_id));
//                            $stu_details = $query->first_row();
//                            $pass = $this->util_model->decrypt_string($stu_details->Pass);
//                            return array($stu_details, $pass); //sending first row
//              }
//
//              public function get_all_details_from_database($EnrollNo = '') {
//                            $this->db->select('nexgen_scnb.EnrollNo,nexgen_student_mst.DOR,nexgen_student_mst.Stu_ID,nexgen_student_mst.StudentName,nexgen_student_mst.FatherName,nexgen_scnb.CourseCode,nexgen_student_mst.Mobile1,nexgen_scnb.Add_User,nexgen_scnb.Mode_User');
//                            $this->db->from('nexgen_student_mst')->order_by("nexgen_student_mst.EnrollNo", "DESC");
//                            if ($EnrollNo != '') {
//                                          $this->db->join('nexgen_scnb', 'nexgen_scnb.EnrollNo = nexgen_student_mst.EnrollNo', 'inner')->where(array('nexgen_student_mst.EnrollNo' => $EnrollNo, 'nexgen_scnb.EnrollNo' => $EnrollNo));
//                            } else {
//                                          $this->db->join('nexgen_scnb', 'nexgen_scnb.EnrollNo = nexgen_student_mst.EnrollNo', 'inner');
//                            }
//                            $this->db->order_by('nexgen_scnb.Mode_DateTime', 'DESC');
//                            $query = $this->db->get(); // It will return query..
//                            return $query->result();  //  It will return result..
//              }
//
    public function get_student_basic_details($Stu_ID = '', $BranchID = '') {
        if ($Stu_ID == "" || $BranchID == "")
            die("Unable to get Student ID");
        $this->db->select("stu_mst.*,bm.BranchCode")->from(DB_PREFIX . "stu_mst stu_mst");
        $this->db->where(array("stu_mst.Stu_ID" => $Stu_ID, "stu_mst.BranchID" => $BranchID));
        $this->db->join(DB_PREFIX . "branch_mst bm", "stu_mst.BranchID = bm.BranchID", "left");
        $query = $this->db->get();
        $stu_details = $query->first_row();
        return array($stu_details); //sending first row
    }

//
    public function get_student_courses($Stu_ID, $Status = '', $CourseID = '') {
        $this->db->select("sc.*,cm.CourseCode,cm.Course_Name")->from(DB_PREFIX . "stu_courses  sc");
        $this->db->join(DB_PREFIX . "course_mst cm", "sc.CourseID=cm.CourseID", "left");
        $this->db->where(array("Stu_ID" => $Stu_ID));
        if ($Status != '') {
            $this->db->where(array("sc.Status" => 1));
        }
        if ($CourseID != '') {
            $this->db->where(array("sc.CourseID" => $CourseID));
        }
        $query = $this->db->get();
        $all_stu_scnb_details = $query->result();
        return $all_stu_scnb_details;
    }

//              public function Del_Admission_Course($EnrollNo) {
//                            $succ = FALSE;
//                            $basic_details = $this->get_details_from_database_via_enroll($EnrollNo);
//                            $this->util_model->check_if_exits_then_delete(STU_UPLOAD_PATH . $basic_details[0]->Pro_pic);
//                            $this->util_model->check_if_exits_then_delete(STU_UPLOAD_PATH . $basic_details[0]->Sign);
//                            if ($this->db->delete('nexgen_individual_fee_plan', array('EnrollNo' => $EnrollNo)))
//                                          if ($this->db->delete('nexgen_fee_trn', array('EnrollNo' => $EnrollNo)))
//                                                        if ($this->db->delete('nexgen_scnb', array('EnrollNo' => $EnrollNo)))
//                                                                      if ($this->db->delete('nexgen_student_mst', array('EnrollNo' => $EnrollNo)))
//                                                                                    return $succ = TRUE;
//
//                            return $succ;
//              }
    // used to gernerate next branch code !!
    public function Next_EnrollNo($Branch_Code) {
        $like = $Branch_Code . date("y");
        $query = $this->db->select('EnrollNo')->from(DB_PREFIX . "stu_mst")->where("EnrollNo like '%$like%'")->order_by('Stu_ID', 'DESC')->limit(1);
        $result = $query->get()->result();
        if (!empty($result)) {
            //  print_r($result);
            return $Branch_Code . (substr($result[0]->EnrollNo, strlen($Branch_Code)) + 1);
        } else {
            return $Branch_Code . date('y', time()) . "0001";
        }
    }

    public function save_basic_details($FormData) {

        global $data;
        // if that enquiry already taken admission, then it will send student id and on the behalf of student id, courses will 
        if (isset($FormData['E_Code'])) {
            $already_exits_ecode = $this->util_model->check_aready_exits(DB_PREFIX . "stu_mst", array("E_Code" => $FormData['E_Code']), TRUE);
            if (count($already_exits_ecode)) {
                return array("succ" => TRUE, "Stu_ID" => $already_exits_ecode[0]->Stu_ID);
            }
        }

        $FormData['EnrollNo'] = $this->Next_EnrollNo($data['Branch_obj']->BranchCode);
        
        //die($FormData['EnrollNo']." DOB ".$FormData['DOB']);
        $this->db->insert(DB_PREFIX . "stu_mst", $FormData);
        return array("succ" => $this->db->affected_rows(), "Stu_ID" => $this->db->insert_id());
    }

    public function save_courses_details($FormData) {
        global $data;
        $this->load->model('branch/branch_model');
        $branch_settings = $this->branch_model->get_branch_setting($data['Session_Data']['IBMS_BRANCHID']);
        $data_to_insert = array();
        $batch_data = array();

        //this funciton wll extract the child most courses of the student
        $FormData['CourseID'] = $this->get_final_courses($FormData['CourseID']);
        //die($this->util_model->printr(array_unique($FormData['CourseID'])));


        foreach ($FormData['CourseID'] as $course) {
            $E_Code = isset($FormData['E_Code']) ? $FormData['E_Code'] : 0;
            $Visit = isset($FormData['Visit']) ? $FormData['Visit'] : 0;
            $exits = "";
            if ($E_Code != "" && $Visit != "") {
                $exits = $this->util_model->check_aready_exits(DB_PREFIX . "stu_courses", array("Stu_ID" => $FormData['Stu_ID'], "CourseID" => $course, "E_Code" => $E_Code, "Visit" => $Visit));
            } else {
                $exits = $this->util_model->check_aready_exits(DB_PREFIX . "stu_courses", array("Stu_ID" => $FormData['Stu_ID'], "CourseID" => $course));
            }
            if (!$exits) {
                $data_to_insert[] = array(
                    "Stu_ID" => $FormData['Stu_ID'],
                    "DOR" => date(DB_DF, strtotime($FormData['DOR'])),
                    "due_day" => $this->get_due_date($FormData['DOR']),
                    "E_Code" => isset($FormData['E_Code']) ? $FormData['E_Code'] : '',
                    "Visit" => isset($FormData['Visit']) ? $FormData['Visit'] : '',
                    "CourseID" => $course,
                    "Add_User" => $FormData['Add_User'],
                    "Add_DateTime" => $FormData['Add_DateTime'],
                    "Remarks" => $FormData['Remarks']
                );
                $batch_data[] = array(
                    "Stu_ID" => $FormData['Stu_ID'],
                    "CourseID" => $course,
                    "Add_User" => $FormData['Add_User'],
                    "Add_DateTime" => $FormData['Add_DateTime'],
                    "Remarks" => $FormData['Remarks'],
                    "BatchStatusID" => $branch_settings->default_batch_status
                );
            }
            if ($E_Code != 0 && $Visit != 0) {
                // in case of direct admssion these condition will not be check
                if (!$this->util_model->check_aready_exits(DB_PREFIX . "e_courses", array("CourseID" => $course, "E_Code" => $FormData['E_Code'], "Visit" => $FormData['Visit']))) {
                    // reverse entry if it is not enquired course 
                    $e_data = array(); // becuase if this loop will be back .. it will insert both values.. so every time it will initialize from blank
                    $e_data = array("CourseID" => $course, "E_Code" => $FormData['E_Code'], "Visit" => $FormData['Visit']);
                    $e_data = $this->util_model->add_common_fields($e_data);
                    $e_data['enquired_course'] = 0; // it is a flag to tell about reverse entry (0 means not enquired courses)
                    $this->db->insert(DB_PREFIX . "e_courses", $e_data);
                }
            }
        }

        // die($this->util_model->printr($data_to_insert));
        if (!empty($data_to_insert)) {
            if ($this->db->insert_batch(DB_PREFIX . 'stu_courses', $data_to_insert) &&
                    $this->db->insert_batch(DB_PREFIX . 'stu_batches', $batch_data)) {
                return array("succ" => TRUE);
            } else {
                return array("succ" => FALSE);
            }
        } else {
            return array("succ" => TRUE);
        }
    }

    /**

     * function get_final_courses() it is used to get child courses subjects and returing 
     * cpt
     * cpt - account
     * cpt law
     * cpd qa              /
     */
    function get_final_courses($course_list) {
        $final_courses = array();
        foreach ($course_list as $courseid) {
            $final_courses = array_merge($final_courses, $this->get_course_record($courseid));
        }
        //die($this->util_model->printr($final_courses));
        return array_unique($final_courses);
    }

    /*

     * to get the rcord               /
     * 
     */

    function get_course_record($parent_id) {
        $child_courses = array();
        $result = $this->db->get_where(DB_PREFIX . "course_mst", array("parentID" => $parent_id));
        $course_list = $result->result_array();
        //die($this->util_model->printr($course_list));
        if (empty($course_list)) {
            return array($parent_id);
        } else {
            foreach ($course_list as $row) {
                $child_courses = array_merge($child_courses, $this->get_course_record($row['CourseID']));
            }
        }
        return $child_courses;
    }

    /*

     * msearch_adm used to search details from ajax and other parts
     *                /
     */

    function msearch_adm($POST) {
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


            //end of Src Wise
            // coursewise
            if (isset($POST['CourseList'])) {
                $this->db->where_in("sc.CourseID", $POST['CourseList']);
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
        }

        //$this->util_model->printr($POST);
//                            $this->db->select("sc.Stu_ID,sc.DOR,sc.due_day,sc.E_Code,sc.Visit,sc.CourseID as admCourseID,sc.Remarks,"
//                                    . "ec.CourseID as enqCourseID,"
//                                    . "stu_mst.EnrollNo,stu_mst.StudentName,stu_mst.FatherName,stu_mst.C_Locality,stu_mst.Mobile1,stu_mst.Email1,"
//                                    . "es.Src_CatID,es.Src_ID,es.PRO,es.DOE,"
//                                    . "(select count(*) as t from " . DB_PREFIX . "e_followup f where  f.E_Code = ec.E_Code and f.Visit = ec.Visit) as total_followups,"
//                                    . "et.EFormNo")->from(DB_PREFIX . "stu_courses sc");
        $this->db->where_in("stu_mst.BranchID", array($data['Session_Data']['IBMS_BRANCHID']));
        $this->db->select("sc.Stu_ID,sc.DOR,sc.due_day,sc.E_Code,sc.Visit,sc.CourseID as admCourseID,sc.Remarks,"
                . "stu_mst.EnrollNo,stu_mst.StudentName,stu_mst.FatherName,stu_mst.C_Locality,stu_mst.Mobile1,stu_mst.Email1")->from(DB_PREFIX . "stu_courses sc");
        $this->db->join(DB_PREFIX . "stu_mst stu_mst", "sc.Stu_ID = stu_mst.Stu_ID", "left");
        // $this->db->join(DB_PREFIX . "e_sources es", "sc.E_Code = es.E_code and sc.Visit = es.Visit", "left");
        // $this->db->join(DB_PREFIX . "e_courses ec", "sc.E_Code = ec.E_Code and sc.Visit= ec.Visit and sc.CourseID = ec.CourseID", "left");
        //$this->db->join(DB_PREFIX . "e_tab et", "sc.E_Code = et.E_code", "left");
        $this->db->where(array("sc.Status" => TRUE));
        $query = $this->db->get();
        //echo $this->db->last_query();
        $result = $query->result_array();
        $all_courses = $this->util_model->get_list('CourseID', 'CourseCode', DB_PREFIX . "course_mst", $data['Session_Data']['IBMS_BRANCHID'], 'CourseID');
//                            $all_users = $this->util_model->get_list('Emp_ID', 'Emp_Code', DB_PREFIX . "employee", $data['Session_Data']['IBMS_BRANCHID'], 'Emp_ID');
//                            $all_sources = $this->util_model->get_list('SrcId', 'Src_Code', DB_PREFIX . "e_source_mst", $data['Session_Data']['IBMS_BRANCHID'], 'SrcId');
        $locality_list = $this->util_model->get_list('localityid', 'locality', DB_PREFIX . "locality", 0, 'localityid');
        $final_enquiry_list = array();
        foreach ($result as $row) {
//                                          $row['enqCourseCode'] = isset($all_courses[$row['enqCourseID']]) ? $all_courses[$row['enqCourseID']] : 'NA';
            $row['admCourseCode'] = isset($all_courses[$row['admCourseID']]) ? $all_courses[$row['admCourseID']] : 'NA';
//                                          $row['Src_CatCode'] = isset($all_sources[$row['Src_CatID']]) ? $all_sources[$row['Src_CatID']] : 'NA';
//                                          $row['Src_Code'] = isset($all_sources[$row['Src_ID']]) ? $all_sources[$row['Src_ID']] : 'NA';
//                                          $row['PROCode'] = isset($all_users[$row['PRO']]) ? $all_users[$row['PRO']] : 'NA';
            $row['lcode'] = isset($locality_list[$row['C_Locality']]) ? $locality_list[$row['C_Locality']] : 'NA';
            $final_enquiry_list[] = $row;
        }

        return $final_enquiry_list;
        //$this->util_model->printr($final_enquiry_list);
    }

    /*

     * function individual course & fee faculty share               */

     function indi_faculty_share($filter_data = array()) {
                            if (!empty($filter_data)) {
                                          if (isset($filter_data['Status'])) {
                                                        $this->db->where("t1.Status", $filter_data['Status']);
                                          }
                                          if (isset($filter_data['Stu_ID'])) {
                                                        $this->db->where("t1.Stu_ID", $filter_data['Stu_ID']);
                                          }
                                          if (isset($filter_data['OrderCol'])) {
                                                        $this->db->order_by($filter_data['OrderCol'], "ASC");
                                          }
//                                          $this->db->where("",1);
                                          
                            }
                            $this->db->select("t1.*,t2.Emp_Code as AddUserCode,t3.Emp_Code as FacultyCode,t4.CourseCode,"
                                    . "t5.CourseFee,t6.Share")->from(DB_PREFIX . "fee_course_indvidual_share t1");
                            $this->db->join(DB_PREFIX . "employee t2", "t1.Add_User=t2.Emp_ID", "left");
                            $this->db->join(DB_PREFIX . "employee t3", "t1.FacultyID=t3.Emp_ID", "left");
                            $this->db->join(DB_PREFIX . "course_mst t4", "t1.CourseID=t4.CourseID", "left");
                            $this->db->join(DB_PREFIX . "course_fee t5", "t1.CourseID=t5.CourseID and t5.Status=1", "left");
                            $this->db->join(DB_PREFIX . "fee_faculty_share t6", "t1.CourseID=t6.CourseID and t1.FacultyID=t6.FacultyID", "left");
                            return $this->db->get()->result();
              }


}
