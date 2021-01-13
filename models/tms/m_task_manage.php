<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_task_manage
 * @Created on : 27 May, 2016, 2:13:56 PM
 * @author Deepak Singh
 * @Team NexGen PHP Development Team
 * @copyright (c) year, NexGen Innovators IT Services Pvt. Ltd.
 * @website http://nexgeninnovators.com
 * @location
 * @Use
 * 
 */
class m_task_manage extends CI_Model {

// constructor
    public function __construct() {
// calling to parent constructor
        parent::__construct();
    }

//add form validation
    function add_form_validation($task_master_data, $sub_task_data) {
        $err_codes = array();
        if ($task_master_data['ttm_id'] == 0) {
            $err_codes[] = "Sub task Needs to selected";
        }
        if ($task_master_data['tm_name'] == "") {
            $err_codes[] = "Task Name cannot be blank";
        }
        if (!isset($sub_task_data['tm_id']) && ($task_master_data['tm_code'] == "" || $this->util_model->get_column_value('status', DB_PREFIX . 'task_mst', array("tm_code" => $task_master_data['tm_code'])) != "")) {
            $err_codes[] = "Task Code cannot be null and duplicate";
        }
        if ($task_master_data['client_id'] == 0) {
            $err_codes[] = "Task cannot be Created without a client";
        }
        if (!is_numeric($task_master_data['approx_exp'])) {
            $err_codes[] = "Expenditure in numbers only";
        }
        if (isset($task_master_data['does_repeat']) && $task_master_data['does_repeat'] != STATUS_FALSE && isset($task_master_data['repeat_unit']) && !is_numeric($task_master_data['repeat_unit'])) {
            $err_codes[] = "Interval in Numbers only!";
        }
        if ($sub_task_data['incharge_id'] == 0) {
            $err_codes[] = "Task cannot be Created without a incharge";
        }
        if (isset($sub_task_data['ttstm_id']) && empty($sub_task_data['ttstm_id'])) {
            $err_codes[] = "Sub task values have been forged!!";
        }
        if (isset($sub_task_data['tstm_id']) && empty($sub_task_data['tstm_id'])) {
            $err_codes[] = "Sub task values have been forged!!";
        }
        foreach ($sub_task_data['assignedto'] as $assigned_to) {
            if ($assigned_to == 0) {
                $err_codes[] = "All the assigned to fields need to be filled!!";
                break;
            }
        }

        foreach ($sub_task_data['joblocalityid'] as $job_locality) {
            if ($job_locality == 0) {
                $err_codes[] = "All the Job locality fields need to be filled!!";
                break;
            }
        }

        foreach ($sub_task_data['ttstm_efforts'] as $ttstm_efforts) {
            if ($ttstm_efforts == 0) {
                $err_codes[] = "All the Efforts fields need to be filled!!";
                break;
            }
        }
        if (isset($sub_task_data['tm_id'])) {
            if ($this->update_time_task_code_validate($sub_task_data['tm_id'], $task_master_data['tm_code'])) {
                $err_codes[] = "Task Code cannot be null and duplicate";
            }
        }
        $valid = empty($err_codes) ? TRUE : FALSE;
        return array("_err" => $valid, "_err_codes" => $err_codes);
    }

