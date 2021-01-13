<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * -----------------------------
  admission controller
 * -----------------------------
 *   1. all Addmission form
 *   2. New Admission form
 *   3. etc All thinks related to admission
 *  */

class cadm extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('adm/admission_model', "adm_model");
    }

    public function index($E_Code = 0, $Visit = 0, $error = '', $_err_codes = '', $Stu_ID = '') { //provide a view of new Employee form
        global $data;

        if ($Stu_ID != '') {
            $data['result'] = $this->adm_model->msearch_adm(array("search_via" => array("Stu_ID"), "search_via_value" => array($Stu_ID)));
            //$this->util_model->printr($data['result']);
            $data['last_admission'] = $this->load->view('Admission/search/v-global_search_result', $data, TRUE);
        }

        if ($E_Code == 0 && $Visit == 0) {
            $this->load->model(array("branch/branch_model"));
            $b_settings = $this->branch_model->get_branch_setting($data['Session_Data']['IBMS_BRANCHID']);
            if (!$b_settings->Adm_allowed_without_enq) // to check whether admission directly possible or not
                redirect(base_url() . "Enquiry/enquiry/index/1/adm_without_enq404IBMS");
        }else {
            $this->load->model(array("enquiry/m_enquiry"));
            $enq_details = $this->m_enquiry->get_e_details($E_Code, $Visit);
            $data['e_basic_details'] = $enq_details['e_basic_details'];
            $data['e_courses'] = $enq_details['e_courses'];
            $data['e_sources'] = $enq_details['e_sources'];
            //g $this->util_model->printr($enq_details);
        }

        $data = $this->util_model->set_error($data, $error, $_err_codes);

        $this->load->model(array('enquiry/locality', 'courses/course', 'super-admin/usertypes_model'));

        //validation
        $data['form_validation'] = $this->load->view('Admission/form_validation.php', '', TRUE);
        // seraching template loading
        $data['Search_List'] = array(
            "Mob1" => "Mobile",
            "Name" => "StudentName",
            "FName" => "FatherName",
            "EFNo" => "Enq Form No",
            "ECode" => "Enq Code",
            "Email1" => "Email1");
        $data['AllPRO'] = $this->usertypes_model->AllUsers($data['Session_Data']['IBMS_BRANCHID'], $data['Branch_obj']->procode);
        $data['All_Course_List'] = $this->course->listConvert($this->course->Course_list_with_child($data['Session_Data']['IBMS_BRANCHID'], 0));
        $data['locality_list'] = $this->locality->AllLocality(0, $data['Branch_obj']->Locality);
        $data['source_list'] = $this->util_model->get_list('SrcId', 'Src_Code', DB_PREFIX . "e_source_mst", $data['Session_Data']['IBMS_BRANCHID'], 'Src_Code');
        $data['enq_search_template'] = $this->load->view('Enquiry/v-search-enq.php', $data, true);
        // end of searching template

        $data['AdmSearch_List'] = array(
            "Name" => "StudentName",
            "Mob1" => "Mobile",
            "FName" => "FatherName",
            "Email1" => "Email1",
            "EnrollNo" => "EnrollNo",
            "Stu_ID" => "Student ID");
        $data['collapse'] = "collapse";
        $data['adm_search_template'] = $this->load->view('Admission/search/v-search-adm.php', $data, true);
        // end of searching template



        $data['n_list'] = $this->util_model->get_list('NID', 'Name', DB_PREFIX . "nationality", $data['Session_Data']['IBMS_BRANCHID'], 'Sort,Code');
        $data['Q_list'] = $this->util_model->get_list('QID', 'Name', DB_PREFIX . "qualification", $data['Session_Data']['IBMS_BRANCHID'], 'Sort,Code');
        $data['country_list'] = $this->util_model->get_list('country_id', 'name', DB_PREFIX . "countries", 0, 'name');
        $data['state_list'] = $this->locality->all_states($data['Branch_obj']->Country);
        $data['City_list'] = $this->util_model->get_list('city_id', 'citycode', DB_PREFIX . "cities", 0, 'Sort,citycode');
        $this->load->view('templates/header.php', $data);
        if ($E_Code != 0 && $Visit != 0) {
            $this->load->view('Admission/new_adm.php', $data);
        } else {
            $this->load->view('Admission/new_adm_without_enq.php', $data);
        }
        $this->load->view('templates/footer.php');
    }

    function adm_save_validation($POST) {
        $err_codes = '';
        if (!isset($POST['CourseID'])) {
            $err_codes.='Enq_CourseEmpty' . ERR_DELIMETER;
        }

        $valid = $err_codes == '' ? TRUE : FALSE;
        return array("_err" => $valid, "_err_codes" => $err_codes);
    }

    function generate_password($FormData) {
        $path = base_url() . "adm/cadm/index/";
        // if menual password gernation then both password should be equal      
        if (!isset($FormData['gernerate_password']) && ($FormData['Password'] == "" || $FormData['confirmPassword'] == "")) {
            redirect($path . "{$FormData['E_Code']}/{$FormData['Visit']}/1/pass_cpassntsame" . ERR_DELIMETER);
            $FormData['Pass'] = $this->util_model->encrypt_string($FormData['Password']);
        } else {
            $FormData['Pass'] = $this->util_model->encrypt_string(rand(500, 80000));
        }
        $FormData = $this->util_model->unset_array($FormData, array('send_on_mail', 'Password', 'confirmPassword', 'gernerate_password'));
        return $FormData;
    }

    /*

     * save_adm 
     * input POST saving data in master table and course table.
     *                */

    public function save_adm() {
        global $data;

//        $config['upload_path'] = './uploads/';
//		$config['allowed_types'] = 'gif|jpg|png';
//		$config['max_size']	= '100';
//		$config['max_width']  = '1024';
//		$config['max_height']  = '768';
//
//		$this->load->library('upload', $config);
//                
//                die();

        $path = base_url() . "adm/cadm/index/";

        if (isset($_REQUEST['save_adm']) && ($_REQUEST['save_adm'] == "Save" || $_REQUEST['save_adm'] == "Save_and_fee")) {
            $FormData = $this->input->post();

            $img_data = array("webcam" => $FormData['webcam']);
            //call to function to upload profile picture and sign
            $img_data = $this->upload_images($img_data);
            if (isset($img_data['Pro_pic']) && $img_data['Pro_pic'] != "") {
                $FormData['Pro_pic'] = $img_data['Pro_pic'];
            }
            if (isset($img_data['Sign']) && $img_data['Sign'] != "") {
                $FormData['Sign'] = $img_data['Sign'];
            }

            // die($this->util_model->printr($FormData));
            // $FormData['Visit'] = $FormData['nextVisit'];
            $validates = $this->adm_save_validation($FormData); // validating the form
            // die($this->util_model->printr($validates));
            if (!$validates['_err']) {
                if (isset($FormData['E_Code']) && isset($FormData['Visit'])) {
                    redirect($path . "{$FormData['E_Code']}/{$FormData['Visit']}/1/{$validates['_err_codes']}");
                } else {
                    redirect($path . "0/0/1/{$validates['_err_codes']}");
                }
            }

            $FormData = $this->util_model->add_common_fields($FormData);
            $FormData['BranchID'] = $data['Session_Data']['IBMS_BRANCHID'];
            // transaction started !!
            $this->db->trans_begin();
            $FormData = $this->generate_password($FormData);
            $data_to_insert = $this->util_model->unset_array($FormData, array('Visit', 'CourseID', 'save_adm', 'DOR', 'webcam'));
            // saving basic details
            $data_to_insert['DOB'] = date(DB_DF, strtotime($data_to_insert['DOB']));
            $result_basic_details = $this->adm_model->save_basic_details($data_to_insert);


            if (!$result_basic_details['succ']) {
                log_message("error", "Class " . $this->router->fetch_class() . " Function " . $this->router->fetch_class() . " " . get_err_msg("adm_basic_deatils_Error"));
            }

            $Stu_ID = isset($result_basic_details['Stu_ID']) ? $result_basic_details['Stu_ID'] : 0;
            $FormData['Stu_ID'] = $Stu_ID;
            $save_courses_result = $this->adm_model->save_courses_details($FormData);

            if (!$save_courses_result['succ']) {
                log_message("error", "Class " . $this->router->fetch_class() . " Function " . $this->router->fetch_class() . " " . get_err_msg("course_feedingerrro"));
            }



            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                if ($FormData['save_adm'] == "Save_and_fee") {
                    die('redirect to fee');
                } else {
                    redirect($path . "0/0/0/Succ_While_Adm/" . $Stu_ID);
                }
            } else {
                $this->db->trans_rollback();
                redirect($path . "{$FormData['E_Code']}/{$FormData['Visit']}/1/Err_While_Adm" . ERR_DELIMETER);
            }
        }
    }

    //function to upload profile picture and sign
    function upload_images($images_data) {
        $uploaded_data = array();
        $config['upload_path'] = STU_UPLOAD_PATH;
        $config['allowed_types'] = 'gif|jpg|png';
        $config['overwrite'] = false;

        if (!empty($_FILES['Pro_pic']) && $_FILES['Pro_pic']['name'] != "") {

            $config['file_name'] = "Pro" . rand(0, 1000000000000000) . time();
            $this->load->library('upload', $config, 'pro_upload');

            if ($this->pro_upload->do_upload('Pro_pic')) {
                $pro = $this->pro_upload->data();
                $uploaded_data['Pro_pic'] = $pro['file_name'];
            }
        }
        if (!empty($_FILES['Sign']) && $_FILES['Sign']['name'] != "") {

            $config['file_name'] = "Sign" . rand(0, 1000000000000000) . time();
            $this->load->library('upload', $config, 'sign_upload');

            if ($this->sign_upload->do_upload('Sign')) {
                $sign = $this->sign_upload->data();
                $uploaded_data['Sign'] = $sign['file_name'];
            }
        }
        if ((!isset($uploaded_data['Pro_pic']) || $uploaded_data['Pro_pic']=="") && isset($images_data['webcam']) && $images_data['webcam'] != "") {

            $picname = "default.jpeg";
            $img_data = $images_data['webcam'];


            $name = "Pro" . rand(0, 1000000000000000) . time();
            $picname = $name . ".jpeg";

            $img_data = base64_decode(preg_replace('#^\[(removed)\]#i', '', $img_data));

            if (file_put_contents(STU_UPLOAD_PATH . $picname, $img_data)) {
                $uploaded_data['Pro_pic'] = $picname;
            }
        }
        return $uploaded_data;
    }

    // 
