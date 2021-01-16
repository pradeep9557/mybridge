<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of show_task
 * @Created on : 30 May, 2016, 5:25:35 PM
 * @author Deepak Singh
 * @Team NexGen PHP Development Team
 * @copyright (c) year, NexGen Innovators IT Services Pvt. Ltd.
 * @website http://nexgeninnovators.com
 * @location
 * @Use
 */
class manage_sub_task extends CI_Controller {

    // constructor
    public function __construct() {
        // calling to parent constructor
        parent::__construct();
        $this->load->model("tms/m_manage_sub_task", "m_sub_task");
    }

    /* function unassignTasks
      function is used to manage the unassigned entries of the user in session
     * shows the index page for the unassignTasks from where the user can punch unassignTasks  */

    public function unassignTasks() {
        global $data;
        $this->load->model("tms/m_task_manage", 'm_task');
        $data['unassign_form_data'] = $this->m_task->get_client_list();
        $data['whom_instruction'] = $this->m_sub_task->whom_instruction();
        $this->load->view('templates/header.php', $data);
        $data['show_comment_box'] = FALSE;
        $this->load->model("tms/m_daily_task", 'daily_task');
        $data['all_progress_flags'] = $this->daily_task->get_all_progress_status();
        $data['all_completion_status'] = $this->daily_task->get_completion_status();
        $this->load->view("tms/user_task_manage/v_unassign_tasks", $data);
        $this->load->view('templates/footer.php');
    }

    /* function fetch_recent_unassign_entry
      function is used to show the datatable of the recent made unassigned tasks of seeesion user
     */

    public function fetch_recent_unassign_entry() {
        $data['Session_Data'] = $this->session->all_userdata();
        $this->load->model("tms/m_daily_task", 'daily_task');
        $data['all_daily_data'] = $this->daily_task->fetch_recent_daily_data();
//        echo $this->db->last_query();
//        die($this->util_model->printr($data['all_task_details']));
        if (!file_exists(APPPATH . '/views/tms/daily_task/v_all_daily_task.php')) {
            show_404();
        }
        $data['title'] = ucfirst("All Task List | " . SITE_NAME); //capitalizing the first character of string for header.
        $this->load->view('tms/daily_task/v_all_daily_task.php', $data);
    }

    /*

     * manage all the view .... of assigned/Unassigned sub task .. depends on 
     * user  type      */

    public function whom_instruction() {
        global $data;
        $formdata = $this->input->post();

        if ($formdata != "") {
            $res = $this->m_sub_task->whom_instruction($formdata);
        }
        echo json_encode($res);
    }

    /* function subTaskDashboard
      function is used to show a panel to the user where he/she can see all of his/her task
     * routing has been used to call this function
     * $_get parameter is used to provide the current tab a user is navigating to
     */

    public function subTaskDashboard() {
        global $data;
        $data['assignTo'] = $this->input->get("assignTo");
        $data['progress_flag'] = $this->input->get('progress_flag');
        $data['client_id'] = $this->input->get("client_id");
        $data['tm_id'] = $this->input->get("tm_id");
        $data['ttm_id'] = $this->input->get("ttm_id");
        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/common_window_pop_up.php');
        if (!empty($_GET)) {
            $data['active_tab'] = isset($_GET['tab']) ? $_GET['tab'] : "pending_sub_task";
        }
        $this->load->library("ajax/tms_ajax.php");
        $data['task_search_for'] = "Tasks";
        $data['sub_task_search_view'] = $this->tms_ajax->sub_task_search();
//        $this->load->model("tms/m_daily_task", 'daily_task');
//        $data['all_progress_flags'] = $this->daily_task->get_all_progress_status();
//        $data['all_completion_status'] = $this->daily_task->get_completion_status();
//        $data['comment_box'] = $this->load->view("tms/common/comment_box",$data,TRUE);
//        $data['task_data'] = $this->m_sub_task->dashboard_task_data();
//        $this->util_model->printr($data['task_data']);
        $this->load->view('tms/user_task_manage/sub_task_dashboard.php', $data);
//        $this->load->view('tms/user_task_manage/task_dashboard.php', $data);
        $this->load->view('templates/footer.php');
    }

    public function get_sub_task_result($form_data = array()) {
        if (empty($form_data)) {
            $form_data = $this->input->post();
        }
//        die($this->util_model->printr($form_data));
        $form_data['page'] = $data['s_no'] = $form_data['page'] * $form_data['limit'];
//         $form_data['page'] = $data['s_no'];
        $data['task_list'] = $this->m_sub_task->getSubTaskData($form_data);

        echo json_encode(array("succ" => TRUE, "html" => $this->load->view('tms/common/get_sub_task_ajax/ajax_result.php', $data, TRUE)));
    }

