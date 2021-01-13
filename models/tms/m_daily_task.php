<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_daily_task
 * @Created on : 5 Jun, 2016, 3:04:04 PM
 * @author Deepak Singh
 * @Team NexGen PHP Development Team
 * @copyright (c) year, NexGen Innovators IT Services Pvt. Ltd.
 * @website http://nexgeninnovators.com
 * @location
 * @Use
 * 
 */
class m_daily_task extends CI_Model {

    // constructor
    public function __construct() {
        // calling to parent constructor
        parent::__construct();
    }

    function validate_punch_data($filter_data) {//validation
        // die($this->util_model->printr($filter_data));
        $err_codes = array();
//        if ($filter_data['client_id'] == 0) {
//            $err_codes[] = "Client Needs to selected";
//        }
        if ($filter_data['tstm_id'] == 0) {
            $err_codes[] = "Sub Task Needs to selected";
        }
        if ($filter_data['comment'] == "") {
            $err_codes[] = "Work Description is required";
        }
        $expr = '/^([0-9]*[.])?[0-9]+/';
        if (!preg_match($expr, $filter_data['efforts'])) {
            $err_codes[] = "Efforts is required and should be numerics only";
        }
        // die($this->util_model->printr($err_codes));
        $valid = empty($err_codes) ? TRUE : FALSE;
        // die($this->util_model->printr($valid));
        return array("_err" => $valid, "_err_codes" => $err_codes);
    }

    /* function get_curr_user_task
     * function is used to fetch all the sub task assigned to a user
     * if the client id is aslo passed in filter_data the the function will filter subtask of passed client only
     *     */

    public function get_curr_user_task($filter_data = "") {
        //   die($this->util_model->printr($filter_data));
//        $this->db->select("tst.tstm_id,tst.tstm_name,tm.tm_name,client.Emp_Name as client_name ")->from(DB_PREFIX . "task_sub_task as tst");
//        //  $this->db->where(array("tst.assignedto" => 63));
//        //  $this->db->where(array("assignedto" => $this->util_model->get_uid()));
//        $this->db->where("tst.progress_flag <> ".COMPLETED_APPROVAL, NULL, FALSE);
////        if ($filter_data != "") {
//        $this->db->join(DB_PREFIX . "task_mst as tm", "tst.tm_id=tm.tm_id", 'left');
//        $this->db->join(DB_PREFIX . "employee as client", "tm.client_id=tm.client_id", 'left');
//        if (isset($filter_data['client_id'])) {
//            $this->db->where("tm.tm_id in (select tm_id from nexgen_task_mst where client_id={$filter_data['client_id']})",NULL,FALSE);
//        }
//        
//        }
        $where2 = "";
        $subQuery = "";
        if (isset($filter_data['client_id'])) {
            $where2 = "AND tst.tm_id in (select tm_id from nexgen_task_mst where client_id={$filter_data['client_id']})";
            $subQuery = ",(select emp.Emp_Name from nexgen_employee emp where emp.Emp_ID={$filter_data['client_id']}) as client_name";
        }
        $sql = "SELECT `tst`.`tstm_id`, `tst`.`tstm_name` $subQuery,tm.tm_name, tm.year, st.name as state_name, period.term_name FROM nexgen_task_sub_task tst left join nexgen_task_mst tm on (tst.tm_id = tm.tm_id)
            left join nexgen_cstates st on (st.state_id=tm.state_id )
            left join nexgen_term_mst period on(period.term_id=tm.task_period_id)
WHERE tst.progress_flag <> 4 $where2";
        //echo $sql;die;
        $result = $this->db->query($sql)->result_array();
//        echo $this->db->last_query();
//        die();
        //die($this->util_model->printr($result));
        if ($filter_data != "") {
            $final_data = array();
            foreach ($result as $value) {

                $final_data['task_data'][] = $value;
            }
            return $final_data;
        } else {
            return $result;
        }
    }

    /* function get_task_users_for_mailing
     * function is used to fetch all members in a task
     * filtered members will than be shown in the checkboxes and mails will be sent to 'em if checked
     *     */

