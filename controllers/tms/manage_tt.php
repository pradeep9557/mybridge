<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of manage_tt
 * @Created on : 24 May, 2016, 11:56:42 AM
 * @author Deepak Singh
 * @Team NexGen PHP Development Team
 * @copyright (c) year, NexGen Innovators IT Services Pvt. Ltd.
 * @website http://nexgeninnovators.com
 * @location
 * @Use
 * 
 */
class manage_tt extends CI_Controller {

    // constructor
    private $tab1 = "create";
    private $tab2 = "docs_required";
    private $tab3 = "sub_task";

    public function __construct() {
        // calling to parent constructor
        parent::__construct();

        $this->load->model('tms/m_tt_manage', 'tms');
        $this->load->model("tms/m_task_log", 'm_log');
    }

    /*

     * this function will list the cateogies     */

    public function taskCatView() {

        global $data;
        $filter_data = array("Status" => TRUE, "extra_where" => "t1.parent_ttmid<>0");
        $data['taskCatList'] = $this->tms->get_taskCat_list($filter_data);
        $data['css']['only_basic'] = 1;
//         $this->util_model->printr($data['taskCatList']);
        $this->load->view('templates/header.php', $data);
        $this->load->view("tms/manage_tt/v-all-task-cat.php", $data);
        $this->load->view('templates/footer.php');
    }

    // start you function from here
    public function index($tab = "", $id = "", $error = '', $_err_codes = '') { //provide a view of new usertype form
        global $data;

        $data = $this->util_model->set_error($data, $error, $_err_codes);
        $data['all_branches'] = $this->util_model->branch_list_with_branch_Cat($data['Session_Data']);
        $this->load->view('templates/header.php', $data);
        $data['id'] = $id;
        if ($id != "" && $id != 0) {
            $data['task_data'] = $this->tms->get_task_data($id);
        }

        $data['extra_link'] = array(
            array(
                "link" => base_url() . "tms/manage_tt_p_cat",
                "name" => "Manage Main Category",
                "icon" => "glyphicon glyphicon-plus"
            ), array(
                "link" => base_url() . "tms/manage_tt/taskCatView",
                "name" => "All Sub Categories",
                "icon" => "glyphicon glyphicon-plus"
        ));
        $data['tab'] = ($tab == "" || !in_array($tab, array($this->tab1, $this->tab2, $this->tab3))) ? $this->tab1 : $tab;
        $data['under'] = array("0" => "Parent Category") + $this->util_model->get_list("ttm_id", "ttm_name", "nexgen_task_type_mst", 0, "ttm_name", TRUE, 1, " parent_ttmid=0");
        $this->load->view('tms/manage_tt/v_create_task_type', $data);
        $this->load->view('templates/footer.php');
    }

    public function add_basic_details() {
        $formData = $this->input->post();
        $action = $formData['action'];
        unset($formData['action']);
        $result['succ'] = FALSE;
        if (isset($formData['ttm_id']) && $formData['ttm_id'] != "") {
            $result = $this->tms->update_task_type($formData);
        } else {
            $result = $this->tms->create_task_type($formData);
        }

        if ($result['succ']) {
            $this->m_log->punch_log(array("log_type" => TASK_CATEGORY_MASTER, "modified_id" => $result['insert_id'], "remarks" => "Task Created!!"));
//            if ($action) {
            // Next page
            echo json_encode($result);
//                redirect(base_url() . "tms/manage_tt/index/" . $this->tab2 . "/" . $result['insert_id'] . "/" . ("0/" . 'TTSucc'));
//            } else {
            // Same Page
//                redirect(base_url() . "tms/manage_tt/index/" . $this->tab1 . "/" . $result['insert_id'] . "/" . ("0/" . 'TTSucc'));
//            }
        } else {
            //Same Page with error Message
            echo json_encode(array("succ" => FALSE, "_err_codes" => $result['_err_codes']));
            //  redirect(base_url() . "tms/manage_tt/index/" .  $this->tab1 . "/" . "0" . "/" . ($result['succ'] ? "0/" . $result['_err_codes'] : "1/" . $result['_err_codes']));
//            redirect(base_url() . "tms/manage_tt/index/" . $this->tab1 . "/" . "0" . "/" . ("1/" . $result['_err_codes']));
        }
    }