    public function singleTab() {
        global $data;
        $formdata = $this->input->post();
        if ($formdata['curr_page'] == "my") {
            $formdata = "tst.assignedto={$data['Session_Data']['IBMS_USER_ID']} and tst.status=" . STATUS_TRUE . " and tst.completed=" . STATUS_TRUE;
        } else if ($formdata['curr_page'] == "due") {
            $formdata = "tst.assignedto={$data['Session_Data']['IBMS_USER_ID']} and tst.status=" . STATUS_TRUE . " and tst.completed=" . STATUS_FALSE . "and tm.end_date < " . date(DB_DF, strtotime(time()));
        } else {
            $formdata = "";
        }
        $result = $this->m_sub_task->dashboard_task_data($formdata);
        if (!empty($result)) {
            echo json_encode(array("succ" => TRUE, "data" => $result));
        } else {
            echo json_encode(array("succ" => FALSE));
        }
    }

    /*

     * assinged sub task     */

    public function mySubTask() {
        echo json_encode($this->m_sub_task->mySubTask($this->input->post()));
        // return json
    }

    public function dummy() {
        global $data;
        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/common_window_pop_up.php');
        $this->load->view('tms/user_task_manage/dummy.php', $data);
        $this->load->view('templates/footer.php');
    }

    /* function taskSingleView
      function is used to throw user to view page of a single sub-task
     * from the same page user can interact and update the progress of the task
     */

    public function taskSingleView($task_id = "") {
        global $data;
        if ($task_id == "" || $this->util_model->get_column_value("status", "nexgen_task_sub_task", array("tstm_id" => $task_id)) == "") {
            $data['error'] = TRUE;
            $data['err_codes'] = 'sd';
//            redirect(base_url())
        } else {
            $data['tstm_id'] = $task_id;
        }
        $this->load->model("tms/m_daily_task", 'daily_task');
        $data['all_progress_flags'] = $this->daily_task->get_all_progress_status();
        $data['all_completion_status'] = $this->daily_task->get_completion_status();
//        $data['comment_box'] = $this->load->view("tms/common/comment_box",$data,TRUE);

        $this->load->view('templates/header.php', $data);
        $this->load->view('tms/user_task_manage/task_display.php', $data);
        $this->load->view('templates/footer.php');
    }

    /*

     * update sub task    status  */

    public function updateSubTaskStatus() {
        $formData = $this->input->post();

        if ($this->m_sub_task->is_incharge($formData['tstm_id']) || in_array($this->util_model->get_utype(), array(PARTNER, DIRECTOR))) {
            $this->db->insert(DB_PREFIX . "task_sub_task_comments", $this->util_model->add_common_fields(array(
                        'tstm_id' => $formData['tstm_id'],
                        'work_datetime' => date(DB_DTF),
                        'progress_flag' => $formData['progress_flag'],
                        'comment' => "System Generated log, task has been marked as " . $this->util_model->get_progress_flag_string($formData['progress_flag']) . " <br><strong>Reason specified :</strong><br> " . $formData['reason']
            )));
            echo json_encode($this->m_sub_task->updateSubTask($formData, $formData['tstm_id']));
//            echo $this->db->last_query();
        }
    }

