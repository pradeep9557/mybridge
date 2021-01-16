<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of daily_task
 * @Created on : Jun 3, 2016, 12:43:48 PM
 * @author Ankit
 * @Team NexGen PHP Development Team
 * @copyright (c) year, NexGen Innovators IT Services Pvt. Ltd.
 * @website http://nexgeninnovators.com
 * @location
 * @Use
 * 
 */
class daily_task extends CI_controller {

    // constructor
    public function __construct() {
        // calling to parent constructor
        parent::__construct();
        $this->load->model("tms/m_daily_task", 'daily_task');
        $this->load->library("messages");
    }

    public function approveDailyTaskEntry() {
        global $data;
        
        $formdata = $this->input->post();
        if(!empty($formdata) && isset($formdata['_action'])){             
             echo json_encode($this->daily_task->bulkApprove($formdata));
             die();
        }
        
        $this->load->model("tms/m_task_manage", 'm_task');
        $data['client_list'] = $this->m_task->getClientByUserType();
        $data['selUser'] = '';

        $this->load->library("ajax/tms_ajax");
        $data['daily_task_search'] = $this->tms_ajax->daily_task_search();
        $this->load->view('templates/header.php', $data);
        $this->load->view('tms/daily_task/approvePendingDailyEntries.php', $data);
        $this->load->view('templates/footer.php');
    }

    /* funciton daily_task_entry
     * this one is used to show the concerned user the index page/main page from where he/she can punch entries
     */

    public function daily_task_entry() {

        global $data;
//        $this->util_model->printr($data['Session_Data']);
        $this->load->model("tms/m_task_manage", 'm_task');
        $data['client_list'] = $this->m_task->getClientByUserType();


        $this->load->library("ajax/tms_ajax");
        $data['daily_task_search'] = $this->tms_ajax->daily_task_search();
//        $data['client_list'] = array("0" => "Select Client") + $this->util_model->get_list("Emp_ID", "Emp_Name", DB_PREFIX . "employee", "", $sort_col = 'Emp_Name', $for_selection = TRUE, $status = 1, $whr = " UTID=" . CLIENT);
        // $filter = array();
        //$filter['assignedto'] =$this->util_model->get_uid();
        $result = $this->daily_task->get_curr_user_task();
        $temp = array();
        foreach ($result as $value) {
            $temp[$value['tstm_id']] = $value['tstm_name'].'('.$value['state_name'].')('.$value['year'].')('.$value['term_name'].')';
        }
        $data['all_progress_flags'] = $this->daily_task->get_all_progress_status();
        $data['all_completion_status'] = $this->daily_task->get_completion_status();
        $data['show_comment_box'] = TRUE;
        $data['comment_box'] = $this->load->view("tms/common/comment_box", $data, TRUE);
//        $data['daily_punched_data'] = $this->fetch_recent_daily_data(TRUE);
        $data['progress_task'] = array("0" => "Select Sub task") + $temp;


        if (!empty($data['client_list'])) {
            $data['daily_task_form'] = $this->load->view("tms/daily_task/v-daily-task-form", $data, TRUE);
        } else {
            $data['message'] = $this->messages->getMessage("daily_task");
            $data['daily_task_form'] = $this->load->view("tms/common/msg", $data, TRUE);
        }

        $this->load->view('templates/header.php', $data);
        $this->load->view('tms/daily_task/v_daily_task.php', $data);
        $this->load->view('templates/footer.php');
    }

    /* funciton filter_subtask_by_client
     * this one is used to filter the seesion user subtask by the client he has asked for
     */

    public function filter_subtask_by_client() {
        $formdata = $this->input->post();
        $result = $this->daily_task->get_curr_user_task($formdata);
        echo json_encode(array("data" => $result));
    }

    /*

     *  $final_data['notify_users'] = $this->get_task_users_for_mailing($value['tstm_id']);
     * it was previousely in filter_subtask_by_client
     * this funciton will return the notify users list     */