    public function sub_task_details() {
        $formData = $this->input->post();
//        $this->util_model->printr($formData);
        if (!isset($formData['ttm_id']) || $formData['ttm_id'] == "") {
            echo json_encode(array("succ" => FALSE, "_err_codes" => array("Invalid Task Type Passed!!")));
            die();
//            redirect(base_url() . "tms/manage_tt/index/" . $this->tab3 . "/" . "" . "/" . ("1/" . 'TTIdError'));
        } else {
            $validate = $this->st_validate($formData); // validating the create sub-task type form
            if (!empty($validate['_err_codes'])) {
                echo json_encode(array("succ" => FALSE, "_err_codes" => $validate['_err_codes']));
                die();
//                redirect(base_url() . "tms/manage_tt/index/" . $this->tab3 . "/" . $formData['ttm_id'] . "/" . ("1/" . $validate['_err_codes']));
            } else {
                $status = $this->util_model->get_column_value("status", "nexgen_task_type_mst", array("ttm_id" => $formData['ttm_id']));
                if ($status != "") {
                    $action = $formData['action'];
                    unset($formData['action']);
                    $FormData = $this->util_model->add_common_fields($formData);
                    $insert_data = array();
                    $update_data = array();

                    // trnx start
                    $this->db->trans_begin();
                    $this->tms->manage_sub_task_update($FormData);
                    $batch_log = array();
                    for ($i = 0; $i < count($FormData['ttstm_name']); $i++) {
                        if (isset($FormData['ttstm_id'][$i]) && $FormData['ttstm_id'][$i] != STATUS_FALSE) {
                            $update_data[$i]['ttstm_id'] = $FormData['ttstm_id'][$i];
                            $update_data[$i]['ttm_id'] = $FormData['ttm_id'];
                            $update_data[$i]['ttstm_name'] = $FormData['ttstm_name'][$i];
                            $update_data[$i]['ttstm_code'] = $FormData['ttstm_code'][$i];
                            $update_data[$i]['ttstm_efforts'] = $FormData['ttstm_efforts'][$i];
                            $update_data[$i]['ttstm_check_points'] = $FormData['ttstm_check_points'][$i];
                            $update_data[$i]['ttstm_control_points'] = $FormData['ttstm_control_points'][$i];
                            $update_data[$i]['ttstm_faqs'] = $FormData['ttstm_faqs'][$i];
                            $update_data[$i]['status'] = $FormData['status'][$i];
                            $update_data[$i] = $this->util_model->add_mode_user($update_data[$i]);
                            $batch_log[] = array("log_type" => TT_SUB_TASK_MASTER, "modifier_id" => $this->util_model->get_uid(), "modified_id" => $FormData['ttstm_id'][$i], "remarks" => "Sub Task Updated !!");
                        } else {
                            $insert_data[$i]['ttm_id'] = $FormData['ttm_id'];
                            $insert_data[$i]['ttstm_name'] = $FormData['ttstm_name'][$i];
                            $insert_data[$i]['ttstm_code'] = $FormData['ttstm_code'][$i];
                            $insert_data[$i]['ttstm_efforts'] = $FormData['ttstm_efforts'][$i];
                            $insert_data[$i]['ttstm_check_points'] = $FormData['ttstm_check_points'][$i];
                            $insert_data[$i]['ttstm_control_points'] = $FormData['ttstm_control_points'][$i];
                            $insert_data[$i]['ttstm_faqs'] = $FormData['ttstm_faqs'][$i];
                            $insert_data[$i]['status'] = $FormData['status'][$i];
                            $insert_data[$i] = $this->util_model->add_common_fields($insert_data[$i]);
//                        $log_punch[] = array("log_type" => TT_SUB_TASK_MASTER, "modified_id" => $FormData['ttstm_id'][$i], "remarks" => "Sub Task Created !!");
                        }
                    }
                    if (!empty($insert_data)) {
                        $this->tms->create_sub_task_type($insert_data);
                    }
                    if (!empty($update_data)) {
                        $this->tms->update_sub_task_type($update_data);
                    }
                    if (!empty($batch_log)) {
                        $this->m_log->punch_batch_log($batch_log);
                    }
                    if ($this->db->trans_status() === TRUE) {
                        $this->db->trans_commit();
                        echo json_encode(array("succ" => TRUE, "_err_codes" => array("Sub tasks created Successfully!!")));
                        die();
//                        if ($action) {
//                            // Next page
//                            redirect(base_url() . "tms/manage_tt/index/" . $this->tab3 . "/" . $FormData['ttm_id'] . "/" . ("0/" . 'TTSubSucc'));
//                        } else {
//                            // Same Page
//                            redirect(base_url() . "tms/manage_tt/index/" . $this->tab3 . "/" . $FormData['ttm_id'] . "/" . ("0/" . 'TTSubSucc'));
//                        }
                    } else {
                        $this->db->trans_rollback();
                        //Same Page with error Message
                        echo json_encode(array("succ" => FALSE, "_err_codes" => array("Error Occured while creating subtask!!")));
                        die();
                        redirect(base_url() . "tms/manage_tt/index/" . $this->tab3 . "/" . $FormData['ttm_id'] . "/" . ("1/" . 'TTSubError'));
                    }
                } else {
                    echo json_encode(array("succ" => FALSE, "_err_codes" => array("Invalid Task Type Passed!!")));
//                    redirect(base_url() . "tms/manage_tt/index/" . $this->tab3 . "/" . "0" . "/" . ("1/" . 'TTIdError'));
                }
            }
        }
    }