    function update_time_task_code_validate($tm_id, $tm_code) {
        $this->db->select("status")->from(DB_PREFIX . 'task_mst');
        $this->db->where("tm_code = '{$tm_code}' and tm_code not in(select tm_code from nexgen_task_mst where tm_id = {$tm_id})", NULL, FALSE);
        $result = $this->db->get()->row_array();
        if (!empty($result)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

// start you function from here
    /*

     * It will return array for select HTML
     * lowest level users list from logged user     */
    function get_lowest_level_usertype($filter_data = array()) {
        if (isset($filter_data['userGroup'])) {
            $this->db->where(" ut.UserTypeGroup in {$filter_data['userGroup']} ", NULL, FALSE);
        }
        $UTID = $this->util_model->get_utype();
        $this->db->select("ut.UTID,ut.UserTypeName")->from(DB_PREFIX . "usertypes as ut");
        $this->db->where("ut.level >= (select level from nexgen_usertypes ut2 where  ut2.UTID = {$UTID})", NULL, FALSE);
        $this->db->order_by("ut.level", 'DESC');

        $res = $this->db->get()->result_array();
        // echo $this->db->last_query();
        if (!empty($res)) {
            $result = array();
            foreach ($res as $value) {
                $result[$value['UTID']] = $value['UserTypeName'];
            }
            return $result;
        } else {
            return array();
        }
    }

// start you function from here

    function get_lowest_level_users() {
        $UTID = $this->util_model->get_utype();
        $this->db->select("e.Emp_ID,e.Emp_Name")->from(DB_PREFIX . "employee as e");
        $this->db->join(DB_PREFIX . "usertypes as ut", "e.UTID=ut.UTID", 'left');
        $this->db->where("ut.UserTypeGroup <> " . CLIENT_GROUP . " and e.status=1 and e.UTID in (select UTID from nexgen_usertypes where level >= (select level from nexgen_usertypes where UTID = {$UTID} and UserTypeGroup<>" . CLIENT_GROUP . "))", NULL, FALSE);
        $this->db->order_by("e.Emp_Name", 'ASC');
        $res = $this->db->get()->result_array();
        if (!empty($res)) {
            $result = array();
            foreach ($res as $value) {
                $result[$value['Emp_ID']] = $value['Emp_Name'];
            }
            return $result;
        } else {
            return array();
        }
    }

// Function for generating Task Code
    public function get_task_code($filter_data) {
        if (isset($filter_data['taskMCatID'])) {
            $taskMCatCode = $this->util_model->get_column_value("ttm_code", DB_PREFIX . "task_type_mst", array("ttm_id" => $filter_data['taskMCatID']));
            $like = str_replace(" ", "", $taskMCatCode . date("y"));
            $query = $this->db->select('tm_code')->from(DB_PREFIX . "task_mst")->where("tm_code like '$like%'", NULL, FALSE)->order_by('tm_id', 'DESC')->limit(1);
            $result = $query->get()->row_array();
            if (!empty($result)) {
//                echo $taskMCatCode."r".$result['tm_code'];
                $code = str_ireplace($taskMCatCode, '', $result['tm_code']) + 1;
                return array("succ" => TRUE, "code" => $taskMCatCode . $code);
            } else {
//                echo $like;
                return array("succ" => TRUE, "code" => $like . "0001");
            }
        } else {
            $MainCat_Code = strtoupper(substr(trim($filter_data['task_name']), 0, 3));
            $like = str_replace(" ", "", $MainCat_Code . date("y", strtotime("+5 hours")));
            $query = $this->db->select('tm_code')->from(DB_PREFIX . "task_mst")->where("tm_code like '%$like%'")->order_by('tm_id', 'DESC')->limit(1);
            $result = $query->get()->result();
            if (!empty($result)) {
                $code = substr($result[0]->tm_code, 3) + 1;
                return array("succ" => TRUE, "code" => $MainCat_Code . $code);
            } else {
                return array("succ" => TRUE, "code" => $like . "0001");
            }
        }
    }

    public function get_pending_task_no_list() {
        $list = array("-1" => "NA");
        for ($i = 0; $i <= 5; $i++) {
            $list[$i] = $i . " Pending Sub Task/s";
        }
        return $list;
    }

    public function getClientDetails($client_id) {
        return $this->db->get_where(DB_PREFIX . "employee e", array('Emp_ID' => $client_id))->row_array();
    }

    public function get_client_list($filter = array()) {

        $query = "SELECT tm.client_id from nexgen_task_mst as tm  where 1 ";
//        $query.=" LEFT JOIN nexgen_task_mst as tm on tm.tm_id=st.tm_id ";
        if (isset($filter['progress_flag'])) {
            $query .= " and tm.progress_flag in ({$filter['progress_flag']}) ";
        } else {
            $query .= " and tm.progress_flag <> " . COMPLETED_APPROVAL . " ";
        }

        $query .= " group by tm.client_id";


        $this->db->select("emp.Emp_ID,emp.Emp_Name")->from(DB_PREFIX . "employee as emp");
        $this->db->join(DB_PREFIX . "usertypes as ut", "ut.UTID=emp.UTID", 'left');
        $this->db->where("ut.UserTypeGroup in(2)", NULL, FALSE);
        // if(isset($filter['client']))
        $this->db->where("emp.Emp_ID in ($query)", NULL, FALSE);


        $result = $this->db->get()->result_array();
//         echo $this->db->last_query(); 
        $final_data = array("0" => "Select Client", "all" => "All Client");
//        $this->util_model->printr($result);
        if (!empty($result)) {
            foreach ($result as $value) {
                $final_data[$value['Emp_ID']] = $value['Emp_Name'];
            }
        }
        return $final_data;
    }

    public function getClientByUserType() {
        $userType = $this->util_model->get_utype();
        if ($userType == PARTNER || $userType == DIRECTOR) {
            $sql = "SELECT emp.Emp_Name as ClientName, tm_mst.client_id FROM nexgen_task_mst tm_mst inner join nexgen_employee emp on (emp.Emp_ID = tm_mst.client_id) where 1 and tm_mst.progress_flag <> " . COMPLETED_APPROVAL;
        } else {
            $sql = "SELECT emp.Emp_Name as ClientName, "
                    . "tm_mst.client_id FROM nexgen_task_mst "
                    . "tm_mst left join nexgen_employee emp on "
                    . "(emp.Emp_ID = tm_mst.client_id) "
                    . "where (tm_mst.tm_id in "
                    . "(SELECT tm_id FROM nexgen_task_sub_task WHERE "
                    . "assignedto = " . $this->util_model->get_uid() . " "
                    . "and progress_flag <> 4 group by tm_id) or tm_mst.tm_id in (SELECT tuser.tm_id FROM nexgen_task_users tuser WHERE user_type=1 and status=1 and user_id = " . $this->util_model->get_uid() . "))";
        }
        $result = $this->db->query($sql)->result_array();
        $final_data = array("0" => "Select Client");
//        $this->util_model->printr($result);
        if (!empty($result)) {
            foreach ($result as $value) {
                $final_data[$value['client_id']] = $value['ClientName'];
            }
        }
        return $final_data;
    }

    public function get_task_types($filter_data) {
        $this->db->select("*")->from(DB_PREFIX . "task_type_mst");
        $this->db->where(array("parent_ttmid" => $filter_data['parent_ttmid'], "status" => STATUS_TRUE));
    }

    public function get_task_data($filter_data) {
        $this->db->select("*")->from(DB_PREFIX . "task_type_mst");
        $this->db->where(array("ttm_id" => $filter_data['ttm_id'], "status" => STATUS_TRUE));
        $result = $this->db->get()->row_array();

        if (!empty($result)) {
            $result['sub_task_data'] = $this->fetch_sub_task_data($result['ttm_id']);
            $result['docs_data'] = $this->fetch_doc_data($result['ttm_id']);
        }
        return $result;
    }

    public function fetch_ttm_id($parent_id) {
        $this->db->select("*")->from(DB_PREFIX . "task_type_mst");
        $this->db->where(array("parent_ttmid" => $parent_id, "status" => STATUS_TRUE));
        $result = $this->db->get()->result_array();
        $data = array();
        foreach ($result as $value) {
            $data[$value['ttm_id']] = $value['ttm_name'];
        }
        return $data;
    }

    public function fetch_sub_task_data($id = "") {
        $this->db->select("*")->from(DB_PREFIX . "task_type_sub_task_mst");
        if (is_array($id)) {
            $this->db->where("ttstm_id in(" . implode(",", $id) . ")", NULL, FALSE);
        } else {
            $this->db->where(array("ttm_id" => $id));
        }
        $this->db->where("status", STATUS_TRUE);
        return $this->db->get()->result_array();
    }

    public function fecth_replicate_sub_task_data($id = array()) {
        $this->db->select("*")->from(DB_PREFIX . "task_sub_task");
        $this->db->where("tstm_id in(" . implode(",", $id) . ")", NULL, FALSE);
        $this->db->where("status", STATUS_TRUE);
        return $this->db->get()->result_array();
    }

//     public function fetch_sub_task_data($id = '') {
//        $this->db->select("*")->from(DB_PREFIX . "task_type_sub_task_mst");
//        $this->db->where("ttstm_id in(" . implode(",", $id) . ")", NULL, FALSE);
//        $this->db->where("status", STATUS_TRUE);
//        return $this->db->get()->result_array();
//    }

    public function fetch_doc_data($id = "") {
        $this->db->select("ttmdoc_name,document_path")->from(DB_PREFIX . "task_type_doc_req_mst");
        $this->db->where(array("status" => STATUS_TRUE, "ttm_id" => $id));
        return $this->db->get()->result_array();
    }

    /*
      function name : getTasks
      work : It will return array  or count of total task
      as per filter
      input array filter
      keys
      1. count : return count int
      2. status : Bool
      3. does_repeat Bool
      4. repeated_from  int | NULL
      5. notify_before_days int : notification before replicate actual date
      e.g client want to notification of replicate task before 7 days.
      default NOTIFY_BEFORE_DATE
      6. client_id : for client
      7. OrderCol : for order by ..
      8. limit : for limit
      9. ttm_id : Task Type Master ID
      10.

     */

    public function getTasks($filter_data = "") {

        if (!empty($filter_data)) {
            if (isset($filter_data['Status'])) {
                $this->db->where("t1.Status", $filter_data['Status']);
            }
            if (isset($filter_data['repeated_from'])) {
                $this->db->where("t1.repeated_from is NULL", NULL, FALSE);
            }
            if (isset($filter_data['Emp_ID']) && $filter_data['Emp_ID'] != 0) {
                $this->db->where("t1.client_id", $filter_data['Emp_ID']);
            }

            if (isset($filter_data['BillingDone']) && $filter_data['BillingDone'] == 1) {
                $this->db->where(array("t1.BillingDone" => STATUS_TRUE, "t1.progress_flag" => COMPLETED_REQUEST));
            } else if (isset($filter_data['BillingDone']) && $filter_data['BillingDone'] == 0) {
                $this->db->where(array("t1.BillingDone" => STATUS_FALSE, "t1.progress_flag" => COMPLETED_REQUEST));
            }

            if (isset($filter_data['progress_flag']) && $filter_data['progress_flag'] != 0) {
                $this->db->where("t1.progress_flag", $filter_data['progress_flag']);
            }

            if (isset($filter_data['user_id']) && $filter_data['user_id'] != 0) {
                $this->db->where("tu.user_id", $filter_data['user_id']);
            }

            if (isset($filter_data['date_wise']) && $filter_data['date_wise']) {
                if (isset($filter_data['start_date'])) {
                    $this->db->where("t1.start_date>='" . date(DB_DF, strtotime($filter_data['start_date'])) . "'", NULL, FALSE);
                }
                if (isset($filter_data['end_date'])) {
                    $this->db->where("t1.end_date<='" . date(DB_DF, strtotime($filter_data['end_date'])) . "'", NULL, FALSE);
                }
            }
            if (isset($filter_data['does_repeat'])) {
                $this->db->where("t1.does_repeat", $filter_data['does_repeat']);
                if (isset($filter_data['notify_before_days'])) {
                    $this->db->where("DATE_ADD(t1.start_date,INTERVAL t1.repeat_unit-" . $filter_data['notify_before_days'] . " day)<now()", NULL, FALSE);
                }
            }
            if (isset($filter_data['ttm_id']) && $filter_data['ttm_id'] != "" && $filter_data['ttm_id'] != 0) {
                $this->db->where("ttm.ttm_id", $filter_data['ttm_id']);
            }
            if (isset($filter_data['tm_id']) && $filter_data['tm_id'] != "") {
                $this->db->where("t1.tm_id", $filter_data['tm_id']);
            }
            if (isset($filter_data['extra_where'])) {
                $this->db->where($filter_data['extra_where'], NULL, FALSE);
            }
            if (isset($filter_data['OrderCol'])) {
                $this->db->order_by($filter_data['OrderCol'], "ASC");
            } else {
                $this->db->order_by("t1.Mode_DateTime", "DESC");
            }
            if (isset($filter_data['limit'])) {
                $this->db->limit($filter_data['limit'], 0);
            }
        }
        $billing_from_sub_query = "(SELECT (SELECT tbacc.account_title FROM " . DB_PREFIX . "task_bill_account tbacc WHERE tbacc.bill_account_id = tbm.bill_account_id) FROM " . DB_PREFIX . "task_billing_mst tbm WHERE tbm.tm_id=t1.tm_id and tbm.status=1) as billedFrom";
        $this->db->select("$billing_from_sub_query,t1.*,add_user.Emp_Name as TaskCreater, e.Emp_Name as InchargeName,emp.Emp_Name as client_name, DATE_ADD(t1.start_date,INTERVAL t1.repeat_unit day) as replicate_date ", FALSE)->from(DB_PREFIX . "task_mst t1");
        $this->db->join(DB_PREFIX . "task_type_mst as ttm", "ttm.ttm_id = t1.ttm_id and ttm.status=1", 'left');
        $this->db->join(DB_PREFIX . "task_users as tu", "t1.tm_id = tu.tm_id and tu.user_type=" . INCHARGE . " and tu.status=1", 'left');
        $this->db->join(DB_PREFIX . "employee as e", "tu.user_id = e.Emp_Id  and tu.status=1", 'left');
        $this->db->join(DB_PREFIX . "employee as add_user", "add_user.Emp_Id = t1.Add_User  and add_user.status=1", 'left');
        $this->db->join(DB_PREFIX . "employee as emp", "t1.client_id = emp.Emp_Id  and t1.status=1", 'left');
        $result = $this->db->get()->result_array();

        if (isset($filter_data['count'])) {
            return count($result);
        }
        return $result;
    }

    public function create_sub_task($task_master_data, $sub_task_data) {
        
        $validate = $this->add_form_validation($task_master_data, $sub_task_data);
        if (!empty($validate['_err_codes'])) {
            return array("succ" => FALSE, "_err_codes" => $validate['_err_codes']);
        }
        $this->db->trans_begin();

        $this->db->insert(DB_PREFIX . "task_mst", $this->util_model->add_common_fields($task_master_data));
        $tm_id = $this->db->insert_id();
        //echo $this->db->last_query();
//        $this->util_model->printr($sub_task_data);
        if (isset($sub_task_data['file_id']) && $sub_task_data['file_id'] != '') {
            $this->load->model('tms/m_files');
            $this->m_files->attach_files_with_task($tm_id, $sub_task_data['file_id']);
        }
        $this->db->query("INSERT INTO " . DB_PREFIX . "task_doc_req (tm_id, tmdoc_name, document_path, Add_User , Add_DateTime) SELECT  {$tm_id}, ttmdoc_name, document_path, {$this->util_model->get_uid()} , '" . date(DB_DTF, time()) . "'  FROM " . DB_PREFIX . "task_type_doc_req_mst WHERE  ttm_id = {$task_master_data['ttm_id']} and status=" . STATUS_TRUE);

        $data_to_insert = array();
//        $this->util_model->printr($sub_task_data['ttstm_id']);
        $sub_tasks = $this->fetch_sub_task_data($sub_task_data['ttstm_id']);
//        $this->util_model->printr($sub_tasks);
        $i = 0;
        foreach ($sub_tasks as $value) {
            $data_to_insert[] = $this->util_model->add_common_fields(array("assignedto" => $sub_task_data['assignedto'][$i],
                "joblocalityid" => $sub_task_data['joblocalityid'][$i],
                "str_date_time" => date(DB_DTF, strtotime($sub_task_data['str_date_time'][$i])),
                "end_date_time" => date(DB_DTF, strtotime($sub_task_data['end_date_time'][$i])),
                "tm_id" => $tm_id,
                "tstm_name" => $sub_task_data['ttstm_name'][$i],
                "tstm_code" => $sub_task_data['ttstm_code'][$i],
                "tstm_efforts" => $sub_task_data['ttstm_efforts'][$i],
                "tstm_control_points" => $value['ttstm_control_points'],
                "tstm_check_points" => $value['ttstm_check_points'],
                "tstm_faqs" => $value['ttstm_faqs'],
                "sort" => $sub_task_data['sort'][$i++],
                "status" => STATUS_TRUE, "progress_flag" => IN_PROGRESS));
        }


        // custom add

        if (isset($sub_task_data['_custom_sub_task'])) {
            foreach ($sub_task_data['_custom_sub_task'] as $i => $value) {
                $data_to_insert[] = $this->util_model->add_common_fields(array("assignedto" => $sub_task_data['_custom_assignedto'][$i],
                    "joblocalityid" => $sub_task_data['_custom_joblocalityid'][$i],
                    "str_date_time" => date(DB_DTF, strtotime($sub_task_data['_custom_str_date_time'][$i])),
                    "end_date_time" => date(DB_DTF, strtotime($sub_task_data['_custom_end_date_time'][$i])),
                    "tm_id" => $tm_id,
                    "tstm_name" => $sub_task_data['_custom_ttstm_name'][$i],
                    "tstm_code" => $sub_task_data['_custom_ttstm_code'][$i],
                    "tstm_efforts" => $sub_task_data['_custom_ttstm_efforts'][$i],
                    "tstm_control_points" => $sub_task_data['_custom_ttstm_control_points'][$i],
                    "tstm_check_points" => $sub_task_data['_custom_ttstm_check_points'][$i],
                    "tstm_faqs" => $sub_task_data['_custom_ttstm_faqs'][$i],
                    "sort" => $sub_task_data['_custom_sort'][$i],
                    "status" => STATUS_TRUE,
                    "progress_flag" => IN_PROGRESS));
            }
        }
//        $this->util_model->printr($data_to_insert);
        $this->db->insert_batch(DB_PREFIX . "task_sub_task", $data_to_insert);


        $pro_users = array();
        $pro_users[] = $this->util_model->add_common_fields(array("tm_id" => $tm_id, "user_type" => INCHARGE, "user_id" => $sub_task_data['incharge_id'], "status" => STATUS_TRUE, "mail_notification" => STATUS_TRUE));

        $directors = $this->util_model->get_list("Emp_ID", "Emp_ID", DB_PREFIX . "employee", $this->util_model->get_ubid(), 'Emp_Name', TRUE, 1, " UTID=" . DIRECTOR);
        $partners = $this->util_model->get_list("Emp_ID", "Emp_ID", DB_PREFIX . "employee", $this->util_model->get_ubid(), 'Emp_Name', TRUE, 1, " UTID=" . PARTNER);

        foreach ($directors as $d_value) {
            $pro_users[] = $this->util_model->add_common_fields(array("tm_id" => $tm_id, "user_type" => DIRECTOR, "user_id" => $d_value, "status" => STATUS_TRUE, "mail_notification" => STATUS_TRUE));
        }
        foreach ($partners as $p_value) {
            $pro_users[] = $this->util_model->add_common_fields(array("tm_id" => $tm_id, "user_type" => PARTNER, "user_id" => $p_value, "status" => STATUS_TRUE, "mail_notification" => STATUS_TRUE));
        }
        //   $this->util_model->printr($pro_users);
        $this->db->insert_batch(DB_PREFIX . "task_users", $pro_users);
//        echo $this->db->last_query();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array("succ" => FALSE, "_err_codes" => array("Some Error Occured,Try again!!"));
        } else {
            $this->db->trans_commit();
            return array("succ" => TRUE, "id" => $tm_id, "_err_codes" => array("Task Created Successfully!!"));
        }
    }

    public function get_first_sub_task($taskid) {
        $sql = "SELECT tstm_id FROM `nexgen_task_sub_task` WHERE tm_id = " . $taskid . " ORDER BY tstm_id DESC LIMIT 1";

        $query = $this->db->query($sql);
        return $query->row_array();
    }

    public function get_task($taskid) {
        $sql = "SELECT * FROM `nexgen_task_mst` WHERE tm_id = " . $taskid . " ORDER BY tm_id DESC LIMIT 1";

        $query = $this->db->query($sql);
        return $query->row_array();
    }

    public function update_sub_task($task_master_data, $sub_task_data) {
        $this->load->model("tms/m_task_log", "m_log");
        $validate = $this->add_form_validation($task_master_data, $sub_task_data);
        if (!$validate['_err']) {
            return array("succ" => FALSE, "_err_codes" => $validate['_err_codes']);
        }
        $this->db->trans_begin();

        $assigned_to_change = FALSE;
        $log_data = array();
        $data_to_update = array();

        $this->db->where("tm_id = {$sub_task_data['tm_id']}", NULL, FALSE);
        $this->db->update(DB_PREFIX . "task_sub_task", array("status" => STATUS_FALSE));

        $this->db->select("DISTINCT(e.Emp_ID)")->from(DB_PREFIX . "task_mst as tm");
        $this->db->join(DB_PREFIX . "task_sub_task as tst", "tst.tm_id=tm.tm_id", 'left');
        $this->db->join(DB_PREFIX . "employee as e", "e.Emp_ID=tst.assignedto", 'left');
        $this->db->where(array("tm.tm_id" => $sub_task_data['tm_id']));
        $all_assigned_to = $this->db->get()->row_array();

        foreach ($sub_task_data['assignedto'] as $value) {
            if (!in_array($value, $all_assigned_to)) {
                $assigned_to_change = TRUE;
            }
        }
        $i = 0;
        foreach ($sub_task_data['tstm_id'] as $value) {
            $data_to_update[] = $this->util_model->add_mode_user(array("joblocalityid" => $sub_task_data['joblocalityid'][$i],
                "assignedto" => $sub_task_data['assignedto'][$i],
                "tstm_efforts" => $sub_task_data['ttstm_efforts'][$i],
                "str_date_time" => date(DB_DTF, strtotime($sub_task_data['str_date_time'][$i])),
                "end_date_time" => date(DB_DTF, strtotime($sub_task_data['end_date_time'][$i])),
                "tstm_name" => $sub_task_data['ttstm_name'][$i],
                "tstm_code" => $sub_task_data['ttstm_code'][$i++],
                "status" => STATUS_TRUE,
                "tstm_id" => $value));
        }
        $this->db->update_batch(DB_PREFIX . "task_sub_task", $data_to_update, 'tstm_id');


        // if incharge has been updated
        if ($sub_task_data['db_incharge_id'] != $sub_task_data['incharge_id']) {
            $this->db->where(array("tm_id" => $sub_task_data['tm_id'], "user_type" => 1, "status" => STATUS_TRUE));
            $this->db->update(DB_PREFIX . "task_users", $this->util_model->add_mode_user(array("status" => STATUS_FALSE)));

            $this->db->insert(DB_PREFIX . "task_users", $this->util_model->add_common_fields(array("tm_id" => $sub_task_data['tm_id'], "user_id" => $sub_task_data['incharge_id'], "user_type" => INCHARGE, "status" => STATUS_TRUE)));

            $log_data[] = array("log_type" => 6, "modified_id" => $sub_task_data['tm_id'], "modifier_id" => $this->util_model->get_uid(), "Remarks" => "Incharge Of the task has been changed!!");
        }


        if ($assigned_to_change) {
            $log_data[] = array("log_type" => 6, "modified_id" => $sub_task_data['tm_id'], "modifier_id" => $this->util_model->get_uid(), "Remarks" => "Assigend to users of this task have been changed!!");
        }

        $this->add_some_new_custome_sub_task($sub_task_data);


        // if task master details has been updated
        $this->db->where(array("tm_id" => $sub_task_data['tm_id']));
        $this->db->update(DB_PREFIX . "task_mst", $this->util_model->add_mode_user($task_master_data));

        if (!empty($log_data)) {
            $this->m_log->punch_batch_log($log_data);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array("succ" => FALSE, "_err_codes" => array("Some Error Occured,Try again!!"));
        } else {
            $this->db->trans_commit();
            return array("succ" => TRUE, "id" => $sub_task_data['tm_id'], "_err_codes" => array("Task Updated Successfully!!"));
        }
    }

    /*

     * manage custome sub task     /
     */

    public function add_some_new_custome_sub_task($sub_task_data) {
        // if some other new custome sub task added
        // custom add
        $data_to_insert = array();
        if (isset($sub_task_data['_custom_sub_task'])) {
            foreach ($sub_task_data['_custom_sub_task'] as $i => $value) {
                $data_to_insert[] = $this->util_model->add_common_fields(array("assignedto" => $sub_task_data['_custom_assignedto'][$i],
                    "joblocalityid" => $sub_task_data['_custom_joblocalityid'][$i],
                    "str_date_time" => date(DB_DTF, strtotime($sub_task_data['_custom_str_date_time'][$i])),
                    "end_date_time" => date(DB_DTF, strtotime($sub_task_data['_custom_end_date_time'][$i])),
                    "tm_id" => $sub_task_data['tm_id'],
                    "tstm_name" => $sub_task_data['_custom_ttstm_name'][$i],
                    "tstm_code" => $sub_task_data['_custom_ttstm_code'][$i],
                    "tstm_efforts" => $sub_task_data['_custom_ttstm_efforts'][$i],
                    "tstm_control_points" => $sub_task_data['_custom_ttstm_control_points'][$i],
                    "tstm_check_points" => $sub_task_data['_custom_ttstm_check_points'][$i],
                    "tstm_faqs" => $sub_task_data['_custom_ttstm_faqs'][$i],
                    "sort" => $sub_task_data['_custom_sort'][$i],
                    "status" => STATUS_TRUE));
            }
        }
        // $this->util_model->printr($data_to_insert);
        if (!empty($data_to_insert))
            $this->db->insert_batch(DB_PREFIX . "task_sub_task", $data_to_insert);
    }

    public function replicate_sub_task($task_master_data, $replicate_data, $copy = FALSE) {
        $validate = $this->add_form_validation($task_master_data, $replicate_data);
        if (!empty($validate['_err_codes'])) {
            return array("succ" => FALSE, "_err_codes" => $validate['_err_codes']);
        }
//        $this->db->trans_begin();

        $this->db->insert(DB_PREFIX . "task_mst", $this->util_model->add_common_fields($task_master_data));
        $tm_id = $this->db->insert_id();
        $replicate_data['tm_id'] = $tm_id;
        $this->add_some_new_custome_sub_task($replicate_data);
        if (!$copy) {
            $this->db->where(array("tm_id" => $replicate_data['tm_id']));
            $this->db->update(DB_PREFIX . "task_mst", array("repeated_from" => $tm_id));
        }
        $this->db->query("INSERT INTO " . DB_PREFIX . "task_doc_req (tm_id, tmdoc_name, document_path, Add_User , Add_DateTime) SELECT  {$tm_id}, ttmdoc_name, document_path, {$this->util_model->get_uid()} , '" . date(DB_DTF, time()) . "'  FROM " . DB_PREFIX . "task_type_doc_req_mst WHERE  ttm_id = {$task_master_data['ttm_id']} and status=" . STATUS_TRUE);
        $task_user_data = array();
        $task_user_data[] = $this->util_model->add_common_fields(array("tm_id" => $tm_id, "user_type" => INCHARGE, "user_id" => $replicate_data['incharge_id'], "status" => STATUS_TRUE, "mail_notification" => STATUS_TRUE));
        $directors = $this->util_model->get_list("Emp_ID", "Emp_ID", DB_PREFIX . "employee", 0, 'Emp_Name', TRUE, 1, " UTID=" . DIRECTOR);
        $partners = $this->util_model->get_list("Emp_ID", "Emp_ID", DB_PREFIX . "employee", 0, 'Emp_Name', TRUE, 1, " UTID=" . PARTNER);
        foreach ($directors as $d_value) {
            $task_user_data[] = $this->util_model->add_common_fields(array("tm_id" => $tm_id, "user_type" => DIRECTOR, "user_id" => $d_value, "status" => STATUS_TRUE, "mail_notification" => STATUS_TRUE));
        }
        foreach ($partners as $p_value) {
            $task_user_data[] = $this->util_model->add_common_fields(array("tm_id" => $tm_id, "user_type" => PARTNER, "user_id" => $p_value, "status" => STATUS_TRUE, "mail_notification" => STATUS_TRUE));
        }
//        $this->util_model->printr($task_user_data);
        $this->db->insert_batch(DB_PREFIX . "task_users", $task_user_data);

        $data_to_insert = array();
        $sub_tasks = $this->m_task->fecth_replicate_sub_task_data($replicate_data['tstm_id']);
        $i = 0;
//        $this->util_model->printr($sub_tasks);
        foreach ($sub_tasks as $value) {
            $data_to_insert[] = $this->util_model->add_mode_user(array("joblocalityid" => $replicate_data['joblocalityid'][$i],
                "assignedto" => $replicate_data['assignedto'][$i],
                "tstm_efforts" => $replicate_data['ttstm_efforts'][$i],
                "tm_id" => $tm_id,
                "str_date_time" => date(DB_DTF, strtotime($replicate_data['str_date_time'][$i])),
                "end_date_time" => date(DB_DTF, strtotime($replicate_data['end_date_time'][$i])),
                "tstm_name" => $replicate_data['ttstm_name'][$i],
                "tstm_code" => $replicate_data['ttstm_code'][$i++],
                "status" => STATUS_TRUE,
                "tstm_control_points" => $value['tstm_control_points'],
                "tstm_check_points" => $value['tstm_check_points'],
                "tstm_faqs" => $value['tstm_faqs']));
        }
//        $this->util_model->printr($data_to_insert);
        $this->db->insert_batch(DB_PREFIX . "task_sub_task", $data_to_insert);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array("succ" => FALSE, "_err_codes" => array("Repliaction Error!!"));
        } else {
            $this->db->trans_commit();
            return array("succ" => TRUE, "id" => $tm_id, "_err_codes" => array("Task Replicated Successfully!!"));
        }
    }