    public function get_task_users_for_mailing($tstm_id = "") {
        $this->db->select("tu.user_id,tu.user_type,e.Emp_Name,e.Emp_ID")->from(DB_PREFIX . "task_users as tu");
//        $this->db->join(DB_PREFIX . "task_mst as tm", "tst.tm_id=tm.tm_id", 'left');
//        $this->db->join(DB_PREFIX . "task_users as tu", "tm.tm_id=tu.tm_id", 'left');
        $this->db->join(DB_PREFIX . "employee as e", "e.Emp_ID=tu.user_id and e.status=1", 'inner');
        $this->db->where("tu.tm_id = (select tm_id FROM " . DB_PREFIX . "task_sub_task as tst WHERE tst.tstm_id = $tstm_id limit 1)");
        $this->db->where("tu.mail_notification<>" . STATUS_FALSE, NULL, FALSE);

        $result = $this->db->get()->result_array();
//        echo $this->db->last_query();
        foreach ($result as $key => $eachRow) {
            if ($eachRow['user_id'] == 183) {
                unset($result[$key]);
                continue;
            }
            $result[$key]['Emp_Name'] = "#{$eachRow['Emp_Name']}(" . $this->util_model->getUtypeString($eachRow['user_type']) . ")";
        }
        return $result;
    }

    /* function punch_daily_entry
     * function is used to punch the data passed by the user from the diluy entry index page
     *     */

    public function punch_daily_entry($filter_data) { 
        $validate = $this->validate_punch_data($filter_data);
        if (!empty($validate['_err_codes'])) {
            return array("succ" => FALSE, "_err_codes" => $validate['_err_codes']);
        } else {
            $data_to_insert = array("tstm_id" => $filter_data['tstm_id'],
                "progress_flag" => $filter_data['progress_flag'],
                "completed" => $filter_data['completed'],
                "efforts" => $filter_data['efforts'],
                "comment" => $filter_data['comment'],
                "approved" => 0,
                "work_datetime" => date(DB_DTF, strtotime($filter_data['work_datetime'])));
            $data_to_insert = $this->util_model->add_common_fields($data_to_insert);
//            echo "punch daily task";
//            $this->util_model->printr($data_to_insert);
            $this->db->insert(DB_PREFIX . "task_sub_task_comments", $data_to_insert);
//            echo $this->db->last_query();
            if ($this->db->affected_rows() < 1) {

                return array("succ" => FALSE, "_err_codes" => array("Error while inserting comment errCode #1606160802pm"));
            } else {
                if ($filter_data['progress_flag'] == COMPLETED_REQUEST) {
                    $this->db->update(DB_PREFIX . "task_sub_task", array('progress_flag' => COMPLETED_REQUEST), array("tstm_id" => $filter_data['tstm_id']));
                }
                return array("succ" => TRUE, "id" => $this->db->insert_id(), "_err_codes" => array("Work Description saved successfully"));
            }
        }
    }

    /*

     * a,proved    */

    public function m_comment_approval($formData, $comment_id) {
        if ($this->db->update(DB_PREFIX . "task_sub_task_comments", $formData, array("comment_id" => $comment_id))) {
            return array("succ" => TRUE, "_err_codes" => "Approved Successfully");
        } else {
            return array("succ" => FALSE, "_err_codes" => "Error");
        }
    }

    /* function fetch_recent_daily_data
     * function is used to show the last 5 entries made by the user from the daily entry index page
     *     */

