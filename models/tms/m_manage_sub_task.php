<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_manage_sub_task
 * @Created on : 31 May, 2016, 12:25:26 PM
 * @author Deepak Singh
 * @Team NexGen PHP Development Team
 * @copyright (c) year, NexGen Innovators IT Services Pvt. Ltd.
 * @website http://nexgeninnovators.com
 * @location
 * @Use
 * 
 */
class m_manage_sub_task extends CI_Model {

// constructor
    public function __construct() {
// calling to parent constructor
        parent::__construct();
    }

    function add_unassign_form_validation($POST) {
        $err_codes = array();
        if ($POST['progress_flag'] == STATUS_FALSE) {
            $err_codes[] = "Progress Not selected!!";
        }
        if (isset($POST['whom_instruction']) && $POST['whom_instruction'] == STATUS_FALSE) {
            $err_codes[] = "Whom Instruction Field is not selected!!";
        }
        if ($POST['efforts'] != "" && !is_numeric($POST['efforts'])) {
            $err_codes[] = 'Invalid entry Hour Spent filed is empty!!';
        }
        $valid = empty($err_codes) ? TRUE : FALSE;
        return array("_err" => $valid, "_err_codes" => $err_codes);
    }

// start you function from here
    public function dashboard_task_data($filter_data = "") {
        global $data;
        $this->db->select("tst.tstm_id,tst.progress_flag,tst.tstm_name,e.Emp_Name,IFNULL(emp.Emp_Name, '" . mysql_real_escape_string("N/A") . "') as client_name,(select completed from nexgen_task_sub_task_comments where tstm_id=tst.tstm_id and status=1 order by Add_Datetime desc limit 1) as completed,(select end_date from nexgen_task_mst where tm_id=tst.tm_id) as overdue_date", FALSE)->from(DB_PREFIX . "task_sub_task as tst");
        $this->db->join(DB_PREFIX . "employee as e", "tst.assignedto=e.Emp_ID", 'left');
        $this->db->join(DB_PREFIX . "task_mst as tm", "tst.tm_id=tm.tm_id", 'left');
        $this->db->join(DB_PREFIX . "employee as emp", "tm.client_id=emp.Emp_ID", 'left');
//        $this->db->join(DB_PREFIX . "task_sub_task_comments as tstc", "tstc.tstm_id=tst.tstm_id", 'left');
        $this->db->where(array("tst.assignedto" => $data['Session_Data']['IBMS_USER_ID'], "tst.status" => STATUS_TRUE));
        if ($filter_data != "") {
            $this->db->where($filter_data, NULL, FALSE);
        }
        return $this->db->get()->result_array();
    }