    public function fetch_task_data($id) {
        $this->db->select("*")->from(DB_PREFIX . "task_mst");
        $this->db->where(array("status" => STATUS_TRUE, "tm_id" => $id));
        $result = $this->db->get()->result_array();

        $task_data = array();
        foreach ($result as $value) {
            $value['incharge_data'] = $this->fetch_incharge_data($value['tm_id']);
            $value['sub_task_data'] = $this->fetch_task_detailed_data($value['tm_id']);
            $value['task_type_data'] = $this->get_task_type_data($value['ttm_id']);
            $value['task_doc_data'] = $this->fetch_doc_data($value['ttm_id']);
            $task_data = $value;
        }
        return $task_data;
    }

    public function fetch_incharge_data($id) {
        $this->db->select("*")->from(DB_PREFIX . "task_users");
        $this->db->where(array("status" => STATUS_TRUE, "tm_id" => $id, "user_type" => INCHARGE));
        return $this->db->get()->row_array();
    }

    public function fetch_task_detailed_data($id) {
        $this->db->select("*")->from(DB_PREFIX . "task_sub_task");
        $this->db->where(array("status" => STATUS_TRUE, "tm_id" => $id));
        $this->db->order_by("sort");
        $st_list = $this->db->get()->result_array();
        $List = array();
        if (!empty($st_list)) {
            foreach ($st_list as $subTask) {
                $subTask['documents'] = $this->getsubTask_doc($subTask['tstm_id']);
                $List[] = $subTask;
            }
        }

        return $List;
    }

    function getsubTask_doc($subTaskId) {

        $this->db->select("ta.attach_id,ta.attach_original_name,ta.link,ta.attach_name")->from(DB_PREFIX . "task_attachments ta");
        $this->db->where(array("status" => STATUS_TRUE, "table_id" => $subTaskId, "attach_type" => 2));
        return $this->db->get()->result_array();
    }

    public function get_task_type_data($ttm_id) {
        $this->db->select("*")->from(DB_PREFIX . "task_type_mst");
        $this->db->where(array("ttm_id" => $ttm_id, "status" => STATUS_TRUE));
        return $this->db->get()->result_array();
    }