    /*
      function add_comment
     * Read the name of the function, you'll get to know what it does     */

//    public function add_comment() {
//        $FormData = $this->input->post();
//        $upload_details = $this->m_sub_task->get_upload_detail_data($FormData['tstm_id']);
//        if (!empty($upload_details)) {
//            $this->db->trans_begin();
//            $comment_data = array("tstm_id" => $FormData['tstm_id'], "comment" => $FormData['comment'], "approved" => STATUS_TRUE, "completed" => $FormData['completed'], "progress_flag" => $FormData['progress_flag'], "efforts" => $FormData['efforts']);
//            $inserted_id = $this->m_sub_task->save_comment($this->util_model->add_common_fields($comment_data));
//            if ($inserted_id['succ'] == FALSE) {
//                $this->db->trans_rollback();
//                echo json_encode($inserted_id);
//                die();
//            }
//            if (!file_exists(SITE_ROOT_PATH . "/uploads/" . $upload_details['tm_code'])) {
//                mkdir(SITE_ROOT_PATH . "/uploads/" . $upload_details['tm_code'], 0777, true);
//            }
//             $config['upload_path'] = SITE_ROOT_PATH . "/uploads/" . $upload_details['tm_code'];
//            $config['allowed_types'] = 'jpg|png|pdf|doc|docx|xlsx|xls';
//            $config['max_size'] = '5120'; // 5MB allowed
//            $this->load->library('upload', $config);
//            if (!empty($_FILES)) {
//                $uploaded_data = array();
//                $cpt = count($_FILES['attach_name']['name']);
//                for ($i = 0; $i < $cpt; $i++) {
//                    $file_name = str_replace(" ", "", $upload_details['tm_code']) . "_" . $upload_details['tstm_id'] . "_" . rand(100, 99999) . "_" . $_FILES['attach_name']['name'][$i];
//                    $_FILES['temp_document_path']['name'] = $file_name;
//                    $_FILES['temp_document_path']['type'] = $_FILES['attach_name']['type'][$i];
//                    $_FILES['temp_document_path']['tmp_name'] = $_FILES['attach_name']['tmp_name'][$i];
//                    $_FILES['temp_document_path']['error'] = $_FILES['attach_name']['error'][$i];
//                    $_FILES['temp_document_path']['size'] = $_FILES['attach_name']['size'][$i];
//
//                    if (!$this->upload->do_upload('temp_document_path')) {
//                        echo json_encode(array("succ" => FALSE, "_err_codes" => array("Error in uploading Files!")));
//                        die();
//                    }
//                    $uploaded_data[$i]['attach_name'] = $file_name;
//                    $uploaded_data[$i]['link'] = "uploads/" . $upload_details['tm_code'] . "/" . $file_name;
//                    $uploaded_data[$i]['table_id'] = $inserted_id['id'];
//                    $uploaded_data[$i] = $this->util_model->add_common_fields($uploaded_data[$i]);
//                }
//                if (!empty($uploaded_data['upload_errors'])) {
//                    $this->db->trans_rollback();
//                    echo json_encode(array("succ" => FALSE, "_err_codes" => array("Error in uploading Files!")));
//                    die();
//                }
//                if (empty($uploaded_data['upload_errors']) && !empty($uploaded_data)) {
//                    $result = $this->m_sub_task->attach_comment_docs($uploaded_data);
//                    if ($result['succ'] != TRUE) {
//                        $this->db->trans_rollback();
//                        echo json_encode(array("succ" => FALSE, "_err_codes" => array("Some Error Occured!!")));
//                        die();
//                    }
//                }
//            }
//            if ($this->db->trans_status() === TRUE) {
//                $this->db->trans_commit();
//                echo json_encode(array("succ" => TRUE, "_err_codes" => array("Comment added Successfully!!")));
//            } else {
//                $this->db->trans_rollback();
//                echo json_encode(array("succ" => FALSE, "_err_codes" => array("Some Error Occured!!")));
//            }
//        } else {
//            echo json_encode(array("succ" => FALSE, "_err_codes" => "Task Sub task ID is Invalid"));
//        }
//    }

    /*
      function get_pending_tasks
     * Read the name of the function, you'll get to know what it does     */

    public function get_pending_tasks() {
        $id = $this->input->post('Emp_ID');
        if ((isset($id)) && $id != "") {
            $res = $this->m_sub_task->getPendingSubTaskviaClient($id);
            echo json_encode(array("succ" => TRUE, "data" => $res));
        }
    }

    /*
      function save_unassign_tasks
     * Read the name of the function, you'll get to know what it does     */