    public function getSubTaskData($filter_data = "") {
        $filter_data['page'] = isset($filter_data['page']) ? $filter_data['page'] : 0;
        if (isset($filter_data['limit']) && $filter_data['limit'] != 0) {
            $this->db->limit($filter_data['limit'], $filter_data['page']);
        }
        if (isset($filter_data['tstm_name']) && $filter_data['tstm_name'] != "") {
            $this->db->where("tst.tstm_name LIKE '%" . $filter_data['tstm_name'] . "%'", NULL, FALSE);
        }
        if (isset($filter_data['tm_id']) && $filter_data['tm_id'] != 0) {
            $this->db->where(array("tm.tm_id" => $filter_data['tm_id']));
        }
        if (isset($filter_data['ttstm_id']) && $filter_data['ttstm_id'] != 0) {
            $this->db->where(array("ttstm.ttstm_id" => $filter_data['ttstm_id']));
        }

        if (isset($filter_data['ttm_id']) && !in_array(0,$filter_data['ttm_id'])) {
            $ttm_id = implode(",", $filter_data['ttm_id']);
            $this->db->where("ttstm.ttstm_id in (SELECT ttstm_id FROM  nexgen_task_type_sub_task_mst WHERE  ttm_id in ($ttm_id))", NULL, FALSE);
        }

        if (isset($filter_data['user_id']) && $filter_data['user_id'] != 0) {
            $this->db->where(array("tm.tm_id" => $filter_data['tm_id']));
        }
        if (isset($filter_data['client_id']) && !in_array(0,$filter_data['client_id'])) {
            $client_id = implode(",", $filter_data['client_id']);
            $this->db->where("emp.Emp_ID in ($client_id)");
        }
        if (isset($filter_data['incharge_id']) && !in_array(0,$filter_data['incharge_id'])) {
            $incharge_id = implode(",", $filter_data['incharge_id']);
            $this->db->where("in_emp.Emp_ID in ($incharge_id)");
        }
        if (isset($filter_data['progress_flag']) && $filter_data['progress_flag'] != 0 && $filter_data['progress_flag'] != -1) {
            $this->db->where(array("tst.progress_flag" => $filter_data['progress_flag']));
        } else if (isset($filter_data['progress_flag']) && $filter_data['progress_flag'] == -1) {
            $this->db->where("tst.progress_flag<>" . COMPLETED_APPROVAL, NULL, FALSE);
        }else if(isset($filter_data['progress_flag']) && $filter_data['progress_flag']==0){
             $this->db->where(array("tst.progress_flag" => IN_PROGRESS));
        }
                   
        if (isset($filter_data['joblocalityid']) && $filter_data['joblocalityid'] != 0) {
            $this->db->where(array("tst.joblocalityid" => $filter_data['joblocalityid']));
        }
        if (isset($filter_data['filter_by']) && $filter_data['filter_by'] != 0) {
            switch ($filter_data['filter_by']) {
                case 1:
                    $this->db->where("tst.progress_flag <>" . COMPLETED_APPROVAL, NULL, FALSE);
                    break;
                case 2:
                    $this->db->where("tst.str_date_time > '" . date(DB_DTF, time()) . "' and tst.status = " . STATUS_TRUE . " and tst.progress_flag <>" . COMPLETED_APPROVAL, NULL, FALSE);
                    break;
                case 3:
                    $this->db->where("tst.progress_flag =" . COMPLETED_REQUEST, NULL, FALSE);
                    break;
                case 4:
                    $this->db->where("tst.progress_flag =" . COMPLETED_APPROVAL, NULL, FALSE);
                    break;
                default:
                    break;
            }
        }
        if (isset($filter_data['sort_by']) && $filter_data['sort_by'] != 0) {
            switch ($filter_data['sort_by']) {
                case 1:
                    $this->db->order_by("tm.start_date", $filter_data['OrderAscDsc']);
                    break;
                case 2:
                    $this->db->order_by("tm.end_date", $filter_data['OrderAscDsc']);
                    break;
                case 3:
                    $this->db->order_by("tst.str_date_time", $filter_data['OrderAscDsc']);
                    break;
                case 4:
                    $this->db->order_by("tst.end_date_time", $filter_data['OrderAscDsc']);
                    break;
                case 5:
                    $this->db->order_by("tst.assigned_to", $filter_data['OrderAscDsc']);
                    break;
                case 6:
                    $this->db->order_by("in_emp.Emp_Name", $filter_data['OrderAscDsc']);
                    break;
                case 7:
                    $this->db->order_by("tst.joblocalityid", $filter_data['OrderAscDsc']);
                    break;
                case 8:
                    $this->db->order_by("emp.Emp_Name", $filter_data['OrderAscDsc']);
                    break;
                case 9:
                    $this->db->order_by("tst.tstm_name", $filter_data['OrderAscDsc']);
                    break;
                case 10:
                    $this->db->order_by("tst.tstm_id", $filter_data['OrderAscDsc']);
                    break;
                case 11:
                    $this->db->order_by("tst.Mode_DateTime", $filter_data['OrderAscDsc']);
                    break;

                default:
                    break;
            }
        }
        if (isset($filter_data['date_wise']) && $filter_data['date_wise']) {
            if ($filter_data['date_wise'] == 1) {
                if (isset($filter_data['start_date'])) {
                    $this->db->where("tst.str_date_time>='" . date(DB_DF, strtotime($filter_data['start_date'])) . "'", NULL, FALSE);
                }
                if (isset($filter_data['end_date'])) {
                    $this->db->where("tst.str_date_time<='" . date(DB_DF, strtotime($filter_data['end_date'])) . "'", NULL, FALSE);
                }
            } else if ($filter_data['date_wise'] == 2) {
                if (isset($filter_data['start_date'])) {
                    $this->db->where("tst.end_date_time>='" . date(DB_DF, strtotime($filter_data['start_date'])) . "'", NULL, FALSE);
                }
                if (isset($filter_data['end_date'])) {
                    $this->db->where("tst.end_date_time<='" . date(DB_DF, strtotime($filter_data['end_date'])) . "'", NULL, FALSE);
                }
            }
        }
        if (isset($filter_data['extra_where']) && $filter_data['extra_where'] != "") {
            $this->db->where($filter_data['extra_where'], NULL, FALSE);
        }
        $this->db->select("tst.tstm_id,tst.tstm_name,tm.tm_name,tm.month,tm.year,tm.state_id,in_emp.Emp_Name as incharge_name,IFNULL(emp.Emp_Name, '" . mysql_real_escape_string("N/A") . "') as client_name,tst.progress_flag,e.Emp_Name,(select completed from nexgen_task_sub_task_comments where tstm_id=tst.tstm_id and status=1 order by Add_Datetime desc limit 1) as completed,tst.str_date_time,tst.end_date_time,", FALSE)->from(DB_PREFIX . "task_sub_task as tst");
        $this->db->join(DB_PREFIX . "task_mst as tm", "tst.tm_id=tm.tm_id", 'left');
        $this->db->join(DB_PREFIX . "task_type_sub_task_mst as ttstm", "ttstm.ttm_id=tm.ttm_id", 'left');
        $this->db->join(DB_PREFIX . "employee as e", "tst.assignedto=e.Emp_ID", 'left');
        $this->db->join(DB_PREFIX . "task_users as tu", "tm.tm_id=tu.tm_id and tu.user_type=" . INCHARGE . " and tu.status=" . STATUS_TRUE, 'left');
        $this->db->join(DB_PREFIX . "employee as emp", "tm.client_id=emp.Emp_ID", 'left');
        $this->db->join(DB_PREFIX . "employee as in_emp", "tu.user_id=in_emp.Emp_ID", 'left');


        if (!isset($filter_data['assigned_to']) && !in_array($this->util_model->get_utype(), array(DIRECTOR, PARTNER))) {
            //
            $this->db->where(array("tst.status" => STATUS_TRUE));
            $this->db->where("(tst.assignedto=" . $this->util_model->get_uid() . " or tst.tm_id in (SELECT tuser.tm_id FROM `nexgen_task_users` tuser WHERE user_type=1 and status=1 and user_id=" . $this->util_model->get_uid() . "))", NULL, FALSE);
        } else if (isset($filter_data['assigned_to']) && !in_array (0,$filter_data['assigned_to'])) {
            $assign_to = implode(",", $filter_data['assigned_to']);
            $this->db->where(array("tst.status" => STATUS_TRUE));
            $this->db->where("(tst.assignedto in ($assign_to) or tst.tm_id in (SELECT tuser.tm_id FROM `nexgen_task_users` tuser WHERE user_type=1 and status=1 and user_id in ($assign_to)))", NULL, FALSE);
        } else if (!in_array($this->util_model->get_utype(), array(DIRECTOR, PARTNER))) {
            $this->db->where(array("tst.status" => STATUS_TRUE));
            $this->db->where("(tst.assignedto=" . $this->util_model->get_uid() . " or tst.tm_id in (SELECT tuser.tm_id FROM `nexgen_task_users` tuser WHERE user_type=1 and status=1 and user_id=" . $this->util_model->get_uid() . "))", NULL, FALSE);
        }

        $this->db->group_by('tst.tstm_id');
        $result = $this->db->get()->result_array();
//        echo $this->db->last_query();
//        die(); 
        return $result;
    }