    public function get_user_availability($filter_data) {
        $this->db->select("tm.tm_name,tst.tstm_id,date(tst.str_date_time) as start_date, date(tst.end_date_time) as end_date,tst.tstm_name")->from(DB_PREFIX . "task_sub_task tst");
        $this->db->join(DB_PREFIX . "task_mst tm", "tm.tm_id = tst.tm_id", "left");
        $this->db->where("tst.assignedto = {$filter_data['assigned_to']} AND tst.progress_flag <> " . COMPLETED_APPROVAL, NULL, FALSE);
        $result = $this->db->get();
//        echo $this->db->last_query();
        $result = $result->result_array();
        if (!empty($result)) {
            return array("succ" => TRUE, "data" => $result);
        } else {
            return array("succ" => FALSE);
        }
    }

    /*

     * it will return task and its sub task only     */

    public function get_my_new_tasks($filter_data = "") {
       if (isset($filter_data['Status']) && $filter_data['Status'] != '') {

            $this->db->where("tm.Status", $filter_data['Status']);
        }
        if (isset($filter_data['repeated_from'])) {
            $this->db->where("tm.repeated_from is NULL", NULL, FALSE);
        }
        if (isset($filter_data['state_id']) && $filter_data['state_id'] != 0) { $this->db->where("tm.state_id", $filter_data['state_id']);
        }
        if (isset($filter_data['year']) && $filter_data['year'] != 0) {
            $this->db->where("tm.year", $filter_data['year']);
        }
        if (isset($filter_data['month']) && $filter_data['month'] != 0) {
            $this->db->where("tm.month", $filter_data['month']);
        }
        if (isset($filter_data['client_id']) && !in_array(0, $filter_data['client_id'])) {
            $client_id = implode(",", $filter_data['client_id']);
            $this->db->where("tm.client_id in ($client_id)");
        }

        if (isset($filter_data['skill_dev_activity']) && $filter_data['skill_dev_activity'] != -1) {
            $this->db->where("tm.skill_dev_activity", $filter_data['skill_dev_activity']);
        }

        if (isset($filter_data['task_period_id']) && $filter_data['task_period_id'] != '') {
            $this->db->where("tm.task_period_id", $filter_data['task_period_id']);
        }

       /* if (isset($filter_data['billedUnbilled']) && $filter_data['billedUnbilled'] != '') {

            $this->db->where("tm.status", $filter_data['billedUnbilled']);

        }*/
        if(isset($filter_data['attachment']) && $filter_data['attachment']=='with_attach'){ 
                $this->db->where("af.file_name !=",'NULL'); 
        } 
        

         



        if (isset($filter_data['BillingDone']) && $filter_data['BillingDone'] == 1) {
            $this->db->where(array("tm.BillingDone" => STATUS_TRUE));
        } else if (isset($filter_data['BillingDone']) && $filter_data['BillingDone'] == 0) {
            $this->db->where(array("tm.BillingDone" => STATUS_FALSE));
        }

        if (isset($filter_data['progress_flag']) && $filter_data['progress_flag'] != 0 && $filter_data['date_wise'] != 5 && $filter_data['date_wise'] != 4) {
            $this->db->where("tm.progress_flag", $filter_data['progress_flag']);
        }



        if (isset($filter_data['date_wise']) && $filter_data['date_wise']) {
            if ($filter_data['date_wise'] == 1) {
                //str date wise 
                if (isset($filter_data['start_date'])) {
                    $this->db->where("tm.start_date>='" . date(DB_DF, strtotime($filter_data['start_date'])) . "'", NULL, FALSE);
                }
                if (isset($filter_data['start_date'])) {
                    $this->db->where("tm.start_date<='" . date(DB_DF, strtotime($filter_data['end_date'])) . "'", NULL, FALSE);
                }
            } else if ($filter_data['date_wise'] == 2) {
                // end date wise

                if (isset($filter_data['start_date'])) {
                    $this->db->where("tm.end_date>='" . date(DB_DF, strtotime($filter_data['start_date'])) . "'", NULL, FALSE);
                }
                if (isset($filter_data['end_date'])) {
                    $this->db->where("tm.end_date<='" . date(DB_DF, strtotime($filter_data['end_date'])) . "'", NULL, FALSE);
                }
            } else if ($filter_data['date_wise'] == 3) {
                // end date wise

                if (isset($filter_data['start_date'])) {
                    $this->db->where("tm.Mode_DateTime>='" . date(DB_DF, strtotime($filter_data['start_date'])) . "'", NULL, FALSE);
                }
                if (isset($filter_data['end_date'])) {
                    $this->db->where("tm.Mode_DateTime<='" . date(DB_DF, strtotime($filter_data['end_date'])) . "'", NULL, FALSE);
                }
            } else if ($filter_data['date_wise'] == 4) {
                // end date wise

                if (isset($filter_data['start_date'])) {
                    $this->db->where("tm.Add_DateTime>='" . date(DB_DF, strtotime($filter_data['start_date'])) . "'", NULL, FALSE);
                }
                if (isset($filter_data['end_date'])) {
                    $this->db->where("tm.Add_DateTime<='" . date(DB_DF, strtotime($filter_data['end_date'])) . "'", NULL, FALSE);
                }
            } else if ($filter_data['date_wise'] == 5) {


                if (isset($filter_data['start_date'])) {

                    $this->db->where("tm.Close_DateTime>='" . date(DB_DF, strtotime($filter_data['start_date'])) . "'", NULL, FALSE);

                }

                if (isset($filter_data['end_date'])) {

                    $this->db->where("tm.Close_DateTime<='" . date(DB_DF, strtotime($filter_data['end_date'])) . "'", NULL, FALSE);

                }

                $this->db->where("tm.progress_flag", COMPLETED_APPROVAL);

            }

        }

        if (isset($filter_data['does_repeat']) && $filter_data['does_repeat'] != 2) {

            $this->db->where("tm.does_repeat", $filter_data['does_repeat']);

            if (isset($filter_data['notify_before_days'])) {

                $this->db->where("DATE_ADD(tm.start_date,INTERVAL tm.repeat_unit-" . $filter_data['notify_before_days'] . " day)<now()", NULL, FALSE);

            }

        }



        if (isset($filter_data['ttm_id']) && !in_array(0, $filter_data['ttm_id'])) {

            $ttm_id = implode(",", $filter_data['ttm_id']);

            $this->db->where("(ttm.ttm_id in ($ttm_id) or ttm.ttm_id in (select tt.ttm_id from " . DB_PREFIX . "task_type_mst tt where tt.parent_ttmid in ($ttm_id)))", NULL, FALSE);

        }

        if (isset($filter_data['tm_id']) && $filter_data['tm_id'] != 0) {

            $this->db->where("tm.tm_id =" . $filter_data['tm_id'], NULL, FALSE);

        }

        if (isset($filter_data['tm_name']) && $filter_data['tm_name'] != "") {

            $this->db->where("tm.tm_name like '%" . $filter_data['tm_name'] . "%'", NULL, FALSE);

        }

        if (isset($filter_data['tm_code']) && $filter_data['tm_code'] != "") {

            $this->db->where("tm.tm_code like '%" . $filter_data['tm_code'] . "%'", NULL, FALSE);

        }

        if (isset($filter_data['extra_where'])) {

            $this->db->where($filter_data['extra_where'], NULL, FALSE);

        }

        if (isset($filter_data['OrderCol'])) {

            $this->db->order_by($filter_data['OrderCol'], $filter_data['OrderAscDsc']);

        } else {

            $this->db->order_by("tm.Mode_DateTime", "DESC");

        }

        if (isset($filter_data['limit'])) {

            $this->db->limit($filter_data['limit'], $filter_data['page']);

        }

        if (isset($filter_data['user_id']) && !in_array(0, $filter_data['user_id'])) {

            $user_id = implode(",", $filter_data['user_id']);

            $this->db->where("tu.user_id in ($user_id)");

        } else {

            if (!in_array($this->util_model->get_utype(), array(DIRECTOR, PARTNER))) {

                $this->db->where("tu.user_id =" . $this->util_model->get_uid(), NULL, FALSE);

            }

        }



        $billing_from_sub_query = "";
 
        $billing_from_sub_query = "(SELECT (SELECT tbacc.account_title FROM " . DB_PREFIX . "task_bill_account tbacc WHERE tbacc.bill_account_id = tbm.bill_account_id) FROM " . DB_PREFIX . "task_billing_mst tbm WHERE tbm.bill_mst_id = (select bill_mst_id from nexgen_task_billnos bn where bn.tm_id=tm.tm_id and bn.status=1 limit 1) and tbm.status=1) as billedFrom";

        $this->db->select("tbacc.account_title as billedFrom,bmst.bill_amt,bmst.bill_no,bmst.bill_mst_id,af.file_name,tm.client_id,tm.year,tm.month,tm.state_id,tm.close_task_note,tm.tm_code,ttm_name,tm.BillingDone,tm.start_date,tm.end_date,"

                . "emp2.Emp_Name as Incharge_name,emp1.Emp_Name as client_name, count(emp1.Emp_ID) as total_count, emp1.gst_no,emp1.po_no,"

                . "tm.extra_note, tm.tm_name,tm.tm_id,tm.skill_dev_activity,tm.progress_flag,tm.Mode_DateTime," 

                . "(select count(DISTINCT(tstm_id)) from nexgen_task_sub_task where tm_id = tm.tm_id) as total_sub_task ", NULL, FALSE)->from(DB_PREFIX . "task_mst as tm");

        $this->db->join(DB_PREFIX . "task_type_mst as ttm", "ttm.ttm_id = tm.ttm_id and ttm.status=1", 'left');

        $this->db->join(DB_PREFIX . "employee as emp1", "emp1.Emp_ID=tm.client_id", 'left');  

        $this->db->join(DB_PREFIX . "task_users as tu", "tu.tm_id=tm.tm_id and tu.user_type = " . INCHARGE . " and tu.status=" . STATUS_TRUE, 'left');

        $this->db->join(DB_PREFIX . "employee as emp2", "emp2.Emp_ID=tu.user_id", 'left');

        $this->db->join(DB_PREFIX . "task_billing_mst as bmst", "bmst.bill_mst_id=(select bill_mst_id from nexgen_task_billnos bn where bn.tm_id=tm.tm_id and bn.status=1 limit 1)", 'left');

        $this->db->join(DB_PREFIX . "task_bill_account as tbacc ", "tbacc.bill_account_id=bmst.bill_account_id", 'left');

        $this->db->join(DB_PREFIX . "attach_file as af","af.tm_id=tm.tm_id",'left');
 

        if (isset($filter_data['no_of_subTask']) && $filter_data['no_of_subTask'] != '-1') {

            $this->db->where('(select count(*) from ' . DB_PREFIX . 'task_sub_task sst where sst.tm_id=tm.tm_id and sst.progress_flag<>' . COMPLETED_APPROVAL . ') = ' . $filter_data['no_of_subTask']);

        }

        if (isset($filter_data['billing_acc_id']) && $filter_data['billing_acc_id'] != 0) {
            $this->db->where("(SELECT count(*) FROM " . DB_PREFIX . "task_billnos tskb WHERE tskb.bill_mst_id in (SELECT tbl2.bill_mst_id FROM nexgen_task_billing_mst tbl2 WHERE tbl2.bill_account_id = {$filter_data['billing_acc_id']}) and tskb.tm_id = tm.tm_id)", NULL, FALSE); 

        }

        $this->db->group_by('client_name');
        //$this->db->order_by("tm.tm_id", 'ASC');


        if (isset($filter_data['end_limit']) & isset($filter_data['start_limit'])) {

            $this->db->limit($filter_data['end_limit'], $filter_data['start_limit']);

        }

        $this->db->where("tm.status", STATUS_TRUE);

//        $result = $this->db->get()->result_array();



        $sql = str_replace('`', "", $this->db->return_query());

        $result = $this->db->query($sql); //->result_array();

//        $this->util_model->printr($result->result_array());

//        echo $this->db->last_query();

//        die();
        //print_r($this->db->last_query());
        $result = $result->result_array();



//        $this->util_model->printr($result);

//        echo $this->db->last_query();

//        die();

        if (!empty($result)) {

            $final_data = array();

            foreach ($result as $val) {

                $val['sub_task_data'] = $this->get_my_tasks_sub_task($val['tm_id']);

                $final_data[] = $val;

            }

            return $final_data;

        }

        return array();
        
    }