//              public function admission_save_update() {
//
//                            global $data;
//                            $Form_Data = $this->input->post();
//                            // die($this->util_model->printr($Form_Data));
//                            if (isset($_REQUEST['save_adm']) && $_REQUEST['save_adm'] == "Save") {
//
//                                          $query_result = $this->adm_model->save_update_admission();
//                                          if ($query_result[0]) {
//                                                        $this->admission_confirm($query_result[1]);
//                                          } else {
//                                                        redirect(base_url() . "admission/all_admission_form/1/1", 'refresh');
//                                          }
//                            } else if (isset($_REQUEST['save_adm']) && $_REQUEST['save_adm'] == "Update") {
//                                          if ($_REQUEST['CourseCode'] == "")
//                                                        redirect(base_url() . 'admission/admission_edit/1/1');
//                                          $query_result = $this->adm_model->save_update_admission();
//                                          if ($query_result[0]) {
//                                                        redirect(base_url() . "admission/admission_edit/0/1/" . $query_result[1]);
//                                          } else {
//                                                        redirect(base_url() . "admission/admission_edit/1/1/" . $_REQUEST['EnrollNo']);
//                                          }
//                            }
//              }

    public function admission_confirm($stu_id = '') {
        global $data;
        $attributes = array('class' => 'new_addmission_form', 'id' => 'new_addmission_form'); // extra attributes for form
        $data['attributes'] = $attributes;
        //common class for all form element of bootstrap
        if ($stu_id == '') {
            redirect(base_url() . "adm/cadm/index/0/0/1/1/void_action" . ERR_DELIMETER);
        }
        $admi_data = $this->adm_model->get_details_from_database($stu_id);
        $data['admission_data'] = $admi_data[0];
        $data['pass'] = $admi_data[1];
        $data['all_stu_scnb_details'] = $this->adm_model->get_details_from_scnb_table($admi_data[0]->Stu_ID);
        if (!file_exists(APPPATH . '/views/Admission/addmission_confirm.php')) {
            show_404();
        }
        $data['title'] = ucfirst("Confirm Your Admission Details"); //capitalizing the first character of string for header.
        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/common_window_pop_up.php');
        $this->load->view("Admission/addmission_confirm.php", $data);
        $this->load->view('templates/footer.php');
    }

    public function edit_adm($Stu_ID = '', $error = '', $_err_codes = '') {

        if ($Stu_ID == "")
            die("sorry unable to fetch proper data !!");
        global $data;

        $data = $this->util_model->set_error($data, $error, $_err_codes);

        /* supported Data */
        $this->load->model(array('enquiry/locality', 'courses/course', 'super-admin/usertypes_model'));
        //validation
        $data['form_validation'] = $this->load->view('Admission/form_validation.php', '', TRUE);

        $data['AllPRO'] = $this->usertypes_model->AllUsers($data['Session_Data']['IBMS_BRANCHID'], $data['Branch_obj']->procode);
        $data['All_Course_List'] = $this->course->listConvert($this->course->Course_list_with_child($data['Session_Data']['IBMS_BRANCHID'], 0));
        $data['locality_list'] = $this->locality->AllLocality(0, 2);
        $data['source_list'] = $this->util_model->get_list('SrcId', 'Src_Code', DB_PREFIX . "e_source_mst", $data['Session_Data']['IBMS_BRANCHID'], 'Src_Code');
        $data['enq_search_template'] = $this->load->view('Enquiry/v-search-enq.php', $data, true);
        $data['n_list'] = $this->util_model->get_list('NID', 'Name', DB_PREFIX . "nationality", $data['Session_Data']['IBMS_BRANCHID'], 'Sort,Code');
        $data['Q_list'] = $this->util_model->get_list('QID', 'Name', DB_PREFIX . "qualification", $data['Session_Data']['IBMS_BRANCHID'], 'Sort,Code');
        $data['country_list'] = $this->util_model->get_list('country_id', 'name', DB_PREFIX . "countries", 0, 'name');
        $data['state_list'] = $this->locality->all_states($data['Branch_obj']->Country);
        $data['City_list'] = $this->util_model->get_list('city_id', 'citycode', DB_PREFIX . "cities", 0, 'Sort,citycode');
        $data['course_cat_list'] = array("" => "Select") + $this->util_model->get_list('C_CID', 'C_CatCode', DB_PREFIX . "course_cat_mst", $data['Session_Data']['IBMS_BRANCHID'], 'C_CatCode');


        $this->load->model('batch/batch_model');
        $basic_result = $this->adm_model->get_student_basic_details($Stu_ID, $data['Session_Data']['IBMS_BRANCHID']);
        $data['basic_details'] = $basic_result[0];
        $data['all_courses'] = $this->adm_model->get_student_courses($Stu_ID);
        $data['all_batches'] = $this->batch_model->get_student_batches($Stu_ID);
        //$this->util_model->printr($data['basic_details']);
        $data['update_faculty_course_share'] = $this->mange_course_faculty_share($Stu_ID);

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/Common_Css_Js_Others_files.php', $data);
        $this->load->view("Admission/edit_adm.php", $data);
        $this->load->view('templates/footer.php');
    }

    // provding the view
    public function mange_course_faculty_share($Stu_ID) {
        global $data;

        $data['All_Faculty_Code'] = $this->util_model->get_list("Emp_ID", "Emp_Code", DB_PREFIX . "employee", $data['Session_Data']['IBMS_BRANCHID'], $sort_col = 'Emp_Code', TRUE, 1, " UTID=" . $data['Branch_obj']->FacultyCode);
        $data['All_Faculty_Code'] = array("" => "Assign Later") + $data['All_Faculty_Code'];
        /*
         * get faculty share data from fee_course_indvidual_share */
        $faculty_share_filter = array("Stu_ID" => $Stu_ID, "Status" => TRUE);
        $data['faculty_course_share'] = $this->adm_model->indi_faculty_share($faculty_share_filter);

        return $this->load->view("Fee_collect/stu_faculty_course_share/v_stu_faculty_course_share", $data, TRUE);
    }

    /*

     * syn with faculty batchs
     * sync_faculties
     * this function will get the faculty codes from the batches table
     * and update it
     * */

    function sync_faculties($Stu_ID) {
        $this->load->model('batch/batch_model');
        $data['all_batches'] = $this->batch_model->get_student_batches($Stu_ID);
        // print_r($data['all_batches']);
        //die($this->util_model->printr($data['all_batches']));

        $this->db->trans_begin();
        foreach ($data['all_batches'] as $each_row) {
            $data_to_update = array();
            $data_to_update['FacultyID'] = $each_row['FacultyID'];
            $whr = array("Stu_ID" => $Stu_ID, "CourseID" => $each_row['CourseID']);
            $this->db->update(DB_PREFIX . "fee_course_indvidual_share", $data_to_update, $whr);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            redirect(base_url() . "adm/cadm/edit_adm/$Stu_ID/0/CorFacultyShrAddErr" . ERR_DELIMETER . "#sectionD");
        } else {
            $this->db->trans_commit();
            redirect(base_url() . "adm/cadm/edit_adm/$Stu_ID/0/CorFacultyShrAddSucc#sectionD");
        }
    }

    /*

     * it is a function with name
     * insert_course_faculty_share
     * param1 Stu_ID an integer
     * mainly purpuse is get all the course from batch master and
     * insert into faculty share */

    public function insert_course_faculty_share($Stu_ID) {
        global $data;
        $this->load->model(array('batch/batch_model', 'courses/course'));
        $data['all_batches'] = $this->batch_model->get_student_batches($Stu_ID);
        //die($this->util_model->printr($data['all_batches']));
        $data_to_insert = array();
        $i = 0;
        foreach ($data['all_batches'] as $each_row) {
            $data_to_insert[$i] = array_merge(array(
                "Stu_ID" => $Stu_ID,
                "CourseID" => $each_row['CourseID'],
//                                              "FacultyID" => $each_row['FacultyID'],
                "ActuallFee" => $this->course->get_course_fee($each_row['CourseID'])));
            $data_to_insert[$i] = $this->util_model->add_common_fields($data_to_insert[$i]);
            $i++;
        }

        $update_data = array("Status" => FALSE);
        $update_data = $this->util_model->add_mode_user($update_data);
        $this->util_model->update_data(DB_PREFIX . "fee_course_indvidual_share", $update_data, array("Stu_ID" => $Stu_ID));
        if ($this->util_model->insert_data(DB_PREFIX . "fee_course_indvidual_share", $data_to_insert, TRUE)) {
            redirect(base_url() . "adm/cadm/edit_adm/$Stu_ID/0/CorFacultyShrAddSucc#sectionD");
        } else {
            redirect(base_url() . "adm/cadm/edit_adm/$Stu_ID/0/CorFacultyShrAddErr" . ERR_DELIMETER . "#sectionD");
        }
    }

    public function update_course_faculty_share() {
        global $data;
        $Form_Data = $this->input->post();
        //$this->util_model->printr($Form_Data);
        $Total_Fees = $Form_Data['Total_Fees'];
        $data_to_update = array();
        $disTotalFee = 0;
        $Stu_ID = $Form_Data['Stu_ID_Hidden'];
        for ($count = 0; $count < count($Form_Data['Stu_ID']); $count++) {
            if (isset($Form_Data['Update'][$count])) {
                $data_to_update[$count]['cisID'] = $Form_Data['Update'][$count];
//                                                        $data_to_update['CourseID'] = $Form_Data['CourseID'][$count];
                $data_to_update[$count]['ActuallFee'] = $Form_Data['ActuallFee'][$count];
                $data_to_update[$count]['Dis'] = ($Form_Data['Dis'][$count] / $data_to_update[$count]['ActuallFee']) * 100;
                $data_to_update[$count]['DisFee'] = $data_to_update[$count]['ActuallFee'] - (($data_to_update[$count]['ActuallFee'] / 100) * $data_to_update[$count]['Dis']); // totalFee - totalfee/100*dis
                $disTotalFee += $data_to_update[$count]['DisFee'];
                $data_to_update[$count]['FacultyID'] = $Form_Data['FacultyID'][$count];
                $data_to_update[$count]['FacultyShare'] = $Form_Data['FacultyShare'][$count];

                //$data_to_update['Weightage'] = ;    
            }
        }

        //  $this->util_model->printr($data_to_update);
        //  die();
        if (!empty($data_to_update)) {
            foreach ($data_to_update as $count => $each_record) {
                if ($each_record['FacultyID'] != "") {
                    $each_record['Weightage'] = round(($each_record['DisFee'] / $disTotalFee) * 100, 2);
                } else {
                    $each_record['Weightage'] = 0;
                }
                unset($each_record['FacultyID']);
                $this->db->where("cisID", $each_record['cisID']);
                $each_record = $this->util_model->add_mode_user($each_record);
                $this->db->update(DB_PREFIX . "fee_course_indvidual_share", $each_record);
            }
            redirect(base_url() . "adm/cadm/edit_adm/" . $Stu_ID . "/0/FacultyCouShareUppSucc#sectionD");
        } else {
            redirect(base_url() . "adm/cadm/edit_adm/" . $Stu_ID . "/1/NoRowEffected" . ERR_DELIMETER . "#sectionD");
        }

        // $this->util_model->printr($data_to_update);
    }