    public function fetch_recent_daily_data($filter_data = array()) {
        if (isset($filter_data['work_date']) && $filter_data['work_date'] != '') {
            $this->db->where("DATE(tstc.work_datetime) = '{$filter_data['work_date']}'", NULL, FALSE);
        }

        if (isset($filter_data['str_date_time']) && isset($filter_data['end_date_time'])) {
            $this->db->where("(DATE(tstc.work_datetime) >= '" . date(DB_DF, strtotime($filter_data['str_date_time'])) . "' and DATE(tstc.work_datetime) <= '" . date(DB_DF, strtotime($filter_data['end_date_time'])) . "')", NULL, FALSE);
        }

        if (isset($filter_data['Add_User']) && $filter_data['Add_User'] != '0') {
            $this->db->where(array("tstc.Add_User" => $filter_data['Add_User']));
        }
        if (isset($filter_data['approved'])) {
            $this->db->where(array("tstc.approved" => $filter_data['approved']));
        }

        if (isset($filter_data['sub_task_id']) && $filter_data['sub_task_id'] != "0") {
            $this->db->where("tstc.tstm_id", $filter_data['sub_task_id']);
        }
        $this->db->select("tst.tstm_id,tst.tstm_name,tm.tm_name, tm.end_date, e.Emp_Name as entryBy,client.Emp_Name as client_name, ta.attach_original_name, tstc.comment_id,tstc.efforts,tstc.approved,tstc.completed,DATE_FORMAT(tstc.work_datetime, '%d-%m-%Y') as work_date,tstc.comment,DATE_FORMAT(tstc.Add_DateTime, '%d-%m-%Y @ %h:%i %p') as EntryTime", FALSE)->from(DB_PREFIX . "task_sub_task_comments as tstc");
        $this->db->join(DB_PREFIX . "task_sub_task as tst", "tstc.tstm_id=tst.tstm_id", 'left');
        $this->db->join(DB_PREFIX . "task_mst as tm", "tst.tm_id=tm.tm_id", 'left');
        $this->db->join(DB_PREFIX . "employee client", "client.Emp_ID = tm.client_id", "left");
        $this->db->join(DB_PREFIX . "employee e", "tstc.Add_User = e.Emp_ID", "left");
        $this->db->join(DB_PREFIX . "task_attachments ta", "tstc.comment_id = ta.table_id", "left");

        $this->db->order_by("tstc.Mode_DateTime", "DESC");
        if (isset($filter_data['limit']))
            $this->db->limit($filter_data['limit'], $filter_data['page']);
        $result = $this->db->get()->result_array();
        //echo $this->db->last_query();
        return $result;
    }

    /* function edit_daily_task_data
     * function is used to fetch the details of a particular comment_id to fill on daily entry page for editing
     *     */

    public function edit_daily_task($comment_id) {
        $this->db->select('tstc.*,tst.tm_id,e.Emp_Name')->from(DB_PREFIX . "task_sub_task_comments as tstc");
        $this->db->join(DB_PREFIX . "task_sub_task as tst", "tstc.tstm_id=tst.tstm_id", 'left');
        $this->db->join(DB_PREFIX . "task_mst as tm", "tm.tm_id=tst.tm_id", 'left');
//        $this->db->join(DB_PREFIX . "task_doc_req as tdr", "tm.tm_id=tdr.tm_id", 'left');
        $this->db->join(DB_PREFIX . "employee as e", "e.Emp_ID=tm.client_id", 'left');
        $this->db->where("tstc.comment_id", $comment_id);
        if ($this->util_model->get_utype() != PARTNER || $this->util_model->get_utype() != DIRECTOR) {
            $this->db->where("tstc.Add_DateTime >= DATE_SUB(tstc.Add_DateTime,INTERVAL 1 HOUR)", NULL, FALSE);
        }

        $res = $this->db->get()->row_array();
//        echo $this->db->last_query();
        // die($this->util_model->printr($res));
        // $this->db->select("Emp_Name")->from(DB_PREFIX . "employee");
        $this->db->select("ta.*")->from(DB_PREFIX . "task_attachments ta");
        $this->db->where(array("ta.table_id" => $comment_id, "ta.status" => 1));
        $res['doc'] = $this->db->get()->result_array();

        return $res;
        //die($this->util_model->printr($res));
//        if (!empty($res)) {
//            echo json_encode(array("succ" => TRUE, "data" => $res));
//        } else {
//            echo json_encode(array("succ" => FALSE, "_err_codes"=>"Entry Can't be Edited Now"));
//        }
        //die($this->util_model->printr($result));
    }

    /* function punch_daily_entry_mail
     * function is used to send mails to the user selected for notify by mail command
     *     */

    public function punch_daily_entry_mail($filter_data, $tstm_id) {
        $this->load->model("tms/mail/mailer", 'mailer');
        $task_name = $this->util_model->get_column_value("tstm_name", "nexgen_task_sub_task", array("tstm_id" => $tstm_id));
        $this->db->select("e.Emp_Name,e.Emp_ID,e.P_Email")->from(DB_PREFIX . "employee as e");
        $this->db->where("e.Emp_ID in(" . implode(",", $filter_data) . ")", NULL, FALSE);
        $result = $this->db->get()->result_array();
        $mailData = array();
        foreach ($result as $value) {
            $mailData['to'][] = $value['P_Email'];
        }
//        $mailData['to'] = $value['P_Email'];
        $mailData['from'] = NOTIFY_EMAIL;
        $mailData['subject'] = "New comment in " . strtoupper($task_name) . $this->util_model->get_uname();
        $formdata['msg'] = "Dear User," . "\n\nA new comment  by " . $this->util_model->get_uname() . ""
                . "<br>Thanks " . EMAIL_FROM;
        $formdata['heading'] = "";
        $mailData['message'] = $this->load->view("tms/mail_template/template", $formdata, TRUE);
        return $this->mailer->send_html($mailData);
//        print_r($code_sent);
//        $this->util_model->printr($code_sent);
//        $this->util_model->printr($mailData);
//        return TRUE;
    }