    public function get_progress_flag_string($progress_flag) {
        switch ($progress_flag) {
            case 2:
                return "In Progress";
            case 3:
                return "Completed Request raised";
            case 4:
                return "Close & Completed";
            default:
                return "Un-defined";
        }
    }

    public function get_approved_flag_string($progress_flag) {
        switch ($progress_flag) {
            case -1:
                return "Rejected";
            case 0:
                return "Pending for Approval";
            case 1:
                return "Approved";
            default:
                return "Un-defined";
        }
    }

    public function task_name_of_sub_tasks() {
        $this->db->select("tm.tm_id,tm.tm_name")->from(DB_PREFIX . "task_sub_task as tst");
        $this->db->join(DB_PREFIX . "task_mst as tm", "tm.tm_id=tst.tm_id", 'left');
        $this->db->where(array("tst.assignedto" => $this->util_model->get_uid(), "tst.status" => STATUS_TRUE));
        $this->db->group_by("tm_id");
        $this->db->order_by("tm.tm_name", "ASC");
        $result = $this->db->get()->result_array();
        if (!empty($result)) {
            $data = array();
            foreach ($result as $value) {
                $data[$value['tm_id']] = $value['tm_name'];
            }
            return $data;
        } else {
            return array();
        }
    }

    public function get_ttm_list($vkey, $skey, $table, $branchid = 0, $sort_col = 'Sort', $for_selection = TRUE, $status = 1, $whr = "") {
        if ($branchid != 0) {
            $this->db->where(array("BranchID" => $branchid));
        }

        if ($status) {
            $this->db->where(array("Status" => $status));
        }
//        $this->db->where("parent_ttmid<>0",NULL,FALSE);
        if ($whr != "") {
            $this->db->where($whr, NULL, FALSE);
        }
        $query = $this->db->select()->from($table)->order_by($sort_col);
        $result = $query->get()->result();
//        $this->util_model->printr($result);
        if (!$for_selection) {
            return $result;
        } else {
            $return_list = array();
            foreach ($result as $value) {
                $return_list[$value->$vkey] = $value->$skey . ($value->parent_ttmid == 0 ? "<strong>(M)</strong>" : "");
            }
            return $return_list;
        }
    }