    public function save_unassign_tasks() {
        $form_data = $this->input->post();
        //, "assignedto" => $form_data['whom_instruction']
        $status = $this->util_model->get_column_value("status", DB_PREFIX . "task_sub_task", array("tstm_id" => $form_data['tstm_id']));
        if ($status != "") {
            $upload_details = $this->m_sub_task->get_upload_detail_data($form_data['tstm_id']);
            $this->db->trans_begin();
            $inserted_id = $this->m_sub_task->save_unassign_tasks($form_data);
            if ($inserted_id['succ'] == FALSE) {
                $this->db->trans_rollback();
                echo json_encode($inserted_id);
                die();
            }
            if (!file_exists(SITE_ROOT_PATH . "/uploads/" . $upload_details['tm_code'])) {
                mkdir(SITE_ROOT_PATH . "/uploads/" . $upload_details['tm_code'], 0777, true);
            }
            if (!file_exists(SITE_ROOT_PATH . "/tempuploads/" . $upload_details['tm_code'])) {
                mkdir(SITE_ROOT_PATH . "/tempuploads/" . $upload_details['tm_code'], 0777, true);
            }
            $config['upload_path'] = SITE_ROOT_PATH . "/uploads/" . $upload_details['tm_code'];
            $config['allowed_types'] = 'jpg|png|pdf|doc|docx|xlsx|xls';
            $config['max_size'] = '5120'; // 5MB allowed
            $this->load->library('upload', $config);
            if (!empty($_FILES)) {
                $uploaded_data = array();
                $cpt = count($_FILES['attach_name']['name']);
                for ($i = 0; $i < $cpt; $i++) {
                    if (!$_FILES['attach_name']['size'][$i] || $_FILES['attach_name']['tmp_name'][$i] == "") {
                        continue;
                    }
                    $uploaded_data[$i]['attach_original_name'] = $_FILES['attach_name']['name'][$i];
                    $file_name = str_replace(" ", "", $upload_details['tm_code']) . "_" . $upload_details['tstm_id'] . "_" . rand(100, 99999) . "." . pathinfo($_FILES['attach_name']['name'][$i], PATHINFO_EXTENSION);
                    $source = SITE_ROOT_PATH . "/uploads/" . $upload_details['tm_code'].'/'.$file_name;
                    $destination = SITE_ROOT_PATH . "/tempuploads/" . $upload_details['tm_code'].'/'.$file_name;
                    $_FILES['temp_document_path']['name'] = $file_name;
                    $_FILES['temp_document_path']['type'] = $_FILES['attach_name']['type'][$i];
                    $_FILES['temp_document_path']['tmp_name'] = $_FILES['attach_name']['tmp_name'][$i];
                    $_FILES['temp_document_path']['error'] = $_FILES['attach_name']['error'][$i];
                    $_FILES['temp_document_path']['size'] = $_FILES['attach_name']['size'][$i];
//                    $this->util_model->printr($_FILES['temp_document_path']);
                    if (!$this->upload->do_upload('temp_document_path')) {
                        echo json_encode(array("succ" => FALSE, "_err_codes" => array(strip_tags($this->upload->display_errors()))));
                        die();
                    }
                    copy($source, $destination);    
                    $uploaded_data[$i]['attach_name'] = $file_name;
                    $uploaded_data[$i]['link'] = "uploads/" . $upload_details['tm_code'] . "/" . $file_name;
                    $uploaded_data[$i]['table_id'] = $inserted_id['id'];
                    $uploaded_data[$i] = $this->util_model->add_common_fields($uploaded_data[$i]);
                }
                if (!empty($uploaded_data['upload_errors'])) {
                    $this->db->trans_rollback();
                    echo json_encode(array("succ" => FALSE, "_err_codes" => array("Error in uploading Files!")));
                    die();
                }
//                $this->util_model->printr($uploaded_data);
                if (empty($uploaded_data['upload_errors']) && !empty($uploaded_data)) {
                    $result = $this->m_sub_task->attach_comment_docs($uploaded_data);
                    if ($result['succ'] != TRUE) {
                        $this->db->trans_rollback();
                        echo json_encode(array("succ" => FALSE, "_err_codes" => array("Some Error Occured!!")));
                        die();
                    }
                }
            }
            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();

                $filter_data = array();
                $filter_data['heading'] = array('S.no', 'Task Name', 'Incharge Name', 'Sub-task Name', 'Sub-Task Desc', 'Efforts', 'Work Date');
                $filter_data['table_data'] = $this->m_sub_task->info_after_unassigned_for_mail_data($form_data);
                $this->load->model("tms/mail/mailer", 'mailer');

                $mailData = array();

                $mailData['to'] = $this->util_model->get_a_column_value("P_Email", DB_PREFIX . "employee", array("Emp_ID" => $form_data['whom_instruction']));
                $mailData['from'] = NOTIFY_EMAIL;
                $mailData['subject'] = "Unassigned Sub-Task with has been done!!";
                $url = base_url() . "tms/manage_sub_task/get_approve_pst";
                $formdata['msg'] = "Dear User," . "\n\nA Sub-task has been done by " . $this->util_model->get_uname() . " on your instruction!!"
                        . "Click on the given link to check it\n\n"
                        . "<a href='" . $url . "' style='color:#D2C9C9'>Click here</a>"
                        . "<br>\nFind details below\n\nThanks NexIBMS Team<br><br>" . $this->mailer->table_data($filter_data);
                $formdata['heading'] = "Unassigned Task Completed!!";
                $mailData['message'] = $this->load->view("tms/mail_template/template", $formdata, TRUE);
                $code_sent = $this->mailer->send_html($mailData);

                echo json_encode(array("succ" => TRUE, "_err_codes" => array("Unassigned Entry added Successfully!!")));
            } else {
                $this->db->trans_rollback();
                echo json_encode(array("succ" => FALSE, "_err_codes" => array("Some Error Occured!!")));
            }
        } else {
            echo json_encode(array("succ" => FALSE, "_err_codes" => "Wrong Assigned to chosen"));
        }
    }