    public function doc_details() {
        $FormData = $this->input->post();
//        $this->util_model->printr($_FILES);
//        die($this->util_model->printr($FormData));
        if (!isset($FormData['ttm_id']) || $FormData['ttm_id'] == "") {
            echo json_encode(array("succ" => FALSE, "_err_codes" => array("Invalid Task Type Passed!!")));
//            redirect(base_url() . "tms/manage_tt/index/" . $this->tab2 . "/" . "" . "/" . ("1/" . 'TTIdError'));
        } else {
            $validate = $this->dr_validate($FormData); // validating the create sub-task type form
            //    die($this->util_model->printr($validate));
            if (!empty($validate['_err_codes'])) {
                echo json_encode(array("succ" => FALSE, "_err_codes" => $validate['_err_codes']));
//                redirect(base_url() . "tms/manage_tt/index/" . $this->tab2 . "/" . $FormData['ttm_id'] . "/" . ("1/" . $validate['_err_codes']));
            } else {
                $status = $this->util_model->get_column_value("status", "nexgen_task_type_mst", array("ttm_id" => $FormData['ttm_id']));
                if ($status != "") {
                    // trnx start
                    $this->db->trans_begin();
                    $this->tms->manage_doc_update($FormData);
//                $count = count($_FILES['document_path']['name']);
                    $config['upload_path'] = "./uploads/";
                    $config['allowed_types'] = 'jpg|png|pdf|doc|docx|xlsx|xls';
                    $config['max_size'] = '5120'; // 5MB allowed
                    $this->load->library('upload', $config);
                    $uploaded_data = array();
                    $update_data = array();
                    $batch_log = array();
                    $u_c = 0;
                    $i_c = 0;
                    foreach ($FormData['ttmdoc_name'] as $key => $ttmdoc_name) {
//                    for ($s = 0; $s <= $count - 1; $s++) {
                        if (isset($FormData['ttmdoc_id'][$key]) && $FormData['ttmdoc_id'][$key]) {
                            $update_data[$u_c]['ttmdoc_id'] = $FormData['ttmdoc_id'][$key];
                            $update_data[$u_c]['ttm_id'] = $FormData['ttm_id'];
                            $update_data[$u_c] = $this->util_model->add_mode_user($update_data[$u_c]);
                            $batch_log[] = array("log_type" => TT_DOC_REQ, "modifier_id" => $this->util_model->get_uid(), "modified_id" => $update_data[$u_c]['ttmdoc_id'], "remarks" => "Document Updated !!");
                            $update_data[$u_c]['ttmdoc_name'] = $FormData['ttmdoc_name'][$key];

                            // if file upload at updating time
                            if (isset($_FILES['document_path']['name'][$key])) {
                                $file_name = str_replace(" ", "", uniqid() . $_FILES['document_path']['name'][$key]);
                                $_FILES['temp_document_path']['name'] = $file_name;
                                $_FILES['temp_document_path']['type'] = $_FILES['document_path']['type'][$key];
                                $_FILES['temp_document_path']['tmp_name'] = $_FILES['document_path']['tmp_name'][$key];
                                $_FILES['temp_document_path']['error'] = $_FILES['document_path']['error'][$key];
                                $_FILES['temp_document_path']['size'] = $_FILES['document_path']['size'][$key];

                                if (!$this->upload->do_upload('temp_document_path')) {
                                    $this->db->trans_rollback();
                                    echo json_encode(array("succ" => FALSE, "_err_codes" => array(strip_tags($this->upload->display_errors()))));
                                    die();
//                                    redirect(base_url() . "tms/manage_tt/index/" . $this->tab2 . "/" . $FormData['ttm_id'] . "/" . ("1/" . 'TTDocError' . ERR_DELIMETER));
                                }
                                $update_data[$u_c]['document_path'] = $file_name == "" ? NULL : "uploads/" . $file_name;
                            }

                            $u_c++;
                        } else {
                            if (!isset($_FILES['document_path']['name'][$key]) || $_FILES['document_path']['name'][$key] == "") {
                                $file_name = "";
                            } else {
                                $file_name = str_replace(" ", "", uniqid() . $_FILES['document_path']['name'][$key]);
                                $_FILES['temp_document_path']['name'] = $file_name;
                                $_FILES['temp_document_path']['type'] = $_FILES['document_path']['type'][$key];
                                $_FILES['temp_document_path']['tmp_name'] = $_FILES['document_path']['tmp_name'][$key];
                                $_FILES['temp_document_path']['error'] = $_FILES['document_path']['error'][$key];
                                $_FILES['temp_document_path']['size'] = $_FILES['document_path']['size'][$key];

                                if (!$this->upload->do_upload('temp_document_path')) {
                                    $this->db->trans_rollback();
                                    
                                    echo json_encode(array("succ" => FALSE, "_err_codes" => array(strip_tags($this->upload->display_errors()))));
                                    die();
//                                    redirect(base_url() . "tms/manage_tt/index/" . $this->tab2 . "/" . $FormData['ttm_id'] . "/" . ("1/" . 'TTDocError' . ERR_DELIMETER));
                                }
                            }

                            $uploaded_data[$i_c]['ttm_id'] = $FormData['ttm_id'];
                            $uploaded_data[$i_c]['document_path'] = $file_name == "" ? NULL : "uploads/" . $file_name;
                            $uploaded_data[$i_c] = $this->util_model->add_common_fields($uploaded_data[$i_c]);
                            $uploaded_data[$i_c++]['ttmdoc_name'] = $FormData['ttmdoc_name'][$key];
                        }
                    }
//                $this->util_model->printr($uploaded_data);
//                 $this->util_model->printr($update_data);
//                echo $count . "hi";
//                die();
                    if (!empty($uploaded_data['upload_errors'])) {
                        echo json_encode(array("succ" => FALSE, "_err_codes" => array("Error in uploading Files!")));
                        die();
//                        redirect(base_url() . "tms/manage_tt/index/" . $this->tab2 . "/" . $FormData['ttm_id'] . "/" . ("1/" . 'TTDocError' . ERR_DELIMETER));
                    }
                    if (empty($uploaded_data['upload_errors']) && !empty($uploaded_data)) {
                        $this->tms->create_doc_for_task($uploaded_data);
                    }
                    if (!empty($update_data)) {
                        $this->tms->update_docs($update_data);
                    }
                    if (!empty($batch_log)) {
                        $this->m_log->punch_batch_log($batch_log);
                    }

                    if ($this->db->trans_status() === TRUE) {
                        $this->db->trans_commit();
                        $doc_data = $this->tms->fetch_doc_data($FormData['ttm_id']);
                        $doc_links = array();
                        $i = 0;
                        foreach ($doc_data as $value) {
//                            $this->util_model->printr($value);
                            $doc_links[$i] = array("link"=>"");
                            if ($value['document_path'] != "uploads/" && $value['document_path'] != NULL) {
                                $link_name = substr($value['document_path'], 0, 8) . "***" . (substr($value['document_path'], strrpos($value['document_path'], ".")));
                                $value["link"] = "<a target='_blank' title='" . $value['ttmdoc_name'] . "' href='" . base_url() . $value['document_path'] . "' >$link_name</a>";
                                $doc_links[$i] = $value;
                            }
                            $i++;
                        }
                        echo json_encode(array("succ" => TRUE, "links" => $doc_links, "_err_codes" => array("File Uploaded Succesfully!")));
                        die();
//                        redirect(base_url() . "tms/manage_tt/index/" . $this->tab3 . "/" . $FormData['ttm_id'] . "/" . ("0/" . 'TTDocSucc'));
                    } else {
                        $this->db->trans_rollback();
                        //Same Page with error Message
                        echo json_encode(array("succ" => FALSE, "_err_codes" => array("Error in uploading Files!")));
                        die();
//                        redirect(base_url() . "tms/manage_tt/index/" . $this->tab2 . "/" . $FormData['ttm_id'] . "/" . ("1/" . 'TTDocError'));
                    }
                } else {
                    echo json_encode(array("succ" => FALSE, "_err_codes" => array("Invalid Task Type Passed!!")));
//                    redirect(base_url() . "tms/manage_tt/index/" . $this->tab2 . "/" . "0" . "/" . ("1/" . 'TTIdError'));
                }
            }
        }
    }

    public function get_parent_code() {
        $formdata = $this->input->post();
        echo json_encode($this->tms->get_parent_code($formdata));
    }

    //sub-task validation
    function st_validate($form_data) {
        $err_codes = array();
        foreach ($form_data['ttstm_name'] as $listname) {
            if ($listname == "") {
                $err_codes[] = "Sub task name not given";
                break;
            }
        }
        foreach ($form_data['ttstm_code'] as $listcode) {
            if ($listcode == "") {
                $err_codes[] = "Sub task Code not given";
                break;
            }
        }
        $valid = !empty($err_codes) ? TRUE : FALSE;
        return array("_err" => $valid, "_err_codes" => $err_codes);
    }

    //document details validation
    function dr_validate($form_data) {
        $err_codes = array();
        foreach ($form_data['ttmdoc_name'] as $docname) {
            if (isset($docname) && $docname == "") {
                $err_codes[] = "File name not passsed";
                break;
            }
        }
        $valid = !empty($err_codes) ? TRUE : FALSE;
        return array("_err" => $valid, "_err_codes" => $err_codes);
    }

}