    public function mySubTask($filter_data) {
        global $data;
        $this->db->select("tst.*,emp.Emp_Name as incharge_name,IFNULL(emp.Pro_Pic, '" . mysql_real_escape_string("NA") . "') as incharge_pic,(select completed from " . DB_PREFIX . "task_sub_task_comments stc where stc.tstm_id=tst.tstm_id and stc.status=1 and stc.approved=1 order by stc.comment_id DESC limit 1) as completed,tm.tm_id,tm.tm_name,tm.start_date,ttm.ttm_name,ttm.background,ttm.purpose,e.Emp_Name,e.P_Email,IFNULL(e.Pro_Pic, '" . mysql_real_escape_string("NA") . "') as Pro_Pic", FALSE)->from(DB_PREFIX . "task_sub_task as tst");
        $this->db->join(DB_PREFIX . "task_mst as tm", "tst.tm_id=tm.tm_id", 'left');
//        $this->db->join(DB_PREFIX . "task_type_sub_task_mst as ttstm", "tm.ttm_id=ttstm.ttm_id", 'left');
        $this->db->join(DB_PREFIX . "task_type_mst as ttm", "tm.ttm_id=ttm.ttm_id", 'left');
        $this->db->join(DB_PREFIX . "employee as e", "tst.assignedto=e.Emp_ID", 'left');
        $this->db->join(DB_PREFIX . "task_users as tu", "tu.tm_id=tm.tm_id and tu.user_type =" . INCHARGE . " and tu.status = " . STATUS_TRUE, 'left');
        $this->db->join(DB_PREFIX . "employee as emp", "tu.user_id=emp.Emp_ID", 'left');
        $this->db->where(array("tst.tstm_id" => $filter_data['tstm_id'], "tst.status" => STATUS_TRUE));
        $this->db->where("((tst.assignedto = {$data['Session_Data']['IBMS_USER_ID']}) or ({$this->util_model->get_uid()} = tu.user_id) or ({$this->util_model->get_utype()} in(" . DIRECTOR . "," . PARTNER . ")))", NULL, FALSE);
        $result = $this->db->get()->row_array();
//        echo $this->db->last_query();
//        $this->util_model->printr($result);
//        die();
//fetch_doc_data
        if (!empty($result)) {
            $result['progress_flag'] = $this->get_progress_flag_string($result['progress_flag']);
            $result['completed'] .=" %";
            $result['start_date'] = $this->util_model->formatted_time($result['start_date']);
            $result['involved_user_data'] = $this->involved_user_data($result['tm_id']);
            $result['comment_data'] = $this->fecth_comments($filter_data['tstm_id']);
//            $result['incharge_name'] = $this->incharge_details($result['tm_id']);
            $result['attachments'] = $this->fetch_attachments($filter_data['tstm_id']);
            $result['doc_required'] = $this->fetch_doc_req($result['tm_id']);
            $this->load->model('tms/m_task_manage');
            $result['sub_task_doc'] = $this->m_task_manage->getsubTask_doc($result['tstm_id']);

            return array("succ" => TRUE, "data" => $result);
        } else {
            return array("succ" => FALSE);
        }
    }

    public function fetch_doc_req($id = "") {
        $this->db->select("tmdoc_name,document_path")->from(DB_PREFIX . "task_doc_req");
        $this->db->where(array("status" => STATUS_TRUE, "tm_id" => $id));
        return $this->db->get()->result_array();
    }

    public function incharge_details($tm_id) {
        $this->db->select("e.Emp_Name,IFNULL(e.Pro_Pic, '" . mysql_real_escape_string("NA") . "') as Pro_Pic", FALSE)->from(DB_PREFIX . "task_users as tu");
        $this->db->join(DB_PREFIX . "employee as e", "tu.user_id=e.Emp_ID", 'left');
        $this->db->where(array("tu.tm_id" => $tm_id, "user_type" => INCHARGE, "tu.status" => STATUS_TRUE));
        $res = $this->db->get()->row_array();
        return !empty($res) ? $res['Emp_Name'] : "Unknown User";
    }

    public function involved_user_data($id) {
        $this->db->select("e.Emp_Name,IFNULL(e.Pro_Pic, '" . mysql_real_escape_string("NA") . "') as Pro_Pic", FALSE)->from(DB_PREFIX . "task_users as tu");
        $this->db->join(DB_PREFIX . "employee as e", "tu.user_id=e.Emp_ID", 'inner');
        $this->db->where(array("tu.tm_id" => $id, "tu.status" => STATUS_TRUE));
        return $this->db->get()->result_array();
    }