//get list of punched pending sub tasks (PST) for approval page
    public function get_approve_pst() {
        global $data;
        $filter = array();
        if (in_array($this->util_model->get_utype(), array(DIRECTOR, PARTNER))) {
            if ($this->input->get('instructor_id') != '') {
                $filter['instructor_id'] = $this->input->get('instructor_id');
            }
            $data['pending_instructor_ids'] = $this->m_sub_task->getPendingApprovalInstructorUsers();
        }
        $data['st_approval_list'] = $this->m_sub_task->get_approve_pst($filter);
        
        $this->load->view('templates/header.php', $data);
        $this->load->view("tms/user_task_manage/sub_task_approval", $data);
        $this->load->view('templates/footer.php');
    }

//approves the task claimed by an unassigned user
    public function approve_pst_list() {
        $formdata = $this->input->post();
        if (isset($formdata['comment_id']) && in_array($this->util_model->get_utype(), array(PARTNER, DIRECTOR))) {
            echo json_encode($this->m_sub_task->approve_pst_list($formdata));
        } else if (isset($formdata['comment_id']) && $this->util_model->get_column_value("status", "nexgen_task_sub_task_comments", array("tstm_id" => $formdata['tstm_id'], "whom_instruction" => $this->util_model->get_uid())) != "") {
            echo json_encode($this->m_sub_task->approve_pst_list($formdata));
        } else {
            echo json_encode(array("succ" => FALSE, "_err_codes" => "Sorry you don't have approval for this command!!"));
        }
    }