    public function get_my_tasks($filter_data = "") {

        if (isset($filter_data['Status']) && $filter_data['Status'] != '') {

            $this->db->where("tm.Status", $filter_data['Status']);

        }

        if (isset($filter_data['repeated_from'])) {

            $this->db->where("tm.repeated_from is NULL", NULL, FALSE);

        }

        if (isset($filter_data['state_id']) && $filter_data['state_id'] != 0) {

            $this->db->where("tm.state_id", $filter_data['state_id']);

        }

        if (isset($filter_data['year']) && $filter_data['year'] != 0) {

            $this->db->where("tm.year", $filter_data['year']);

        }

        if (isset($filter_data['month']) && $filter_data['month'] != 0) {

            $this->db->where("tm.month", $filter_data['month']);

        }

        if (isset($filter_data['client_id']) && !in_array(0, $filter_data['client_id'])) {

            $client_id = implode(",", $filter_data['client_id']);

            $this->db->where("tm.client_id in ($client_id)");

        }



        if (isset($filter_data['skill_dev_activity']) && $filter_data['skill_dev_activity'] != -1) {

            $this->db->where("tm.skill_dev_activity", $filter_data['skill_dev_activity']);

        }



        if (isset($filter_data['task_period_id']) && $filter_data['task_period_id'] != '') {

            $this->db->where("tm.task_period_id", $filter_data['task_period_id']);

        }

       /* if (isset($filter_data['billedUnbilled']) && $filter_data['billedUnbilled'] != '') {

            $this->db->where("tm.status", $filter_data['billedUnbilled']);

        }*/
        if(isset($filter_data['attachment']) && $filter_data['attachment']=='with_attach'){ 
                $this->db->where("af.file_name !=",'NULL'); 
        } 
        

         



        if (isset($filter_data['BillingDone']) && $filter_data['BillingDone'] == 1) {

            $this->db->where(array("tm.BillingDone" => STATUS_TRUE));

        } else if (isset($filter_data['BillingDone']) && $filter_data['BillingDone'] == 0) {

            $this->db->where(array("tm.BillingDone" => STATUS_FALSE));

        }



        if (isset($filter_data['progress_flag']) && $filter_data['progress_flag'] != 0 && $filter_data['date_wise'] != 5 && $filter_data['date_wise'] != 4) {

            $this->db->where("tm.progress_flag", $filter_data['progress_flag']);

        }







        if (isset($filter_data['date_wise']) && $filter_data['date_wise']) {

            if ($filter_data['date_wise'] == 1) {

                //str date wise 

                if (isset($filter_data['start_date'])) {

                    $this->db->where("tm.start_date>='" . date(DB_DF, strtotime($filter_data['start_date'])) . "'", NULL, FALSE);

                }

                if (isset($filter_data['start_date'])) {

                    $this->db->where("tm.start_date<='" . date(DB_DF, strtotime($filter_data['end_date'])) . "'", NULL, FALSE);

                }

            } else if ($filter_data['date_wise'] == 2) {

                // end date wise



                if (isset($filter_data['start_date'])) {

                    $this->db->where("tm.end_date>='" . date(DB_DF, strtotime($filter_data['start_date'])) . "'", NULL, FALSE);

                }

                if (isset($filter_data['end_date'])) {

                    $this->db->where("tm.end_date<='" . date(DB_DF, strtotime($filter_data['end_date'])) . "'", NULL, FALSE);

                }

            } else if ($filter_data['date_wise'] == 3) {

                // end date wise



                if (isset($filter_data['start_date'])) {

                    $this->db->where("tm.Mode_DateTime>='" . date(DB_DF, strtotime($filter_data['start_date'])) . "'", NULL, FALSE);
                }
                if (isset($filter_data['end_date'])) {
                    $this->db->where("tm.Mode_DateTime<='" . date(DB_DF, strtotime($filter_data['end_date'])) . "'", NULL, FALSE);
                }

            } else if ($filter_data['date_wise'] == 4) {

                // end date wise



                if (isset($filter_data['start_date'])) {

                    $this->db->where("tm.Add_DateTime>='" . date(DB_DF, strtotime($filter_data['start_date'])) . "'", NULL, FALSE);

                }

                if (isset($filter_data['end_date'])) {

                    $this->db->where("tm.Add_DateTime<='" . date(DB_DF, strtotime($filter_data['end_date'])) . "'", NULL, FALSE);

                }

            } else if ($filter_data['date_wise'] == 5) { 


                if (isset($filter_data['start_date'])) {

                    $this->db->where("tm.Close_DateTime>='" . date(DB_DF, strtotime($filter_data['start_date'])) . "'", NULL, FALSE);

                }

                if (isset($filter_data['end_date'])) {

                    $this->db->where("tm.Close_DateTime<='" . date(DB_DF, strtotime($filter_data['end_date'])) . "'", NULL, FALSE);

                }

                $this->db->where("tm.progress_flag", COMPLETED_APPROVAL);
            }
        }
        if (isset($filter_data['does_repeat']) && $filter_data['does_repeat'] != 2) {
            $this->db->where("tm.does_repeat", $filter_data['does_repeat']);
            if (isset($filter_data['notify_before_days'])) {
                $this->db->where("DATE_ADD(tm.start_date,INTERVAL tm.repeat_unit-" . $filter_data['notify_before_days'] . " day)<now()", NULL, FALSE);
            }
        }

        if (isset($filter_data['ttm_id']) && !in_array(0, $filter_data['ttm_id'])) {
            $ttm_id = implode(",", $filter_data['ttm_id']);
            $this->db->where("(ttm.ttm_id in ($ttm_id) or ttm.ttm_id in (select tt.ttm_id from " . DB_PREFIX . "task_type_mst tt where tt.parent_ttmid in ($ttm_id)))", NULL, FALSE);
        }
        if (isset($filter_data['tm_id']) && $filter_data['tm_id'] != 0) {
            $this->db->where("tm.tm_id =" . $filter_data['tm_id'], NULL, FALSE);
        }
        if (isset($filter_data['tm_name']) && $filter_data['tm_name'] != "") {
            $this->db->where("tm.tm_name like '%" . $filter_data['tm_name'] . "%'", NULL, FALSE);
        }
        if (isset($filter_data['tm_code']) && $filter_data['tm_code'] != "") {
            $this->db->where("tm.tm_code like '%" . $filter_data['tm_code'] . "%'", NULL, FALSE);
        }
        if (isset($filter_data['extra_where'])) {
            $this->db->where($filter_data['extra_where'], NULL, FALSE);
        }
        if (isset($filter_data['OrderCol'])) {
            $this->db->order_by($filter_data['OrderCol'], $filter_data['OrderAscDsc']);
        } else {
            $this->db->order_by("tm.Mode_DateTime", "DESC");
        }
        if (isset($filter_data['limit'])) {
            $this->db->limit($filter_data['limit'], $filter_data['page']);
        }
        if (isset($filter_data['user_id']) && !in_array(0, $filter_data['user_id'])) {
            $user_id = implode(",", $filter_data['user_id']);
            $this->db->where("tu.user_id in ($user_id)");
        } else {
            if (!in_array($this->util_model->get_utype(), array(DIRECTOR, PARTNER))) {
                $this->db->where("tu.user_id =" . $this->util_model->get_uid(), NULL, FALSE);
            }
        }

        $billing_from_sub_query = "";
        $billing_from_sub_query = "(SELECT (SELECT tbacc.account_title FROM " . DB_PREFIX . "task_bill_account tbacc WHERE tbacc.bill_account_id = tbm.bill_account_id) FROM " . DB_PREFIX . "task_billing_mst tbm WHERE tbm.bill_mst_id = (select bill_mst_id from nexgen_task_billnos bn where bn.tm_id=tm.tm_id and bn.status=1 limit 1) and tbm.status=1) as billedFrom";

        $this->db->select("tbacc.account_title as billedFrom,bmst.bill_amt,bmst.bill_no,bmst.bill_mst_id,af.file_name,tm.client_id,tm.year,tm.month,tm.state_id,tm.close_task_note,tm.tm_code,ttm_name,tm.BillingDone,tm.start_date,tm.end_date,"

                . "emp2.Emp_Name as Incharge_name,emp1.Emp_Name as client_name,emp1.gst_no,emp1.po_no,"
                . "tm.extra_note,tm.tm_name,tm.tm_id,tm.skill_dev_activity,tm.progress_flag,tm.Mode_DateTime,"
                . "(select count(DISTINCT(tstm_id)) from nexgen_task_sub_task where tm_id = tm.tm_id) as total_sub_task ", NULL, FALSE)->from(DB_PREFIX . "task_mst as tm");
        $this->db->join(DB_PREFIX . "task_type_mst as ttm", "ttm.ttm_id = tm.ttm_id and ttm.status=1", 'left');
        $this->db->join(DB_PREFIX . "employee as emp1", "emp1.Emp_ID=tm.client_id", 'left');
        $this->db->join(DB_PREFIX . "task_users as tu", "tu.tm_id=tm.tm_id and tu.user_type = " . INCHARGE . " and tu.status=" . STATUS_TRUE, 'left');
        $this->db->join(DB_PREFIX . "employee as emp2", "emp2.Emp_ID=tu.user_id", 'left');
        $this->db->join(DB_PREFIX . "task_billing_mst as bmst", "bmst.bill_mst_id=(select bill_mst_id from nexgen_task_billnos bn where bn.tm_id=tm.tm_id and bn.status=1 limit 1)", 'left');
        $this->db->join(DB_PREFIX . "task_bill_account as tbacc ", "tbacc.bill_account_id=bmst.bill_account_id", 'left');

        $this->db->join(DB_PREFIX . "attach_file as af","af.tm_id=tm.tm_id",'left');

//         $this->db->join(DB_PREFIX . "task_billing_mst as bmst", "tm.tm_id=bmst.tm_id", 'left');

        if (isset($filter_data['no_of_subTask']) && $filter_data['no_of_subTask'] != '-1') {
            $this->db->where('(select count(*) from ' . DB_PREFIX . 'task_sub_task sst where sst.tm_id=tm.tm_id and sst.progress_flag<>' . COMPLETED_APPROVAL . ') = ' . $filter_data['no_of_subTask']);
        }
        if (isset($filter_data['billing_acc_id']) && $filter_data['billing_acc_id'] != 0) {
            $this->db->where("(SELECT count(*) FROM " . DB_PREFIX . "task_billnos tskb WHERE tskb.bill_mst_id in (SELECT tbl2.bill_mst_id FROM nexgen_task_billing_mst tbl2 WHERE tbl2.bill_account_id = {$filter_data['billing_acc_id']}) and tskb.tm_id = tm.tm_id)", NULL, FALSE);
//            $this->db->where("(select count(*) from " . DB_PREFIX . "task_billing_mst tbm1 where tbm1.tm_id=tm.tm_id and tbm1.bill_account_id={$filter_data['billing_acc_id']})");
        }

        $this->db->group_by('client_name'); 
        //$this->db->order_by("tm.tm_id", 'ASC'); 
        if (isset($filter_data['end_limit']) & isset($filter_data['start_limit'])) {
            $this->db->limit($filter_data['end_limit'], $filter_data['start_limit']);
        }
        $this->db->where("tm.status", STATUS_TRUE);
//        $result = $this->db->get()->result_array();

        $sql = str_replace('`', "", $this->db->return_query());
        $result = $this->db->query($sql); //->result_array();
//        $this->util_model->printr($result->result_array());
//        echo $this->db->last_query();
//        die();
        //print_r($this->db->last_query());
        $result = $result->result_array();

//        $this->util_model->printr($result);
//        echo $this->db->last_query();
//        die();
        if (!empty($result)) {
            $final_data = array();
            foreach ($result as $val) {
                $val['sub_task_data'] = $this->get_my_tasks_sub_task($val['tm_id']);
                $final_data[] = $val;
            }
            return $final_data;
        }
        return array();
    }