    public function get_upload_detail_data($tstm_id = "") {
        $this->db->select("tst.tstm_id,tm.tm_code,tm.tm_name,tst.tm_id")->from(DB_PREFIX . "task_sub_task as tst");
        $this->db->join(DB_PREFIX . "task_mst as tm", "tm.tm_id=tst.tm_id", 'left');
        $this->db->where(array("tst.tstm_id" => $tstm_id));
        return $this->db->get()->row_array();
    }

    public function attach_comment_docs($filter_data) {
        $this->db->insert_batch(DB_PREFIX . "task_attachments", $filter_data);
        
        if ($this->db->affected_rows() > 0) {
            return array("succ" => TRUE, "attach_id" => $this->db->insert_id());
        } else {
            return array("succ" => FALSE);
        }
    }

    public function delete_doc($filters = array()) {
//  print_r($filters);
//delete the document from server
        $this->db->select("link")->from(DB_PREFIX . "task_attachments");
        if (isset($filters['attach_id']))
            $this->db->where("attach_id", $filters['attach_id']);
        $sub_t_doc = $this->db->get()->row_array();

// print_r($sub_t_doc);

        if (!empty($sub_t_doc)) {

            try {
                $file = "/home/nexibms/public_html/tms/" . $sub_t_doc['link'];
                if (file_exists($file)) {
                    unlink($file);
                }
            } catch (Exception $ex) {
                
            }

            return $this->delete_doc_from_db($filters['attach_id']);
            ;
        }
    }