    public function get_notify_users($filter_data = array()) {
        if (empty($filter_data)) {
            $filter_data = $this->input->post();
        }
        echo json_encode($this->daily_task->get_task_users_for_mailing($filter_data['tstm_id']));
    }

    public function fetch_task_dates(){
        $formdata = $this->input->post();
        $sql = "SELECT str_date_time,end_date_time FROM " . DB_PREFIX . "task_sub_task WHERE tstm_id='{$formdata['tstm_id']}'";
        $query = $this->db->query($sql);
        $result = $query->result();
        if (count($result) > 0) {
            echo json_encode(array("succ" => TRUE, "data" => $result[0]));
        }else {
            echo json_encode(array("succ" => FALSE));
        }
    }

    public function update_attachment(){
        $formdata = $this->input->post();
        //print_r($formdata);
        $sql = "Update " . DB_PREFIX . "task_attachments set table_id='{$formdata['clientid']}' WHERE attach_id='{$formdata['attachid']}'";
        $query = $this->db->query($sql);
        echo json_encode(array("success" => TRUE,"_err_msg"=> 'Attachment Updated'));
    }
    public function update_attachment_main(){
        $formdata = $this->input->post();
        //print_r($formdata);
        $sql = "SELECT attachment_id FROM " . DB_PREFIX . "attach_file WHERE id='{$formdata['attachid']}'";
        $query = $this->db->query($sql);
        $attachresult = $query->result('array');
        //print_r($attachresult);
        $sql = "SELECT tm_id FROM " . DB_PREFIX . "task_sub_task WHERE tstm_id='{$formdata['clientid']}'";
        $query = $this->db->query($sql);
        $result = $query->result('array');
        if($result[0]['tm_id']!='' && $result[0]['tm_id']!='0'){
            $sql = "Update " . DB_PREFIX . "attach_file set tm_id='{$result[0]['tm_id']}' WHERE id='{$formdata['attachid']}'";
            $query = $this->db->query($sql);
        }
        if($attachresult[0]['attachment_id']!=''){
            $sql = "Update " . DB_PREFIX . "task_attachments set table_id='{$formdata['clientid']}' WHERE attach_id='{$attachresult[0]['attachment_id']}'";
            $query = $this->db->query($sql);
        }
        echo json_encode(array("success" => TRUE,"_err_msg"=> 'Attachment Updated'));
    }

    /* funciton punch_daily_entry
     * saves the data in the datatbase
     */