    public function count_my_task($filter_data = array()) {
        $this->db->select("count(tm.tm_id) as count")->from("nexgen_task_mst as tm");
        $this->db->join("nexgen_task_users as tu", "tu.tm_id=tm.tm_id and tu.status=1 and tu.user_type=1", 'left');
        $this->db->where("tu.user_type = 1 and tu.status = 1", NULL, FALSE);
        if (!in_array($this->util_model->get_utype(), array(DIRECTOR, PARTNER))) {
            $this->db->where("tu.user_id = " . $this->util_model->get_uid());
        }
        if (isset($filter_data['completed'])) {
            $this->db->where("tm.BillingDone = " . STATUS_FALSE . " and tm.progress_flag =" . COMPLETED_REQUEST, NULL, FALSE);
        } else {
            $this->db->where("tm.progress_flag =" . IN_PROGRESS, NULL, FALSE);
        }
        $res = $this->db->get()->row_array();
        return $res['count'];
    }

    public function get_my_tasks_sub_task($tm_id) {
//        die('coming');
        $this->db->reset_obj();
        $this->db->select("tst.tstm_id,(SELECT sum(tstm_comment.efforts) FROM nexgen_task_sub_task_comments tstm_comment WHERE tstm_comment.tstm_id = tst.tstm_id) as total_efforts,  tst.tstm_name,tst.str_date_time,tst.end_date_time,tst.tstm_efforts,tst.tstm_id,tst.progress_flag,emp.Emp_Name")->from(DB_PREFIX . "task_mst as tm");
        $this->db->join(DB_PREFIX . "task_sub_task as tst", "tst.tm_id=tm.tm_id", 'left');
        $this->db->join(DB_PREFIX . "employee as emp", "emp.Emp_ID=tst.assignedto", 'left');
        $this->db->where("tm.tm_id=" . $tm_id . " and tm.status =" . STATUS_TRUE, NULL, FALSE);
//        $sql = $this->
//        $result = $this->db->query();
//        $this->util_model->printr($result);
        return $this->db->get()->result_array();
//        echo $this->db->last_query();
//        die('here');
    }

    public function reopen_task($filter_data) {
        $this->db->query("UPDATE nexgen_task_sub_task as tst,nexgen_task_mst as tm SET tm.progress_flag=" . IN_PROGRESS . ",tst.progress_flag=" . IN_PROGRESS . ""
                . " WHERE "
                . $this->util_model->get_uid() . " in(select Emp_ID from nexgen_employee as emp where emp.UTID in(" . DIRECTOR . "," . PARTNER . ") )"
                . "and tst.tm_id = {$filter_data['task_id']} and tm.tm_id = {$filter_data['task_id']}");
        if ($this->db->affected_rows() > 0) {
            return array("succ" => TRUE, "_err_codes" => "Task Re-Opened Successfully!!");
        } else {
            return array("succ" => FALSE, "_err_codes" => "Error Occured!!, Refresh Your page!!");
        }
    }

    public function reopen_sub_task($filter_data) {
        $this->db->query("UPDATE nexgen_task_sub_task as tst,nexgen_task_mst as tm SET tm.progress_flag=" . IN_PROGRESS . ",tst.progress_flag=" . IN_PROGRESS . ""
                . " WHERE "
                . $this->util_model->get_uid() . " in(select Emp_ID from nexgen_employee as emp where emp.UTID in(" . DIRECTOR . "," . PARTNER . ") )"
                . "and tst.tstm_id = {$filter_data['sub_task_id']} and tm.tm_id = {$filter_data['task_id']}");
        if ($this->db->affected_rows() > 0) {
            return array("succ" => TRUE, "_err_codes" => "Sub Task Re-Opened Successfully!!");
        } else {
            return array("succ" => FALSE, "_err_codes" => "Error Occured!!, Refresh Your page!!");
        }
    }

    /*

     * request to close task
     * name has been given by deepak, so I 
     * haven't changed ..      */

    public function close_task($filter_data) {
//        $this->util_model->printr($filter_data);
//        die();
        $result = $this->db->query("UPDATE nexgen_task_sub_task as tst,nexgen_task_mst as tm SET tm.close_task_note = '{$filter_data['extra_note']}', tm.progress_flag=" . COMPLETED_REQUEST . ",tst.progress_flag=" . COMPLETED_REQUEST . ""
                . " WHERE ((select user_id from nexgen_task_users where tm_id = {$filter_data['task_id']} and user_type = " . INCHARGE . "  and status = " . STATUS_TRUE . ") = " . $this->util_model->get_uid() . " "
                . " or " . $this->util_model->get_utype() . " in(" . DIRECTOR . "," . PARTNER . "))"
                . "and tst.tm_id = {$filter_data['task_id']} and tm.tm_id = {$filter_data['task_id']}");

        return array("succ" => $result, "_err_codes" => "Task Clsoe request send Successfully!!");
    }

    /*

     * it iwll final completed this
     * only director or patner can do this     /
     */

    public function final_complete_task($filter_data) {
        if (in_array($this->util_model->get_utype(), array(DIRECTOR, PARTNER))) {
            $result = $this->db->query("UPDATE nexgen_task_sub_task as tst,nexgen_task_mst as tm SET tm.progress_flag=" . COMPLETED_APPROVAL . ",tst.progress_flag=" . COMPLETED_APPROVAL . ""
                    . " WHERE 1 and tst.tm_id = {$filter_data['task_id']} and tm.tm_id = {$filter_data['task_id']}");

            return array("succ" => $result, "_err_codes" => "Task Closed & completed Successfully!!");
        }
    }

    public function close_sub_task($filter_data) {
        $this->db->query("update nexgen_task_sub_task as tst set progress_flag = 3 "
                . "where (tst.assignedto = " . $this->util_model->get_uid() . " or " . $this->util_model->get_utype() . " in (" . DIRECTOR . "," . PARTNER . ")  or " . $this->util_model->get_uid() . " = (select user_id from nexgen_task_users where status = 1 and tm_id = {$filter_data['task_id']} and user_type = " . INCHARGE . ")) and tst.tstm_id = {$filter_data['sub_task_id']} and tst.status = " . STATUS_TRUE);
//                echo $this->db->last_query();
        if ($this->db->affected_rows() > 0) {
            return array("succ" => TRUE, "_err_codes" => "Sub Task Closed Successfully!!");
        } else {
            return array("succ" => FALSE, "_err_codes" => "Sorry, you don't have access or it has already closed !!");
        }
    }

    public function del_sub_task($filter_data) {
        if (is_array($filter_data['tstm_id'])) {
            $this->db->where_in('tstm_id', $filter_data['tstm_id']);
        } else {
            $this->db->where('tstm_id', $filter_data['tstm_id']);
        }

        $result = $this->db->delete(DB_PREFIX . "task_sub_task");

        if ($result) {
            return array("succ" => TRUE, "_err_codes" => "Sub Task deleted Successfully!!");
        } else {
            return array("succ" => FALSE, "_err_codes" => "Sorry, you don't have access !!");
        }
    }

    public function fetch_data_for_reassign_sub_task($filter_data) {
        $this->db->select("tst.tstm_name, tst.tstm_id, emp.Username, emp.Emp_ID")->from(DB_PREFIX . "task_sub_task as tst");
        $this->db->join(DB_PREFIX . "employee as emp", "emp.Emp_ID = tst.assignedto", 'left');
        if (isset($filter_data['sub_task_id']) && $filter_data['sub_task_id'] != '') {
            $this->db->where("tst.tstm_id = " . $filter_data['sub_task_id'] . " and tst.status = " . STATUS_TRUE, NULL, FALSE);
        } else {
            $this->db->where("tst.status = " . STATUS_TRUE, NULL, FALSE);
        }
        $result = $this->db->get()->row_array();
//        echo $this->db->last_query();
        if (!empty($result)) {
            $final_data['free_users'] = $this->fetch_users();
            $final_data['sub_task_info'] = $result;
            return array("succ" => TRUE, "data" => $final_data);
        } else {
            return array("succ" => FALSE, "_err_codes" => "Invalid Sub Task Id Passed");
        }
    }

    public function fetch_users($filter = array()) {
        $limit = 0;
        $date = " CONCAT(CURDATE(),' 00:00:00') ";
        if (isset($filter['limit']) && $filter['limit'] != '')
            $limit = $filter['limit'];
        if (isset($filter['date']) && $filter['date'] != '') {
            $d = date("Y-m-d", strtotime($filter['date']));
            $date = " CAST('$d' AS DATE) ";
        }

        $this->db->query("SET time_zone='+05:30'");
        $query = $this->db->query("SELECT e.Emp_ID, e.Emp_Name,ut.UserTypeName,"
                . "(SELECT " . PER_DAY_HOURS . "-SUM(ROUND((tstm_efforts/(ROUND(HOUR(TIMEDIFF(str_date_time , end_date_time))/24,2))),2)) as hours "
                . "FROM nexgen_task_sub_task WHERE assignedto = e.Emp_ID and $date between str_date_time and end_date_time) as free_hours"
                . " FROM (nexgen_employee as e) LEFT JOIN nexgen_usertypes as ut ON ut.UTID = e.UTID WHERE ut.UserTypeGroup <> " . CLIENT_GROUP . " "
                . "and e.UTID in (select UTID from nexgen_usertypes where level >= (select level from nexgen_usertypes where UTID = " . $this->util_model->get_utype() . ")) and e.status=1 ORDER BY e.Emp_Name ASC limit {$limit} , 100");
        $list = $query->result_array();

        // echo $this->db->last_query();
//        
//        echo "<pre>";
//        print_r($list);
        return $list;


//        $UTID = $this->util_model->get_utype();
//        $this->db->select("e.Emp_ID, e.Emp_Name")->from(DB_PREFIX . "employee as e");
//        $this->db->join(DB_PREFIX . "usertypes as ut", "ut.UTID = e.UTID", 'left');
//        $this->db->where("ut.UserTypeGroup <> " . CLIENT_GROUP . " and e.UTID in (select UTID from nexgen_usertypes where level > (select level from nexgen_usertypes where UTID = {$UTID}))", NULL, FALSE);
//        $this->db->order_by("e.Emp_Name", 'ASC');
//        return $this->db->get()->result_array();
    }

    public function free_hours($filter = array()) {
        $limit = 0;
        $date = " CONCAT(CURDATE(),' 00:00:00') ";
        if (isset($filter['limit']) && $filter['limit'] != '')
            $limit = $filter['limit'];
        if (isset($filter['date']) && $filter['date'] != '') {
            $d = date("Y-m-d", strtotime($filter['date']));
            $date = " CAST('$d' AS DATE) ";
        }


        $this->db->query("SET time_zone='+05:30'");
        $sub_query = "(SELECT sum(efforts) from nexgen_task_sub_task_comments where Add_User = e.Emp_ID and DATE(work_datetime) = $date ) as workHour,  ";
        $query = $this->db->query("SELECT e.Emp_ID, e.Emp_Name,ut.UserTypeName,$sub_query"
                . "(SELECT " . PER_DAY_HOURS . "-SUM(ROUND((tstm_efforts/(ROUND(HOUR(TIMEDIFF(str_date_time , end_date_time))/24,2))),2)) as hours "
                . "FROM nexgen_task_sub_task WHERE assignedto = e.Emp_ID and $date between str_date_time and end_date_time) as free_hours"
                . " FROM (nexgen_employee as e) LEFT JOIN nexgen_usertypes as ut ON ut.UTID = e.UTID WHERE ut.UserTypeGroup <> " . CLIENT_GROUP . " "
                . "and e.Status=1 and e.UTID in (select UTID from nexgen_usertypes where level >= (select level from nexgen_usertypes where UTID = " . $this->util_model->get_utype() . ")) ORDER BY e.Emp_Name ASC limit {$limit} , 100");
        $list = $query->result_array();

        // echo $this->db->last_query();
        return $list;


//        $UTID = $this->util_model->get_utype();
//        $this->db->select("e.Emp_ID, e.Emp_Name")->from(DB_PREFIX . "employee as e");
//        $this->db->join(DB_PREFIX . "usertypes as ut", "ut.UTID = e.UTID", 'left');
//        $this->db->where("ut.UserTypeGroup <> " . CLIENT_GROUP . " and e.UTID in (select UTID from nexgen_usertypes where level > (select level from nexgen_usertypes where UTID = {$UTID}))", NULL, FALSE);
//        $this->db->order_by("e.Emp_Name", 'ASC');
//        return $this->db->get()->result_array();
    }