    /*

     * update form validation     */

    public function updateformValidation($filter_data) {
        //validation
        // die($this->util_model->printr($filter_data));
        $err_codes = array();
//        if ($filter_data['client_id'] == 0) {
//            $err_codes[] = "Client Needs to selected";
//        }
        if ($filter_data['tstm_id'] == 0) {
            $err_codes[] = "Sub Task Needs to selected";
        }
        if ($filter_data['comment'] == "") {
            $err_codes[] = "Work Description is required";
        }
        if ($filter_data['comment_id'] == "") {
            $err_codes[] = "Internal Error, work desc id not found";
        }
//        $start_date = new DateTime();
//        $since_start = $start_date->diff(new DateTime($filter_data['work_datetime']));
//        echo $since_start->days;
//        if (round(abs($to_time - $from_time) / 60,2) == "") {
//            $err_codes[] = "Internal Error, work desc id not found";
//        }
//        $err_codes[] = "Internal Error, work desc id not found";
        $expr = '/^[1-9][0-9]*$/';
        if (!preg_match($expr, $filter_data['efforts'])) {
            $err_codes[] = "Efforts Should Be Numerics Only";
        }
        // die($this->util_model->printr($err_codes));
        $valid = empty($err_codes) ? TRUE : FALSE;
        // die($this->util_model->printr($valid));
        return array("_err" => $valid, "_err_codes" => $err_codes);
    }

    /*

     * update form action will land here     */

    public function update_daily_task($formdata) {
        $valid = $this->updateformValidation($formdata);
        if (!$valid['_err']) {
            $valid['succ'] = FALSE;
            return $valid;
        }
        $this->db->where("comment_id", $formdata['comment_id']);
        $data_to_update = array("tstm_id" => $formdata['tstm_id'],
            "progress_flag" => $formdata['progress_flag'],
            "completed" => $formdata['completed'],
            "efforts" => $formdata['efforts'],
            "comment" => $formdata['comment'],
            'approved' => $formdata['approved'],
            "work_datetime" => date(DB_DTF, strtotime($formdata['work_datetime'])));
        $data_to_update = $this->util_model->add_mode_user($data_to_update);
        return array("succ" => $this->db->update(DB_PREFIX . "task_sub_task_comments", $data_to_update));
    }

    public function bulkApprove($formData) {
        try {
            if (!isset($formData['approve'])) {
                throw new Exception('There is not entry selected');
            }
             
            $this->db->where_in('comment_id',$formData['approve']);
            $this->db->update(DB_PREFIX.'task_sub_task_comments',array('approved'=>$formData['_action']));
           
            return array('succ' => true, '_err_codes' => 'Enteries updated successfully');
        } catch (Exception $ex) {
            return array('succ' => false, '_err_codes' => $ex->getMessage(), '_post' => $formData);
        }
    }

    /*

     * return the progress status     */

    public function get_all_progress_status() {
        $status = array("0" => "Select Progress Status", "2" => "In Progress", "3" => "Send complete request");
        if (in_array($this->util_model->get_utype(), array(DIRECTOR, PARTNER))) {
            $status["4"] = "Mark Completed";
        }
        return $status;
    }

    /*

     * return completion status     */

    public function get_completion_status() {
        $c_status = array();
        for ($c_i = 0; $c_i <= 100; $c_i+=5) {
            $c_status[$c_i] = "$c_i % completed";
        }
        return $c_status;
    }

    /*

     * get progress flag     */

    public function get_progress_flag() {
        return array(
            '0' => 'Pending for approval',
            '1' => 'Approved',
            '-1' => 'Rejected'
        );
    }

}