    public function punch_daily_entry() {
        $this->load->model("emp/employee_model");
        $this->load->model("tms/m_manage_sub_task", "m_sub_task");
        $formdata = $this->input->post(); 
        if (isset($formdata['work_datetime']) && $formdata['work_datetime'] == '') {
            echo json_encode(array("succ" => FALSE, "_err_codes" => array("Date is required")));
            die();
        }
        $days = (time() - strtotime($formdata['work_datetime'])) / (60 * 60 * 24);

        if ($days > 3 && !in_array($this->util_model->get_utype(), array(PARTNER, DIRECTOR))) {
            echo json_encode(array("succ" => FALSE, "_err_codes" => array("Only 2 days back date entry is allowed")));
            die();
        }
        if ($days < -1) {
            echo json_encode(array("succ" => FALSE, "_err_codes" => array("Future date entry not allowed")));
            die();
        }
        if (isset($formdata['tstm_id'])) {
            if ($this->m_sub_task->is_sub_task_closed($formdata['tstm_id'])) {
                echo json_encode(array("succ" => FALSE, "_err_codes" => array("Sorry Sub Task has been closed, unable to mark entry")));
                die();
            }

            if (!$this->m_sub_task->is_auth_to_punchEntry($formdata['tstm_id'])) {
                echo json_encode(array("succ" => FALSE, "_err_codes" => array("Sorry, you are not authorized to punch entry.")));
                die();
            }

//            echo $this->db->last_query();
//        $this->util_model->printr($formdata);
//        $this->util_model->printr($_FILES);
//        die(); 
            $upload_details = $this->m_sub_task->get_upload_detail_data($formdata['tstm_id']);
//            $this->util_model->printr($upload_details); working tested 17 june 2016
            $this->db->trans_begin();
            //$this->util_model->printr($formdata);
            $inserted_id = $this->daily_task->punch_daily_entry($formdata);
            //$this->util_model->printr($inserted_id);
            if ($inserted_id['succ'] == FALSE) {
                $this->db->trans_rollback();
                echo json_encode($inserted_id);
                die();
            }
            
            $data = $this->employee_model->get__subtask_record($formdata['tstm_id'], $formdata['client_id']);

            if (!file_exists(SITE_ROOT_PATH . "/uploads/" . $data['clint_name'] . "/" . $data['state']. "/" . $data['task_code'] . "/" . $data['year'] . "/" . $data['month'] )) {

                // echo "/uploads/" . $formdata['tm_code']."/".$formdata['ttm_id']."/".$formdata['year']."/".$formdata['month']; exit;
                mkdir(SITE_ROOT_PATH . "/uploads/" . $data['clint_name'] . "/" . $data['state'] . "/" . $data['task_code'] . "/" . $data['year'] . "/" . $data['month'] , 0777, true);
            }
            if (!file_exists(SITE_ROOT_PATH . "/tempuploads/" . $data['clint_name'] . "/" . $data['state']. "/" . $data['task_code'] . "/" . $data['year'] . "/" . $data['month'] )) {

                // echo "/uploads/" . $formdata['tm_code']."/".$formdata['ttm_id']."/".$formdata['year']."/".$formdata['month']; exit;
                mkdir(SITE_ROOT_PATH . "/tempuploads/" . $data['clint_name'] . "/" . $data['state'] . "/" . $data['task_code'] . "/" . $data['year'] . "/" . $data['month'] , 0777, true);
            }

            // if (!file_exists(SITE_ROOT_PATH . "/uploads/" . $upload_details['tm_code'])) {
            //     mkdir(SITE_ROOT_PATH . "/uploads/" . $upload_details['tm_code'], 0777, true);
            // }
//            echo SITE_ROOT_PATH . "/uploads/".$upload_details['tm_code'];
           // $config['upload_path'] = SITE_ROOT_PATH . "/uploads/" . $upload_details['tm_code'];
            $config['upload_path'] = SITE_ROOT_PATH . "/uploads/" . $data['clint_name']. "/" . $data['state'] . "/" . $data['task_code'] . "/" . $data['year'] . "/" . $data['month'];
            $config['allowed_types'] = 'pdf|png|jpg|gif|jpeg|xls|docs|doc|txt|xlsx|docx';
            $config['max_size'] = '20480'; // 20MB allowed
            $this->load->library('upload', $config);
//            $this->util_model->printr($_SERVER);
            if (!empty($_FILES)) {
                $uploaded_data = array();
                $cpt = count($_FILES['attach_name']['name']);
                for ($i = 0; $i < $cpt; $i++) {
                    $j=$i+1;
                    if (!$_FILES['attach_name']['size'][$i] || $_FILES['attach_name']['tmp_name'][$i] == "") {
                        continue;
                    }
                    $uploaded_data[$i]['attach_original_name'] = $_FILES['attach_name']['name'][$i];
                    $file_name = str_replace(" ", "", $upload_details['tm_code']) . "_" . $upload_details['tstm_id'] . "_" . rand(100, 99999) . "." . pathinfo($_FILES['attach_name']['name'][$i], PATHINFO_EXTENSION);
                    $source = SITE_ROOT_PATH . "/uploads/" . $data['clint_name']. "/" . $data['state'] . "/" . $data['task_code'] . "/" . $data['year'] . "/" . $data['month']."/".$file_name;
                    $destination = SITE_ROOT_PATH . "/tempuploads/" . $data['clint_name']. "/" . $data['state'] . "/" . $data['task_code'] . "/" . $data['year'] . "/" . $data['month']."/".$file_name;
                    $_FILES['temp_document_path']['name'] = $file_name;
                    $_FILES['temp_document_path']['type'] = $_FILES['attach_name']['type'][$i];
                    $_FILES['temp_document_path']['tmp_name'] = $_FILES['attach_name']['tmp_name'][$i];
                    $_FILES['temp_document_path']['error'] = $_FILES['attach_name']['error'][$i];
                    $_FILES['temp_document_path']['size'] = $_FILES['attach_name']['size'][$i];
//                    $this->util_model->printr($_FILES);
                    if (!$this->upload->do_upload('temp_document_path')) {
                        $this->db->trans_rollback();
                        echo json_encode(array("succ" => FALSE, "_err_codes" => array($this->upload->display_errors("", ""))));
                        die();
                    }
                    copy($source, $destination);
                    $uploaded_data[$i]['attach_name'] = $file_name;
                    //$uploaded_data[$i]['link'] = "uploads/" . $upload_details['tm_code'] . "/" . $file_name;
                    $uploaded_data[$i]['link'] = "tempuploads/" . $data['clint_name']. "/" . $data['state'] . "/" . $data['task_code'] . "/" . $data['year'] . "/" . $data['month']."/".$file_name;
                    $uploaded_data[$i]['table_id'] = $inserted_id['id'];
                    $uploaded_data[$i]['file_type'] = $formdata['fileType'.$j];
                    $uploaded_data[$i] = $this->util_model->add_common_fields($uploaded_data[$i]); 
                }
                //$this->util_model->printr($uploaded_data);
                //die();
                if (!empty($uploaded_data['upload_errors'])) {
                    echo json_encode(array("succ" => FALSE, "_err_codes" => array("ErrorCode #10092016_1202")));
                    die();
                }
                if (empty($uploaded_data['upload_errors']) && !empty($uploaded_data)) {
                    $result = $this->m_sub_task->attach_comment_docs($uploaded_data); 
                    foreach ($uploaded_data as $k => $value) {
                        $arr = array(
                            'user_id' => $value['Add_User'],
                            'tm_id' => $upload_details['tm_id'],
                            'file_name' => $value['attach_name'],
                            'link' => $value['link'],
                            'state_name' => $data['state'],
                            'date' => $value['Add_DateTime'],
                            'status' => 0,
                            'attachment_id' => $result['attach_id'],
                        );
                        $this->db->insert('nexgen_attach_file', $arr);
                    }

                    if ($result['succ'] != TRUE) {
                        $this->db->trans_rollback();
                        echo json_encode(array("succ" => FALSE, "_err_codes" => array("Some Error Occured!!")));
                        die();
                    }
                }
//                $this->util_model->printr($inserted_id);
//                 $this->util_model->printr($formdata);
            }
            // if (isset($formdata['email']) && !empty($formdata['email']) && $inserted_id['succ']) {
            $mailData['to'] = $this->m_sub_task->get_incharge_email(array("tstm_id" => 1));
            // ....

            if ($mailData['to'] != '') {
                $mailData['from'] = NOTIFY_EMAIL;
                if ($formdata['progress_flag'] == COMPLETED_REQUEST && $this->m_sub_task->request_for_close($formdata['tstm_id'])) {
                    //$this->m_sub_task->request_for_close($formdata['tstm_id']); 

                    $mailData['subject'] = "New comment & Raise complete request in " . strtoupper($upload_details['tm_name']) . $this->util_model->get_uname();
                } else {
                    $mailData['subject'] = "New comment in " . strtoupper($upload_details['tm_name']) . $this->util_model->get_uname();
                }

                $formdata['msg'] = "Dear User," . "<br>A New comment <br>{$formdata['comment']}<br> by " . $this->util_model->get_uname() . ""
                        . "<br>Thanks " . EMAIL_FROM;
                $formdata['heading'] = "";
                $mailData['message'] = $this->load->view("tms/mail_template/template", $formdata, TRUE);
                $this->load->model("tms/mail/mailer", 'mailer');
//            $this->util_model->printr($mailData);
                $this->mailer->send_html($mailData);
            }
            // .... 
            //$this->daily_task->punch_daily_entry_mail($formdata['email'], $formdata['tstm_id']);
            //  }
            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                if ($formdata['progress_flag'] == COMPLETED_REQUEST) {
                    $msg = "Daily entry added successfully & completed request raised !!";
                } else {
                    $msg = "Daily Entry added successfully !!";
                }

                echo json_encode(array("succ" => TRUE, "_err_codes" => array($msg)));
            } else {
                $this->db->trans_rollback();
                echo json_encode(array("succ" => FALSE, "_err_codes" => array("Some Error Occured!!")));
            }
        } else {
            echo json_encode(array("succ" => FALSE, "_err_code" => "Invalid Task, errorCode #TSMID_BLANK"));
        }
    }

    /* funciton fetch_recent_daily_data
     * Used for the datatable display purpose
     */

    public function fetch_recent_daily_data($return_view, $only_json = 0) {
        global $data;
        $filter_data['s_no'] = 0;
        $filter_data = $this->input->post();
        if (isset($filter_data['page'])) {
            $filter_data['page'] = $data['s_no'] = $filter_data['page'] * $filter_data['limit'];
        }

        $data['all_daily_data'] = $this->daily_task->fetch_recent_daily_data($filter_data);

        if ($only_json) {
            echo json_encode($data['all_daily_data']);
        }

        if ($return_view) {
            return $this->load->view('tms/daily_task/v_all_daily_task.php', $data, TRUE);
        }
        $this->load->view('tms/daily_task/v_all_daily_task.php', $data);
    }

    /* function edit_daily_task_data
     * Used to fetch the details of a particular comment_id to fill on daily entry page for editing
     *     */

    public function edit_daily_task($comment_id) {
        global $data;
        $this->load->model("tms/m_task_manage", 'm_task');
        $data['client_list'] = $this->m_task->get_client_list();
        $result = $this->daily_task->get_curr_user_task();
        $temp = array();
        foreach ($result as $value) {
            $temp[$value['tstm_id']] = $value['tstm_name'];
        }

        $data['daily_punched_data'] = $this->fetch_recent_daily_data(TRUE);
        $data['progress_task'] = array("0" => "Select Sub task") + $temp;
//        $temp = array();
//        foreach ($result as $value) {
//            $temp[$value['tstm_id']] = $value['tstm_name'];
//        }
//        $data['progress_task'] = array("0" => "Select Sub task") + $temp;
//        $data['show_comment_box'] = TRUE;
        //  die($this->util_model->printr($comment_id));


        if (isset($comment_id) && $comment_id != "") {
            $data['edit_daily_data'] = $this->daily_task->edit_daily_task($comment_id);
        } else {
            array("succ" => FALSE, "_err_codes" => "Error Occured");
        }
        $sql = "SELECT nexgen_task_sub_task.tstm_id,nexgen_task_sub_task.`tstm_name`,nexgen_task_mst.`tm_name` FROM nexgen_task_sub_task INNER JOIN nexgen_task_mst ON nexgen_task_mst.tm_id=nexgen_task_sub_task.`tm_id`";
        $query = $this->db->query($sql);
        $data['clientlist'] = $query->result('array');
        $data['all_progress_flags'] = $this->daily_task->get_all_progress_status();
        $data['all_completion_status'] = $this->daily_task->get_completion_status();
        $data['show_comment_box'] = TRUE;
        //  die($this->util_model->printr($data['edit_daily_data']));
        $this->load->view('templates/header.php', $data);
        $this->load->view('tms/daily_task/v_edit_daily_task.php', $data);
        $this->load->view('templates/footer.php');
    }

    public function update_daily_task() {
        // $this->load->model("tms/m_manage_sub_task", "m_sub_task");
        global $data;
        $formdata = $this->input->post();
        $this->load->model("tms/m_manage_sub_task", "m_sub_task");
//        die($this->util_model->printr($form_data));
//        //  $form_data['category'] = TRUE;
//        if (isset($form_data['comment_id']) && $form_data['comment_id'] != "") {
//            $updated = $this->daily_task->update_daily_task($form_data);
//            if($updated['succ']){
//                
//            }
//            echo json_encode($updated);
//        } else {
//            echo json_encode(array("succ" => FALSE, "_err_codes" => "Error While Updating"));
//        }
//        new one
        if (isset($formdata['comment_id']) && $formdata['comment_id'] != "") {
            $upload_details = $this->m_sub_task->get_upload_detail_data($formdata['tstm_id']);
//            $this->util_model->printr($upload_details); working tested 17 june 2016
            $this->db->trans_begin();
            $updated_id = $this->daily_task->update_daily_task($formdata);
//             $this->util_model->printr($inserted_id);
            if ($updated_id['succ'] == FALSE) {
                $this->db->trans_rollback();
                echo json_encode($updated_id);
                die();
            }
            $data = $this->employee_model->get__subtask_record($formdata['tstm_id'], $formdata['client_id']);

            if (!file_exists(SITE_ROOT_PATH . "/uploads/" . $data['clint_name'] . "/" . $data['state']. "/" . $data['task_code'] . "/" . $data['year'] . "/" . $data['month'])) {
                mkdir(SITE_ROOT_PATH . "/uploads/" . $data['clint_name'] . "/" . $data['state']. "/" . $data['task_code'] . "/" . $data['year'] . "/" . $data['month'], 0777, true);
            }

            if (!file_exists(SITE_ROOT_PATH . "/tempuploads/" . $data['clint_name'] . "/" . $data['state']. "/" . $data['task_code'] . "/" . $data['year'] . "/" . $data['month'])) {
                mkdir(SITE_ROOT_PATH . "/tempuploads/" . $data['clint_name'] . "/" . $data['state']. "/" . $data['task_code'] . "/" . $data['year'] . "/" . $data['month'], 0777, true);
            }

            $config['upload_path'] = SITE_ROOT_PATH . "/uploads/"  . $data['clint_name'] . "/" . $data['state']. "/" . $data['task_code'] . "/" . $data['year'] . "/" . $data['month'];
            $config['allowed_types'] = 'jpg|png|pdf|doc|docx|xlsx|xls';
            $config['max_size'] = '5120'; // 5MB allowed
            $this->load->library('upload', $config);
//            $this->util_model->printr($_FILES);
            if (!empty($_FILES)) {
                $uploaded_data = array();
                $cpt = count($_FILES['attach_name']['name']);
                for ($i = 0; $i < $cpt; $i++) {

                    if (!$_FILES['attach_name']['size'][$i] || $_FILES['attach_name']['tmp_name'][$i] == "") {
                        continue;
                    }
                    $uploaded_data[$i]['attach_original_name'] = $_FILES['attach_name']['name'][$i];
                    $file_name = str_replace(" ", "", $upload_details['tm_code']) . "_" . $upload_details['tstm_id'] . "_" . rand(100, 99999) . "_" . $_FILES['attach_name']['name'][$i];
                    $source = SITE_ROOT_PATH . "/uploads/" . $data['clint_name']. "/" . $data['state'] . "/" . $data['task_code'] . "/" . $data['year'] . "/" . $data['month']."/".$file_name;
                    $destination = SITE_ROOT_PATH . "/tempuploads/" . $data['clint_name']. "/" . $data['state'] . "/" . $data['task_code'] . "/" . $data['year'] . "/" . $data['month']."/".$file_name;
                    $_FILES['temp_document_path']['name'] = $file_name;
                    $_FILES['temp_document_path']['type'] = $_FILES['attach_name']['type'][$i];
                    $_FILES['temp_document_path']['tmp_name'] = $_FILES['attach_name']['tmp_name'][$i];
                    $_FILES['temp_document_path']['error'] = $_FILES['attach_name']['error'][$i];
                    $_FILES['temp_document_path']['size'] = $_FILES['attach_name']['size'][$i];
//                    $this->util_model->printr($_FILES);
                    if (!$this->upload->do_upload('temp_document_path')) {
                        $this->db->trans_rollback();
                        echo json_encode(array("succ" => FALSE, "_err_codes" => array("Error in uploading Files!")));
                        die();
                    }
                    copy($source, $destination);    
                    $uploaded_data[$i]['attach_name'] = $file_name;
                    $uploaded_data[$i]['link'] = "uploads/" . $upload_details['tm_code'] . "/" . $file_name;
                    $uploaded_data[$i]['table_id'] = $formdata['comment_id'];
                    $uploaded_data[$i] = $this->util_model->add_common_fields($uploaded_data[$i]);
                }
//                $this->util_model->printr($uploaded_data);
                if (!empty($uploaded_data['upload_errors'])) {
                    echo json_encode(array("succ" => FALSE, "_err_codes" => array("Error in uploading Files!")));
                    die();
                }
                if (empty($uploaded_data['upload_errors']) && !empty($uploaded_data)) {
                    $result = $this->m_sub_task->attach_comment_docs($uploaded_data);
                    if ($result['succ'] != TRUE) {
                        $this->db->trans_rollback();
                        echo json_encode(array("succ" => FALSE, "_err_codes" => array("Some Error Occured!!")));
                        die();
                    }
                }
//                $this->util_model->printr($updated_id);
//                 $this->util_model->printr($formdata);
            }
            if (isset($formdata['email']) && !empty($formdata['email']) && $updated_id['succ']) {
                $this->daily_task->punch_daily_entry_mail($formdata['email'], $formdata['tstm_id']);
            }
            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                echo json_encode(array("succ" => TRUE, "_err_codes" => array("Daily Entry Updated Successfully!!")));
            } else {
                $this->db->trans_rollback();
                echo json_encode(array("succ" => FALSE, "_err_codes" => array("Some Error Occured!!")));
            }
        } else {
            echo json_encode(array("succ" => FALSE, "_err_code" => "Invalid Task, errorCode #TSMID_BLANK"));
        }
    }

    public function manage_comment_approval() {
        $formData = $this->input->post();
        echo json_encode($this->daily_task->m_comment_approval($formData, $formData['comment_id']));
    }

    /*
     * Function  was used to update task name and code of data which were duplicated/
     */

    public function dummy() {
        $this->db->select("tm_id,ttm_id")->from("nexgen_task_mst");
        $this->db->order_by("tm_id", 'ASC');
        $res = $this->db->get()->result_array();
//    $this->util_mlodel->printr($res);
        foreach ($res as $value) {
            $this->db->select("*")->from("nexgen_task_type_sub_task_mst")->where(array("ttm_id" => $value['ttm_id'], "status" => 1));
            $master_result = $this->db->get()->result_array();

            $this->db->select("*")->from("nexgen_task_sub_task")->where(array("tm_id" => $value['tm_id'], "status" => 1));
            $sub_task_result = $this->db->get()->result_array();
//
//            $this->util_model->printr($master_result);
//            $this->util_model->printr($sub_task_result);
//            die();
            $i = 0;
            foreach ($master_result as $value) {
//                echo "Start";
//                $this->util_model->printr($sub_task_result[$i]);
//                echo "ENd";
                if (isset($sub_task_result[$i]['tstm_id'])) {
                    $this->db->update("nexgen_task_sub_task", array("tstm_name" => $value['ttstm_name'], "tstm_code" => $value['ttstm_code']), array("tstm_id" => $sub_task_result[$i]['tstm_id'], "status" => 1));
//                die("die");
                    echo "<br>";
                    echo $this->db->last_query();
                    $i++;
                } else {
                    echo "not found ";
                }
            }
        }

//
////        $filter_data = array();
////        foreach ($result as $value) {
////            $filter_data[] = array("id" => $value['ttstm_id'], "tstm_name" => $value['ttstm_name'], "tstm_code" => $value['ttstm_code']);
////        }
    }

    public function get_dailyTask_result() {
        echo json_encode(array("succ" => TRUE, "html" => $this->fetch_recent_daily_data(1)));
    }

}