    public function validate_reassigned_data($filter_data) {
        $err_codes = array();
        if ($filter_data['tstm_id'] == "") {
            $err_codes[] = "Task Id Seems to be Invalid!!";
        }
        if ($filter_data['new_assignedto'] == "" || $filter_data['new_assignedto'] == 0) {
            $err_codes[] = "Please Select atleast One User";
        }
        if (empty($err_codes)) {
            return array("succ" => TRUE, "_err_codes" => $err_codes);
        } else {
            return array("succ" => FALSE, "_err_codes" => $err_codes);
        }
    }

    public function del_task($filter_data) {
        if (!in_array($this->util_model->get_utype(), array(DIRECTOR, PARTNER))) {
            return array("succ" => FALSE, "_err_codes" => "You are Not Authorize to perform this task!!");
        } else {
            $this->db->trans_begin();

            $this->db->query("SET FOREIGN_KEY_CHECKS=0");

            $this->db->query("INSERT INTO nexgen_task_logs (log_type, modifier_id, modified_datetime, remarks) VALUES "
                    . "(4," . $this->util_model->get_uid() . ",now(),(select CONCAT('A task with task name ' ,tm_name, 'has been deleted by user " . $this->util_model->get_uname() . "')"
                    . " from nexgen_task_mst where tm_id = {$filter_data['task_id']}))");


            $this->db->query("Delete from " . DB_PREFIX . "task_attachments where table_id in "
                    . "(select comment_id from " . DB_PREFIX . "task_sub_task_comments where tstm_id in "
                    . "(select tstm_id from " . DB_PREFIX . "task_sub_task where tm_id = {$filter_data['task_id']}))");

            $this->db->where(array("tm_id" => $filter_data['task_id']));
            $this->db->delete(DB_PREFIX . "task_doc_req");

            $this->db->query("Delete from " . DB_PREFIX . "task_sub_task_comments where tstm_id in "
                    . "(select tstm_id from " . DB_PREFIX . "task_sub_task where tm_id = {$filter_data['task_id']})");

            $this->db->where(array("tm_id" => $filter_data['task_id']));
            $this->db->delete(DB_PREFIX . "task_sub_task");

            $this->db->where(array("tm_id" => $filter_data['task_id']));
            $this->db->delete(DB_PREFIX . "task_users");

            $this->db->where(array("tm_id" => $filter_data['task_id']));
            $this->db->delete(DB_PREFIX . "task_mst");

            $this->db->query("SET FOREIGN_KEY_CHECKS=1");

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return array("succ" => FALSE, "_err_codes" => array("Error in deleting Task!!"));
            } else {
                $this->db->trans_commit();
                return array("succ" => TRUE, "_err_codes" => array("Task Deleted Successfully!!"));
            }
        }
    }

    public function reassign_sub_task($filter_data) {
        $validate = $this->validate_reassigned_data($filter_data);
        if (!empty($validate['_err_codes'])) {
            return array("succ" => FALSE, "_err_codes" => $validate['_err_codes']);
        }
        if (isset($filter_data['form_type']) && $filter_data['form_type'] == 'reassign') {
            $this->db->where("tst.tstm_id in ({$filter_data['tstm_id']})");
            $this->db->where("tst.status", STATUS_TRUE);
        } else if (isset($filter_data['form_type']) && $filter_data['form_type'] == 're-schedule') {
            $this->db->where("tst.tstm_id in ({$filter_data['tstm_id']})");

            $this->db->where("tst.status", STATUS_TRUE);
        } else {
            $this->db->where(array("tst.tstm_id" => $filter_data['tstm_id'], "tst.status" => STATUS_TRUE));
        }
        if (isset($filter_data['form_type']) && $filter_data['form_type'] == 're-schedule') {
            if ($this->db->update(DB_PREFIX . "task_sub_task as tst", array("tst.str_date_time" => date(DB_DTF, strtotime($filter_data['start_date'])), "tst.end_date_time" => date(DB_DTF, strtotime($filter_data['start_date']))))) {
                return array("succ" => TRUE, "_err_codes" => "Sub Task Reassigned Successfully!!");
            } else {
                return array("succ" => FALSE, "_err_codes" => "Error Occured!!, Refresh Your page!!");
            }
        } else {
            if ($this->db->update(DB_PREFIX . "task_sub_task as tst", array("assignedto" => $filter_data['new_assignedto']))) {
                return array("succ" => TRUE, "_err_codes" => "Sub Task Reassigned Successfully!!");
            } else {
                return array("succ" => FALSE, "_err_codes" => "Error Occured!!, Refresh Your page!!");
            }
        }
    }

    public function reassign_task($filter_data) {

        //$validate = $this->validate_reassigned_data($filter_data);

       /* if (!empty($validate['_err_codes'])) {

            return array("succ" => FALSE, "_err_codes" => $validate['_err_codes']);

        } */

        if (isset($filter_data['form_type']) && $filter_data['form_type'] == 're-schedule') {

            $this->db->where("tm.tm_id in ({$filter_data['tm_id']})"); 
            $this->db->where("tm.status", STATUS_TRUE);

        } else {

            $this->db->where(array("tm.tm_id" => $filter_data['tm_id'], "tm.status" => STATUS_TRUE));

        }

        if (isset($filter_data['form_type']) && $filter_data['form_type'] == 're-schedule') {

            if ($this->db->update(DB_PREFIX . "task_mst as tm", array("tm.start_date" => date(DB_DTF, strtotime($filter_data['start_date'])), "tm.end_date" => date(DB_DTF, strtotime($filter_data['end_date']))))) {
 
                return array("succ" => TRUE, "_err_codes" => "Task Re-schedule Successfully!!");

            } else {

                return array("succ" => FALSE, "_err_codes" => "Error Occured!!, Refresh Your page!!");

            }

        }  

    }



    public function info_after_reassign_for_mail_data($filter_data) {
        $query = $this->db->query("select (@cnt := @cnt + 1) AS S_no, tm.tm_name, emp.UserName, tst.tstm_name, CONCAT(tstm_efforts, ' Hours') as efforts, now() as work_date,tst.str_date_time,tst.end_date_time
from nexgen_task_sub_task as tst CROSS JOIN (SELECT @cnt := 0) as dummy
left join nexgen_task_mst as tm on tst.tm_id = tm.tm_id
left join nexgen_task_users as tu on tu.tm_id = tm.tm_id and tu.user_type = " . INCHARGE . " and tu.status = " . STATUS_TRUE . "
left join nexgen_employee as emp on tu.user_id = emp.Emp_ID
where tm.tm_id = (select tm_id from nexgen_task_sub_task where tstm_id = {$filter_data['tstm_id']}) and tst.tstm_id = {$filter_data['tstm_id']}");
        return $query;
    }

    public function send_new_task_create_mail($filter_data, $task_id) {
        $data['my_tasks'] = $this->get_my_tasks(array("tm_id" => $task_id));
        $this->load->model("tms/mail/mailer", 'mailer');
        $table_data_html = $this->load->view("tms/manage_tasks/table_for_mail", $data, TRUE);
        $mailData = array();
        foreach ($filter_data as $value) {
            $mailData['to'][] = $value['P_Email'];
        }
        $mailData['from'] = NOTIFY_EMAIL;
        $mailData['subject'] = "New Task has been Created!!";
        $formdata['msg'] = "Dear User, " . "\n\nA new task has been Created by " . $this->util_model->get_uname() . " and you are a part of that task!!"
                . "Below is the detail for the same!!<br><br>" . $table_data_html . " <br><br>\n\n\nThanks NexIBMS Team";
        $formdata['heading'] = "New Task Created!!";
        $mailData['message'] = $this->load->view("tms/mail_template/template", $formdata, TRUE);
        $code_sent = $this->mailer->send_html($mailData);
        return TRUE;
    }

    public function gettaskname($taskid) {
        $this->db->where('tstm_id in (' . $taskid . ')');
        $res = $this->db->select("tstm_name")->from('nexgen_task_sub_task')->get()->result_array();
        return $res;
    }

    public function get_pagination_data() {
        
    }

    /*

     * calling from signle task history     */
    /*

     * it will return task and its sub task only     */

    public function get_single_history($filter_data = "") {


        if (isset($filter_data['tm_id']) && $filter_data['tm_id'] != 0) {
            $this->db->where("tm.tm_id =" . $filter_data['tm_id'], NULL, FALSE);
        }

        $billing_from_sub_query = "";
//        $billing_from_sub_query = "(SELECT (SELECT tbacc.account_title FROM " . DB_PREFIX . "task_bill_account tbacc WHERE tbacc.bill_account_id = tbm.bill_account_id) FROM " . DB_PREFIX . "task_billing_mst tbm WHERE tbm.bill_mst_id = (select bill_mst_id from nexgen_task_billnos bn where bn.tm_id=tm.tm_id and bn.status=1 limit 1) and tbm.status=1) as billedFrom";
        $this->db->select("tbacc.account_title as billedFrom,bmst.bill_amt,bmst.bill_no,bmst.bill_mst_id,tm.close_task_note,tm.tm_code,ttm_name,tm.BillingDone,tm.start_date,tm.end_date,"
                . "emp2.Emp_Name as Incharge_name,emp1.Emp_ID as client_id,emp1.Emp_Name as client_name,emp1.P_Mob as client_mobile,emp1.P_Email as client_email,"
                . "tm.extra_note,tm.tm_name,tm.tm_id,tm.skill_dev_activity,tm.progress_flag,date(tm.Mode_DateTime) as Mode_DateTime,"
                . "(select count(DISTINCT(tstm_id)) from nexgen_task_sub_task where tm_id = tm.tm_id) as total_sub_task ", NULL, FALSE)->from(DB_PREFIX . "task_mst as tm");
        $this->db->join(DB_PREFIX . "task_type_mst as ttm", "ttm.ttm_id = tm.ttm_id and ttm.status=1", 'left');
        $this->db->join(DB_PREFIX . "employee as emp1", "emp1.Emp_ID=tm.client_id", 'left');
        $this->db->join(DB_PREFIX . "task_users as tu", "tu.tm_id=tm.tm_id and tu.user_type = " . INCHARGE . " and tu.status=" . STATUS_TRUE, 'left');
        $this->db->join(DB_PREFIX . "employee as emp2", "emp2.Emp_ID=tu.user_id", 'left');

        $this->db->join(DB_PREFIX . "task_billing_mst as bmst", "bmst.bill_mst_id=(select bill_mst_id from nexgen_task_billnos bn where bn.tm_id=tm.tm_id and bn.status=1 limit 1)", 'left');
        $this->db->join(DB_PREFIX . "task_bill_account as tbacc ", "tbacc.bill_account_id=bmst.bill_account_id", 'left');
        if (isset($filter_data['billing_acc_id']) && $filter_data['billing_acc_id'] != 0) {
            $this->db->where("(select count(*) from " . DB_PREFIX . "task_billing_mst tbm1 where tbm1.tm_id=tm.tm_id and tbm1.bill_account_id={$filter_data['billing_acc_id']})");
        }


        $this->db->order_by("tm.tm_id", 'ASC');
        if (isset($filter_data['end_limit']) & isset($filter_data['start_limit'])) {
            $this->db->limit($filter_data['end_limit'], $filter_data['start_limit']);
        }
        $this->db->where("tm.status", STATUS_TRUE);
        $sql = str_replace('`', "", $this->db->return_query());
        $result = $this->db->query($sql);
        $result = $result->result_array();
//        $this->util_model->printr($result);
        if (!empty($result)) {
            // $totalgivetime = 0;
            // $totalspendtime = 0;
            $final_data = array();
            foreach ($result as $val) {
//                $this->util_model->printr($val);
                $val['progress_flag_name'] = $this->util_model->get_progress_flag_string($val['progress_flag']);
                $val['sub_task_data'] = $this->get_my_tasks_sub_task($val['tm_id']);
                $all_tst_ids = array();
                foreach ($val['sub_task_data'] as $index => $eachSubTask) {
                    $val['sub_task_data'][$index]['progress_sub_task'] = $this->util_model->get_progress_flag_string($eachSubTask['progress_flag']);
                    // $val['sub_task_data'][$index]['total_spend_time'] =$totalspendtime+$eachSubTask['tstm_efforts'] ;
                    $val['sub_task_data'][$index]['comments'] = $this->getSubTaskComments(array("tstm_id" => $eachSubTask['tstm_id']));
                    $all_tst_ids[] = $eachSubTask['tstm_id'];
                }

                $val['attached_files'] = $this->get_attached_task_files($all_tst_ids);
                $val['attached_files'] = array_merge($val['attached_files'], $this->get_task_files($val['tm_id']));
                $val['notify_to'] = $this->getNotifyTo($val['client_id']);
                $val['notify_to'][] = array('client_id' => $val['client_id'], 'emails' => $val['client_email'], 'mobiles' => $val['client_mobile']);
                $final_data[] = $val;
            }
            return $final_data;
        }
        return array();
    }

    function getNotifyTo($client_id) {
        $this->db->select('client_id,emails,mobiles')->from(DB_PREFIX . 'client_notification_level')->where(array('client_id' => $client_id, 'status' => 1));
        return $this->db->get()->result_array();
    }

    public function get_attached_task_files($all_tst_ids) {
        $query = $this->db->query("SELECT table_id,ta.attach_original_name as attach_name, REPLACE(ta.link, ' ', ' ') as link, DATE_FORMAT(ta.Add_DateTime, '%b %d %Y %h:%i %p') as date FROM (" . DB_PREFIX . "task_attachments as ta) WHERE ta.attach_type=" . COMMENT_ATT_TYPE . " and ta.table_id in (select comment_id from " . DB_PREFIX . "task_sub_task_comments where tstm_id in (" . implode(',', $all_tst_ids) . ")  and approved=" . STATUS_TRUE . ")");

        return $query->result_array();
    }

    public function get_task_files($tm_id) {
//        echo "SELECT table_id,ta.attach_original_name as attach_name, REPLACE(ta.link, ' ', ' ') as link, DATE_FORMAT(ta.Add_DateTime, '%b %d %Y %h:%i %p') as date FROM (" . DB_PREFIX . "task_attachments as ta) WHERE ta.attach_type=" . TASK_ATT_TYPE . " and ta.table_id = $tm_id and approved=" . STATUS_TRUE;
        $query = $this->db->query("SELECT table_id,ta.attach_original_name as attach_name, REPLACE(ta.link, ' ', ' ') as link, DATE_FORMAT(ta.Add_DateTime, '%b %d %Y %h:%i %p') as date FROM (" . DB_PREFIX . "task_attachments as ta) WHERE ta.attach_type=" . TASK_ATT_TYPE . " and ta.table_id = $tm_id");
        return $query->result_array();
    }

    public function getSubTaskComments($filter_data = array()) {
        if (isset($filter_data['tstm_id']) && $filter_data['tstm_id'] != "") {
            $this->db->where("tstm_comment.tstm_id", $filter_data['tstm_id']);
        }
        $this->db->select("tstm_comment.*,emp.Emp_Name")->from(DB_PREFIX . "task_sub_task_comments as tstm_comment");
//        $this->db->join(DB_PREFIX . "task_sub_task as tst", "tst.tm_id=tm.tm_id", 'left');
        $this->db->join(DB_PREFIX . "employee as emp", "emp.Emp_ID=tstm_comment.Add_User", 'left');
        $this->db->where("tstm_comment.status =" . STATUS_TRUE, NULL, FALSE);
        return $this->db->get()->result_array();
    }

    //$tm_id is array
    public function get_tasks_to_list($tm_id) {
        $this->db->select('tm.tm_id,tm.tm_name,client.Emp_Name as client_name')->from(DB_PREFIX . 'task_mst tm');
        $this->db->join(DB_PREFIX . "employee client ", 'client.Emp_ID=tm.client_id', 'left');
        $this->db->where_in('tm.tm_id', $tm_id);
        return $this->db->get()->result_array();
    }

    public function get_single_task($tm_id) {
        return $this->db->get_where(DB_PREFIX . "task_mst", array('tm_id' => $tm_id))->row_array();
    }

    public function get_sub_task($tm_id) {
        return $this->db->get_where(DB_PREFIX . "task_sub_task", array('tm_id' => $tm_id))->result_array();
    }

    public function get_task_document($tm_id) {
        return $this->db->get_where(DB_PREFIX . "task_doc_req", array('tm_id' => $tm_id))->result_array();
    }

    public function get_incarhge_id($tm_id) {
        $res = $this->db->get_where(DB_PREFIX . "task_users", array('tm_id' => $tm_id, 'user_type' => INCHARGE))->row_array();
        if (!empty($res)) {
            return $res['user_id'];
        }
    }

    public function replicate_single_task($form_data) {
        try {
            $tm_id = $form_data['tm_id'];
            $this->db->trans_begin();

            //get old task details to create array
            $task_details = $this->get_single_task($tm_id);
            if (empty($task_details)) {
                throw new Exception('Invalid Task ID');
            }



            $date1 = new DateTime(date(DB_DF, strtotime($task_details['start_date'])));
            $date2 = new DateTime(date(DB_DF, strtotime($form_data['start_date'])));

            $days_diff = $date2->diff($date1)->format("%a");
//$diff = abs(strtotime($form_data['start_date']) - strtotime($task_details['start_date']));
//$years = floor($diff / (365*60*60*24));
//$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
//            $days_diff = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
            // replacing new data
            $catCode = $this->get_task_code(array('taskMCatID' => $task_details['ttm_id']));
            $task_details['tm_code'] = $catCode['code'];

            $task_details['BillingDone'] = 0;
            $task_details['progress_flag'] = IN_PROGRESS;
            $task_details['client_visiblity'] = $form_data['client_visiblity'];
            $task_details['month'] = $form_data['month'];
            $task_details['year'] = $form_data['year'];
            $task_details['start_date'] = date(DB_DF, strtotime($form_data['start_date']));
            $task_details['end_date'] = date(DB_DF, strtotime($form_data['end_date']));
            $task_form_data = $task_details;
            // removing primary key
            unset($task_details['tm_id']);
            $task_details = $this->util_model->add_common_fields($task_details);
            // inserting new create task details
            $this->db->insert(DB_PREFIX . "task_mst", $task_details);
            // new task id
            $tm_id_new = $this->db->insert_id();

            // fetching old sub tasks
            $old_sub_tasks = $this->get_sub_task($tm_id);
            // creating new sub task data according to old sub task data
            $sub_tasks = array();
            foreach ($old_sub_tasks as $eachSubTask) {
                $eachSubTask['tm_id'] = $tm_id_new;
                unset($eachSubTask['tstm_id']);
                $eachSubTask['progress_flag'] = IN_PROGRESS;
                $eachSubTask['str_date_time'] = date(DB_DTF, strtotime("{$eachSubTask['str_date_time']} + $days_diff days"));
                $eachSubTask['end_date_time'] = date(DB_DTF, strtotime("{$eachSubTask['end_date_time']} + $days_diff days"));
                $sub_tasks[] = $this->util_model->add_common_fields($eachSubTask);
            }
            // inserting new sub tasks
            if (!empty($sub_tasks)) {
                $this->db->insert_batch(DB_PREFIX . 'task_sub_task', $sub_tasks);
            }

            // fetching old task docus
            $old_task_docs = $this->get_task_document($tm_id);
            $tasks_docs = array();
            foreach ($old_task_docs as $eachTaskDocs) {
                $eachTaskDocs['tm_id'] = $tm_id_new;
                unset($eachTaskDocs['tmdoc_id']);
                $tasks_docs[] = $this->util_model->add_common_fields($eachTaskDocs);
            }
            if (!empty($tasks_docs)) {
                $this->db->insert_batch(DB_PREFIX . 'task_doc_req', $tasks_docs);
            }


            $pro_users = array();

            $incharge_id = isset($form_data['old_incharge']) ? $this->get_incarhge_id($tm_id) : $form_data['incharge_id'];

            $pro_users[] = $this->util_model->add_common_fields(array("tm_id" => $tm_id_new, "user_type" => INCHARGE, "user_id" => $incharge_id, "status" => STATUS_TRUE, "mail_notification" => STATUS_TRUE));

            $directors = $this->util_model->get_list("Emp_ID", "Emp_ID", DB_PREFIX . "employee", $this->util_model->get_ubid(), 'Emp_Name', TRUE, 1, " UTID=" . DIRECTOR);
            $partners = $this->util_model->get_list("Emp_ID", "Emp_ID", DB_PREFIX . "employee", $this->util_model->get_ubid(), 'Emp_Name', TRUE, 1, " UTID=" . PARTNER);

            foreach ($directors as $d_value) {
                $pro_users[] = $this->util_model->add_common_fields(array("tm_id" => $tm_id_new, "user_type" => DIRECTOR, "user_id" => $d_value, "status" => STATUS_TRUE, "mail_notification" => STATUS_TRUE));
            }
            foreach ($partners as $p_value) {
                $pro_users[] = $this->util_model->add_common_fields(array("tm_id" => $tm_id_new, "user_type" => PARTNER, "user_id" => $p_value, "status" => STATUS_TRUE, "mail_notification" => STATUS_TRUE));
            }

            $this->db->insert_batch(DB_PREFIX . "task_users", $pro_users);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                throw new Exception("Some Error Occured,Try again!!");
            } else {
                $this->db->trans_commit();
                return array('succ' => TRUE, '_err_codes' => $tm_id . ' task replicated successfully with task id <a href="' . base_url('tms/manage_task_logs/index/' . $tm_id_new) . '">' . $tm_id_new . ' click here to view</a>!');
            }
        } catch (Exception $ex) {
            return array('succ' => FALSE, '_err_codes' => $ex->getMessage());
        }
    }

    public function list_month() {

        $month_list = array('0' => 'Select Month');
        for ($m = 1; $m <= 12; $m++) {
            $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
            $month_list[$m] = $month;
        }
        return $month_list;
    }

    public function list_year() {

        $year = array(
            '0' => 'Select Year');



        for ($count = 12; $count > -1; $count--) {

            $year[date('Y', strtotime("-$count year"))] = date('Y', strtotime("-$count year")) . "-" . date('Y', strtotime("-" . ($count - 1) . " year"));
        }
        return $year;
    }

    public function list_state() {
        $this->db->select("cs.*")->from(DB_PREFIX . 'cstates cs');
        $res = $this->db->get()->result_array();

        $state_list = array('0' => 'Select State - NA');
        foreach ($res as $value) {
            $state_list[$value['state_id']] = $value['name'];
        }
        return $state_list;
    }

    public function updatetask($formData) {
        
    }
    
     public function get_tasks_code($tmid,$sid){
        $this->db->where('ttm_id',$tmid);
        $result=  $this->db->get('nexgen_task_type_mst')->row();
        $this->db->where('state_id',$sid);
        $r3=  $this->db->get('nexgen_cstates')->row();
        $array =array('task_code'=>$result->ttm_code,"state_name"=>$r3->name);
        return $array;  
    }
    
    public function fetch_attachment(){
        $this->db->where('status',null);
        $pending=$this->db->count_all_results('nexgen_attach_file');
        $this->db->where('status',1);
        $approove=$this->db->count_all_results('nexgen_attach_file');
        $array=array('pending'=>$pending,'approve'=>$approove);
       // print_r($array);
        return $array;
    }

    public function approveAll($tm_id) {
        if(is_array($tm_id)){
            $this->db->where_in('tm_id', $tm_id);
        }else{
            $this->db->where(array('tm_id' => $tm_id));
        }
        return $this->db->update(DB_PREFIX . "task_mst", array('progress_flag' => COMPLETED_APPROVAL, 'Mode_User' => $this->util_model->get_uid()));
    }



}