//discards the task claimed by an unassigned user
    public function discard_pst_list() {
        $formdata = $this->input->post();
        if (isset($formdata['comment_id']) && in_array($this->util_model->get_utype(), array(PARTNER, DIRECTOR))) {
            echo json_encode($this->m_sub_task->discard_pst($formdata));
        } else if (isset($formdata['comment_id']) && $this->util_model->get_column_value("status", "nexgen_task_sub_task_comments", array("tstm_id" => $formdata['tstm_id'], "whom_instruction" => $this->util_model->get_uid())) != "") {
            echo json_encode($this->m_sub_task->discard_pst($formdata));
        } else {
            echo json_encode(array("succ" => FALSE, "_err_codes" => "Invalid Data Passed!!"));
        }
    }

    public function sub_task_document_attact() {
        $formdata = $this->input->post();
        $uploaded_data = array();
        if (!file_exists(SITE_ROOT_PATH . "/uploads/" . $formdata['tm_code'])) {
            mkdir(SITE_ROOT_PATH . "/uploads/" . $formdata['tm_code'], 0777, true);
        }
        if (!file_exists(SITE_ROOT_PATH . "/tempuploads/" . $formdata['tm_code'])) {
            mkdir(SITE_ROOT_PATH . "/tempuploads/" . $formdata['tm_code'], 0777, true);
        }
        $config['upload_path'] = SITE_ROOT_PATH . "/uploads/" . $formdata['tm_code'];
        $config['allowed_types'] = 'jpg|png|pdf|doc|docx|xlsx|xls';
        $config['max_size'] = '5120'; // 5MB allowed
        $this->load->library('upload', $config);
        $upload_details['tm_code'] = $formdata['tm_code'];
        $upload_details['tstm_id'] = $formdata['tstm_id'];


        if (!empty($_FILES)) {

            $cpt = count($_FILES['file']['name']);
            for ($i = 0; $i < $cpt; $i++) {

                if (!$_FILES['file']['size'] || $_FILES['file']['tmp_name'] == "") {
                    // print_r($_FILES);
                    continue;
                }
                // echo "here";
                // print_r($upload_details);
                $uploaded_data[$i]['attach_original_name'] = $_FILES['file']['name'];
                $file_name = str_replace(" ", "", $upload_details['tm_code']) . "_" . $upload_details['tstm_id'] . "_" . rand(100, 99999) . "." . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                $source = SITE_ROOT_PATH . "/uploads/" . $upload_details['tm_code'].'/'.$file_name;
                $destination = SITE_ROOT_PATH . "/tempuploads/" . $upload_details['tm_code'].'/'.$file_name;
                $_FILES['temp_document_path']['name'] = $file_name;
                $_FILES['temp_document_path']['type'] = $_FILES['file']['type'];
                $_FILES['temp_document_path']['tmp_name'] = $_FILES['file']['tmp_name'];
                $_FILES['temp_document_path']['error'] = $_FILES['file']['error'];
                $_FILES['temp_document_path']['size'] = $_FILES['file']['size'];
                //    print_r($_FILES);
//                    $this->util_model->printr($_FILES['temp_document_path']);
                if (!$this->upload->do_upload('temp_document_path')) {
                    echo json_encode(array("succ" => FALSE, "_err_codes" => array("1.Error in uploading Files!")));

                    echo $this->upload->display_errors();
                    die();
                }
                copy($source, $destination);    
                $uploaded_data[$i]['attach_name'] = $file_name;
                $uploaded_data[$i]['link'] = "tempuploads/" . $upload_details['tm_code'] . "/" . $file_name;
                $uploaded_data[$i]['table_id'] = $upload_details['tstm_id'];
                $uploaded_data[$i]['attach_type'] = 2;
                $uploaded_data[$i] = $this->util_model->add_common_fields($uploaded_data[$i]);
            }
            if (!empty($uploaded_data['upload_errors'])) {

                echo json_encode(array("succ" => FALSE, "_err_codes" => array("2.Error in uploading Files!")));
                die();
            }
//                $this->util_model->printr($uploaded_data);
            if (empty($uploaded_data['upload_errors']) && !empty($uploaded_data)) {
                $result = $this->m_sub_task->attach_comment_docs($uploaded_data);

                if ($result['succ'] != TRUE) {
                    //     $this->db->trans_rollback();
                    echo json_encode(array("succ" => FALSE, "_err_codes" => array("Some Error Occured!!")));
                    die();
                }
                $uploaded_data['attach_id'] = $result['attach_id'];
            }
        }



        echo json_encode(array("message" => "File Added ", "data" => $uploaded_data));
    }

    public function delete_subTask_document() {
        $formdata = $this->input->post();
        $json = array();
        if ($formdata) {

            //  print_r($formdata);
            if ($this->m_sub_task->delete_doc($formdata)) {
                $json['msg'] = "File Deleted";
                $json['success'] = TRUE;
            } else {
                $json['success'] = FALSE;
            }
        }

        echo json_encode($json);
    }

    /*

     * list pending sub task to reassign     */

    public function get_pending_sub_task() {
        $req = $this->input->post();
        $filter['date'] = $req['date'];

        $this->load->model("tms/m_task_manage");
        echo json_encode(array(
            "sub_tasks" => $this->m_sub_task->get_not_completed_subTask(array("assigned_to" => $req['assigned_to'])),
            "free_users" => $this->m_task_manage->free_hours($filter)));
    }

    /*

     * close sub task     */

    public function close_sub_task() {
        $formData = $this->input->post();
//        print_r($formData);die();
        if(is_array($formData['tstm_id'])){
        if(in_array($this->util_model->get_utype(), array(PARTNER, DIRECTOR))){
            echo json_encode(array("succ" => $this->m_sub_task->close_sub_task($formData['tstm_id']), "_err_codes" => ''));
        }else{
            echo json_encode(array("succ" => FALSE, "_err_codes" => 'To Close this in bulk, you have to be Director!'));
        }
            
        }else if (in_array($this->util_model->get_utype(), array(PARTNER, DIRECTOR)) || $this->m_sub_task->is_incharge($formData['tstm_id'])) {
//            echo "hi";
            echo json_encode(array("succ" => $this->m_sub_task->close_sub_task($formData['tstm_id']), "_err_codes" => ''));
        } else {
//            echo "jhi";
            echo json_encode(array("succ" => FALSE, "_err_codes" => 'To Close this, you have to be Director, partner or Incharge of this !'));
        }
    }

    public function UpdateSubTask() {
        $formData = $this->input->post();
        $data_to_update = array(
            'str_date_time' => date(DB_DTF, strtotime($formData['start_date'])),
            'end_date_time' => date(DB_DTF, strtotime($formData['end_date']))
        );
        echo json_encode($this->m_sub_task->updateSubTask($data_to_update, $formData['tstm_id']));
    }

}
