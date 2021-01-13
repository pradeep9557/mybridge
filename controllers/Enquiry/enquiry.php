<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of enquiry
 *
 * @package Enquiry
 * @class enquiry
 * @author Anup kumar
 */
class enquiry extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('enquiry/m_enquiry');
    }

    /*

     * index($error = '', $_err_codes = '', $E_Code = '')
      Add Enquiry View */

    public function index($error = '', $_err_codes = '', $E_Code = '') { //provide a view of new course form
        try {

            global $data;
            $data = $this->util_model->set_error($data, $error, $_err_codes);
            if ($E_Code != '') {
                $data['Enq_Details'] = $this->m_enquiry->search_enq(array("search_via" => array("ECode"), "search_via_value" => array($E_Code)));
                //$this->util_model->printr($data['Enq_Details']);
            }

            $this->load->model(array('enquiry/m_source', 'super-admin/usertypes_model', 'enquiry/locality', 'courses/course'));


            // seraching loading
            $data['Search_List'] = $this->m_enquiry->get_search_col_list();
            $data['type'] = "enq";
            $data['AllPRO'] = $this->usertypes_model->AllUsers($data['Session_Data']['IBMS_BRANCHID']);
            $data['All_Course_List'] = $this->course->listConvert($this->course->Course_list_with_child($data['Session_Data']['IBMS_BRANCHID'], 0));
            $data['locality_list'] = $this->locality->AllLocality(0, $data['Branch_obj']->cityid);
            $data['source_list'] = $this->util_model->get_list('SrcId', 'Src_Code', DB_PREFIX . "e_source_mst", $data['Session_Data']['IBMS_BRANCHID'], 'Src_Code');
            $data['enq_search_template'] = $this->load->view('Enquiry/v-search-enq.php', $data, true);


            $data['c_doing'] = $this->util_model->get_list('CDID', 'Name', DB_PREFIX . "current_doing", $data['Session_Data']['IBMS_BRANCHID'], 'Sort,Code');
            $data['nationality_list'] = $this->util_model->get_list('NID', 'Name', DB_PREFIX . "nationality", $data['Session_Data']['IBMS_BRANCHID'], 'Sort,Code');
            $data['Quali_list'] = $this->util_model->get_list('QID', 'Name', DB_PREFIX . "qualification", $data['Session_Data']['IBMS_BRANCHID'], 'Sort,Code');
            $data['SourceList'] = $this->m_source->showParentList($data['Session_Data']['IBMS_BRANCHID']);
//                                          $data['SourceList'] = $data['source_list'];
            //$data['AllUsers'] = $this->usertypes_model->AllUsers($data['Session_Data']['IBMS_BRANCHID'], $data['Branch_obj']->procode);
            $data['AllUsers'] = $data['AllPRO'];
            $data['country_list'] = $this->util_model->get_list('country_id', 'name', DB_PREFIX . "countries", 0, 'name');
            $data['state_list'] = $this->locality->all_states($data['Branch_obj']->Country);
            //$data['locality_list'] = $this->locality->AllLocality(0, 2);
            $data['City_list'] = $this->util_model->get_list('city_id', 'citycode', DB_PREFIX . "cities", 0, 'Sort,citycode');
            //$data['All_Course_List'] = $this->course->listConvert($this->course->Course_list_with_child($data['Session_Data']['IBMS_BRANCHID'], 0));
            $data['course_cat_list'] = array("" => "Select") + $this->util_model->get_list('C_CID', 'C_CatCode', DB_PREFIX . "course_cat_mst", $data['Session_Data']['IBMS_BRANCHID'], 'C_CatCode');
            $data['all_enq_list'] = $this->m_enquiry->all_enq_list($data['Session_Data']['IBMS_BRANCHID'], 5);

            $this->load->view('templates/header.php', $data);
            $this->load->view('templates/common_window_pop_up.php', $data);
            $this->load->view('Enquiry/v-add-enquiry');
            $this->load->view('templates/footer.php');
        } catch (Exception $ex) {
            log_message("error", "File : " . $ex->getFile() . " Line " . $ex->getLine() . " Error String " . $ex->getTraceAsString());
        }
    }

    /*

     * addenqformvalidation($POST): 
      It has been used for form Validation Currently checking
      2.1 CourseID should be set
      2.2 DOE,Src_CatID,Src_ID,Src_CatID Shouldn't be blank
      RETRUNS
      TRUE if there is not any error
      False if there is any error with Error codes
     */

    function addenqformvalidation($POST) {
        $err_codes = '';
        if (!isset($POST['CourseID'])) {
            $err_codes.='Enq_CourseEmpty' . ERR_DELIMETER;
        }
        if (!isset($POST['PRO']) || $POST['PRO'] == "") {
            $err_codes.='Enq_PROBlank' . ERR_DELIMETER;
        }
        if (!isset($POST['DOE']) || $POST['DOE'] == "") {
            $err_codes.='Enq_DOEBlank' . ERR_DELIMETER;
        }
        if (!isset($POST['Src_CatID']) || $POST['Src_CatID'] == 0) {
            $err_codes.='Enq_SrcCatBlank' . ERR_DELIMETER;
        }
        if (!isset($POST['Src_ID']) || $POST['Src_ID'] == 0) {
            $err_codes.='Enq_SrcBlank' . ERR_DELIMETER;
        }


        $valid = $err_codes == '' ? TRUE : FALSE;
        return array("_err" => $valid, "_err_codes" => $err_codes);
    }

    function othervisit_form_validation($POST) {
        $err_codes = '';
        if (!isset($POST['CourseID'])) {
            $err_codes.='Enq_CourseEmpty' . ERR_DELIMETER;
        }
        if (!isset($POST['PRO']) || $POST['PRO'] == "") {
            $err_codes.='Enq_PROBlank' . ERR_DELIMETER;
        }
        if (!isset($POST['Src_CatID']) || $POST['Src_CatID'] == 0) {
            $err_codes.='Enq_SrcCatBlank' . ERR_DELIMETER;
        }
        if (!isset($POST['Src_ID']) || $POST['Src_ID'] == 0) {
            $err_codes.='Enq_SrcBlank' . ERR_DELIMETER;
        }


        $valid = $err_codes == '' ? TRUE : FALSE;
        return array("_err" => $valid, "_err_codes" => $err_codes);
    }

    public function Othervisit($E_Code = '', $error = '', $_err_codes = '') {
        //provide a view of followups form
        global $data;
        $this->load->helper('array');

        $this->load->model(array('courses/course', 'enquiry/m_source', 'enquiry/m_enquiry', 'enquiry/locality', 'super-admin/usertypes_model', 'branch/branch_model'));
        $data['title_window'] = "Add Next Visit";

        $data = $this->util_model->set_error($data, $error, $_err_codes);
        if ($E_Code != '') {
            $data['Enq_Details'] = $this->m_enquiry->get_enquiry_via_e_code($data['Session_Data']['IBMS_BRANCHID'], $E_Code);
            $data['Enq_Visit_Details'] = $this->m_enquiry->get_Enq_visit_Details_via_e_code($E_Code);
        }

        $data['branch_setting'] = $this->branch_model->get_branch_setting($data['Session_Data']['IBMS_BRANCHID']);
        $data['state_list'] = $this->util_model->get_list("state_id", "code", DB_PREFIX . "cstates", 0, "code");
        $data['country_list'] = $this->util_model->get_list("country_id", "name", DB_PREFIX . "countries", 0, "name");
        $data['city_list'] = $this->util_model->get_list("city_id", "citycode", DB_PREFIX . "cities", 0);
        $data['locality_list'] = $this->locality->AllLocality(0, $data['Branch_obj']->cityid);

        $data['ResponseList'] = $this->util_model->get_list('ResponseID', 'ResponseText', DB_PREFIX . 'e_response_mst', $data['Session_Data']['IBMS_BRANCHID'], 'Sort,ResponseText');
        $data['AllPRO'] = $this->usertypes_model->AllUsers($data['Session_Data']['IBMS_BRANCHID'], $data['Branch_obj']->procode);
        $data['course_cat_list'] = array("" => "Select") + $this->util_model->get_list('C_CID', 'C_CatCode', DB_PREFIX . "course_cat_mst", $data['Session_Data']['IBMS_BRANCHID'], 'C_CatCode');
        $data['SourceCatList'] = $this->m_source->showParentList($data['Session_Data']['IBMS_BRANCHID']);
        // $data['SourceList'] = $this->m_source->showParentList($data['Session_Data']['IBMS_BRANCHID'], $data['e_source']->Src_CatID);
        //$data['e_course'] = $this->m_enquiry->all_ecourses_visit_wise($E_Code, $Visit);
        $data['All_Course_List'] = $this->course->listConvert($this->course->Course_list_with_child($data['Session_Data']['IBMS_BRANCHID'], 0));

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/common_window_pop_up.php', $data);
        $this->load->view('Enquiry/v-other-visit');
        $this->load->view('templates/footer.php');
    }

    function saveothervisit() {
        global $data;
        $this->load->helper('array');
        $path = base_url() . "Enquiry/enquiry/Othervisit/";
        $FormData = $this->input->post();
        $FormData = $this->util_model->add_common_fields($FormData);

        if (isset($FormData['Addvisit'])) {
            // $FormData['Visit'] = $FormData['nextVisit'];
            $validates = $this->othervisit_form_validation($FormData); // validating the form
            // die($this->util_model->printr($validates));
            if (!$validates['_err']) {
                redirect($path . $FormData['E_Code'] . "/1/{$validates['_err_codes']}");
            }

            // transaction started !!
            $this->db->trans_begin();

            $e_sources_data = elements(array('E_Code', 'Src_CatID', 'Src_ID', 'Visit', 'DOE', 'PRO', 'Add_User', 'Add_DateTime', 'Remarks'), $FormData);
            //die($this->util_model->printr($e_sources_data));
            $e_sources_data['DOE'] = date(DB_DTF, strtotime($e_sources_data['DOE']));
            $inserted_source = $this->m_enquiry->addsource($e_sources_data);

            if (!$inserted_source['succ']) {

                log_message("error", "Class " . $this->router->fetch_class() . " Function " . $this->router->fetch_class() . " " . get_err_msg("SrcAddErr"));
            }

            $inserted_courses = $this->m_enquiry->addecourses($FormData);
            if (!$inserted_courses['succ']) {
                log_message("error", "Class " . $this->router->fetch_class() . " Function " . $this->router->fetch_class() . " " . get_err_msg("EnqCourseAddErr"));
            }

            $inserted_ptime = $this->m_enquiry->addptime($FormData);

            if (!$inserted_ptime['succ']) {
                log_message("error", "Class " . $this->router->fetch_class() . " Function " . $this->router->fetch_class() . " " . get_err_msg("EnqptimeAddErr"));
            }
            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                redirect($path . $FormData['E_Code'] . "/0/EnqAddSucc");
            } else {
                log_message("error", "Class " . $this->router->fetch_class() . " Function " . $this->router->fetch_class() . " " . get_err_msg("EnqCourseAddErr"));
                $this->db->trans_rollback();
                redirect($path . $FormData['E_Code'] . "/1/EnqCourseAddErr" . ERR_DELIMETER);
            }
        }
    }

    /*

     * AddEnquiry() 
      Saving enquiry form data to database
     * Inserting in e_tab,e_sources, e_courses,e_ptime           */

    public function AddEnquiry() {
        try {
            global $data;
            $path = base_url() . "Enquiry/enquiry/index/";
            $FormData = $this->input->post();
            $this->load->helper('array');
            if (isset($FormData['AddEnquiry'])) {

                // Searching existing enquiry
                $SearchExisting = $this->m_enquiry->check_name_mobile_already_exits(array($data['Session_Data']['IBMS_BRANCHID']), $FormData['StudentName'], $FormData['Mobile1']);
                if ($SearchExisting['succ']) {
                    redirect(base_url() . "Enquiry/enquiry/Othervisit/" . $SearchExisting['edata']->E_Code);
                }

                $FormData['EFormNo'] = $this->m_enquiry->_gen_eformno($data['Session_Data']['IBMS_BRANCHID']);
                $FormData = $this->util_model->add_common_fields($FormData);
                $FormData['DOB'] = date(DB_DF, strtotime($FormData['DOB']));
                $e_tab_data = elements(array('EFormNo', 'BranchID', 'StudentName', 'FatherName', 'MotherName', 'DOB', 'Gender', 'Quali', 'CurrentDoing', 'NID', 'Mobile1', 'Phone1', 'Email1', 'C_Galino', 'Block', 'C_Add', 'C_Locality', 'C_SubLocality', 'C_City', 'C_State', 'C_Country', 'C_Pincode', 'Add_User', 'Add_DateTime', 'Remarks'), $FormData);
                $validates = $this->addenqformvalidation($FormData); // validating the form
                // die($this->util_model->printr($validates));
                if (!$validates['_err']) {
                    redirect($path . "1/{$validates['_err_codes']}");
                }

                // transaction started !!
                $this->db->trans_begin();

                $inserted_enq = $this->m_enquiry->addenq($e_tab_data);

                if (!$inserted_enq['succ']) {
                    throw new Exception($this->util_model->get_err_msg("EnqAddErr"));
                }

                $FormData['DOE'] = date(DB_DTF, strtotime($FormData['DOE']));
                $FormData['E_Code'] = $inserted_enq['E_Code'];
                $FormData['Visit'] = 1;
                $e_sources_data = elements(array('E_Code', 'Src_CatID', 'Src_ID', 'Visit', 'DOE', 'PRO', 'Add_User', 'Add_DateTime', 'Remarks'), $FormData);
                $inserted_source = $this->m_enquiry->addsource($e_sources_data);
                if (!$inserted_source['succ']) {
                    throw new Exception($this->util_model->get_err_msg("SrcAddErr"));
                }


                $FormData['ESID'] = $inserted_source['ESID'];
                $inserted_courses = $this->m_enquiry->addecourses($FormData);
                if (!$inserted_courses['succ']) {
                    throw new Exception($this->util_model->get_err_msg("EnqCourseAddErr"));
                }

                $inserted_ptime = $this->m_enquiry->addptime($FormData);

                if (!$inserted_ptime['succ']) {
                    throw new Exception($this->util_model->get_err_msg("EnqptimeAddErr"));
                }
                if ($this->db->trans_status() === TRUE) {
                    $this->db->trans_commit();
                    redirect($path . "0/EnqAddSucc/{$FormData['E_Code']}");
                } else {
                    throw new Exception($this->util_model->get_err_msg("EnqCourseAddErr"));
                }
            }
        } catch (Exception $e) {
            // if this function will find any error so it will simply rollback
            $this->db->trans_rollback();
            log_message("error", $e->getMessage() . " File : " . $ex->getFile() . " Line " . $ex->getLine() . " Error String " . $ex->getTraceAsString());
            redirect($path . "1/EnqCourseAddErr" . ERR_DELIMETER);
        }
    }

    /*
     * @function
     * gen_eformno($BranchID): Used To gernerate enquiry
     * form  number,
     * echo form_no for ajax
     */

    function gen_eformno($BranchID) {
        echo $this->m_enquiry->_gen_eformno($BranchID);
    }

    /*

     * @edit_enquiry($E_Code='',$error = '', $_err_codes = '')
     * show edit view */

    public function edit_enquiry($E_Code = '', $error = '', $_err_codes = '') { //provide a view of new course form
        global $data;
        $this->load->helper('array');
        $this->load->model(array('enquiry/m_enquiry', 'enquiry/locality', 'super-admin/usertypes_model', 'branch/branch_model'));
        $data['title_window'] = "Edit Enquiry Details";
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        if ($E_Code != '') {
            $data['Enq_Details'] = $this->m_enquiry->get_enquiry_via_e_code($data['Session_Data']['IBMS_BRANCHID'], $E_Code);
            $data['Enq_Visit_Details'] = $this->m_enquiry->get_Enq_visit_Details_via_e_code($E_Code);
        }
        //$this->util_model->printr($data);
        $data['branch_setting'] = $this->branch_model->get_branch_setting($data['Session_Data']['IBMS_BRANCHID']);
        $data['state_list'] = $this->util_model->get_list("state_id", "code", DB_PREFIX . "cstates", 0, "code");
        $data['country_list'] = $this->util_model->get_list("country_id", "name", DB_PREFIX . "countries", 0, "name");
        $data['city_list'] = $this->util_model->get_list("city_id", "citycode", DB_PREFIX . "cities", 0);
        $data['locality_list'] = $this->locality->AllLocality(0, $data['Branch_obj']->cityid);
        $data['ResponseList'] = $this->util_model->get_list('ResponseID', 'ResponseText', DB_PREFIX . 'e_response_mst', $data['Session_Data']['IBMS_BRANCHID'], 'Sort,ResponseText');
        $data['AllUsers'] = $this->usertypes_model->AllUsers($data['Session_Data']['IBMS_BRANCHID'], 9);
        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/common_window_pop_up.php', $data);
        $this->load->view('Enquiry/followups/v-add-followup');
        $this->load->view('templates/footer.php');
    }

    /* All Enquiry List view page */

    function all_enq_list() {
        global $data;
        $this->load->model(array('enquiry/m_source', 'super-admin/usertypes_model', 'enquiry/locality', 'courses/course'));


        // seraching loading
        $data['Search_List'] = $this->m_enquiry->get_search_col_list();
        $data['type'] = "enq";
        $data['collapse'] = "";
        $data['AllPRO'] = $this->usertypes_model->AllUsers($data['Session_Data']['IBMS_BRANCHID'], $data['Branch_obj']->procode);
        $data['All_Course_List'] = $this->course->listConvert($this->course->Course_list_with_child($data['Session_Data']['IBMS_BRANCHID'], 0));
        $data['locality_list'] = $this->locality->AllLocality(0, $data['Branch_obj']->cityid);
        $data['source_list'] = $this->util_model->get_list('SrcId', 'Src_Code', DB_PREFIX . "e_source_mst", $data['Session_Data']['IBMS_BRANCHID'], 'Src_Code');
        $data['enq_search_template'] = $this->load->view('Enquiry/v-search-enq.php', $data, true);

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/common_window_pop_up.php', $data);
        $this->load->view('Enquiry/v-all-enquiry');
        $this->load->view('templates/footer.php');
    }

    // calling from ajax v-basic-edit-enquiry
    function save_basic_details() {
        // $this->util_model->printr($_POST);         
        $FormData = $this->input->post();
        $E_Code = $FormData['E_Code'];
        echo json_encode($this->m_enquiry->update_basic_enquiry_details($FormData, $E_Code));
    }

    // show update basic datails
    /*
     *  
      Providing the update view of basic details, means after
      basic details of enquiry it loads the fresh view
     */
    function show_updated_basic_details($E_Code) {
        global $data;
        $this->load->model(array('enquiry/locality'));
        $data['state_list'] = $this->util_model->get_list("state_id", "code", DB_PREFIX . "cstates", 0, "code");
        $data['country_list'] = $this->util_model->get_list("country_id", "name", DB_PREFIX . "countries", 0, "name");
        $data['city_list'] = $this->util_model->get_list("city_id", "citycode", DB_PREFIX . "cities", 0);
        $data['locality_list'] = $this->locality->AllLocality(0, $data['Branch_obj']->cityid);

        $data['Enq_Details'] = $this->m_enquiry->get_enquiry_via_e_code($data['Session_Data']['IBMS_BRANCHID'], $E_Code);
        $this->load->view("Enquiry/followups/basic_enq_details", $data);
    }

    function edit_e_visit($E_Code, $Visit) {
        // if someone put wrong ... url
        if ($E_Code == "" || $Visit == "")
            redirect(base_url());
        global $data;
        $this->load->model(array('enquiry/m_source', 'super-admin/usertypes_model', 'courses/course'));
        $data['AllPRO'] = $this->usertypes_model->AllUsers($data['Session_Data']['IBMS_BRANCHID'], $data['Branch_obj']->procode);
        $data['e_source'] = $this->m_enquiry->get_e_details_vai_visit_and_ecode($E_Code, $Visit);
        $data['SourceCatList'] = $this->m_source->showParentList($data['Session_Data']['IBMS_BRANCHID']);
        $data['SourceList'] = $this->m_source->showParentList($data['Session_Data']['IBMS_BRANCHID'], $data['e_source']->Src_CatID);
        $data['e_course'] = $this->m_enquiry->all_ecourses_visit_wise($E_Code, $Visit);
        $data['All_Course_List'] = $this->course->listConvert($this->course->Course_list_with_child($data['Session_Data']['IBMS_BRANCHID'], 0));
        $this->load->view('templates/header.php', $data);
        $this->load->view('Enquiry/edit_e_visit', $data);
        $this->load->view('templates/footer.php');
    }

    function e_source_update() {
        echo json_encode($this->m_enquiry->update_e_source());
    }

    function e_course_update() {
        echo json_encode($this->m_enquiry->update_e_course());
    }

    function e_course_add() {
        // die($this->util_model->printr($_POST));
        echo json_encode($this->m_enquiry->add_e_course());
    }

    function e_course_delete() {
        //  die($this->util_model->printr($_POST));
        echo json_encode($this->m_enquiry->delete_e_course());
    }

    public function edit_ebasic_details($E_Code) {
        global $data;
        $this->load->model(array('enquiry/locality'));
        $data['c_doing'] = $this->util_model->get_list('CDID', 'Name', DB_PREFIX . "current_doing", $data['Session_Data']['IBMS_BRANCHID'], 'Sort,Code');
        $data['nationality_list'] = $this->util_model->get_list('NID', 'Name', DB_PREFIX . "nationality", $data['Session_Data']['IBMS_BRANCHID'], 'Sort,Code');
        $data['state_list'] = $this->locality->all_states($data['Branch_obj']->Country);
        $data['locality_list'] = $this->locality->AllLocality(0, $data['Branch_obj']->cityid);
        $data['City_list'] = $this->util_model->get_list('city_id', 'citycode', DB_PREFIX . "cities", 0, 'Sort,citycode');
        $data['country_list'] = $this->util_model->get_list('country_id', 'name', DB_PREFIX . "countries", 0, 'name');
        $data['Quali_list'] = $this->util_model->get_list('QID', 'Name', DB_PREFIX . "qualification", $data['Session_Data']['IBMS_BRANCHID'], 'Sort,Code');
        $data['Enq_Details'] = $this->m_enquiry->get_enquiry_via_e_code($data['Session_Data']['IBMS_BRANCHID'], $E_Code);
        $this->load->view("Enquiry/v-basic-edit-enquiry", $data);
    }

    /*

     * search_enq()
     * calling from ajax
     * @param nothing
     * receiving POST data from search form
     * Processing and returning html data               */

    function search_enq() {
        global $data;
        $POST = $this->input->post();
        //$this->load->model('enquiry/m_enquiry');
        $data['result'] = $this->m_enquiry->search_enq($POST);
        $this->load->view('Enquiry/v-global_search', $data);
    }

}