    public function delete_doc_from_db($attach_id) {
        $this->db->where("attach_id", $attach_id);
        $this->db->delete(DB_PREFIX . "task_attachments");
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function save_comment($filter_data) {
        $this->db->insert(DB_PREFIX . "task_sub_task_comments", $filter_data);
        if ($this->db->affected_rows() > 0) {
            return array("succ" => TRUE, "id" => $this->db->insert_id());
        } else {
            return array("succ" => FALSE);
        }
    }

    public function fecth_comments($tstm_id = "") {
        $this->db->select("tstc.*,e.Emp_Name,IFNULL(e.Pro_Pic, '" . mysql_real_escape_string("NA") . "') as Pro_Pic", FALSE)->from(DB_PREFIX . "task_sub_task_comments as tstc");
        $this->db->join(DB_PREFIX . "employee as e", "tstc.Add_User=e.Emp_ID", 'left');
//        $this->db->where(array("tstc.tstm_id" => $tstm_id, "tstc.approved" => STATUS_TRUE));
        $this->db->where(array("tstc.tstm_id" => $tstm_id));
        $result = $this->db->get()->result_array();
        $data = array();
        foreach ($result as $value) {
            $value['comment_attachments'] = $this->fetch_comment_attachments($value['comment_id']);
            $value['progress_flag'] = $this->get_progress_flag_string($value['progress_flag']);
            $value['approved_flag'] = $this->get_approved_flag_string($value['approved']);
            $data[] = $value;
        }
        return $data;
    }

    public function fetch_comment_attachments($table_id) {
        $this->db->select("ta.*")->from(DB_PREFIX . "task_attachments as ta");
        $this->db->where(array("ta.table_id" => $table_id, "ta.status" => STATUS_TRUE, "attach_type" => 0));
        return $this->db->get()->result_array();
    }

    public function fetch_attachments($tstm_id = "") {
        $query = $this->db->query("SELECT table_id,ta.attach_original_name as attach_name, REPLACE(ta.link, ' ', ' ') as link, DATE_FORMAT(ta.Add_DateTime, '%b %d %Y %h:%i %p') as date FROM (" . DB_PREFIX . "task_attachments as ta) WHERE ta.attach_type=" . COMMENT_ATT_TYPE . " and ta.table_id in (select comment_id from " . DB_PREFIX . "task_sub_task_comments where tstm_id={$tstm_id} and approved=" . STATUS_TRUE . ")");
        return $query->result_array();
    }

    public function get_pending_tasks($id) {
// die(print_r($id));
        $this->db->select("tm_id")->from(DB_PREFIX . "task_mst");
        $this->db->where(array("progress_flag" => IN_PROGRESS, "client_id" => $id['Emp_ID'], "status" => STATUS_TRUE));
        $result = $this->db->get()->row_array();
//        echo $this->db->last_query();
        if (!empty($result)) {
            $res = $this->get_pending_sub_tasks($result['tm_id']);
            if (!empty($res) && $res != "") {
                return array("succ" => TRUE, "data" => $res);
            } else {
                return array("succ" => FALSE);
            }
        } else {
            return array("succ" => FALSE);
        }
    }

    public function getPendingSubTaskviaClient($clientID) {

        $this->db->select("tstm.tstm_id,tstm.tstm_name, tm.tm_name, client.Emp_Name as client_name", FALSE)->from(DB_PREFIX . "task_sub_task tstm");
        $this->db->join(DB_PREFIX . "task_mst as tm", " tstm.tm_id=tm.tm_id and tm.client_id=$clientID ", 'inner');
        $this->db->join(DB_PREFIX . "employee as client", "client.Emp_ID=tm.client_id", 'left');
        $this->db->where('tstm.progress_flag <>' . COMPLETED_APPROVAL);
        $q = $this->db->get();
//            echo $this->db->last_query();
        return $q->result_array();
    }

    public function get_pending_sub_tasks($filter_data) {
        if ($filter_data != "") {
            $this->db->select("tstm_id,tstm_name, tm.tm_name. client.Emp_Name as client_name")->from(DB_PREFIX . "task_sub_task tstm");
            $this->db->join(DB_PREFIX . "task_mst as tm", "tstm.tm_id=tm.tm_id", 'left');
            $this->db->join(DB_PREFIX . "employee as client", "tm.client_id=tm.client_id", 'left');

            $this->db->where(array("tstm.tstm_id" => $filter_data, "tstm.status" => STATUS_TRUE));
            return $this->db->get()->result_array();
        }
// die($this->util_model->printr($filter_data));
    }

    public function whom_instruction() {
//   die($this->util_model->printr($filter_data));
        $this->db->select("emp.UserName,emp.Emp_Name,emp.Emp_ID")->from(DB_PREFIX . "employee as emp");
        $this->db->join(DB_PREFIX . "usertypes as ut", "ut.UTID=emp.UTID and ut.UserTypeGroup<>" . CLIENT_GROUP, 'left');
        $this->db->where("ut.level <= (select level from nexgen_usertypes where UTID=" . $this->util_model->get_utype() . ")", NULL, FALSE);
        $this->db->order_by("emp.UserName", 'ASC');
        $res = $this->db->get()->result_array();
        if (!empty($res)) {
            $data = array();
            foreach ($res as $value) {
                $data[$value['Emp_ID']] = ucwords($value['Emp_Name']);
            }
            return $data;
        } else {
            return array();
        }
    }

    public function save_unassign_tasks($form_data) {
//        $this->util_model->printr($form_data);
        $this->load->helper('array');
        $form_data['work_datetime'] = date(DB_DTF, strtotime($form_data['work_datetime']));
        $data_to_insert = elements(array('tstm_id', 'progress_flag', 'completed', 'efforts', 'comment', 'whom_instruction', 'work_datetime'), $form_data);
//        $data_to_insert['tstm_id'] = $form_data['p_subtasks'];
        $data_to_insert['approved'] = 2;
//$this->util_model->printr($data_to_insert);
        $validates = $this->add_unassign_form_validation($data_to_insert); // validating the form
        if (!empty($validates['_err_codes'])) {
            return array("succ" => false, "_err_codes" => $validates['_err_codes']);
        } else {
            $data_to_insert = $this->util_model->add_common_fields($data_to_insert);
//            $this->util_model->printr($data_to_insert);
            $this->db->insert(DB_PREFIX . "task_sub_task_comments", $data_to_insert);
            if ($this->db->affected_rows() > 0) {
                return array("succ" => TRUE, "id" => $this->db->insert_id());
            } else {
                return array("succ" => FALSE);
            }
        }
    }

    public function info_after_unassigned_for_mail_data($filter_data) {
        $query = $this->db->query("select (@cnt := @cnt + 1) AS S_no,tm.tm_name,emp.UserName,tst.tstm_name,('" . strip_tags($filter_data['comment']) . "') as sub_task_desc,CONCAT(tstm_efforts, ' Hours') as efforts,now() as work_date
                                    from nexgen_task_sub_task as tst CROSS JOIN (SELECT @cnt := 0) as dummy 
                                    left join nexgen_task_mst as tm on tst.tm_id=tm.tm_id
                                    left join nexgen_task_users as tu on tu.tm_id=tm.tm_id and tu.user_type=" . INCHARGE . " and tu.status=" . STATUS_TRUE . "
                                    left join nexgen_employee as emp on tu.user_id=emp.Emp_ID
                                    where tm.tm_id = (select tm_id from nexgen_task_sub_task where tstm_id={$filter_data['tstm_id']}) and tst.tstm_id={$filter_data['tstm_id']}");
        return $query;
    }

    public function get_approve_pst($filter = array()) {
        $this->db->select("tstc.*,e.Emp_Name, tst.tstm_name, client_list.Emp_Name as client_name, tm.tm_name, tm.start_date, tm.end_date")->from(DB_PREFIX . "task_sub_task_comments as tstc");
        $this->db->join(DB_PREFIX . "employee as e", "tstc.Add_User=e.Emp_ID", 'left');
        $this->db->join(DB_PREFIX . "task_sub_task as tst", "tstc.tstm_id=tst.tstm_id", 'left');
        $this->db->join(DB_PREFIX . "task_mst as tm", "tm.tm_id=tst.tm_id", 'left');
        $this->db->join(DB_PREFIX . "employee as client_list", "tm.client_id=client_list.Emp_ID", 'left');
        $this->db->where(array('tstc.approved' => 2, "tstc.status" => STATUS_TRUE));

        if (!in_array($this->util_model->get_utype(), array(DIRECTOR, PARTNER)) && !isset($filter['instructor_id'])) {
            $this->db->where(array("tstc.whom_instruction" => $this->util_model->get_uid()));
        } else if (isset($filter['instructor_id'])) {
            $this->db->where(array("tstc.whom_instruction" => $filter['instructor_id']));
        }


        return $this->db->get()->result_array();
    }

    public function getPendingApprovalInstructorUsers() {
        $this->db->select("tstc.whom_instruction,e.Emp_Name")->from(DB_PREFIX . "task_sub_task_comments as tstc");
        $this->db->join(DB_PREFIX . "employee as e", "tstc.whom_instruction=e.Emp_ID", 'left');
        $this->db->where(array('tstc.approved' => 2, "tstc.status" => STATUS_TRUE));
        $return = $this->db->get()->result_array();
        $list = array();
        foreach($return as $eachRow){
            $list[$eachRow['whom_instruction']] = $eachRow['Emp_Name'];
        }
        return $list;
    }

    public function approve_pst_list($filter_data) {
        if(is_array($filter_data['comment_id'])){
            $this->db->where_in('comment_id',$filter_data['comment_id']);
        }else { 
            $this->db->where('comment_id', $filter_data['comment_id']);
            
        }
        $this->db->update(DB_PREFIX . 'task_sub_task_comments', array('approved' => STATUS_TRUE));
        if ($this->db->affected_rows() > 0) {
            return array("succ" => TRUE, "_err_codes" => "Update Done Successfully");
        } else {
            return array("succ" => FALSE, "_err_codes" => "Unauthorize");
        }
    }

    public function discard_pst($filter_data) {
        if(is_array($filter_data['comment_id'])){
            $this->db->where_in('comment_id',$filter_data['comment_id']);
        }else { 
            $this->db->where('comment_id', $filter_data['comment_id']);
            
        }

        if ($this->db->update(DB_PREFIX . 'task_sub_task_comments', array('status' => STATUS_FALSE))) {
            $this->punch_invalid_unassigned_mail($filter_data);
            return array("succ" => TRUE, "_err_codes" => "Update Done Successfully");
        } else {
            return array("succ" => FALSE, "_err_codes" => "Unauthorize");
        }
    }

    public function punch_invalid_unassigned_mail($filter_data) {
        $task_name = $this->util_model->get_column_value("tstm_name", "nexgen_task_sub_task", array("tstm_id" => $filter_data['tstm_id']));
        $this->db->select("e.Emp_Name,e.Emp_ID,e.P_Email")->from(DB_PREFIX . "task_sub_task as tst");
        $this->db->join(DB_PREFIX . "task_mst as tm", "tst.tm_id=tm.tm_id", 'left');
        $this->db->join(DB_PREFIX . "task_users as tu", "tm.tm_id=tu.tm_id", 'left');
        $this->db->join(DB_PREFIX . "employee as e", "tu.user_id=e.Emp_ID", 'left');
        $this->db->where(array("tst.tstm_id" => $filter_data['tstm_id'], "tu.mail_notification" => STATUS_TRUE, "tst.status" => STATUS_TRUE));
        $result = $this->db->get()->result_array();
        $this->load->model("tms/mail/mailer", 'mailer');
        $mailData = array();
        foreach ($result as $value) {
            $mailData['to'][] = $value['P_Email'];
        }

//        $mailData['to'] = $value['P_Email'];
        $mailData['from'] = NOTIFY_EMAIL;
        $mailData['subject'] = "Unauthorize Entry in task " . strtoupper($task_name);
        $formdata['msg'] = "Dear User, \n\nThere has been unauthorize unassigned task entry in one of your projects by "
                . "<br>\n\n\nThanks NexIBMS Team";
        $formdata['heading'] = "Changes In Task!!";
        $mailData['message'] = $this->load->view("tms/mail_template/template", $formdata, TRUE);
        $code_sent = $this->mailer->send_html($mailData);
        return TRUE;
    }

//    public function all_employees(){
//        $this->db->select('');
//    }

    public function get_incharge_email($filter_data = array()) {
        $this->db->select("P_Email FROM " . DB_PREFIX . "employee"
                . " WHERE Emp_ID = (SELECT user_id FROM " . DB_PREFIX . "task_users WHERE "
                . "status=1 and mail_notification=1 and  tm_id = (SELECT tm_id FROM " . DB_PREFIX . "task_sub_task WHERE tstm_id ={$filter_data['tstm_id']} order by tstm_id limit 1) and "
                . "user_type =1 order by tuid limit 1) and Status = 1");
        $result = $this->db->get()->result_array();
        if (!empty($result[0])) {
            return $result[0]['P_Email'];
        } else {
            return '';
        }
    }

    /*

     * request approval of sub task     */

    public function request_for_close($tstm_id) {
        return $this->db->update(DB_PREFIX . "task_sub_task", array("progress_flag" => COMPLETED_REQUEST), array("tstm_id" => $tstm_id));
    }

    public function get_not_completed_subTask($filter_data = array()) {
        $filter = array("extra_where" => "tst.progress_flag <>" . COMPLETED_APPROVAL . "");
        if (isset($filter_data['assigned_to'])) {
            $filter['assigned_to'] = $filter_data['assigned_to'];
        }
        $result = $this->getSubTaskData($filter);
        $list = array();
        foreach ($result as $eachRow) {
//            $this->util_model->printr($eachRow);
            $list[$eachRow['tstm_id']] = "{$eachRow['tstm_name']}( {$eachRow['tstm_id']} )( " . ($eachRow['completed'] == '' ? "0" : $eachRow['completed']) . "% ), AssignedTo: {$eachRow['Emp_Name']}, Incharge: {$eachRow['incharge_name']}, Client Name: {$eachRow['client_name']}, Task Name: {$eachRow['tm_name']}";
        }
        return $list;
    }

    public function updateSubTask($data_to_update, $tstm_id) {

        if ($this->db->update(DB_PREFIX . "task_sub_task", $data_to_update, array("tstm_id" => $tstm_id))) {

            return array('succ' => TRUE, '_err_codes' => 'Thanks, status updated successfully!', 'last_query' => $this->db->last_query());
        } else {
            return array('succ' => TRUE, '_err_codes' => 'error while updating status !');
        }
    }

    public function is_sub_task_closed($tstm_id) {
        $this->db->where("tstm_id=$tstm_id and  progress_flag=" . COMPLETED_APPROVAL, NULL, FALSE);
        $this->db->select("*")->from(DB_PREFIX . "task_sub_task");
        $result = $this->db->get()->row_array();
        return count($result);
    }

    public function close_sub_task($tstm_id) {
        if(is_array($tstm_id)){
            $this->db->where_in('tstm_id', $tstm_id);
        }else{
            $this->db->where(array('tstm_id' => $tstm_id));
        }
        return $this->db->update(DB_PREFIX . "task_sub_task", array('progress_flag' => COMPLETED_APPROVAL, 'Mode_User' => $this->util_model->get_uid()));
    }

    public function is_incharge($tstm_id) {
        $sql = "SELECT count(*) as incharge FROM nexgen_task_sub_task tst  WHERE (SELECT count(*) FROM nexgen_task_users WHERE tm_id = tst.tm_id and user_type = 1 and status=1 and user_id = " . $this->util_model->get_uid() . ") and tst.status=1 and tst.tstm_id = $tstm_id";
        $res = $this->db->query($sql)->row_array();
        return $res['incharge'];
//        $this->util_model->printr($res);
//        die();
    }

    public function is_auth_to_punchEntry($tstm_id) {
        // check is_incharge or assigned to or parnr or diector
        return TRUE;
        // false will stop enrty
    }

    public function getSubTaskListForSelect() {
        $this->db->select('stm.tstm_id,stm.tstm_name,tm.tm_name,client.Emp_Name as clientName')->from(DB_PREFIX . "task_sub_task stm");
        if (!in_array($this->util_model->get_utype(), array(DIRECTOR, PARTNER))) {
            $this->db->where('stm.assignedto', $this->util_model->get_uid());
        }
        $this->db->join(DB_PREFIX . "task_mst tm", "tm.tm_id=stm.tm_id", 'left');
        $this->db->join(DB_PREFIX . "employee client", "client.Emp_ID=tm.client_id", 'left');
        $this->db->where("stm.tstm_name<>''", NULL, FALSE);
        $result = $this->db->get();
//        echo $this->db->last_query();
        $result = $result->result();
        $return_list = array();
        foreach ($result as $value) {

            $return_list[$value->tstm_id] = $value->tstm_name . " ({$value->tm_name}) ({$value->clientName})";
        }
        return $return_list;
    }

}