//              public function Student_details($Stu_ID='') {
//                            if($Stu_ID=="")
//                                 die("sorry unable to fetch proper data !!");         
//                            global $data;
//                            $this->load->model('batch/batch_model');
//                            $data['basic_details'] = $this->adm_model->get_student_basic_details($Stu_ID,$data['Session_Data']['IBMS_BRANCHID']);
//                            $data['all_courses'] = $this->adm_model->get_student_courses($Stu_ID);
//                            $data['all_batches'] = $this->batch_model->get_student_batches($Stu_ID);
//                            $this->util_model->printr($data['basic_details']);
//                            $this->load->view('templates/header.php', $data);
//                            $this->load->view('templates/Common_Css_Js_Others_files.php', $data);
//                            $this->load->view("Admission/student_details.php", $data);
//                            $this->load->view('templates/footer.php');
//              }
    public function update_basic_details() {
        $FormData = $this->input->post();
        $path = base_url() . "adm/cadm/edit_adm/";
        $Stu_ID = $FormData['Stu_ID'];
        $FormData['DOB'] = date(DB_DF, strtotime($FormData['DOB']));

        $img_data = array("webcam" => $FormData['webcam']);
        $img_data = $this->upload_images($img_data);
        if (isset($img_data['Pro_pic']) && $img_data['Pro_pic'] != "") {
            $FormData['Pro_pic'] = $img_data['Pro_pic'];
        }
        if (isset($img_data['Sign']) && $img_data['Sign'] != "") {
            $FormData['Sign'] = $img_data['Sign'];
        }


        $data_to_update = $this->util_model->unset_array($FormData, array('BranchID', 'EnrollNo', 'save_adm', 'Stu_ID', 'webcam', 'gernerate_password'));
        if ($this->util_model->update_data(DB_PREFIX . "stu_mst", $data_to_update, array("Stu_ID" => $Stu_ID))) {
            redirect($path . "$Stu_ID/0/SuccWhileadmUpp");
        } else {
            redirect($path . "$Stu_ID/1/ErrWhileadmUpp" . ERR_DELIMETER);
        }
    }

    // to cancel and recancel adm
    public function cancel_course() {
        $path = base_url() . "adm/cadm/edit_adm/";
        $FormData = $this->input->post();
        $Stu_ID = 0;
        //print_r($data_to_update);
        // die();
        if (!isset($FormData['ID'])) {
            redirect($path . $Stu_ID . "/0/Void_action" . ERR_DELIMETER);
        }
        $Stu_ID = $FormData['ID'];
        $Section = isset($FormData['section']) ? $FormData['section'] : '';
        $CourseID = $FormData['CourseID'];
        $data_to_update = array("Status" => $FormData['act_dea'], "Remarks" => $FormData['remarks']);
        $where = array("Stu_ID" => $Stu_ID, "CourseID" => $CourseID);
        $this->util_model->update_data(DB_PREFIX . "stu_courses", $data_to_update, $where);
        if ($this->db->affected_rows()) {
            redirect($path . "$Stu_ID/0/CCSUCC" . $Section);
        } else {
            redirect($path . "$Stu_ID/1/ErrWhileCC" . ERR_DELIMETER . $Section);
        }
    }

    // function to add new course
    public function add_course() {
        $path = base_url() . "adm/cadm/edit_adm/";
        $Stu_ID = 0;
        $FormData = $this->input->post();
        //die($this->util_model->printr($FormData));
        if (!isset($FormData['Stu_ID'])) {
            redirect($path . $Stu_ID . "/0/Void_action" . ERR_DELIMETER);
        }

        $FormData = $this->util_model->add_common_fields($FormData);
        $Stu_ID = $FormData['Stu_ID'];
        $FormData['Stu_ID'] = $Stu_ID;
        $save_courses_result = $this->adm_model->save_courses_details($FormData);
        $Section = isset($FormData['section']) ? $FormData['section'] : '';
        if (!$save_courses_result['succ']) {
            log_message("error", "Class " . $this->router->fetch_class() . " Function " . $this->router->fetch_class() . " " . get_err_msg("course_feedingerrro"));
            redirect($path . "$Stu_ID/1/ErrAddCSUCC" . ERR_DELIMETER . $Section);
        } else {
            redirect($path . "$Stu_ID/0/AddCSUCC" . $Section);
        }
    }

    public function Del_Admission($EnrollNo = '') {
        global $data;
        $this->load->library('../controllers/auth');
        if ($this->adm_model->Del_Admission_Course($EnrollNo)) {
            redirect(base_url() . "admission/all_admission_list/0/1");
            // passing error alert 0 means no error, 1 means Error
        } else {
            redirect(base_url() . "admission/all_admission_list/1/1");
            // passing error alert 0 means no error, 1 means Error
        }
    }

    // to get new enrollno
    public function next_enroll($BranchCode) {
        if ($BranchCode == "")
            die("Sorry Unable to Fetch BranchCode");
        // to remove white space before enrollno
        // if (ob_get_contents()) ob_end_clean();
        echo trim($this->adm_model->Next_EnrollNo($BranchCode));
    }

    public function print_admission($EnrollNo = '') {
        $data['Session_Data'] = $this->session->all_userdata();
        if (!$this->session->userdata('LOGIN_STATUS')) {
            redirect('/auth/login/1/1');
        }
        $this->load->helper('form'); // Loading Form helper which helps to make form elements
        $attributes = array('class' => 'new_addmission_form', 'id' => 'new_addmission_form'); // extra attributes for form
        $data['attributes'] = $attributes;
        //common class for all form element of bootstrap
        if ($EnrollNo == '') {
            redirect(base_url() . "admission/all_admission_form/1/1", 'refresh');
        }
        $student_scnb_details = $this->adm_model->get_details_from_scnb_table($EnrollNo);
        $student_mst_details = $this->adm_model->get_details_from_database_via_enroll($EnrollNo);
        $this->load->library('encrypt');
        $student_mst_details[0]->Pass = $this->encrypt->decode($student_mst_details[0]->Pass);
        $data['basic_details'] = $student_mst_details[0];
        $data['scnb_details'] = $student_scnb_details[0];
        if (!file_exists(APPPATH . '/views/fpdf/admission_printing.php')) {
            show_404();
        }
        $this->load->view('fpdf/admission_printing.php', $data);
    }

    public function all_adm() {
        global $data;
        $this->load->model(array('courses/course', 'enquiry/locality'));
        // seraching template loading
        $data['AdmSearch_List'] = array(
            "Name" => "StudentName",
            "Mob1" => "Mobile",
            "FName" => "FatherName",
            "Email1" => "Email1",
            "EnrollNo" => "EnrollNo",
            "Stu_ID" => "stu_mst.Stu_ID");
        $data['type'] = "enq";
        $data['All_Course_List'] = $this->course->listConvert($this->course->Course_list_with_child($data['Session_Data']['IBMS_BRANCHID'], 0));
        $data['locality_list'] = $this->locality->AllLocality(0, $data['Branch_obj']->cityid);
        $data['adm_search_template'] = $this->load->view('Admission/search/v-search-adm.php', $data, true);
        // end of searching template

        $this->load->view('templates/header.php', $data);
        $this->load->view('Admission/All_Admission_List.php', $data);
        $this->load->view('templates/footer.php');
    }

    // search admission
    public function search_adm() {
        global $data;
        $POST = $this->input->post();
        //$this->util_model->printr($data['branch_settings']);
        //$this->load->model('enquiry/m_enquiry');
        $data['result'] = $this->adm_model->msearch_adm($POST);

        $this->load->view('Admission/search/v-global_search_result', $data);
    }

}
